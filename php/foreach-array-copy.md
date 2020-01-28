**Originally copied from <a href='https://nikic.github.io/2011/11/11/PHP-Internals-When-does-foreach-copy.html'>here</a>(added here just in case the link expires)**
<p>This post requires some knowledge of PHP’s internal workings, namely <code class="highlighter-rouge">zval</code>s, <code class="highlighter-rouge">refcount</code>s and
copy-on-write behavior. If those terms don’t mean anything to you, you will need to read up on
them in oder to understand this post. I would recommend <a href="http://blog.golemon.com/2007/01/youre-being-lied-to.html">an article by Sara Golemon</a>.</p>

<p>PHP’s <code class="highlighter-rouge">foreach</code> is a very neat and to-the-point language construct. Still some people don’t like to
use it, because they think it is slow. One reason usually named is that <code class="highlighter-rouge">foreach</code> copies the array
it iterates. Thus some people recommend to write:</p>

<div class="language-php highlighter-rouge"><div class="highlight"><pre class="highlight"><code><span class="nv">$keys</span> <span class="o">=</span> <span class="nb">array_keys</span><span class="p">(</span><span class="nv">$array</span><span class="p">);</span>
<span class="nv">$size</span> <span class="o">=</span> <span class="nb">count</span><span class="p">(</span><span class="nv">$array</span><span class="p">);</span>
<span class="k">for</span> <span class="p">(</span><span class="nv">$i</span> <span class="o">=</span> <span class="mi">0</span><span class="p">;</span> <span class="nv">$i</span> <span class="o">&lt;</span> <span class="nv">$size</span><span class="p">;</span> <span class="nv">$i</span><span class="o">++</span><span class="p">)</span> <span class="p">{</span>
    <span class="nv">$key</span>   <span class="o">=</span> <span class="nv">$keys</span><span class="p">[</span><span class="nv">$i</span><span class="p">];</span>
    <span class="nv">$value</span> <span class="o">=</span> <span class="nv">$array</span><span class="p">[</span><span class="nv">$key</span><span class="p">];</span>

    <span class="c1">// ...</span>
<span class="p">}</span>
</code></pre></div></div>

<p>Instead of the much more intuitive and straightforward:</p>

<div class="language-php highlighter-rouge"><div class="highlight"><pre class="highlight"><code><span class="k">foreach</span> <span class="p">(</span><span class="nv">$array</span> <span class="k">as</span> <span class="nv">$key</span> <span class="o">=&gt;</span> <span class="nv">$value</span><span class="p">)</span> <span class="p">{</span>
    <span class="c1">// ...</span>
<span class="p">}</span>
</code></pre></div></div>

<p>There are two problems with this:</p>

<ol>
  <li><a href="https://blog.ircmaxell.com/2011/08/on-optimization-in-php.html">Microoptimization is evil</a>. Usually it only wastes your time and doesn’t give any measurable
performance improvements.</li>
  <li>The copying behavior of <code class="highlighter-rouge">foreach</code> is somewhat more complicated than most people think. Often the
“optimized” variant happens to be slower than the original.</li>
</ol>

<h2 id="when-does-foreach-copy">When does foreach copy?</h2>

<p>Whether or not <code class="highlighter-rouge">foreach</code> copies the array and how much of it depends on three things: Whether the
iterated array is referenced, how high its <code class="highlighter-rouge">refcount</code> is and whether the iteration is done by
reference.</p>

<h3 id="not-referenced-refcount--1">Not referenced, refcount == 1</h3>

<p>In the below code <code class="highlighter-rouge">$array</code> is not referenced and has a refcount of <code class="highlighter-rouge">1</code>. In this case <code class="highlighter-rouge">foreach</code> will
<strong>not</strong> copy the array - contrary to the popular belief that <code class="highlighter-rouge">foreach</code> always copies
the iterated array if it isn’t referenced.</p>

<div class="language-php highlighter-rouge"><div class="highlight"><pre class="highlight"><code><span class="nx">test</span><span class="p">();</span>
<span class="k">function</span> <span class="nf">test</span><span class="p">()</span> <span class="p">{</span>
    <span class="nv">$array</span> <span class="o">=</span> <span class="nb">range</span><span class="p">(</span><span class="mi">0</span><span class="p">,</span> <span class="mi">100000</span><span class="p">);</span>
    <span class="k">foreach</span> <span class="p">(</span><span class="nv">$array</span> <span class="k">as</span> <span class="nv">$key</span> <span class="o">=&gt;</span> <span class="nv">$value</span><span class="p">)</span> <span class="p">{</span>
        <span class="c1">// ...</span>
    <span class="p">}</span>
<span class="p">}</span>
</code></pre></div></div>

<p>The reason is simple: Why should it? The only thing that <code class="highlighter-rouge">foreach</code> modifies about <code class="highlighter-rouge">$array</code> is it’s
internal array pointer. This is expected behavior and thus doesn’t need to be prevented.</p>

<h3 id="not-referenced-refcount--1-1">Not referenced, refcount &gt; 1</h3>

<p>The following code looks very similar to the previous one. The only difference is that the array is
now passed as an argument. This seems like an insignificant difference, but it does change the
behavior of <code class="highlighter-rouge">foreach</code>: It now <strong>will</strong> copy the array structure, but <strong>not</strong> the values 
if you want to see that this is really only the structure being copied compare <a href="http://codepad.viper-7.com/nNX1Rt">this</a> and <a href="http://codepad.viper-7.com/lQC1K6">that</a>
script. The first only copies the structure, the second copies both).</p>

<div class="language-php highlighter-rouge"><div class="highlight"><pre class="highlight"><code><span class="nv">$array</span> <span class="o">=</span> <span class="nb">range</span><span class="p">(</span><span class="mi">0</span><span class="p">,</span> <span class="mi">100000</span><span class="p">);</span>
<span class="nx">test</span><span class="p">(</span><span class="nv">$array</span><span class="p">);</span>
<span class="k">function</span> <span class="nf">test</span><span class="p">(</span><span class="nv">$array</span><span class="p">)</span> <span class="p">{</span>
    <span class="k">foreach</span> <span class="p">(</span><span class="nv">$array</span> <span class="k">as</span> <span class="nv">$key</span> <span class="o">=&gt;</span> <span class="nv">$value</span><span class="p">)</span> <span class="p">{</span>
        <span class="c1">// ...</span>
    <span class="p">}</span>
<span class="p">}</span>
</code></pre></div></div>

<p>This might seem odd at first: Why would it copy when the array is passed through an argument, but
not if it is defined in the function? The reason is that the array <code class="highlighter-rouge">zval</code> is now shared between
multiple variables: The <code class="highlighter-rouge">$array</code> variable outside the function and the <code class="highlighter-rouge">$array</code> variable inside it.
If <code class="highlighter-rouge">foreach</code> would iterate the array without copying its structure it would not only change the array
pointer of the <code class="highlighter-rouge">$array</code> variable in the function, but also the pointer of the <code class="highlighter-rouge">$array</code> variable outside
the function. Thus <code class="highlighter-rouge">foreach</code> needs to copy the array structure (i.e. the hash table). The values on
the other hand still can share zvals and thus don’t need to be copied.</p>

<h3 id="referenced">Referenced</h3>

<p>The next case is very similar to the previous one. The only difference is that the array is passed
by reference. In this case the array again will <strong>not</strong> be copied.</p>

<div class="language-php highlighter-rouge"><div class="highlight"><pre class="highlight"><code><span class="nv">$array</span> <span class="o">=</span> <span class="nb">range</span><span class="p">(</span><span class="mi">0</span><span class="p">,</span> <span class="mi">100000</span><span class="p">);</span>
<span class="nx">test</span><span class="p">(</span><span class="nv">$array</span><span class="p">);</span>
<span class="k">function</span> <span class="nf">test</span><span class="p">(</span><span class="o">&amp;</span><span class="nv">$array</span><span class="p">)</span> <span class="p">{</span>
    <span class="k">foreach</span> <span class="p">(</span><span class="nv">$array</span> <span class="k">as</span> <span class="nv">$key</span> <span class="o">=&gt;</span> <span class="nv">$value</span><span class="p">)</span> <span class="p">{</span>
        <span class="c1">// ...</span>
    <span class="p">}</span>
<span class="p">}</span>
</code></pre></div></div>

<p>In this case the same reasoning applies as with the previous case: The outer <code class="highlighter-rouge">$array</code> and the inner
<code class="highlighter-rouge">$array</code> share <code class="highlighter-rouge">zval</code>s. The difference is that they now are references (<code class="highlighter-rouge">isref == 1</code>). Thus in this
case it is expected that any change to the inner array will also be done to the outer array. So if
the array pointer of the inner array is changed, the array pointer of the outer array should change,
too. That’s why <code class="highlighter-rouge">foreach</code> doesn’t need to copy.</p>

<h3 id="iterated-by-reference">Iterated by reference</h3>

<p>The above examples were all iterating by value. For iteration by reference the same rules apply, but
the additional value reference changes copying behavior of the array <em>values</em> (the behavior about
<em>structure</em> copying stays).</p>

<p>The case “Not referenced, refcount == 1” doesn’t change. By reference iteration means we want to
change the original array if there are any changes to the <code class="highlighter-rouge">$value</code>, so the array isn’t copied
.</p>

<p>The case “Referenced” also stays the same, as in this case a change to <code class="highlighter-rouge">$value</code> should change all
variables referencing the iterated array</p>

<p>Only the “Not referenced, refcount &gt; 1” case changes, as now both the array structure and its values
need are be copied. The array structure because otherwise the array pointer of the <code class="highlighter-rouge">$array</code> variable
outside the function would change and the values because a change to <code class="highlighter-rouge">$value</code> would also change the
outside <code class="highlighter-rouge">$array</code> values.</p>

<h2 id="summary">Summary</h2>

<p>To summarize:</p>

<ul>
  <li><code class="highlighter-rouge">foreach</code> will copy the array <em>structure</em> if and only if the iterated array is not referenced and
has a <code class="highlighter-rouge">refcount &gt; 1</code></li>
  <li><code class="highlighter-rouge">foreach</code> will additionally copy the array <em>values</em> if and only if the previous point applies and
the iteration is done by reference</li>
</ul>

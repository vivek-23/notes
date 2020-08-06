In PHP, there are only 2 scopes, global and local. 
Local scope is when something is executing inside a function. So you can't access those variables outside of the function
because they are local variables. 
Everything else is global scope. Even the below example is valid:

```
$arr = [1,2,3];

foreach($arr as $val){
  // whatever
}

echo $val; // prints 3
```

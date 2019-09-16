> count() function in PHP to find array count is O(1).

**A good read:** https://stackoverflow.com/questions/5835241/is-phps-count-function-o1-or-on-for-arrays/5835419

**Copying text from there:**

Well, we can look at the source:


/ext/standard/array.c
PHP_FUNCTION(count) calls php_count_recursive(), which in turn calls zend_hash_num_elements() for non-recursive array, which is implemented this way:

> ZEND_API int zend_hash_num_elements(const HashTable *ht)

> {

>    IS_CONSISTENT(ht);

>

>    return ht->nNumOfElements;

> }

So you can see, it's O(1) for $mode = COUNT_NORMAL.

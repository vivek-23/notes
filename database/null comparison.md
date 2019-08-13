* `NULL` is considered as a 'missing, unknown value', as opposed to no value.
* Comparison with NULL value should never be made with `>`,`<`,`>=`,`<=`,`!=`,`<>`, or will result in always falsy boolean value.
* Above behavior is expected due to it's very definition. 
* So, always use `IS` or `IS NOT` for checking with `NULL`, like `IS NULL` or `IS NOT NULL`.

**A good read: https://stackoverflow.com/questions/9608639/mysql-comparison-with-null-value**

Strict types in PHP only make function return types and function parameters strict.
It doesn't do anything with variables passed to function or those newly created inside the function.
Variables still remain loosely typed. You use strict types using 

```
declare(strict_types=1);
```

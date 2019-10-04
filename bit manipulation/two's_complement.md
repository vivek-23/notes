* We represent negative numbers in binary using 2's complement. 
* The most MSB bit, if set, represents a negative number. If unset, it is an unsigned number.

> 2's complement  = 1's complement(just inverting all bits, 0 to 1 and 1 to 0) + 1 

For example, 2's complement of `5` is:

> 5 => 00000000000000000000000000000101

> 1's complement => 11111111111111111111111111111010

> \+

> 1

> = -5(2's complement) => 11111111111111111111111111111011

* Doing a vice-versa on a negative number would yield you it's absolute unsigned value.

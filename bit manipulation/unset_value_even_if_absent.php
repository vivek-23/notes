<?php


$x = 45 | 67 | 78;

echo $x,PHP_EOL;

$x ^= 45;

echo $x,PHP_EOL;

$x ^= 45;

echo $x,PHP_EOL;

$x &= ~45;

echo $x,PHP_EOL;

$x &= ~45;

echo $x,PHP_EOL;



/*
Output:

111
66
111
66
66

Demo: https://3v4l.org/A53nl

If we don't know whether a value is set or not in a bitwise OR of a sequence of numbers, then we can 
just use &= ~(your number) to remove the effect of that particular number from the bitwise ORing in the final result.

*/

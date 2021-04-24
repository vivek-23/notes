<?php

$arr = [
    [1,2,3],
    [4,5],
    [6,7,8,9,10,11]
];
/* way 1 - Use foreach */
$sum = 0;
foreach($arr as $v){
    foreach($v as $val){
        $sum += $val;
    }
}

echo $sum,PHP_EOL;
/* Way 1 ends */

/* Way 2 - Using array functions */
echo array_sum(array_map('array_sum',$arr));
/* Way 2 ends */

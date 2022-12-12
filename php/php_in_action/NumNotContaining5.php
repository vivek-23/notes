// testcases.txt
/*
1 555
1 78
1 14500
1 2589
1 80
1 1000
1 10
1 459
1 7
1 4590
1 1000000
1 10000000
4 17
100 195
1 1000000000
*/

<?php

function bruteForce($start, $end, $digit = 5){
  $cnt = 0;
  for($i = $start; $i <= $end; ++$i){
    if(strpos(strval($i), '5') === false){
      $cnt++;
    }
  }
  return $cnt;
}

function getRangeCount($start, $end, $digit = 5){
  return getCount($end, $digit) - getCount($start - 1, $digit);
}

function getCount($end, $digit){
  if($end === 0) return 0;
  $sum = 0;
  $end = strval($end);
  $length = strlen($end);

  for($i = 1, $curr = 1; $i < $length; ++$i, $curr *= 9){
    $sum += ($i === 1 ? 8 : 8 * $curr);
  }

  return $sum + getMSBCount($end, 0, $digit, $length);
}

function getMSBCount($end, $idx, $digit, $length){
  if($idx === $length) return 0;
  if($end[ $idx ] === '0') return 1;

  $validDigits = ord($end[ $idx ]) - ord('0') + 1;
  if($idx === 0) $validDigits--;
  if($idx < $length - 1) $validDigits--;
  if($validDigits > $digit) $validDigits--;

  $mul = 1;

  for($i = 1; $i < $length - $idx; ++$i){
    $mul *= 9;
  }

  return $mul * $validDigits + ($end[ $idx ] == $digit ? 0 : getMSBCount($end, $idx + 1, $digit, $length));
}

if(count($argv) == 3){
  $fp = fopen('testcases.txt', 'a+');
  fwrite($fp, $argv[1] . " " . $argv[2] . "\n");
  fclose($fp);
}

foreach(array_filter(explode("\n",file_get_contents('testcases.txt'))) as $line){
  list($start, $end) = explode(" ", $line);
  $start = intval($start);
  $end = intval($end);
  $ans1 = bruteForce($start, $end);
  $ans2 = getRangeCount($start, $end);
  echo $start, " - ", $end, " => ", $ans1, " , ", $ans2, " ", var_dump($ans1 === $ans2), PHP_EOL;
}

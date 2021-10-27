<?php

/**
 * This method generates all permutations of a given string
 * @param $str - The string to generate permutations for
 * @return Returns an array of all the possible permutations of the given string
 */ 

function generateAllPermutations($str){
  $str = str_split($str);
  sort($str); // starting with non decreasing permutation for a uniform flow
  $perms = [];
  $len = count($str);

  while(true){
    $perms[] = implode("", $str);
    $x = $y = -1;
    for($i = $len - 1; $i >= 0; --$i){
      for($j = $i - 1; $j >= 0; --$j){
        if($str[ $i ] > $str[ $j ]){
          if($y == -1 || $y < $j){
            $x = $i;
            $y = $j;
          }
        }
      }
    }

    if($x === -1) break;// since no more permutations exist
    swap($str, $x, $y);
    reverseArray($str, $y + 1, $len - 1);
  }

  return $perms;
}

/**
 * This method reverses the given array in range [start_index, end_index] inclusive
 * @param $arr - The array to perform reverse in.
 * @param $i - The start index of the slice of the array to be reversed
 * @param $j - The end index of the slice of the array to be reversed
 * @return void
 */ 

function reverseArray(&$arr, $i, $j){
  while($i < $j){
    swap($arr, $i++, $j--);
  }
}

/**
 * This method swaps the values of 2 given indices in an array
 * @param $arr - The array to perform reverse in.
 * @param $i - The first index involved in the swap
 * @param $j - The second index involved in the swap
 * @return void
 */

function swap(&$arr, $i ,$j){
  $temp = $arr [ $i ];
  $arr[ $i ] = $arr[ $j ];
  $arr[ $j ] = $temp;
}


print_r(generateAllPermutations("12345"));

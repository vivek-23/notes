<?php

$str = "abcefghijklmnopqrstuvwxyz0123456789";


for($i=1;$i<=10000;++$i){
	$length = rand(1,strlen($str));
	$new_str = "";
	for($j=1;$j<=$length;++$j){
		$new_str .= $str[rand(0,strlen($str)-1)];
	}

	$new_str .= ".";
	$length = rand(1,strlen($str)-20);
	for($j=1;$j<=$length;++$j){
		$new_str .= $str[rand(0,strlen($str)-1)];
	}

	echo $new_str,"\r";
	usleep(800);
}

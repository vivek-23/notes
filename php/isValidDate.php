<?php

function isValidDate($date){
	$dateTime = DateTime::createFromFormat('Y-m-d',$date);
	$errors = DateTime::getLastErrors();
	return $errors['warning_count'] === 0;
}

/* 

above function checks if date is valid in PHP
A good read: https://stackoverflow.com/a/10120725/4964822

*/

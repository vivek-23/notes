<?php

$conn = mysqli_connect("localhost","root","","dummy");

if($conn === false){
  die(mysqli_connect_error());
}

$query = mysqli_query($conn,"select * from groups");

if($query !== false && mysqli_num_rows($query) > 0){
    while($each_row = mysqli_fetch_assoc($query)){
      //print_r($each_row);
    } 
}else{
      echo "No results found!";
}

$query = mysqli_query($conn,"insert into groups(group_name,teams) values('lol',10)");

//insert into groups(group_name,teams) values('lol',10),('haha',299) - Don't do 1+ inserts in a row. It returns wrong last insert id

if($query === false){
   throw new Exception("Could not execute query");   
}else{
  echo "Values inserted successfully<br/>";
}

echo "last inserted ID : ",mysqli_insert_id($conn)," ",mysqli_insert_id($conn);

mysqli_close($conn);

<?php

$conn = new mysqli("localhost","root","","dummy");

if($conn->errno !== 0){
  die($conn->error);
}

$result_set = $conn->query("select * from groups");

if($result_set !== false && $result_set->num_rows > 0){
    while($each_row = $result_set->fetch_assoc()){
      print_r($each_row);
    } 
}else{
      echo "No results found or probably query is syntactically incorrect!";
}

$result_set = $conn->query("insert into groups(group_name,teams) values('lol',10)");

//insert into groups(group_name,teams) values('lol',10),('haha',299) - Don't do 1+ inserts in a row. It returns wrong last insert id

if($result_set === false){
   throw new Exception("Could not execute query");   
}else{
  echo "Values inserted successfully<br/>";
}

echo "last inserted ID : ",$conn->insert_id;

$conn->close();

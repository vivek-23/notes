<pre>
<?php

$conn = new mysqli("localhost","root","","dummy");

if($conn->errno !== 0){
  die($conn->error);
}

$group_name = "lol";

$prepared_statement = $conn->prepare("select * from groups where group_name = ?");
$prepared_statement->bind_param("s",$group_name);

if($prepared_statement === false){
  die("Incorrect Query : Select !!!");
}



if($prepared_statement->execute() === true){
    $prepared_statement->bind_result($id,$name,$team_score);
    while($prepared_statement->fetch()){
      echo $id," ",$name," ",$team_score,"<br/>";
    }
}

list($group_name,$team_score) = ['hahaoei',588];

$prepared_statement = $conn->prepare("insert into groups(group_name,teams) values(?,?)");

if($prepared_statement === false){
  die("Incorrect Query : Insert !!!");
}

$prepared_statement->bind_param("si",$group_name,$team_score);

if($prepared_statement->execute() === true){
	echo "Inserted successfully<br/>";
	echo $conn->insert_id,"<br/>";
}

$conn->close();

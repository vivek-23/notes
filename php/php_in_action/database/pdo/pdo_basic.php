<pre>
<?php

try{
	$conn = new PDO("mysql:host=localhost;dbname=dummy","root","");
	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$prepared_statement = $conn->prepare("select * from groups where group_name = :group_name");
	$prepared_statement->bindParam(":group_name",$group_name);
	$group_name = "lol";
	$team_score = 78787;
	$prepared_statement->execute();
	while($row = $prepared_statement->fetch()){
		print_r($row);
	}
	
	$prepared_statement = $conn->prepare("insert into groups(group_name,teams) values(:group_name,:team_score)");
	$prepared_statement->bindParam(":group_name",$group_name);
	$prepared_statement->bindParam(":team_score",$team_score);
	if($prepared_statement->execute() === true){
		echo "last inserted ID: ",$conn->lastInsertId();
	}
	
}catch(PDOEXception $e){
	die($e->getMessage());
}

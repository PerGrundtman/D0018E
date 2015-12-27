<?php
include ("admin_area/includes/db.php");


$name = $_POST["name"];
$comment = $_POST["comment"];
$id = (int)$_GET["product"];

$comment_length = strlen($comment);

if($comment_length>100){
	header("location: details.php?pro_id=" . $id . "&error=1");
} else {
	//mysqli_query($con, "INSERT INTO comments(id, name, comment) VALUES({$id}, {$name}, {$comment} )");
	$con->query("INSERT INTO comments(id, name, comment) VALUES({$id}, {$name}, {$comment} )");
	
	echo "$id <p>";
	echo "$name <p>";
	echo "$comment";
	
	//header("location: details.php?pro_id=" . $id");
	
}

?>
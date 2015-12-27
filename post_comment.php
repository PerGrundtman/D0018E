<?php
include ("admin_area/includes/db.php");

$id = (int)$_GET["product"];
$name = $_POST["name"];
$comment = $_POST["comment"];


$comment_length = strlen($comment);

if($comment_length>100){
	header("location: details.php?pro_id=" . $id . "&error=1");
} else {
	 //mysqli_query($con, "INSERT INTO comments(id, name, comment) VALUES({$id}, {$name}, {$comment} )");
	$con->query("INSERT INTO comments(product_id, name, comment) VALUES ('$id', '$name', '$comment')");
	
	//debug
	echo "product id: $id <p>";
	echo "Commenters name: $name <p>";
	echo "Commenter: $comment";
	
	//comment this line for debug
	header("location: details.php?pro_id=" . $id);
	
}

?>
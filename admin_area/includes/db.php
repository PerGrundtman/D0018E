<?php


$host="utbweb.its.ltu.se";
$port=3306;
$socket="";
$user="pergru-0";
$password="1337";
$dbname="pergru0db";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

//$con->close();



?>
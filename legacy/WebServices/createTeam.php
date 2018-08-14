<?php
require_once("../database_access.php");
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
if(!$connection){
	die("Couldn't connect to database server: " . mysqli_error($connection));
}
if(isset($_POST['name'])){
	$name = strip_tags(stripslashes($_POST['name']));
}else{
	$name = "";
}
if(isset($_POST['message'])){
	$desc = strip_tags(stripslashes($_POST['message']));
}else{
	$desc = "";
}
$sql = "INSERT INTO `Organizations` VALUES (default, '$name', 0, 0, '$desc')";
$result = mysqli_query($connection, $sql);
if (!$result){
	die("Couldn't complete database query");
}
header('Location: teams.php');
?>
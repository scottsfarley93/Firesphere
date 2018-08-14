<?php
require_once('../database_access.php');
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
if (!$connection){
	die("Couldn't connect to database server: " . mysqli_error($connection));
}
if (isset($_POST['name'])){
	$name = stripslashes(strip_tags($_POST['name']));
}else{
	$name = "";
}
if (isset($_POST['email'])){
	$email = strip_tags(stripslashes($_POST['email']));
}else{
	$email = "";
}
if(isset($_POST['subject'])){
	$subject = strip_tags(stripslashes($_POST['subject']));
}else{
	$subject = "";
}
if (isset($_POST['message'])){
	$message = strip_tags(stripslashes($_POST['message']));
}else{
	$message = "";
}
$sql = "INSERT INTO `WebComments` VALUES (Default, '$name', '$email', '$subject', Default, '$message')";
$result = mysqli_query($connection, $sql);
if(!$result){
	die("Couldn't complete database update: " . mysqli_error($connection));
}else{
	header("Location: http://firesphere.org/documents/currentBehavior.php?Feedback=True");
}
?>
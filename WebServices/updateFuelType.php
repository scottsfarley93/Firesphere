<?php
require_once("../database_access.php");
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
if(isset($_POST['type'])){
	$type = $_POST['type'];
}else{
	$type = "";
}
if(isset($_POST['photo'])){
	$photo = $_POST['photo'];
}else{
	$photo = "";
}
$sql = "UPDATE FuelsData SET `Type` = '$type' WHERE `Photo`='$photo'";
$result = mysqli_query($connection, $sql);
if(!$result){
	die("Couldn't connect " . mysqli_error($connection));
}else{
	echo "1";
}
?>
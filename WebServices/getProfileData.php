<?php
require_once("../database_access.php");
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
if(!$connection){
	die("Database Server Connection Error");
}
$user = $_GET['user'];
$sql = "SELECT * FROM `Users` WHERE `Username` = '$user'";
$result = mysqli_query($connection, $sql);
if(mysqli_num_rows($result) == 0){
	echo "Invalid Username Submitted";
}else{
	$theData= mysqli_fetch_assoc($result);
	$response = array("username"=>$theData['Username'], "firstName"=>$theData['First'], "lastName"=>$theData['Last'], "email"=>$theData['email'], "numObs"=>$theData['NumObs'], "Team"=>$theData['Team']);
	$r = json_encode($response);
	echo $r;
}
?>

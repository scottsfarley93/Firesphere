<?php
require_once('../database_access.php');
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
if (!$connection){
	die("Could not connect to the database server" . mysqli_error($connection));
}
if(isset($_POST['username'])){
	$username = $_POST['username'];
}else{
	$username = "";
}
if(isset($_POST['pass'])){
	$pass = $_POST['pass'];
}else{
	$pass = "";
}
$checkPass = hash('sha512', $pass);
$sql = "SELECT * FROM `Users` WHERE `Username` = '$username'";
$result = mysqli_query($connection, $sql);
$rows = mysqli_num_rows($result);
if($rows != 1){ //the username is not correct
	echo "0";
}else{
	$theUser = mysqli_fetch_assoc($result);
	$dbPass = $theUser['EncPass'];
	//echo $dbPass;
	//echo $checkPass;
	if($checkPass == $dbPass){//the user is authenticated correctly
		echo "1";
	}else{//the password is wrong
		echo "0";
	}
}
?>
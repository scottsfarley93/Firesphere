<?php
session_start();
require_once("../database_access.php");
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);

if(isset($_POST['username'])){
	$username = strip_tags(trim($_POST['username']));
}
if(isset($_POST['password'])){
	$password = strip_tags(trim($_POST['password']));
} else{
}
if(isset($_POST['firstname'])){
	$firstname = strip_tags(trim($_POST['firstname']));
}
if(isset($_POST['lastname'])){
	$lastname = strip_tags(trim($_POST['lastname']));
}
if(isset($_POST['email'])){
	$email = strip_tags(trim($_POST['email']));
}
$user_check_sql= "SELECT * FROM `Users` WHERE `Username` = '$username'";
$user_check_query = mysqli_query($connection, $user_check_sql);
$user_check_rows = mysqli_num_rows($user_check_query);
if($user_check_rows!=0){
	echo "-1";
}else{
	$sec_password = hash('sha512', $password);
	$insert_sql = "INSERT INTO `Users` VALUES (DEFAULT, '$firstname', '$lastname', '$username', '$sec_password', DEFAULT, '$email', 0, 'None')";
	$insert_query = mysqli_query($connection, $insert_sql);
	if(!$insert_query){
		echo "0";
	}else{	
		echo "1";
	}
}

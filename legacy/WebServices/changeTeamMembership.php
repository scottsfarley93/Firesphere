<?php
require_once("../database_access.php");
$connection = mysqli_connect(HOST, USER, PASSWORD,NEW_DB);
if(isset($_POST['username'])){
	$username = $_POST['username'];
}else{
	$username = "";
}
if(isset($_POST['team'])){
	$team = $_POST['team'];
}else{
	$team = "";
}

//get user's old team
$sql = "SELECT Team From `Users` WHERE Username='$username'";
$result = mysqli_query($connection, $sql);
if(!$result){
	die("Couldn't fetch user observations: " . mysqli_error($connection));
}
$row = mysqli_fetch_assoc($result);
$oldTeam = $row['Team'];

//first change the user's memebership
$sql = "UPDATE `Users` Set Team='$team' WHERE Username='$username'";
$result = mysqli_query($connection, $sql);
if(!$result){
	die("Couldn't update user membership: " . mysqli_error($connection));
}

//Set +1 user & +X obs in new team
$sql = "UPDATE Organizations SET NumUsers=NumUsers+1 WHERE Name='$team'";
$result = mysqli_query($connection, $sql);
if(!$result){
	die("Couldn't complete new organization query" . mysqli_error($connection));
}
//set -1 user in old team
$sql = "UPDATE Organizations SET NumUsers=NumUsers-1 WHERE Name='$oldTeam'";
$result = mysqli_query($connection, $sql);
if(!$result){
	die("Couldn't complete old organization query" . mysqli_error($connection));
}else{
	echo "1";
}
	
?>
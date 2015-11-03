<?php
require_once("../database_access.php");
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
if(isset($_POST['term'])){
	$term = $_POST['term'];
}else{
	$term = "";
}
if(isset($_POST['var1'])){
	$var1 = $_POST['var1'];
}else{
	$var1 = "";
}
if(isset($_POST['var2'])){
	$var2 = $_POST['var2'];
}else{
	$var2 = "";
}
if(isset($_POST['username'])){
	$username = $_POST['username'];
}else{
	$username = "";
}
if($term == "name"){//update real name of the user
	$first = $var1;
	$last = $var2;
	$sql = "UPDATE Users SET First = '$first', Last='$last' WHERE Username = '$username'";
	$result = mysqli_query($connection, $sql);
	if(!$result){
		echo "-1";
	}
}else if($term = "email"){//update email address
	$email = $var1;
	$sql = "UPDATE Users SET email='$email' WHERE Username = '$username'";
	$result = mysqli_query($connection, $sql);
	if(!$result){
		echo "-1";
	}
}	
?>
<?php
require_once("../database_access.php");
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
$wd = getcwd();
$time = time();
$name = $_FILES['image']['name'];
$filename = "../userimages/" . time() . "_" . $name;
if(isset($_POST['fuelModel'])){
	$fuelModel = $_POST['fuelModel'];
}else{
	$fuelModel = "";
}
if(isset($_POST['comments'])){
	$comments = $_POST['comments'];
}else{
	$comments = "";
}
if(isset($_POST['lat'])){
	$lat = $_POST['lat'];
}else{
	$lat = -1;
}
if(isset($_POST['lon'])){
	$lon = $_POST['lon'];
}else{
	$lon = -1;
}
if(isset($_POST['acc'])){
	$acc = $_POST['acc'];
}else{
	$acc = -1;
}
if(isset($_POST['username'])){
	$username = $_POST['username'];
}else{
	$username = "";
}
if(isset($_POST['now'])){
	$now = $_POST['now'] / 1000;
}else{
	$now = strtotime('now');
}
$sql = "INSERT INTO `PhotoObservations` VALUES (Default, '$username', '$fuelModel', FROM_UNIXTIME($now), '$comments', '$filename', $lat, $lon, $acc)";
$result = mysqli_query($connection, $sql);
if(!$result){
	echo "-1";
}else{
	if(move_uploaded_file($_FILES['image']['tmp_name'], $filename)){
		echo "2"; //
	}else{
		 echo "1";
	}
}
$sql = "SELECT `NumObs`, `Team` FROM `Users` WHERE `Username` = '$username'";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
if (!$result){
	die("Error in fetching username" . mysqli_error($connection));
}
$sql1 = "UPDATE `Users` SET `NumObs`=NumObs+1 WHERE `Username` = '$username'"; //update user row to show new number of observations
$result1 = mysqli_query($connection, $sql1);
if (!$result1){
	die("Error in updating user: " . mysqli_error($connection));
}
$org = $row['Team']; // now update the team profile with a new observation
$sql3 = "UPDATE Organizations SET NumObs=NumObs+1 WHERE `Name` = '$org'";
$result3 = mysqli_query($connection, $sql3);
if(!$result3){
	die("Couldn't complete update");
}
?>
<?php
require_once('../database_access.php');
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
if(isset($_POST['N'])){
	$nBound = floatval($_POST['N']);
}else{
	$nBound = 90;
}
if(isset($_POST['E'])){
	$eBound = floatval($_POST['E']);
}else{
	$eBound = 180;
}
if(isset($_POST['S'])){
	$sBound = floatval($_POST['S']);
}else{
	$sBound = -90;
}
if(isset($_POST['W'])){
	$wBound = floatval($_POST['W']);
}else{
	$wBound = -180;
}

$sql = "SELECT * FROM `PhotoObservations` WHERE Lat > $sBound AND Lat < $nBound AND Lon > $wBound AND Lon < $eBound";
$query = mysqli_query($connection, $sql);
if (!$query){
	die("Could not complete query" . mysqli_error($connection));
}else{
	$resultArray= array();
	$tempArray = array();
	while($row = $query->fetch_object()){
		$tempArray = $row;
		array_push ($resultArray, $tempArray);
	}
	echo json_encode($resultArray);
}
mysqli_close($connection)
?>
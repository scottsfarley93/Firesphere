<?php
require_once("../database_access.php");
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
if(isset($_POST['type'])){
	$type = $_POST['type'];
}else{
	$type = "None";
}
$sql = "SELECT `Index`, `ps_name`, `Latitude`, `Longitude`, `Photo`,`Type`, `Num`, `Name` FROM `FuelsData` WHERE `Type` = '$type'";
$result = mysqli_query($connection, $sql);
if(!$result){
	die("Couldn't complete database Query " . mysqli_error($connection));
}
$Response = array();
while($row = mysqli_fetch_assoc($result)){
	array_push($Response, $row);
}
echo json_encode($Response);
?>
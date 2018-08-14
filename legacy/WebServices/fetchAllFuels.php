<?php
require_once("../database_access.php");
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
$sql = "SELECT * FROM `FuelsData` WHERE 1";
$result = mysqli_query($connection, $sql);
if(!$result){
	die("Couldn't fetch fuels data..." . mysqli_error($connection));
}
$Response = array();
while($row = mysqli_fetch_assoc($result)){
	array_push($Response, $row);
}
echo json_encode($Response);
	
?>
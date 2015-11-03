<?php
require_once("../database_access.php");
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
if(!$connection){
	die("Could not connect to the database: " . mysqli_error($connection));
}
$sql = "SELECT Name FROM `Organizations`";
$result = mysqli_query($connection, $sql);
$theResult = array();
while($row = mysqli_fetch_assoc($result)){
	array_push($theResult, $row);
}
$theResult = json_encode($theResult);
echo $theResult;
?>
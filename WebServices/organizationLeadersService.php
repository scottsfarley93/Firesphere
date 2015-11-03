<?php
require_once('../database_access.php');
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
if(!$connection){
	die("Could not connect to database server.  Sever Error Message: " . mysqli_error($connection));
}
$sql = "SELECT * FROM `Organizations` ORDER BY `NumObs` DESC LIMIT 10";
$result = mysqli_query($connection, $sql);
if(!$result){
	die("Could not complete query.  Server Error Message: " . mysqli_error($result));
}
$Response = array();
while($row = mysqli_fetch_assoc($result)){
	$row_array = array();
	$id = $row['OrgID'];
	$name = $row['Name'];
	$numUsers = $row['NumUsers'];
	$numObs = $row['NumObs'];
	$desc = $row['Description'];
	array_push($row_array, $id);
	array_push($row_array, $name);
	array_push($row_array, $numObs);
	array_push($row_array, $numUsers);
	array_push($row_array, $desc);
	array_push($Response, $row_array);
}
$res = json_encode($Response);
echo $res;

?>
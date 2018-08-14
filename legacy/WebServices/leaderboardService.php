<?php
require_once('../database_access.php');
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
if(!$connection){
	die("Could not connect to database server.  Sever Error Message: " . mysqli_error($connection));
}
$sql = "SELECT * FROM `Users` ORDER BY `NumObs` DESC LIMIT 10";
$result = mysqli_query($connection, $sql);
if(!$result){
	die("Could not complete query.  Server Error Message: " . mysqli_error($result));
}
$Response = array();
while($row = mysqli_fetch_assoc($result)){
	$row_array = array();
	$username = $row['Username'];
	$First = $row['First'];
	$Last = $row['Last'];
	$email = $row['email'];
	$numObs = $row['NumObs'];
	$Team = $row['Team'];
	array_push($row_array, $username);
	array_push($row_array, $numObs);
	array_push($row_array, $email);
	array_push($row_array, $First);
	array_push($row_array, $Last);
	array_push($row_array, $Team);
	array_push($Response, $row_array);
}
$res = json_encode($Response);
echo $res;

?>
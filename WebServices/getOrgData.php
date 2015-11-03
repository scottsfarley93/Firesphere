<?php
require_once("../database_access.php");
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
if(!$connection){
	die("Could not connect to the database server. " . mysqli_error($connection));
}
if(isset($_POST['orgName'])){
	$orgName = $_POST['orgName'];
}else{
	$orgName = "";
}
$sql = "SELECT * FROM `Organizations` WHERE `Name` = '$orgName'";
$result = mysqli_query($connection, $sql);
if(mysqli_num_rows($result) == 0){
	$response = array("Name"=>"", "numUsers"=>"", "numObs"=>"", "Description"=>"");
}else{
	$theData= mysqli_fetch_assoc($result);
	$response = array("Name"=>$theData['Name'], "numUsers"=>$theData['NumUsers'], "numObs"=>$theData['NumObs'], "Description"=>$theData['Description']);
}
$r = json_encode($response);
echo $r;
?>
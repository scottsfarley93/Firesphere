<?php
require_once("../database_access.php");
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
$Response = Array();
$sql1 = "SELECT * FROM `CharacteristicSummary` ORDER BY `Timestamp` DESC LIMIT 7";
$charSumRequest = mysqli_query($connection, $sql1);
if (!$charSumRequest){
	die("Query error: " . mysqli_error($connection));
}
$charSum = Array();
while ($row = mysqli_fetch_assoc($charSumRequest)){
	array_push($charSum, $row);
}
array_push($Response, $charSum);
$sql2 = "SELECT * FROM `FuelMoisture` ORDER By `Timestamp` DESC LIMIT 7";
$fmRequest = mysqli_query($connection, $sql2);
if(!$fmRequest){
	die("Query error: " . mysqli_error($connection));
}
$fmSum = Array();
while($row = mysqli_fetch_assoc($fmRequest)){
	array_push($fmSum, $row);
}
array_push($Response, $fmSum);
$sql2 = "SELECT * FROM `ForecastDelta` ORDER By `Timestamp` DESC LIMIT 7";
$forecastRequest = mysqli_query($connection, $sql2);
if(!$forecastRequest){
	die("Query error: " . mysqli_error($connection));
}
$forecast = Array();
while($row = mysqli_fetch_assoc($forecastRequest)){
	array_push($forecast, $row);
}
array_push($Response, $forecast);
echo json_encode($Response);
?>
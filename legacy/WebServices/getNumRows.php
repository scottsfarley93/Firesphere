<?php
require_once("../database_access.php");
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
$resultsArray = array();
$sql = "SELECT * FROM `Users`";
$result = mysqli_query($connection, $sql);
$result = mysqli_num_rows($result);
array_push($resultsArray, $result);
$sql = "SELECT * FROM `PhotoObservations`";
$result = mysqli_query($connection, $sql);
$result = mysqli_num_rows($result);
array_push($resultsArray, $result);
echo json_encode($resultsArray);
?>

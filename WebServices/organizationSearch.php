<?php
require_once('../database_access.php');
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
if(!$connection){
	die("Could not connect to database server.  Sever Error Message: " . mysqli_error($connection));
}
if(isset($_GET['term'])){
	$term = $_GET['term'];
}else{
	$term = " ";
}
$sql = "SELECT * FROM `Organizations`";
$result = mysqli_query($connection, $sql);
$Response = array();
$searchTermList =explode(" ", $term);
$searchTermsMetas = array();
foreach($searchTermList as $t){
	$m = metaphone($t);
	array_push($searchTermsMetas, $m);
}
while($row = mysqli_fetch_assoc($result)){
	$orgNameList = explode(" ", $row['Name']);
	foreach($orgNameList as $o){
		$orgMeta = metaphone($o);
		foreach($searchTermsMetas as $s){
			if($orgMeta === $s){
				if (!in_array($row, $Response)){
					array_push($Response, $row);
				}
			}
		}
	}
}
$res = json_encode($Response);
echo $res;

?>
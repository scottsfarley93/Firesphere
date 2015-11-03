<?php
require_once("../database_access.php");
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
if(isset($_POST['comments'])){
	$comments = $_POST['comments'];
}else{
	$comments = "";
}
$sql = "INSERT INTO `BetaComments` VALUES (Default, Default, '$comments')";
$result = mysqli_query($connection, $sql);
if(!$result){
	die("Couldnt Connect " . mysqli_error($connection));
}else{
	echo "1";
}

?>
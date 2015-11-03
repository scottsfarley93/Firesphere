<?php
$require_("../database_access.php");
$connection = mysqli_connect(HOST, USER, PASSWORD, NEW_DB);
$sql = "SET time_zone = '-08:00'";
$result = mysqli_query($connection, $sql);
echo  $result;
?>
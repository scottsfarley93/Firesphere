<?php
	require_once("../database_access.php");
	if (isset($_POST['one_load'])){
		$one_load = $_POST['one_lost'];
	}else{
		$one_load = 0;
	}
	if(isset($_POST['ten_load'])){
		$ten_load = $_POST['ten_load'];
	}else{
		$ten_load = $_POST['ten_load'];
	}
	if(isset($_POST['hund_load'])){
		$hund_load - $_POST['hund_load'];
	}else{
		$hund_load = 0;
	}
	if(isset($_POST['thou_load'])){
		$thou_load = $_POST['thou_load'];
	}else{
		$thou_load = 0;
	}
	if(isset($_POST['lw_load'])){
		$lw_load = $_POST['lw_load'];
	}else{
		$lw_load = 0;
	}
	if(isset($_POST['lh_load'])){
		$lh_laod = $_POST['lh_load'];
	}else{
		$lh_laod = 0;
	}
	if(isset($_POST['one_sav'])){
		$one_sav = $_POST['one_sav'];
	}else{
		$one_sav = 0;
	}
	if(isset($_POST['ten_sav'])){
		$ten_sav = $_POST['ten_sav'];
	}else{
		$ten_sav = 0;
	}
	if(isset($_POST['hund_sav'])){
		$hund_sav = $_POST['hund_sav'];
	}else{
		$hund_sav = 0;
	}
	if(isset($_POST['thou_sav'])){
		$thou_sav = $_POST['thou_sav'];
	}else{
		$thou_sav = 0;
	}
	if(isset($_POST['lw_sav'])){
		$lw_sav = $_POST['lw_sav'];
	}else{
		$lw_sav = 0;
	}
	if(isset($_POST['lh_sav'])){
		$lh_sav = $_POSt['lh_sav'];
	}else{
		$lh_sav = 0;
	}
	if(isset($_POST['mxt'])){
		$mxt = $_POST['mxt'];
	}else{
		$mxt = 0;
	}
	if (isset($_POST['depth'])){
		$depth = $_POST['depth'];
	}else{
		$depth = 0;
	}
	if(isset($_POST['heat'])){
		$heat = $_POST['heat'];
	}else{
		$heat = 8000;
	}
	if(isset($_POST['waf'])){
		$waf = $_POST['waf'];
	}else{
		$waf = 0;
	}
	if(isset($_POST['name'])){
		$name = $_POST['name'];
	}else{
		$name = "";
	}
	if(isset($_POST['desc'])){
		$desc = $_POST['desc'];
	}else{
		$desc = "";
	}
	if($name != ""){
		$sql = "";
		
	}else{
		die("You must provide a name for the fuel model.");
	}
	
?>
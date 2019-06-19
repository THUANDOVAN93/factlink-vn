<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$h_pckid = $_POST['h_pckid'];
	$t_name_en = $_POST['t_name_en'];
	$t_month = $_POST['t_month'];
	$t_type = $_POST['t_type'];

	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql1 = "update flc_package set pck_name_en = '$t_name_en', pck_month = '$t_month', pck_type = '$t_type' where pck_id = '$h_pckid';";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_package.php?start=0\">";
	exit();
?>

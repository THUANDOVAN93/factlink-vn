<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);

	$h_admid = $_POST['h_admid'];
	$h_catid = $_POST['h_catid'];
	$t_name_en = $_POST['t_name_en'];
	$t_name_jp = $_POST['t_name_jp'];
	$t_name_vn = $_POST['t_name_vn'];
	$t_des_en = $_POST['t_des_en'];
	$t_des_jp = $_POST['t_des_jp'];
	$t_des_vn = $_POST['t_des_vn'];
	$t_pos = $_POST['t_pos'];
	$t_under = $_POST['t_under'];

	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	if ($t_pos != 's') { $t_under = ""; }

	$sql1 = "update flc_category set cat_name_en = '$t_name_en', cat_name_jp = '$t_name_jp', cat_name_vn = '$t_name_vn', cat_des_en = '$t_des_en', cat_des_jp = '$t_des_jp', cat_des_vn = '$t_des_vn', cat_pos = '$t_pos', cat_under = '$t_under' where cat_id = '$h_catid';";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_category.php?start=0\">";
	exit();
?>

<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$t_name = $_POST['t_name'];
	$t_detail_en = $_POST['t_detail_en'];
	$t_detail_jp = $_POST['t_detail_jp'];
	$t_detail_vn = $_POST['t_detail_vn'];

	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql1 = "insert into flc_upinfo (uif_name, uif_detail_en, uif_detail_jp, uif_detail_vn, uif_date)
					values ('$t_name', '$t_detail_en', '$t_detail_jp', '$t_detail_vn', '$nowdate');";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_updateinfo.php?start=0\">";
	exit();
?>

<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$t_name_en = $_POST['t_name_en'];
	$t_name_jp = $_POST['t_name_jp'];
	$t_name_vn = $_POST['t_name_vn'];

	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql1 = "insert into flc_news_editor (nwe_name_en, nwe_name_jp, nwe_name_vn) values ('$t_name_en', '$t_name_jp', '$t_name_vn');";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_news_editor.php?start=0\">";
	exit();
?>

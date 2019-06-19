<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$h_clfid = $_POST['h_clfid'];
	$t_name_en = $_POST['t_name_en'];
	$t_code = $_POST['t_code'];

	if ($_SESSION['d'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql1 = "update flc_color_font set clf_name_en = '$t_name_en', clf_code = '$t_code' where clf_id = '$h_clfid';";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_fontcolor.php?start=0\">";
	exit();
?>

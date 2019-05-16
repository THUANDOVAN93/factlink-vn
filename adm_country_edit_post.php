<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	
	
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$h_ctyid = $_POST['h_ctyid'];
	$t_name_en = $_POST['t_name_en'];
	$t_name_jp = $_POST['t_name_jp'];
	$t_name_vn = $_POST['t_name_vn'];

	if ($_SESSION['vd'] != $h_admid) {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">";
		exit();
	}

	$sql1 = "update flc_country set cty_name_en = '$t_name_en', cty_name_jp = '$t_name_jp', cty_name_vn = '$t_name_vn' where cty_id = '$h_ctyid';";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_country.php?start=0\">";
	exit();
	
?>

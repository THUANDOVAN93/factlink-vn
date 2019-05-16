<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	mysql_query("use $db_name;");

	$t_pospage = $_POST['t_pospage'];
	$t_posside = $_POST['t_posside'];

	$_SESSION['vsearchbulpage'] = $t_pospage;
	$_SESSION['vsearchbulside'] = $t_posside;

	if ($t_pospage != "") {

		if ($t_posside != '') { $sql = "select * from flc_bulletin where bul_page = '$t_pospage' and bul_side = '$t_posside'"; }
		else { $sql = "select * from flc_bulletin where bul_page = '$t_pospage'"; }

	} else { $sql = "select * from flc_bulletin where bul_id = ''"; }

	$_SESSION['vsearchbul'] = $sql;

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_bulletin.php?start=0\">";
	exit();
?>

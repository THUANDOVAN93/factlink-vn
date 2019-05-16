<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_type = $_POST['h_type'];
	$t_pospage = $_POST['t_pospage'];
	$t_posside = $_POST['t_posside'];

	if ($h_type == 'spc') {

			if ($t_pospage != "") { $sql = "select * from flc_banner where ban_type = 'spc' and ban_page = '$t_pospage'"; }
			else { $sql = "select * from flc_banner where ban_type = 'spc' and ban_id = ''"; }

			$_SESSION['vsearchbanspc'] = $sql;
			$_SESSION['vsearchbanspcpage'] = $t_pospage;

	} else {

		if ($t_pospage != "") {

			if ($t_posside != '') { $sql = "select * from flc_banner where ban_type = 'bsc' and ban_page = '$t_pospage' and ban_side = '$t_posside'"; }
			else { $sql = "select * from flc_banner where ban_type = 'bsc' and ban_page = '$t_pospage'"; }

		} else { $sql = "select * from flc_banner where ban_type = 'bsc' and ban_id = ''"; }

		$_SESSION['vsearchbanbsc'] = $sql;
		$_SESSION['vsearchbanbscpage'] = $t_pospage;
		$_SESSION['vsearchbanbscside'] = $t_posside;

	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_banner.php?start=0&type=$h_type\">";
	exit();
?>

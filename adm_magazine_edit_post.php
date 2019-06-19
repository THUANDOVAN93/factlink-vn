<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$h_magid = $_POST['h_magid'];
	$t_subject = $_POST['t_subject'];
	$t_detail = $_POST['t_detail'];
	
	/* Convert LineBreak character to string [br] */
	$t_subject = str_replace('\\r\\n','[br]',($t_subject));
	$t_detail = str_replace('\\r\\n','[br]',($t_detail));

	if ($_SESSION['d'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql1 = "update flc_magazine set mag_subject = '$t_subject', mag_detail = '$t_detail', mag_date = '$nowdate', mag_time = '$nowtime' where mag_id = '$h_magid';";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_magazine.php?start=0\">";
	exit();
?>

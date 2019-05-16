<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$h_insid = $_POST['h_insid'];
	$t_int1 = $_POST['t_int1'];
	$t_int2 = $_POST['t_int2'];
	$t_int3 = $_POST['t_int3'];

	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql1 = "update flc_introduce_set set ins_1 = '$t_int1', ins_2 = '$t_int2', ins_3 = '$t_int3', ins_date = '$nowdate' where ins_id = '$h_insid';";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_introduce_set.php?start=0\">";
	exit();
?>

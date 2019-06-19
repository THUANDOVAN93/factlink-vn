<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$t_name_en = $_POST['t_name_en'];
	$t_name_file = $_POST['t_name_file'];
	$t_clf = $_POST['t_clf'];
	$t_tpk = $_POST['t_tpk'];

	if ($_SESSION['d'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql1 = "insert into flc_template_main (tpm_name_en, tpm_name_file, tpk_id, clf_id) values ('$t_name_en', '$t_name_file', '$t_tpk', '$t_clf');";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_tempmain.php?start=0\">";
	exit();
?>

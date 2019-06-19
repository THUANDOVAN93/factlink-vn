<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$h_uifid = $_POST['h_uifid'];
	$t_name = $_POST['t_name'];
	$t_detail_en = $_POST['t_detail_en'];
	$t_detail_jp = $_POST['t_detail_jp'];
	$t_detail_vn = $_POST['t_detail_vn'];
	
		/* Convert LineBreak character to string [br] */
	$t_name = str_replace('\\r\\n','[br]',($t_name));
	$t_detail_en = str_replace('\\r\\n','[br]',($t_detail_en));
	$t_detail_jp = str_replace('\\r\\n','[br]',($t_detail_jp));
	$t_detail_vn = str_replace('\\r\\n','[br]',($t_detail_vn));

	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql1 = "update flc_upinfo set uif_name = '$t_name', uif_detail_en = '$t_detail_en', uif_detail_jp = '$t_detail_jp', uif_detail_vn = '$t_detail_vn', uif_date = '$nowdate' where uif_id = '$h_uifid';";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_updateinfo.php?start=0\">";
	exit();
?>

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

	$sql0 = "select * from flc_country order by cty_order limit 0,1;";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $ctyorder = $dbarr0['cty_order'] + 1; } if ($ctyorder == '') { $ctyorder = 1; }

	$sql1 = "insert into flc_country (cty_name_en, cty_name_jp, cty_name_vn, cty_order) values ('$t_name_en', '$t_name_jp', '$t_name_vn', '$ctyorder');";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_country.php?start=0\">";
	exit();
?>

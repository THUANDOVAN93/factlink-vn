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
	$t_pos = $_POST['t_pos'];
	$t_under = $_POST['t_under'];
	$t_des_en = $_POST['t_des_en'];
	$t_des_jp = $_POST['t_des_jp'];
	$t_des_vn = $_POST['t_des_vn'];

	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql0 = "select * from flc_category order by cat_order DESC  limit 0,1;";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $catorder = $dbarr0['cat_order'] + 1; } if ($catorder == '') { $catorder = 1; }

	if ($t_pos != 's') { $t_under = ""; }

	$sql1 = "insert into flc_category (cat_name_en, cat_name_jp, cat_name_vn, cat_des_en, cat_des_jp, cat_des_vn, cat_pos, cat_under, cat_order) values ('$t_name_en', '$t_name_jp', '$t_name_vn', '$t_des_en', '$t_des_jp', '$t_des_vn', '$t_pos', '$t_under', '$catorder');";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_category.php?start=0\">";
	exit();
?>

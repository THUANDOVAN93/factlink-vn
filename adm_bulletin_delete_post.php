<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$h_bulid = $_POST['h_bulid'];
	$h_bulfiletype = $_POST['h_bulfiletype'];
	$imgfile = "images/bulletin/".$h_bulid.".".$h_bulfiletype;

	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql0 = "select * from flc_bulletin where bul_id = '$h_bulid';";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $bulsort = $dbarr0['bul_sort']; $bulpage = $dbarr0['bul_page']; $bulside = $dbarr0['bul_side']; }

	$sql2 = "select * from flc_bulletin where bul_page = '$bulpage' and bul_side = '$bulside' and bul_sort > '$bulsort' order by bul_sort asc;";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {

		$upbulid = $dbarr2['bul_id'];
		$newbulsort = $dbarr2['bul_sort'] - 1;

		$sql3 = "update flc_bulletin set bul_sort = '$newbulsort' where bul_id = '$upbulid';";
		$result3 = mysql_query($sql3);

	}

	$sql1 = "delete from flc_bulletin where bul_id = '$h_bulid';";
	$result1 = mysql_query($sql1);

	if (file_exists($imgfile)) { unlink($imgfile); }

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_bulletin.php?start=0\">";
	exit();
?>

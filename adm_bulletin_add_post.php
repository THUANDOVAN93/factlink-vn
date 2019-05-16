<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);

	mysql_query("use $db_name;");

	$h_admid = $_POST['h_admid'];
	$t_name = $_POST['t_name'];
	$t_detail_en = $_POST['t_detail_en'];
	$t_detail_jp = $_POST['t_detail_jp'];
	$t_detail_vn = $_POST['t_detail_vn'];
	$t_image = $_FILES['t_image'];
	$t_filetype = imagetype($_FILES['t_image']['type']);
	$t_width = "180";
	$t_link = $_POST['t_link'];
	$t_pospage = $_POST['t_pospage'];
	$t_posside = $_POST['t_posside'];

	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql0 = "select * from flc_bulletin where bul_page = '$t_pospage' and bul_side = '$t_posside' order by bul_sort desc limit 0,1;";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $bulsort = $dbarr0['bul_sort'] + 1; } if ($bulsort == '') { $bulsort = 1; }

	$sql1 = "insert into flc_bulletin (bul_name, bul_text_en, bul_text_jp, bul_text_vn, bul_link, bul_page, bul_side, bul_date, bul_sort)
					values ('$t_name', '$t_detail_en', '$t_detail_jp', '$t_detail_vn', '$t_link', '$t_pospage', '$t_posside', '$nowdate', '$bulsort');";
	$result1 = mysql_query($sql1);

	$sql2 = "select * from flc_bulletin order by bul_id desc limit 0,1;";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) { $bulid = $dbarr2['bul_id']; }

	if ($_FILES['t_image']['size'] > 0) {
		$newfile = $bulid.".".$t_filetype;
		$imgpath = "images/bulletin/".$newfile;
		move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath);
		$sql4 = "update flc_bulletin set bul_image = 't', bul_filetype = '$t_filetype', bul_width = '$t_width' where bul_id = '$bulid';";
		$result4 = mysql_query($sql4);
	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_bulletin.php?start=0\">";
	exit();
?>

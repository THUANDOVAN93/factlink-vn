<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	mysql_query("use $db_name;");

	$h_admid = $_POST['h_admid'];
	$h_bulid = $_POST['h_bulid'];
	$h_bulsort = $_POST['h_bulsort'];
	$h_pospage = $_POST['h_pospage'];
	$h_posside = $_POST['h_posside'];
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

	if ($h_pospage != $t_pospage || $h_posside != $t_posside) {

		$sql0 = "select * from flc_bulletin where bul_page = '$t_pospage' and bul_side = '$t_posside' order by bul_sort desc limit 0,1;";
		$result0 = mysql_query($sql0);
		while ($dbarr0 = mysql_fetch_array($result0)) { $bulsort = $dbarr0['bul_sort'] + 1; } if ($bulsort == '') { $bulsort = 1; }

		$sql2 = "select * from flc_bulletin where bul_page = '$h_pospage' and bul_side = '$h_posside' and bul_sort > '$h_bulsort' order by bul_sort asc;";
		$result2 = mysql_query($sql2);
		while ($dbarr2 = mysql_fetch_array($result2)) {

			$upbulid = $dbarr2['bul_id'];
			$newbulsort = $dbarr2['bul_sort'] - 1;

			$sql3 = "update flc_bulletin set bul_sort = '$newbulsort' where bul_id = '$upbulid';";
			$result3 = mysql_query($sql3);

		}

		$sql5 = "update flc_bulletin set bul_sort = '$bulsort' where bul_id = '$h_bulid';";
		$result5 = mysql_query($sql5);

	}

	$sql1 = "update flc_bulletin set bul_name = '$t_name', bul_text_en = '$t_detail_en', bul_text_jp = '$t_detail_jp', bul_text_vn = '$t_detail_vn', bul_link = '$t_link',
					bul_page = '$t_pospage', bul_side = '$t_posside' where bul_id = '$h_bulid';";
	$result1 = mysql_query($sql1);

	if ($_FILES['t_image']['size'] > 0) {
		$newfile = $h_bulid.".".$t_filetype;
		$imgpath = "images/bulletin/".$newfile;
		move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath);
		$sql4 = "update flc_bulletin set bul_image = 't', bul_filetype = '$t_filetype', bul_width = '$t_width' where bul_id = '$h_bulid';";
		$result4 = mysql_query($sql4);
	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_bulletin.php?start=0\">";
	exit();
?>

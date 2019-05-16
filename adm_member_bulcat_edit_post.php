<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$h_memid = $_POST['h_memid'];
	$h_bucid = $_POST['h_bucid'];
	$h_memcate = $_POST['h_memcate'];
	$h_mempackage = $_POST['h_mempackage'];
	$t_name = addslashes($_POST['t_name']);
	$t_detail_en = addslashes($_POST['t_detail_en']);
	$t_detail_jp = addslashes($_POST['t_detail_jp']);
	$t_detail_vn = addslashes($_POST['t_detail_vn']);
	$t_image = $_FILES['t_image'];
	$t_filetype = imagetype($_FILES['t_image']['type']);
	$t_width = "180";
	$t_link = $_POST['t_link'];
	$t_pospage = "sch";
	$t_posside = "r";

	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql1 = "update flc_bulletin_cate set buc_name = '$t_name', buc_text_en = '$t_detail_en', buc_text_jp = '$t_detail_jp', buc_text_vn = '$t_detail_vn', buc_link = '$t_link',
					buc_page = '$t_pospage', buc_side = '$t_posside' where buc_id = '$h_bucid';";
	$result1 = mysql_query($sql1);

	if ($_FILES['t_image']['size'] > 0) {
		$newfile = "C".$h_bucid.".".$t_filetype;
		$imgpath = "images/bulletin/".$newfile;
		move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath);
		$sql4 = "update flc_bulletin_cate set buc_image = 't', buc_filetype = '$t_filetype', buc_width = '$t_width' where buc_id = '$h_bucid';";
		$result4 = mysql_query($sql4);
	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_view.php?id=$h_memid\">";
	exit();
?>

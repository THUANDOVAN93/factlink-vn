<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$h_memid = $_POST['h_memid'];
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

	if ($h_mempackage != '') {

		if ($h_memcate != '') {

			$sql0 = "select * from flc_bulletin_cate where cat_id = '$h_memcate' and buc_page = '$t_pospage' and buc_side = '$t_posside' order by buc_sort desc limit 0,1;";
			$result0 = mysql_query($sql0);
			while ($dbarr0 = mysql_fetch_array($result0)) { $bucsort = $dbarr0['buc_sort'] + 1; } if ($bucsort == '') { $bucsort = 1; }

		} else { $bucsort = 0; $bucstatus = "d"; }

	} else { $bucsort = 0; $bucstatus = "d"; }

	$sql1 = "insert into flc_bulletin_cate (mem_id, cat_id, buc_name, buc_text_en, buc_text_jp, buc_text_vn, buc_link, buc_page, buc_side, buc_date, buc_sort, buc_status)
					values ('$h_memid', '$h_memcate', '$t_name', '$t_detail_en', '$t_detail_jp', '$t_detail_vn', '$t_link', '$t_pospage', 'r', '$nowdate', '$bucsort', '$bucstatus');";
	$result1 = mysql_query($sql1);

	$sql2 = "select * from flc_bulletin_cate order by buc_id desc limit 0,1;";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) { $bucid = $dbarr2['buc_id']; }

	if ($_FILES['t_image']['size'] > 0) {
		$newfile = "C".$bucid.".".$t_filetype;
		$imgpath = "images/bulletin/".$newfile;
		move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath);
		$sql4 = "update flc_bulletin_cate set buc_image = 't', buc_filetype = '$t_filetype', buc_width = '$t_width' where buc_id = '$bucid';";
		$result4 = mysql_query($sql4);
	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_view.php?id=$h_memid\">";
	exit();
?>

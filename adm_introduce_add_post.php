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
	$t_title_en = $_POST['t_title_en'];
	$t_title_jp = $_POST['t_title_jp'];
	$t_title_vn = $_POST['t_title_vn'];
	$t_detail_en = $_POST['t_detail_en'];
	$t_detail_jp = $_POST['t_detail_jp'];
	$t_detail_vn = $_POST['t_detail_vn'];
	$t_link = $_POST['t_link'];
	$t_image = $_FILES['t_image'];
	$t_imagewidth = 160;

	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql1 = "insert into flc_introduce (int_name_en, int_name_jp, int_name_vn, int_title_en, int_title_jp, int_title_vn, int_detail_en, int_detail_jp, int_detail_vn,
					int_link, int_date) values ('$t_name_en', '$t_name_jp', '$t_name_vn', '$t_title_en', '$t_title_jp', '$t_title_vn', '$t_detail_en', '$t_detail_jp', '$t_detail_vn',
					'$t_link', '$nowdate');";
	$result1 = mysql_query($sql1);

	$sql3 = "select * from flc_introduce order by int_id desc limit 0,1;";
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) { $intid = $dbarr3['int_id']; }

	if ($_FILES['t_image']['size'] > 0) {
		$newfile = $intid."-T.jpg";
		$imgpath = "images/introduce/".$newfile;
		move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth == '') { $t_imagewidth = $imgdms[0]; }
		$sql4 = "update flc_introduce set int_image = 't', int_image_width = '$t_imagewidth' where int_id = '$intid';";
		$result4 = mysql_query($sql4);
	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_introduce.php?start=0\">";
	exit();
?>

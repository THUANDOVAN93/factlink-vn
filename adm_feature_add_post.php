<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$t_title_en = $_POST['t_title_en'];
	$t_title_jp = $_POST['t_title_jp'];
	$t_title_vn = $_POST['t_title_vn'];
	$t_detail_en = $_POST['t_detail_en'];
	$t_detail_jp = $_POST['t_detail_jp'];
	$t_detail_vn = $_POST['t_detail_vn'];
	$t_image = $_FILES['t_image'];
	$t_imagewidth = $_POST['t_imagewidth'];
	$t_imagelink = $_POST['t_imagelink'];
	$t_detail_en1 = $_POST['t_detail_en1'];
	$t_detail_jp1 = $_POST['t_detail_jp1'];
	$t_detail_vn1 = $_POST['t_detail_vn1'];
	$t_image1 = $_FILES['t_image1'];
	$t_imagewidth1 = $_POST['t_imagewidth1'];
	$t_imagelink1 = $_POST['t_imagelink1'];
	$t_imageside1 = $_POST['t_imageside1'];
	$t_detail_en2 = $_POST['t_detail_en2'];
	$t_detail_jp2 = $_POST['t_detail_jp2'];
	$t_detail_vn2 = $_POST['t_detail_vn2'];
	$t_image2 = $_FILES['t_image2'];
	$t_imagewidth2 = $_POST['t_imagewidth2'];
	$t_imagelink2 = $_POST['t_imagelink2'];
	$t_imageside2 = $_POST['t_imageside2'];
	$t_link = $_POST['t_link'];

	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql1 = "insert into flc_feature (fea_title_en, fea_title_jp, fea_title_vn, fea_detail_en, fea_detail_jp, fea_detail_vn, fea_detail1_en, fea_detail1_jp, fea_detail1_vn,
					fea_detail2_en, fea_detail2_jp, fea_detail2_vn, fea_link, fea_date)
					values ('$t_title_en', '$t_title_jp', '$t_title_vn', '$t_detail_en', '$t_detail_jp', '$t_detail_vn', '$t_detail_en1', '$t_detail_jp1', '$t_detail_vn1',
					'$t_detail_en2', '$t_detail_jp2', '$t_detail_vn2', '$t_link', '$nowdate');";
	$result1 = mysql_query($sql1)or die(mysql_error());


	$sql3 = "select * from flc_feature order by fea_id desc limit 0,1;";
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) { $feaid = $dbarr3['fea_id']; }

	if ($_FILES['t_image']['size'] > 0) {
		$newfile = $feaid."-F.jpg";
		$imgpath = "images/feature/".$newfile;
		move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth == '') { $t_imagewidth = $imgdms[0]; }
		$sql4 = "update flc_feature set fea_image = 't', fea_image_width = '$t_imagewidth', fea_image_link = '$t_imagelink' where fea_id = '$feaid';";
		$result4 = mysql_query($sql4);
	}

	if ($_FILES['t_image1']['size'] > 0) {
		$newfile = $feaid."-F1.jpg";
		$imgpath = "images/feature/".$newfile;
		move_uploaded_file($_FILES['t_image1']['tmp_name'], $imgpath);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth1 == '') { $t_imagewidth1 = $imgdms[0]; }
		$sql4 = "update flc_feature set fea_image1 = 't', fea_image1_width = '$t_imagewidth1', fea_image1_link = '$t_imagelink1', fea_image1_side = '$t_imageside1' where fea_id = '$feaid';";
		$result4 = mysql_query($sql4);
	}

	if ($_FILES['t_image2']['size'] > 0) {
		$newfile = $feaid."-F2.jpg";
		$imgpath = "images/feature/".$newfile;
		move_uploaded_file($_FILES['t_image2']['tmp_name'], $imgpath);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth2 == '') { $t_imagewidth2 = $imgdms[0]; }
		$sql4 = "update flc_feature set fea_image2 = 't', fea_image2_width = '$t_imagewidth2', fea_image2_link = '$t_imagelink2', fea_image2_side = '$t_imageside2' where fea_id = '$feaid';";
		$result4 = mysql_query($sql4);
	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_feature.php?start=0\">";
	exit();
?>

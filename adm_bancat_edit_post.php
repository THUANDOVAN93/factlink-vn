<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);	
	mysql_query("use $db_name;");
	
	
	$h_admid = $_POST['h_admid'];
	$h_bacid = $_POST['h_bacid'];
	$h_bactype = $_POST['h_bactype'];
	$h_bacpackage = $_POST['h_bacpackage'];
	$t_name = $_POST['t_name'];
	$t_member = $_POST['t_member'];
	$t_image_en = $_FILES['t_image_en'];
	$t_filetype_en = imagetype($_FILES['t_image_en']['type']);
//	$t_filetype_en = imagetype2($_FILES['t_image_en']['type']);
	$t_width_en = "180";
	$t_height_en = $_POST['t_height_en'];
	$t_link_en = $_POST['t_link_en'];
	$t_image_jp = $_FILES['t_image_jp'];
	$t_filetype_jp = imagetype($_FILES['t_image_jp']['type']);
//	$t_filetype_jp = imagetype2($_FILES['t_image_jp']['type']);
	$t_width_jp = "180";
	$t_height_jp = $_POST['t_height_jp'];
	$t_link_jp = $_POST['t_link_jp'];
	$t_image_vn = $_FILES['t_image_vn'];
	$t_filetype_vn = imagetype($_FILES['t_image_vn']['type']);
//	$t_filetype_vn = imagetype2($_FILES['t_image_vn']['type']);
	$t_width_vn = "180";
	$t_height_vn = $_POST['t_height_vn'];
	$t_link_vn = $_POST['t_link_vn'];
	$t_pospage = "sch";
	$t_pospage = "";
	$t_cat = $_POST['t_cat'];
	$t_package = $_POST['t_package'];
	$t_day = $_POST['t_day'];
	$t_month = $_POST['t_month'];
	$t_year = $_POST['t_year'];

	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql6 = "select * from flc_banner_cate where bac_id = '$h_bacid';";
	$result6 = mysql_query($sql6);
	while ($dbarr6 = mysql_fetch_array($result6)) { $bacsort = $dbarr6['bac_sort']; }

	if ($t_day == '' || $t_month == '' || $t_year == '') { $t_startdate = ""; } else { $startdate = $t_day." ".$t_month." ".$t_year; }

	if ($t_package != '') {

		// Package
		$sql3 = "select * from flc_package where pck_id = '$t_package';";
		$result3 = mysql_query($sql3);
		while ($dbarr3 = mysql_fetch_array($result3)) { $pckmonth = $dbarr3['pck_month']; }
		//while ($dbarr3 = mysql_fetch_array($result3)) { $pckday = $dbarr3['pck_day']; }

		// Expire
		$gap = explode(" ", $startdate);
		$gap[1] = mcvsubtonum($gap[1]);
		$endyear = $gap[2];

		$endmonth = $gap[1] + $pckmonth;

		for ($em=$endmonth;$em>12;$em-12) {
			$endmonth = $endmonth - 12;
			$endyear = $endyear + 1;
			$em = $endmonth;
		}

		$mlimit = explode("-",monthcal($endmonth, $endyear));
		if ($gap[0] > $mlimit[2]) { $endday = $mlimit[2]; } else { $endday = $gap[0]; }

		$enddate = addzero2($endday)." ".mcvnumtosub($endmonth)." ".$endyear;

		// Pre expire
		$preyear = $endyear;
		$premonth = $endmonth - 1; // Warning 1 month before expire
		if ($premonth < 1) { $premonth = 12; $preyear = $preyear - 1; }

		$mlimit = explode("-",monthcal($premonth, $preyear));
		if ($gap[0] > $mlimit[2]) { $preday = $mlimit[2]; } else { $preday = $gap[0]; }

		$preenddate = addzero2($preday)." ".mcvnumtosub($premonth)." ".$preyear;

		/*
		// Expire date
		$len = $pckday;
		$gap = explode(" ", $startdate);
		$gap[1] = mcvsubtonum($gap[1]);
		$gap[3] = "";
		$end = expcal($gap[0], $gap[1], $gap[2], $gap[3], $len);

		$tmpend = explode(" ", $end);
		$tmpend[1] = mcvnumtosub($tmpend[1]);
		$tmpend[0] = addzero2($tmpend[0]);

		$enddate = $tmpend[0]." ".$tmpend[1]." ".$tmpend[2];

		// Pre-Expire date
		$len = $pckday - 30;
		$gap = explode(" ", $startdate);
		$gap[1] = mcvsubtonum($gap[1]);
		$gap[3] = "";
		$preend = expcal($gap[0], $gap[1], $gap[2], $gap[3], $len);

		$tmppreend = explode(" ", $preend);
		$tmppreend[1] = mcvnumtosub($tmppreend[1]);
		$tmppreend[0] = addzero2($tmppreend[0]);

		$preenddate = $tmppreend[0]." ".$tmppreend[1]." ".$tmppreend[2];
		*/

		if ($bacsort == '0') {

			$sql0 = "select * from flc_banner_cate where bac_type = '$h_bactype' order by bac_sort desc limit 0,1;";
			$result0 = mysql_query($sql0);
			while ($dbarr0 = mysql_fetch_array($result0)) { $bacsort = $dbarr0['bac_sort'] + 1; }

		}

	} else {

		$sql2 = "select * from flc_banner_cate where bac_type = '$h_bactype' and bac_sort > '$bacsort' order by bac_sort asc;";
		$result2 = mysql_query($sql2);
		while ($dbarr2 = mysql_fetch_array($result2)) {

			$upbacid = $dbarr2['bac_id'];
			$newbacsort = $dbarr2['bac_sort'] - 1;

			$sql3 = "update flc_banner_cate set bac_sort = '$newbacsort' where bac_id = '$upbacid';";
			$result3 = mysql_query($sql3);

		}

		$bacsort = "0";
		$startdate = "";
		$bacstatus = "d";

	}

	if ($h_bactype == 'spc') {

		$sql5 = "select * from flc_banner_cate where bac_type = 'spc' and bac_page = '$t_pospage' and cat_id = '$t_cat' and bac_status = '';";
		$result5 = mysql_query($sql5);
		while ($dbarr5 = mysql_fetch_array($result5)) { $spccheck = "t"; }

		if ($spccheck == 't') { $bacstatus = "d"; }

		$t_width_en = "450"; $t_height_en = "120";
		$t_width_jp = "450"; $t_height_jp = "120";
		$t_width_vn = "450"; $t_height_vn = "120";
		$bacsort = "0";

	}

	$sql1 = "update flc_banner_cate set mem_id = '$t_member', cat_id = '$t_cat', bac_name = '$t_name', bac_page = '$t_pospage', bac_side = '$t_posside', bac_link_en = '$t_link_en', bac_link_jp = '$t_link_jp', bac_link_vn = '$t_link_vn',
					bac_package = '$t_package', bac_startdate = '$startdate', bac_enddate = '$enddate', bac_preenddate = '$preenddate', bac_sort = '$bacsort', bac_status = '$bacstatus' where bac_id = '$h_bacid';";
	$result1 = mysql_query($sql1);

	$sql2 = "select * from flc_banner_cate order by bac_id desc limit 0,1;";
	$result2 = mysql_query($sql2);
	$t_filetype=imagetype($_FILES['t_image_en']['type']);

	while ($dbarr2 = mysql_fetch_array($result2)) { $bacid = $dbarr2['bac_id']; }

	if ($_FILES['t_image_en']['size'] > 0) {
		
		echo $newfile = "C".$h_bacid."_en.".$t_filetype;
		$imgpath = "images/banner/".$newfile;
		
		if(!move_uploaded_file($_FILES['t_image_en']['tmp_name'], $imgpath)){
			exit("Upload failed: $imgpath");
		}
		
		$sql4 = "update flc_banner_cate set bac_filetype_en = '$t_filetype_en', bac_width_en = '$t_width_en', bac_height_en = '$t_height_en' where bac_id = '$h_bacid';";
		$result4 = mysql_query($sql4);
	}

	if ($_FILES['t_image_jp']['size'] > 0) {
		$newfile = "C".$h_bacid."_jp.".$t_filetype;
		$imgpath = "images/banner/".$newfile;
		
		if(!move_uploaded_file($_FILES['t_image_jp']['tmp_name'], $imgpath)){
			exit("Upload failed: $imgpath");
		}
		
		$sql4 = "update flc_banner_cate set bac_filetype_jp = '$t_filetype_jp', bac_width_jp = '$t_width_jp', bac_height_jp = '$t_height_jp' where bac_id = '$h_bacid';";
		$result4 = mysql_query($sql4);
	}

	if ($_FILES['t_image_vn']['size'] > 0) {
		$newfile = "C".$h_bacid."_vn.".$t_filetype;
		$imgpath = "images/banner/".$newfile;
		
		if(!move_uploaded_file($_FILES['t_image_vn']['tmp_name'], $imgpath)){
			exit("Upload failed: $imgpath");
		}
		
		$sql4 = "update flc_banner_cate set bac_filetype_vn = '$t_filetype_vn', bac_width_vn = '$t_width_vn', bac_height_vn = '$t_height_vn' where bac_id = '$h_bacid';";
		$result4 = mysql_query($sql4);
	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_bancat.php?type=$h_bactype&start=0\">";
	exit();
?>

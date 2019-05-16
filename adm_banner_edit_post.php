<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
		
	mysql_query("use $db_name;");

	$h_admid = $_POST['h_admid'];
	$h_banid = $_POST['h_banid'];
	$h_bantype = $_POST['h_bantype'];
	$h_pospage = $_POST['h_pospage'];
	$h_posside = $_POST['h_posside'];
	$h_banpackage = $_POST['h_banpackage'];
	$t_name = $_POST['t_name'];
	$t_member = $_POST['t_member'];
	$t_image_en = $_FILES['t_image_en'];
	$t_filetype_en = imagetype($_FILES['t_image_en']['type']);
	$t_width_en = "180";
	$t_height_en = $_POST['t_height_en'];
	$t_link_en = $_POST['t_link_en'];
	$t_image_jp = $_FILES['t_image_jp'];
	$t_filetype_jp = imagetype($_FILES['t_image_jp']['type']);
	$t_width_jp = "180";
	$t_height_jp = $_POST['t_height_jp'];
	$t_link_jp = $_POST['t_link_jp'];
	$t_image_vn = $_FILES['t_image_vn'];
	$t_filetype_vn = imagetype($_FILES['t_image_vn']['type']);
	$t_width_vn = "180";
	$t_height_vn = $_POST['t_height_vn'];
	$t_link_vn = $_POST['t_link_vn'];
	$t_pospage = $_POST['t_pospage'];
	$t_posside = $_POST['t_posside'];
	$t_package = $_POST['t_package'];
	$t_day = $_POST['t_day'];
	$t_month = $_POST['t_month'];
	$t_year = $_POST['t_year'];

	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql6 = "select * from flc_banner where ban_id = '$h_banid';";
	$result6 = mysql_query($sql6);
	while ($dbarr6 = mysql_fetch_array($result6)) { $bansort = $dbarr6['ban_sort']; }

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

		$checkend = $tmpend[2]."-".addzero2($tmpend[1])."-".addzero2($tmpend[0])." 00:00:00";
		if ($checkend <= date("Y-m-d H:i:s")) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_banner.php?type=$h_bantype&start=0\">"; exit(); }

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

		$checkpreend = $tmppreend[2]."-".addzero2($tmppreend[1])."-".addzero2($tmppreend[0])." 00:00:00";
		if ($checkpreend <= date("Y-m-d H:i:s")) { $warning = "t"; } else { $warning = ""; }

		$tmppreend[1] = mcvnumtosub($tmppreend[1]);
		$tmppreend[0] = addzero2($tmppreend[0]);

		$preenddate = $tmppreend[0]." ".$tmppreend[1]." ".$tmppreend[2];
		*/

		if ($bansort != '0') {

			if ($h_pospage != $t_pospage || $h_posside != $t_posside) {

				$sql2 = "select * from flc_banner where ban_type = '$h_bantype' and ban_page = '$h_pospage' and ban_side = '$h_posside' and ban_sort > '$bansort' order by ban_sort asc;";
				$result2 = mysql_query($sql2);
				while ($dbarr2 = mysql_fetch_array($result2)) {

					$upbanid = $dbarr2['ban_id'];
					$newbansort = $dbarr2['ban_sort'] - 1;

					$sql3 = "update flc_banner set ban_sort = '$newbansort' where ban_id = '$upbanid';";
					$result3 = mysql_query($sql3);

				}

				$sql0 = "select * from flc_banner where ban_type = '$h_bantype' and ban_page = '$t_pospage' and ban_side = '$t_posside' order by ban_sort desc limit 0,1;";
				$result0 = mysql_query($sql0);
				while ($dbarr0 = mysql_fetch_array($result0)) { $bansort = $dbarr0['ban_sort'] + 1; } if ($bansort == '') { $bansort = 1; }

			}

		} else {

			$sql0 = "select * from flc_banner where ban_type = '$h_bantype' and ban_page = '$t_pospage' and ban_side = '$t_posside' order by ban_sort desc limit 0,1;";
			$result0 = mysql_query($sql0);
			while ($dbarr0 = mysql_fetch_array($result0)) { $bansort = $dbarr0['ban_sort'] + 1; } if ($bansort == '') { $bansort = 1; }

		}

	} else {

		if ($bansort != '0') {

			$sql2 = "select * from flc_banner where ban_type = '$h_bantype' and ban_page = '$h_pospage' and ban_side = '$h_posside' and ban_sort > '$bansort' order by ban_sort asc;";
			$result2 = mysql_query($sql2);
			while ($dbarr2 = mysql_fetch_array($result2)) {

				$upbanid = $dbarr2['ban_id'];
				$newbansort = $dbarr2['ban_sort'] - 1;

				$sql3 = "update flc_banner set ban_sort = '$newbansort' where ban_id = '$upbanid';";
				$result3 = mysql_query($sql3);

			}

		}

		$bansort = "0";
		$startdate = ""; $enddate = ""; $preenddate = ""; $warning = "";
		$banstatus = "d";

	}

	if ($h_bantype == 'spc') {

		$sql5 = "select * from flc_banner where ban_type = 'spc' and ban_page = '$t_pospage' and ban_status = '' and ban_id != '$h_banid';";
		$result5 = mysql_query($sql5);
		while ($dbarr5 = mysql_fetch_array($result5)) { $spccheck = "t"; }

		if ($spccheck == 't') { $banstatus = "d"; }

		$t_width_en = "450"; $t_height_en = "120";
		$t_width_jp = "450"; $t_height_jp = "120";
		$t_width_vn = "450"; $t_height_vn = "120";
		$bansort = "0";

	}

	$sql1 = "update flc_banner set mem_id = '$t_member', ban_name = '$t_name', ban_page = '$t_pospage', ban_side = '$t_posside', ban_link_en = '$t_link_en', ban_link_jp = '$t_link_jp', ban_link_vn = '$t_link_vn',
					ban_package = '$t_package', ban_startdate = '$startdate', ban_enddate = '$enddate', ban_preenddate = '$preenddate', ban_expirewarning = '$warning',
					ban_sort = '$bansort', ban_status = '$banstatus' where ban_id = '$h_banid';";
	$result1 = mysql_query($sql1);

	if ($_FILES['t_image_en']['size'] > 0) {
		$newfile = $h_banid."_en.".$t_filetype_en;
		$imgpath = "images/banner/".$newfile;
		move_uploaded_file($_FILES['t_image_en']['tmp_name'], $imgpath);
		$sql4 = "update flc_banner set ban_filetype_en = '$t_filetype_en', ban_width_en = '$t_width_en', ban_height_en = '$t_height_en' where ban_id = '$h_banid';";
		$result4 = mysql_query($sql4);
	}

	if ($_FILES['t_image_jp']['size'] > 0) {
		$newfile = $h_banid."_jp.".$t_filetype_jp;
		$imgpath = "images/banner/".$newfile;
		move_uploaded_file($_FILES['t_image_jp']['tmp_name'], $imgpath);
		$sql4 = "update flc_banner set ban_filetype_jp = '$t_filetype_jp', ban_width_jp = '$t_width_jp', ban_height_jp = '$t_height_jp' where ban_id = '$h_banid';";
		$result4 = mysql_query($sql4);
	}

	if ($_FILES['t_image_vn']['size'] > 0) {
		$newfile = $h_banid."_vn.".$t_filetype_vn;
		$imgpath = "images/banner/".$newfile;
		move_uploaded_file($_FILES['t_image_vn']['tmp_name'], $imgpath);
		$sql4 = "update flc_banner set ban_filetype_vn = '$t_filetype_vn', ban_width_vn = '$t_width_vn', ban_height_vn = '$t_height_vn' where ban_id = '$h_banid';";
		$result4 = mysql_query($sql4);
	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_banner.php?type=$h_bantype&start=0\">";
	exit();
?>

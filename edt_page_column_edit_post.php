<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_memid = $_POST['h_memid'];
	$h_langcode = $_POST['h_langcode'];
	$h_pagid = $_POST['h_pagid'];
	$h_conid = $_POST['h_conid'];
	$t_consort = $_POST['t_consort'];
	$t_ptc = $_POST['t_ptc'];
	$t_clf = $_POST['t_clf'];
	$t_contitle = $_POST['t_contitle'];
	$t_consubtitle = $_POST['t_consubtitle'];
	$t_condetail = $_POST['t_condetail'];
	$t_image = $_FILES['t_image'];
	$t_imagewidth = $_POST['t_imagewidth'];
	$t_imagelink = $_POST['t_imagelink'];
	$t_imagedisable = $_POST['t_imagedisable'];

	if ($_SESSION['vmd'] != $h_memid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql0 = "select * from flc_member where mem_id = '$h_memid';";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $memfolder = $dbarr0['mem_folder']; }

	if ($h_langcode == 'en') {

		$sql1 = "update flc_content set con_title_color = '$t_clf', con_title_en = '$t_contitle', con_subtitle_en = '$t_consubtitle', con_detail_en = '$t_condetail', con_sort = '$t_consort',
						con_status = '$t_constatus', con_pattern = '$t_ptc' where con_id = '$h_conid';";

	} else if ($h_langcode == 'vn') {

		$sql1 = "update flc_content set con_title_color = '$t_clf', con_title_vn = '$t_contitle', con_subtitle_vn = '$t_consubtitle', con_detail_vn = '$t_condetail', con_sort = '$t_consort',
						con_status = '$t_constatus', con_pattern = '$t_ptc' where con_id = '$h_conid';";

	} else  {

		$sql1 = "update flc_content set con_title_color = '$t_clf', con_title_jp = '$t_contitle', con_subtitle_jp = '$t_consubtitle', con_detail_jp = '$t_condetail', con_sort = '$t_consort',
						con_status = '$t_constatus', con_pattern = '$t_ptc' where con_id = '$h_conid';";

	}

	$result1 = mysql_query($sql1);

	if ($_FILES['t_image']['size'] > 0) {
		$t_imagedisable = "";
		$newfile = $h_memid."-".$h_pagid."-".$h_conid."-C.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth == '') { $t_imagewidth = $imgdms[0]; }
		$sql4 = "update flc_content set con_image = 't', con_image_width = '$t_imagewidth', con_image_link = '$t_imagelink' where con_id = '$h_conid';";
		$result4 = mysql_query($sql4);
	}

	if ($t_imagedisable == 't') { $sql5 = "update flc_content set con_image = '', con_image_width = '', con_image_link = '' where con_id = '$h_conid';"; }
	else { $sql5 = "update flc_content set con_image_width = '$t_imagewidth', con_image_link = '$t_imagelink' where con_id = '$h_conid';"; }
	$result5 = mysql_query($sql5);

	$sqlpagupd = "update flc_page set pag_editdate = '$nowdate', pag_edittime = '$nowtime' where pag_id = '$h_pagid';";
	$resultpagupd = mysql_query($sqlpagupd); // to update pag_update

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_page_column_add.php?page=$h_pagid&lang=$h_langcode\">";

	exit();
?>

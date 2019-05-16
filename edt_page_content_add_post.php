<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_memid = addslashes($_POST['h_memid']);
	$h_langcode = addslashes($_POST['h_langcode']);
	$t_setlang = addslashes($_POST['t_setlang']);
	$t_pagname = addslashes($_POST['t_pagname']);
	$t_pagpagetitle = addslashes($_POST['t_pagpagetitle']);
	$t_pagsort = $_POST['t_pagsort'];
	$t_clf = addslashes($_POST['t_clf']);
	$t_pagtitle = addslashes($_POST['t_pagtitle']);
	$t_pagdetail = addslashes($_POST['t_pagdetail']);
	$t_image = $_FILES['t_image'];
	$t_imagewidth = $_POST['t_imagewidth'];
	$t_imageside = $_POST['t_imageside'];
	$t_imagelink = $_POST['t_imagelink'];

	if ($_SESSION['vmd'] != $h_memid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql0 = "select * from flc_member where mem_id = '$h_memid';";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $memfolder = $dbarr0['mem_folder']; }

	if ($h_langcode == 'en') {

		$sql1 = "insert into flc_page (pag_show_en, pag_name_en, pag_name_jp, pag_name_vn, pag_pagetitle_en, pag_title_color, pag_title_en, pag_detail_en, pag_sort, pag_type, mem_id)
						values ('$t_setlang', '$t_pagname', '$t_pagname', '$t_pagname', '$t_pagpagetitle', '$t_clf', '$t_pagtitle', '$t_pagdetail', '$t_pagsort', 'con', '$h_memid');";

	} else if ($h_langcode == 'vn') {

		$sql1 = "insert into flc_page (pag_show_vn, pag_name_en, pag_name_jp, pag_name_vn, pag_pagetitle_vn, pag_title_color, pag_title_vn, pag_detail_vn, pag_sort, pag_type, mem_id)
						values ('$t_setlang', '$t_pagname', '$t_pagname', '$t_pagname', '$t_pagpagetitle', '$t_clf', '$t_pagtitle', '$t_pagdetail', '$t_pagsort', 'con', '$h_memid');";

	} else  {

		$sql1 = "insert into flc_page (pag_show_jp, pag_name_en, pag_name_jp, pag_name_vn, pag_pagetitle_jp, pag_title_color, pag_title_jp, pag_detail_jp, pag_sort, pag_type, mem_id)
						values ('$t_setlang', '$t_pagname', '$t_pagname', '$t_pagname', '$t_pagpagetitle', '$t_clf', '$t_pagtitle', '$t_pagdetail', '$t_pagsort', 'con', '$h_memid');";

	}

	$result1 = mysql_query($sql1);

	$sql3 = "select * from flc_page order by pag_id desc limit 0,1;";
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) { $pagid = $dbarr3['pag_id']; }

	if ($_FILES['t_image']['size'] > 0) {
		$newfile = $h_memid."-".$pagid."-P.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth == '') { $t_imagewidth = $imgdms[0]; }
		$sql4 = "update flc_page set pag_image = 't', pag_image_width = '$t_imagewidth', pag_image_link = '$t_imagelink', pag_image_side = '$t_imageside' where pag_id = '$pagid';";
		$result4 = mysql_query($sql4);
	}

	$sqlpagupd = "update flc_page set pag_editdate = '$nowdate', pag_edittime = '$nowtime' where pag_id = '$pagid';";
	$resultpagupd = mysql_query($sqlpagupd); // to update pag_update

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_page.php\">";

	exit();
?>

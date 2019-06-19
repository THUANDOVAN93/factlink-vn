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
	$h_homid = $_POST['h_homid'];
	$t_setlang = $_POST['t_setlang'];
	$t_pagname = $_POST['t_pagname'];
	$t_pagpagetitle = addslashes($_POST['t_pagpagetitle']);
	$t_pagsort = addslashes($_POST['t_pagsort']);
	$t_clf = addslashes($_POST['t_clf']);
	$t_pagtitle = addslashes($_POST['t_pagtitle']);
	$t_pagdetail = addslashes($_POST['t_pagdetail']);
	$t_image = $_FILES['t_image'];
	$t_imagewidth = $_POST['t_imagewidth'];
	$t_imageside = $_POST['t_imageside'];
	$t_imagelink = $_POST['t_imagelink'];
	$t_imagedisable = $_POST['t_imagedisable'];
	$t_clfkey = addslashes($_POST['t_clfkey']);
	$t_keytitle = addslashes($_POST['t_keytitle']);
	$t_keydetail = addslashes($_POST['t_keydetail']);
	$t_keytitle1 = addslashes($_POST['t_keytitle1']);
	$t_keydetail1 = addslashes($_POST['t_keydetail1']);
	$t_keytitle2 = addslashes($_POST['t_keytitle2']);
	$t_keydetail2 = addslashes($_POST['t_keydetail2']);
	$t_keytitle3 = addslashes($_POST['t_keytitle3']);
	$t_keydetail3 = addslashes($_POST['t_keydetail3']);
	$t_tpk = addslashes($_POST['t_tpk']);
	$t_clfline = addslashes($_POST['t_clfline']);
	$t_linetitle = addslashes($_POST['t_linetitle']);
	$t_linedetail = addslashes($_POST['t_linedetail']);
	$t_linetitle1 = addslashes($_POST['t_linetitle1']);
	$t_linedetail1 = addslashes($_POST['t_linedetail1']);
	$t_lineimage1 = $_FILES['t_lineimage1'];
	$t_lineimagewidth1 = $_POST['t_lineimagewidth1'];
	$t_lineimagelink1 = $_POST['t_lineimagelink1'];
	$t_lineimagedisable1 = $_POST['t_lineimagedisable1'];
	$t_linetitle2 = addslashes($_POST['t_linetitle2']);
	$t_linedetail2 = addslashes($_POST['t_linedetail2']);
	$t_lineimage2 = $_FILES['t_lineimage2'];
	$t_lineimagewidth2 = $_POST['t_lineimagewidth2'];
	$t_lineimagelink2 = $_POST['t_lineimagelink2'];
	$t_lineimagedisable2 = $_POST['t_lineimagedisable2'];
	$t_linetitle3 = addslashes($_POST['t_linetitle3']);
	$t_linedetail3 = addslashes($_POST['t_linedetail3']);
	$t_lineimage3 = $_FILES['t_lineimage3'];
	$t_lineimagewidth3 = $_POST['t_lineimagewidth3'];
	$t_lineimagelink3 = $_POST['t_lineimagelink3'];
	$t_lineimagedisable3 = $_POST['t_lineimagedisable3'];
	$t_desc = addslashes($_POST['t_desc']);

	if ($_SESSION['vmd'] != $h_memid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql0 = "select * from flc_member where mem_id = '$h_memid';";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $memfolder = $dbarr0['mem_folder']; }

	if ($h_langcode == 'en') {

		$sql1 = "update flc_page set pag_show_en = '$t_setlang', pag_name_en = '$t_pagname', pag_pagetitle_en = '$t_pagpagetitle', pag_title_color = '$t_clf',
						pag_title_en = '$t_pagtitle', pag_detail_en = '$t_pagdetail', pag_sort = '$t_pagsort', pag_editdate = '$nowdate', pag_edittime = '$nowtime'
						where pag_id = '$h_pagid';";

		$sql2 = "update flc_home set hom_keytitle_color = '$t_clfkey', hom_keytitle_en = '$t_keytitle', hom_keydetail_en = '$t_keydetail', hom_keytitle1_en = '$t_keytitle1',
						hom_keydetail1_en = '$t_keydetail1', hom_keytitle2_en = '$t_keytitle2', hom_keydetail2_en = '$t_keydetail2',
						hom_keytitle3_en = '$t_keytitle3', hom_keydetail3_en = '$t_keydetail3', hom_template = '$t_tpk', hom_linetitle_color = '$t_clfline', hom_linetitle_en = '$t_linetitle',
						hom_linedetail_en = '$t_linedetail', hom_linetitle1_en = '$t_linetitle1', hom_linedetail1_en = '$t_linedetail1', hom_linetitle2_en = '$t_linetitle2',
						hom_linedetail2_en = '$t_linedetail2', hom_linetitle3_en = '$t_linetitle3', hom_linedetail3_en = '$t_linedetail3', hom_description_en = '$t_desc'
						where mem_id = '$h_memid';";

	} else if ($h_langcode == 'vn') {

		$sql1 = "update flc_page set pag_show_vn = '$t_setlang', pag_name_vn = '$t_pagname', pag_pagetitle_vn = '$t_pagpagetitle', pag_title_color = '$t_clf',
						pag_title_vn = '$t_pagtitle', pag_detail_vn = '$t_pagdetail', pag_sort = '$t_pagsort', pag_editdate = '$nowdate', pag_edittime = '$nowtime'
						where pag_id = '$h_pagid';";

		$sql2 = "update flc_home set hom_keytitle_color = '$t_clfkey', hom_keytitle_vn = '$t_keytitle', hom_keydetail_vn = '$t_keydetail', hom_keytitle1_vn = '$t_keytitle1',
						hom_keydetail1_vn = '$t_keydetail1', hom_keytitle2_vn = '$t_keytitle2', hom_keydetail2_vn = '$t_keydetail2',
						hom_keytitle3_vn = '$t_keytitle3', hom_keydetail3_vn = '$t_keydetail3', hom_template = '$t_tpk', hom_linetitle_color = '$t_clfline', hom_linetitle_vn = '$t_linetitle',
						hom_linedetail_vn = '$t_linedetail', hom_linetitle1_vn = '$t_linetitle1', hom_linedetail1_vn = '$t_linedetail1', hom_linetitle2_vn = '$t_linetitle2',
						hom_linedetail2_vn = '$t_linedetail2', hom_linetitle3_vn = '$t_linetitle3', hom_linedetail3_vn = '$t_linedetail3', hom_description_vn = '$t_desc'
						where mem_id = '$h_memid';";

	} else  {

		$sql1 = "update flc_page set pag_show_jp = '$t_setlang', pag_name_jp = '$t_pagname', pag_pagetitle_jp = '$t_pagpagetitle', pag_title_color = '$t_clf',
						pag_title_jp = '$t_pagtitle', pag_detail_jp = '$t_pagdetail', pag_sort = '$t_pagsort', pag_editdate = '$nowdate', pag_edittime = '$nowtime'
						where pag_id = '$h_pagid';";

		$sql2 = "update flc_home set hom_keytitle_color = '$t_clfkey', hom_keytitle_jp = '$t_keytitle', hom_keydetail_jp = '$t_keydetail', hom_keytitle1_jp = '$t_keytitle1',
						hom_keydetail1_jp = '$t_keydetail1', hom_keytitle2_jp = '$t_keytitle2', hom_keydetail2_jp = '$t_keydetail2',
						hom_keytitle3_jp = '$t_keytitle3', hom_keydetail3_jp = '$t_keydetail3', hom_template = '$t_tpk', hom_linetitle_color = '$t_clfline', hom_linetitle_jp = '$t_linetitle',
						hom_linedetail_jp = '$t_linedetail', hom_linetitle1_jp = '$t_linetitle1', hom_linedetail1_jp = '$t_linedetail1', hom_linetitle2_jp = '$t_linetitle2',
						hom_linedetail2_jp = '$t_linedetail2', hom_linetitle3_jp = '$t_linetitle3', hom_linedetail3_jp = '$t_linedetail3', hom_description_jp = '$t_desc'
						where mem_id = '$h_memid';";

	}

	$result1 = mysql_query($sql1);

	$result2 = mysql_query($sql2);

	if ($_FILES['t_image']['size'] > 0) {
		$t_imagedisable = "";
		$newfile = $h_memid."-".$h_pagid."-P.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth == '') { $t_imagewidth = $imgdms[0]; }
		$sql4 = "update flc_page set pag_image = 't' where pag_id = '$h_pagid';";
		$result4 = mysql_query($sql4);
	}

	if ($t_imagedisable == 't') { $sql5 = "update flc_page set pag_image = '', pag_image_width = '', pag_image_link = '', pag_image_side = '' where pag_id = '$h_pagid';"; }
	else { $sql5 = "update flc_page set pag_image_width = '$t_imagewidth', pag_image_link = '$t_imagelink', pag_image_side = '$t_imageside' where pag_id = '$h_pagid';"; }
	$result5 = mysql_query($sql5);


	if ($_FILES['t_lineimage1']['size'] > 0) {
		$t_lineimagedisable1 = "";
		$newfile = $h_memid."-".$h_pagid."-H-1.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_lineimage1']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_lineimagewidth1 == '') { $t_lineimagewidth1 = $imgdms[0]; }
		$sql4 = "update flc_home set hom_lineimage1 = 't' where hom_id = '$h_homid';";
		$result4 = mysql_query($sql4);
	}

	if ($t_lineimagedisable1 == 't') { $sql5 = "update flc_home set hom_lineimage1 = '', hom_lineimage1_width = '', hom_lineimage1_link = '' where hom_id = '$h_homid';"; }
	else { $sql5 = "update flc_home set hom_lineimage1_width = '$t_lineimagewidth1', hom_lineimage1_link = '$t_lineimagelink1' where hom_id = '$h_homid';"; }
	$result5 = mysql_query($sql5);

	if ($_FILES['t_lineimage2']['size'] > 0) {
		$t_lineimagedisable2 = "";
		$newfile = $h_memid."-".$h_pagid."-H-2.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_lineimage2']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_lineimagewidth2 == '') { $t_lineimagewidth2 = $imgdms[0]; }
		$sql4 = "update flc_home set hom_lineimage2 = 't' where hom_id = '$h_homid';";
		$result4 = mysql_query($sql4);
	}

	if ($t_lineimagedisable2 == 't') { $sql5 = "update flc_home set hom_lineimage2 = '', hom_lineimage2_width = '', hom_lineimage2_link = '' where hom_id = '$h_homid';"; }
	else { $sql5 = "update flc_home set hom_lineimage2_width = '$t_lineimagewidth2', hom_lineimage2_link = '$t_lineimagelink2' where hom_id = '$h_homid';"; }
	$result5 = mysql_query($sql5);

	if ($_FILES['t_lineimage3']['size'] > 0) {
		$t_lineimagedisable3 = "";
		$newfile = $h_memid."-".$h_pagid."-H-3.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_lineimage3']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_lineimagewidth3 == '') { $t_lineimagewidth3 = $imgdms[0]; }
		$sql4 = "update flc_home set hom_lineimage3 = 't' where hom_id = '$h_homid';";
		$result4 = mysql_query($sql4);
	}

	if ($t_lineimagedisable3 == 't') { $sql5 = "update flc_home set hom_lineimage3 = '', hom_lineimage3_width = '', hom_lineimage3_link = '' where hom_id = '$h_homid';"; }
	else { $sql5 = "update flc_home set hom_lineimage3_width = '$t_lineimagewidth3', hom_lineimage3_link = '$t_lineimagelink3' where hom_id = '$h_homid';"; }
	$result5 = mysql_query($sql5);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_page.php\">";

	exit();
?>

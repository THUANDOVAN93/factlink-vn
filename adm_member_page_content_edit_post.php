<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	/* Convert LineBreak character to string [br] */
	$_POST['t_pagname'] = str_replace('\\r\\n','[br]',$_POST['t_pagname']);
	$_POST['t_pagtitle'] = str_replace('\\r\\n','[br]',$_POST['t_pagtitle']);
	$_POST['t_pagdetail'] = str_replace('\\r\\n','[br]',$_POST['t_pagdetail']);
	
	/*  */
	$h_memid = $_POST['h_memid'];
	$h_langcode = $_POST['h_langcode'];
	$h_pagid = $_POST['h_pagid'];
	$h_freemem = $_POST['h_freemem'];
	$t_setlang = $_POST['t_setlang'];
	$t_pagname = ($_POST['t_pagname']);
	$t_pagpagetitle = ($_POST['t_pagpagetitle']);
	$t_pagsort = ($_POST['t_pagsort']);
	$t_clf = ($_POST['t_clf']);
	$t_pagtitle = ($_POST['t_pagtitle']);
	$t_pagdetail = ($_POST['t_pagdetail']);
	$t_image = $_FILES['t_image'];
	$t_imagewidth = $_POST['t_imagewidth'];
	$t_imageside = $_POST['t_imageside'];
	$t_imagelink = $_POST['t_imagelink'];
	$t_imagedisable = $_POST['t_imagedisable'];
	$t_videolink = $_POST['t_videolink'];
	$t_media_option = $_POST['t_media_option'];
	$sql0 = "select * from flc_member where mem_id = '$h_memid';";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $memfolder = $dbarr0['mem_folder']; }
	
	if ($h_langcode == 'en') {

		$sql1 = "update flc_page set pag_show_en = '$t_setlang', pag_name_en = '$t_pagname', pag_pagetitle_en = '$t_pagpagetitle', pag_title_color = '$t_clf',
						pag_title_en = '$t_pagtitle', pag_detail_en = '$t_pagdetail', pag_sort = '$t_pagsort', pag_editdate = '$nowdate', pag_edittime = '$nowtime'
						where pag_id = '$h_pagid';";

	} else if ($h_langcode == 'vn') {

		$sql1 = "update flc_page set pag_show_vn = '$t_setlang', pag_name_vn = '$t_pagname', pag_pagetitle_vn = '$t_pagpagetitle', pag_title_color = '$t_clf',
						pag_title_vn = '$t_pagtitle', pag_detail_vn = '$t_pagdetail', pag_sort = '$t_pagsort', pag_editdate = '$nowdate', pag_edittime = '$nowtime'
						where pag_id = '$h_pagid';";

	} else  {

		$sql1 = "update flc_page set pag_show_jp = '$t_setlang', pag_name_jp = '$t_pagname', pag_pagetitle_jp = '$t_pagpagetitle', pag_title_color = '$t_clf',
						pag_title_jp = '$t_pagtitle', pag_detail_jp = '$t_pagdetail', pag_sort = '$t_pagsort', pag_editdate = '$nowdate', pag_edittime = '$nowtime'
						where pag_id = '$h_pagid';";

	}

	$result1 = mysql_query($sql1);

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

	// upload video
	if ( !empty( $t_videolink ) ) {
		$t_videolink_validated = stripslashes ( $t_videolink );
		$sql6 = "update flc_page set pag_video_link = '$t_videolink_validated', pag_image = 't' where pag_id = '$h_pagid';";
		$result6 = mysql_query($sql6);
	}
	// upload media option
	if ( !empty( $t_media_option ) ) {
		$sql7 = "update flc_page set pag_media_option = '$t_media_option' where pag_id = '$h_pagid';";
		$result7 = mysql_query($sql7);
	}

	if ($t_imagedisable == 't') { $sql5 = "update flc_page set pag_image = '', pag_image_width = '0', pag_image_link = '', pag_image_side = '', pag_video_link = '' where pag_id = '$h_pagid';"; }
	else { $sql5 = "update flc_page set pag_image_width = '$t_imagewidth', pag_image_link = '$t_imagelink', pag_image_side = '$t_imageside' where pag_id = '$h_pagid';"; }
	$result5 = mysql_query($sql5);

	if ($h_freemem == 't') { $sql9 = "update flc_page set pag_status = 'd' where pag_id = '$h_pagid';"; $result9 = mysql_query($sql9); }

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_page.php?id=$h_memid\">";

	exit();
?>

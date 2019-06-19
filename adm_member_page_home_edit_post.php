<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");


	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);

	mysql_query("use $db_name;");	
	
	
	$h_memid = $_POST['h_memid'];
	$h_langcode = $_POST['h_langcode'];
	$h_pagid = $_POST['h_pagid'];
	$h_homid = $_POST['h_homid'];
	$h_freemem = $_POST['h_freemem'];
	$t_setlang = $_POST['t_setlang'];
	$t_pagname = $_POST['t_pagname'];
	$t_pagpagetitle = addslashes($_POST['t_pagpagetitle']);	
	$t_pagsort = $_POST['t_pagsort'];
	$t_clf = $_POST['t_clf'];
	$t_pagtitle = addslashes($_POST['t_pagtitle']);
	$t_pagdetail = addslashes($_POST['t_pagdetail']);
	$t_image = $_FILES['t_image'];
	$t_imagewidth = $_POST['t_imagewidth'];
	$t_imageside = $_POST['t_imageside'];
	$t_imagelink = $_POST['t_imagelink'];
	$t_imagedisable = $_POST['t_imagedisable'];
	$t_videolink = $_POST['t_videolink'];
	$t_media_option = $_POST['t_media_option'];
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
	$t_linevideolink1 = $_POST['t_linevideolink1'];
	$t_media_option1 = $_POST['t_media_option1'];
	/*$t_linetitle2 = $_POST['t_linetitle2'];*/
	$t_linetitle2 = addslashes($_POST['t_linetitle2']);
	$t_linedetail2 = addslashes($_POST['t_linedetail2']);
	$t_lineimage2 = $_FILES['t_lineimage2'];
	$t_lineimagewidth2 = $_POST['t_lineimagewidth2'];
	$t_lineimagelink2 = $_POST['t_lineimagelink2'];
	$t_lineimagedisable2 = $_POST['t_lineimagedisable2'];
	$t_linevideolink2 = $_POST['t_linevideolink2'];
	$t_media_option2 = $_POST['t_media_option2'];

	$t_linetitle3 = addslashes($_POST['t_linetitle3']);
	$t_linedetail3 = addslashes($_POST['t_linedetail3']);
	$t_lineimage3 = $_FILES['t_lineimage3'];
	$t_lineimagewidth3 = $_POST['t_lineimagewidth3'];
	$t_lineimagelink3 = $_POST['t_lineimagelink3'];
	$t_lineimagedisable3 = $_POST['t_lineimagedisable3'];
	$t_linevideolink3 = $_POST['t_linevideolink3'];
	$t_media_option3 = $_POST['t_media_option3'];
	$t_desc = addslashes($_POST['t_desc']);
	
	/* Convert LineBreak character to string [br] */
	$t_pagname = str_replace('\\r\\n','[br]',($t_pagname));
	$t_pagtitle = str_replace('\\r\\n','[br]',stripcslashes($t_pagtitle));
	$t_pagdetail = str_replace('\\r\\n','[br]',stripcslashes($t_pagdetail));
	$t_business = str_replace('\\r\\n','[br]',stripcslashes($t_business));
	$t_product = str_replace('\\r\\n','[br]',stripcslashes($t_product));
	$t_comaddlab1 = str_replace('\\r\\n','[br]',stripcslashes($t_comaddlab1));
	$t_comadd1 = str_replace('\\r\\n','[br]',stripcslashes($t_comadd1));
	$t_comaddlab2 = str_replace('\\r\\n','[br]',stripcslashes($t_comaddlab2));
	$t_comadd2 = str_replace('\\r\\n','[br]',stripcslashes($t_comadd2));
	$t_comaddlab3 = str_replace('\\r\\n','[br]',stripcslashes($t_comaddlab3));
	$t_comadd3 = str_replace('\\r\\n','[br]',stripcslashes($t_comadd3));
	$t_comaddlab4 = str_replace('\\r\\n','[br]',stripcslashes($t_comaddlab4));
	$t_comadd4 = str_replace('\\r\\n','[br]',stripcslashes($t_comadd4));
	$t_comaddlab5 = str_replace('\\r\\n','[br]',stripcslashes($t_comaddlab5));
	$t_comadd5 = str_replace('\\r\\n','[br]',stripcslashes($t_comadd5));
	$t_comtellab1 = str_replace('\\r\\n','[br]',stripcslashes($t_comtellab1));
	$t_comtellab2 = str_replace('\\r\\n','[br]',stripcslashes($t_comtellab2));
	$t_comtellab3 = str_replace('\\r\\n','[br]',stripcslashes($t_comtellab3));
	$t_comtellab4 = str_replace('\\r\\n','[br]',stripcslashes($t_comtellab4));
	$t_comtellab5 = str_replace('\\r\\n','[br]',stripcslashes($t_comtellab5));
	$t_commaillab1 = str_replace('\\r\\n','[br]',stripcslashes($t_commaillab1));
	$t_commaillab2 = str_replace('\\r\\n','[br]',stripcslashes($t_commaillab2));
	$t_commaillab3 = str_replace('\\r\\n','[br]',stripcslashes($t_commaillab3));
	$t_commaillab4 = str_replace('\\r\\n','[br]',stripcslashes($t_commaillab4));
	$t_commaillab5 = str_replace('\\r\\n','[br]',stripcslashes($t_commaillab5));
	$t_url = str_replace('\\r\\n','[br]',($t_url));
	$t_comparent = str_replace('\\r\\n','[br]',stripcslashes($t_comparent));
	$t_shareholder = str_replace('\\r\\n','[br]',stripcslashes($t_shareholder));
	$t_valcus = str_replace('\\r\\n','[br]',stripcslashes($t_valcus));
	$t_conlab1 = str_replace('\\r\\n','[br]',stripcslashes($t_conlab1));
	$t_con1 = str_replace('\\r\\n','[br]',stripcslashes($t_con1));
	$t_conlab2 = str_replace('\\r\\n','[br]',stripcslashes($t_conlab2));
	$t_con2 = str_replace('\\r\\n','[br]',stripcslashes($t_con2));
	$t_conlab3 = str_replace('\\r\\n','[br]',stripcslashes($t_conlab3));
	$t_con3 = str_replace('\\r\\n','[br]',stripcslashes($t_con3));
	$t_conlab4 = str_replace('\\r\\n','[br]',stripcslashes($t_conlab4));
	$t_con4 = str_replace('\\r\\n','[br]',stripcslashes($t_con4));
	$t_conlab5 = str_replace('\\r\\n','[br]',stripcslashes($t_conlab5));
	$t_con5 = str_replace('\\r\\n','[br]',stripcslashes($t_con5));
	$t_keydetail = str_replace('\\r\\n','[br]',stripcslashes($t_keydetail));
	$t_keydetail1 = str_replace('\\r\\n','[br]',stripcslashes($t_keydetail1));
	$t_keydetail2 = str_replace('\\r\\n','[br]',stripcslashes($t_keydetail2));	
	$t_keydetail3 = str_replace('\\r\\n','[br]',stripcslashes($t_keydetail3));
	$t_linetitle = str_replace('\\r\\n','<br>',stripcslashes($t_linetitle));	
	$t_linetitle1 = str_replace('\\r\\n','<br>',stripcslashes($t_linetitle1));
	$t_linetitle2 = str_replace('\\r\\n','<br>',stripcslashes($t_linetitle2));
	$t_linetitle3 = str_replace('\\r\\n','<br>',stripcslashes($t_linetitle3));
	$t_linedetail = str_replace('\\r\\n','[br]',stripcslashes($t_linedetail));	
	$t_linedetail1 = str_replace('\\r\\n','[br]',stripcslashes($t_linedetail1));
	$t_linedetail2 = str_replace('\\r\\n','[br]',stripcslashes($t_linedetail2));	
	$t_linedetail3 = str_replace('\\r\\n','[br]',stripcslashes($t_linedetail3));
	$t_desc = str_replace('\\r\\n','[br]',stripcslashes($t_desc));	
	
	
	

	$sql0 = "select * from flc_member where mem_id = '$h_memid';";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) {
		$memfolder = $dbarr0['mem_folder'];
	}

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




	function countFlcPageByPageID($pageID) {
		$query = 'SELECT COUNT(*) FROM `flc_page` WHERE `pag_id` = "%1$s";';
		$query = sprintf($query,$pageID);
		$query = mysql_query($query);
		$fetch = mysql_fetch_assoc($query,0);
		return $fetch['COUNT(*)'];
	}

	function countFlcHomeByMemeberID($memeberID) {
		$query = 'SELECT COUNT(*) FROM `flc_home` WHERE `mem_id` = "%1$s";';
		$query = sprintf($query,$memeberID);
		$query = mysql_query($query);
		$fetch = mysql_fetch_assoc($query,0);
		return $fetch['COUNT(*)'];
	}

	function insertEmptyFlcHome($memeberID) {
		$query = 'INSERT INTO `flc_home` (`mem_id`) VALUES ("%1$s");';
		$query = sprintf($query,$memeberID);
		//exit("<hr/>$query");
		$query = mysql_query($query);
		return $queryl;
	}


	/* Counting row to check if row exists in the database */
	$count['flc_page'] = countFlcPageByPageID($h_pagid);
	$count['flc_home'] = countFlcHomeByMemeberID($h_memid);

	/* Insert empty row with id to prevent update row that is not exists */
	if($count['flc_home'] == 0) {
		insertEmptyFlcHome($h_memid);
	}



	/* Update `flc_page` & `flc_home` */
	$result1 = mysql_query($sql1) or die(mysql_error());
	$result2 = mysql_query($sql2) or die(mysql_error());







	if ($_FILES['t_image']['size'] > 0) {
		$t_imagedisable = "";
		$newfile = $h_memid."-".$h_pagid."-P.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth == '') { $t_imagewidth = $imgdms[0]; }

		$sql4 = "update flc_page set pag_image = 't' where pag_id = '$h_pagid';";
		$result4 = mysql_query($sql4) or die(mysql_error());
	}

	// upload video
	if ( !empty( $t_videolink ) ) {
		$t_videolink_validated = stripslashes ( $t_videolink );
		$sql6 = "update flc_page set pag_video_link = '$t_videolink_validated' where pag_id = '$h_pagid';";
		$result6 = mysql_query($sql6);
	}
	// upload media option
	if ( !empty( $t_media_option ) ) {
		$sql7 = "update flc_page set pag_media_option = '$t_media_option' where pag_id = '$h_pagid';";
		$result7 = mysql_query($sql7);
	}

	if ($t_imagedisable == 't') {
		$sql5 = "update flc_page set pag_image = '', pag_image_width = '0', pag_image_link = '', pag_image_side = '', pag_video_link = '' where pag_id = '$h_pagid';";
	} else {
		$sql5 = "update flc_page set pag_image_width = '$t_imagewidth', pag_image_link = '$t_imagelink', pag_image_side = '$t_imageside' where pag_id = '$h_pagid';";
	}

	$result5 = mysql_query($sql5) or die(mysql_error());;


	if ($_FILES['t_lineimage1']['size'] > 0) {
		$t_lineimagedisable1 = "";
		$newfile = $h_memid."-".$h_pagid."-H-1.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_lineimage1']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_lineimagewidth1 == '') { $t_lineimagewidth1 = $imgdms[0]; }
		$sql4 = "update flc_home set hom_lineimage1 = 't' where hom_id = '$h_homid';";
		$result4 = mysql_query($sql4) or die(mysql_error());;
	}

	// upload video 1
	if ( !empty( $t_linevideolink1 ) ) {
		$t_linevideolink1_validated = stripslashes ( $t_linevideolink1 );
		$sql6 = "update flc_home set hom_linevideo1_link = '$t_linevideolink1_validated' where pag_id = '$h_pagid';";
		$result6 = mysql_query($sql6);
	}
	// upload media option 1
	if ( !empty( $t_media_option1 ) ) {
		$sql7 = "update flc_home set hom_media_option1 = '$t_media_option1' where pag_id = '$h_pagid';";
		$result7 = mysql_query($sql7);
	}

	if ($t_lineimagedisable1 == 't') {
		$sql5 = "update flc_home set hom_lineimage1 = '', hom_lineimage1_width = '', hom_lineimage1_link = '', hom_linevideo1_link = '' where hom_id = '$h_homid';";
	} else {
		$sql5 = "update flc_home set hom_lineimage1_width = '$t_lineimagewidth1', hom_lineimage1_link = '$t_lineimagelink1' where hom_id = '$h_homid';";
	}

	$result5 = mysql_query($sql5) or die(mysql_error());;




	if ($_FILES['t_lineimage2']['size'] > 0) {
		$t_lineimagedisable2 = "";
		$newfile = $h_memid."-".$h_pagid."-H-2.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_lineimage2']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_lineimagewidth2 == '') { $t_lineimagewidth2 = $imgdms[0]; }
		$sql4 = "update flc_home set hom_lineimage2 = 't' where hom_id = '$h_homid';";
		$result4 = mysql_query($sql4) or die(mysql_error());;
	}

	// upload video 2
	if ( !empty( $t_linevideolink2 ) ) {
		$t_linevideolink2_validated = stripslashes ( $t_linevideolink2 );
		$sql6 = "update flc_home set hom_linevideo2_link = '$t_linevideolink2_validated' where pag_id = '$h_pagid';";
		$result6 = mysql_query($sql6);
	}
	// upload media option 2
	if ( !empty( $t_media_option2 ) ) {
		$sql7 = "update flc_home set hom_media_option2 = '$t_media_option2' where pag_id = '$h_pagid';";
		$result7 = mysql_query($sql7);
	}

	if ($t_lineimagedisable2 == 't') {
		$sql5 = "update flc_home set hom_lineimage2 = '', hom_lineimage2_width = 0, hom_lineimage2_link = '', hom_linevideo2_link = '' where hom_id = '$h_homid';";
	} else {
		$sql5 = "update flc_home set hom_lineimage2_width = '$t_lineimagewidth2', hom_lineimage2_link = '$t_lineimagelink2' where hom_id = '$h_homid';";
	}
	$result5 = mysql_query($sql5);



	if ($_FILES['t_lineimage3']['size'] > 0) {
		$t_lineimagedisable3 = "";
		$newfile = $h_memid."-".$h_pagid."-H-3.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_lineimage3']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_lineimagewidth3 == '') { $t_lineimagewidth3 = $imgdms[0]; }
		$sql4 = "update flc_home set hom_lineimage3 = 't' where hom_id = '$h_homid';";
		$result4 = mysql_query($sql4) or die(mysql_error());;
	}

	// upload video 3
	if ( !empty( $t_linevideolink3 ) ) {
		$t_linevideolink3_validated = stripslashes ( $t_linevideolink3 );
		$sql6 = "update flc_home set hom_linevideo3_link = '$t_linevideolink3_validated' where pag_id = '$h_pagid';";
		$result6 = mysql_query($sql6);
	}
	// upload media option 3
	if ( !empty( $t_media_option3 ) ) {
		$sql7 = "update flc_home set hom_media_option3 = '$t_media_option3' where pag_id = '$h_pagid';";
		$result7 = mysql_query($sql7);
	}

	if ($t_lineimagedisable3 == 't') {
		$sql5 = "update flc_home set hom_lineimage3 = '', hom_lineimage3_width = '', hom_lineimage3_link = '', hom_linevideo3_link = '' where hom_id = '$h_homid';";
	} else {
		$sql5 = "update flc_home set hom_lineimage3_width = '$t_lineimagewidth3', hom_lineimage3_link = '$t_lineimagelink3' where hom_id = '$h_homid';";
	}

	$result5 = mysql_query($sql5)or die(mysql_error());
	//if ($h_freemem == 't') { $sql9 = "update flc_page set pag_status = 'd' where pag_id = '$h_pagid';"; $result9 = mysql_query($sql9); }

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_page.php?id=$h_memid\">";

	exit();
?>

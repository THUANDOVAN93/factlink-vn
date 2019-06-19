<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$h_feaid = $_POST['h_feaid'];
	$t_title_en = $_POST['t_title_en'];
	$t_title_jp = $_POST['t_title_jp'];
	$t_title_vn = $_POST['t_title_vn'];
	$t_detail_en = $_POST['t_detail_en'];
	$t_detail_jp = $_POST['t_detail_jp'];
	$t_detail_vn = $_POST['t_detail_vn'];
	$t_image = $_FILES['t_image'];
	$t_imagewidth = $_POST['t_imagewidth'];
	$t_imagelink = $_POST['t_imagelink'];
	$t_imagedisable = $_POST['t_imagedisable'];

	$t_videolink = $_POST['t_videolink'];
	$t_media_option = $_POST['t_media_option'];


	$t_detail_en1 = $_POST['t_detail_en1'];
	$t_detail_jp1 = $_POST['t_detail_jp1'];
	$t_detail_vn1 = $_POST['t_detail_vn1'];
	$t_image1 = $_FILES['t_image1'];
	$t_imagewidth1 = $_POST['t_imagewidth1'];
	$t_imagelink1 = $_POST['t_imagelink1'];
	$t_imagedisable1 = $_POST['t_imagedisable1'];
	$t_imageside1 = $_POST['t_imageside1'];

	$t_videolink1 = $_POST['t_videolink1'];
	$t_media1_option = $_POST['t_media_option1'];


	$t_detail_en2 = $_POST['t_detail_en2'];
	$t_detail_jp2 = $_POST['t_detail_jp2'];
	$t_detail_vn2 = $_POST['t_detail_vn2'];
	$t_image2 = $_FILES['t_image2'];
	$t_imagewidth2 = $_POST['t_imagewidth2'];
	$t_imagelink2 = $_POST['t_imagelink2'];
	$t_imagedisable2 = $_POST['t_imagedisable2'];
	$t_imageside2 = $_POST['t_imageside2'];

	$t_videolink2 = $_POST['t_videolink2'];
	$t_media2_option = $_POST['t_media_option2'];


	$t_link = $_POST['t_link'];
	
	/* Convert LineBreak character to string [br] */
	$t_title_en = str_replace('\\r\\n','[br]',($t_title_en));
	$t_title_jp = str_replace('\\r\\n','[br]',($t_title_jp));
	$t_title_vn = str_replace('\\r\\n','[br]',($t_title_vn));
	$t_detail_en = str_replace('\\r\\n','[br]',($t_detail_en));
	$t_detail_jp = str_replace('\\r\\n','[br]',($t_detail_jp));	
	$t_detail_vn = str_replace('\\r\\n','[br]',($t_detail_vn));
	$t_detail_en1 = str_replace('\\r\\n','[br]',($t_detail_en1));
	$t_detail_jp1 = str_replace('\\r\\n','[br]',($t_detail_jp1));
	$t_detail_vn1 = str_replace('\\r\\n','[br]',($t_detail_vn1));
	$t_detail_en2 = str_replace('\\r\\n','[br]',($t_detail_en2));
	$t_detail_jp2 = str_replace('\\r\\n','[br]',($t_detail_jp2));
	$t_detail_vn2 = str_replace('\\r\\n','[br]',($t_detail_vn2));
	$t_link = str_replace('\\r\\n','[br]',($t_link));
	
	
	

	if ($_SESSION['vd'] != $h_admid) {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">";
		exit();
	}

	
	/** Don't escape string again...
	 *	SQL already escape at
	 *	array_map('mysql_real_escape_string') around LINE 10-11
	 */
	 
	// echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
    // $t_detail_en=addslashes($t_detail_en);
	// $t_detail_jp=addslashes($t_detail_jp);
	// $t_detail_vn=addslashes($t_detail_vn);
	// $t_detail_en1=addslashes($t_detail_en1);
	// $t_detail_jp1=addslashes($t_detail_jp1);
	// $t_detail_vn1=addslashes($t_detail_vn1);
	// $t_detail_en2=addslashes($t_detail_en2);
	// $t_detail_jp2=addslashes($t_detail_jp2);
	// $t_detail_vn2=addslashes($t_detail_vn2);
	
	

	$sql1 = "
		UPDATE  flc_feature SET
		fea_title_en = '$t_title_en',
		fea_title_jp = '$t_title_jp',
		fea_title_vn = '$t_title_vn',
		fea_detail_en = '$t_detail_en',
		fea_detail_jp = '$t_detail_jp',
		fea_detail_vn = '$t_detail_vn',
		fea_detail1_en = '$t_detail_en1',
		fea_detail1_jp = '$t_detail_jp1',
		fea_detail1_vn = '$t_detail_vn1',
		fea_detail2_en = '$t_detail_en2',
		fea_detail2_jp = '$t_detail_jp2',
		fea_detail2_vn = '$t_detail_vn2',
		fea_link = '$t_link',
		fea_date = '$nowdate'
		WHERE fea_id = '$h_feaid';
	";
	
	$result1 = mysql_query($sql1);

	
	if ($_FILES['t_image']['size'] > 0) {
		$t_imagedisable = "";
		$newfile = $h_feaid."-F.jpg";
		$imgpath = "images/feature/".$newfile;
		$rs = move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth == '') { $t_imagewidth = $imgdms[0]; }
		$sql4 = "update flc_feature set fea_image = 't' where fea_id = '$h_feaid';";
		$result4 = mysql_query($sql4);
	}

	// upload video
	if ( !empty( $t_videolink ) ) {

		$t_videolink_validated = stripslashes ( $t_videolink );
		$sql6 = "update flc_feature set fea_video_link = '$t_videolink_validated' where fea_id = '$h_feaid';";
		$result6 = mysql_query($sql6);
	}
	// upload media option
	if ( !empty( $t_media_option ) ) {
		$sql7 = "update flc_feature set fea_media_option = '$t_media_option' where fea_id = '$h_feaid';";
		$result7 = mysql_query($sql7);
	}

	if ($_FILES['t_image1']['size'] > 0) {
		$t_imagedisable1 = "";
		$newfile = $h_feaid."-F1.jpg";
		$imgpath = "images/feature/".$newfile;
		move_uploaded_file($_FILES['t_image1']['tmp_name'], $imgpath);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth1 == '') { $t_imagewidth1 = $imgdms[0]; }
		$sql4 = "update flc_feature set fea_image1 = 't' where fea_id = '$h_feaid';";
		$result4 = mysql_query($sql4);
	}

	// upload video 1
	if ( !empty( $t_videolink1 ) ) {
		
		$t_videolink1_validated = stripslashes ( $t_videolink1 );
		$sql6 = "update flc_feature set fea_video1_link = '$t_videolink1_validated' where fea_id = '$h_feaid';";
		$result6 = mysql_query($sql6);
	}
	// upload media option 1
	if ( !empty( $t_media_option ) ) {
		$sql7 = "update flc_feature set fea_media1_option = '$t_media1_option' where fea_id = '$h_feaid';";
		$result7 = mysql_query($sql7);
	}

	if ($_FILES['t_image2']['size'] > 0) {
		$t_imagedisable2 = "";
		$newfile = $h_feaid."-F2.jpg";
		$imgpath = "images/feature/".$newfile;
		move_uploaded_file($_FILES['t_image2']['tmp_name'], $imgpath);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth2 == '') { $t_imagewidth2 = $imgdms[0]; }
		$sql4 = "update flc_feature set fea_image2 = 't' where fea_id = '$h_feaid';";
		$result4 = mysql_query($sql4);
	}

	// upload video 2
	if ( !empty( $t_videolink2 ) ) {
		
		$t_videolink2_validated = stripslashes ( $t_videolink2 );
		$sql6 = "update flc_feature set fea_video2_link = '$t_videolink2_validated' where fea_id = '$h_feaid';";
		$result6 = mysql_query($sql6);
	}
	// upload media option 2
	if ( !empty( $t_media_option ) ) {
		$sql7 = "update flc_feature set fea_media2_option = '$t_media2_option' where fea_id = '$h_feaid';";
		$result7 = mysql_query($sql7);
	}

	/*  */
	if ($t_imagedisable == 't') {
		$sql5 = "update flc_feature set fea_image = '', fea_image_width = '0', fea_image_link = '', fea_video_link = '' where fea_id = '$h_feaid';";
	} else {
		$sql5 = "update flc_feature set fea_image_width = '$t_imagewidth', fea_image_link = '$t_imagelink' where fea_id = '$h_feaid';";
	}
	$result5 = mysql_query($sql5);

	/*  */
	if ($t_imagedisable1 == 't') {
		$sql5 = "update flc_feature set fea_image1 = '', fea_image1_width = '0', fea_image1_link = '', fea_image1_side = '', fea_video1_link = '' where fea_id = '$h_feaid';";
	} else {
		$sql5 = "update flc_feature set fea_image1_width = '$t_imagewidth1', fea_image1_link = '$t_imagelink1', fea_image1_side = '$t_imageside1' where fea_id = '$h_feaid';";
	}
	$result5 = mysql_query($sql5);

	/*  */
	if ($t_imagedisable2 == 't') {
		$sql5 = "update flc_feature set fea_image2 = '', fea_image2_width = '0', fea_image2_link = '', fea_image2_side = '', fea_video2_link = '' where fea_id = '$h_feaid';"; }
	else {
		$sql5 = "update flc_feature set fea_image2_width = '$t_imagewidth2', fea_image2_link = '$t_imagelink2', fea_image2_side = '$t_imageside2' where fea_id = '$h_feaid';";
	}
	$result5 = mysql_query($sql5);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_feature.php?start=0\">";
	exit();
	
?>

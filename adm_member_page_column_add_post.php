<?php
	session_start();
	error_reporting(-1);

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_memid = $_POST['h_memid'];
	$h_langcode = $_POST['h_langcode'];
	$h_pagid = $_POST['h_pagid'];
	$h_freemem = $_POST['h_freemem'];
	$t_constatus = $_POST['t_constatus'];
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
	$t_videolink = $_POST['t_videolink'];
	$t_media_option = $_POST['t_media_option'];

/* Convert LineBreak character to string [br] */
	$t_contitle = str_replace('\\r\\n','[br]',($t_contitle));
	$t_consubtitle = str_replace('\\r\\n','[br]',($t_consubtitle));
	$t_condetail = str_replace('\\r\\n','[br]',($t_condetail));
	
	
	$sql0 = "select * from flc_member where mem_id = '$h_memid';";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $memfolder = $dbarr0['mem_folder']; }

	if ($h_langcode == 'en') {

		$sql1 = "insert into flc_content (mem_id, pag_id, con_title_color, con_title_en, con_subtitle_en, con_detail_en, con_sort, con_status, con_pattern)
						values ('$h_memid', '$h_pagid', '$t_clf', '$t_contitle', '$t_consubtitle', '$t_condetail', '$t_consort', '$t_constatus', '$t_ptc');";

	} else if ($h_langcode == 'vn') {

		$sql1 = "insert into flc_content (mem_id, pag_id, con_title_color, con_title_vn, con_subtitle_vn, con_detail_vn, con_sort, con_status, con_pattern)
						values ('$h_memid', '$h_pagid', '$t_clf', '$t_contitle', '$t_consubtitle', '$t_condetail', '$t_consort', '$t_constatus', '$t_ptc');";

	} else  {

		$sql1 = "insert into flc_content (mem_id, pag_id, con_title_color, con_title_jp, con_subtitle_jp, con_detail_jp, con_sort, con_status, con_pattern)
						values ('$h_memid', '$h_pagid', '$t_clf', '$t_contitle', '$t_consubtitle', '$t_condetail', '$t_consort', '$t_constatus', '$t_ptc');";

	}

	$result1 = mysql_query($sql1) or die('flc_content');

	$sql3 = "select * from flc_content order by con_id desc limit 0,1;";
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) { $conid = $dbarr3['con_id']; }

	if ($_FILES['t_image']['size'] > 0) {

		$newfile = $h_memid."-".$h_pagid."-".$conid."-C.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;


		if(is_dir("home/".$memfolder)) {
			// $old_umask = umask(0);
			chmod("home/".$memfolder, 0777);
			// umask($old_umask);
			// exit("test 0777");
		} else {
			exit('dir not exists');
		}



		if(!move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath)){
			echo "<pre>".print_r($_FILES['t_image']['tmp_name'],true)."</pre>";
			echo "<pre>".print_r($_FILES['t_image']['error'],true)."</pre>";
			echo "<pre>".print_r($imgpath,true)."</pre>";
			exit('upload error');
		}


		$imgdms = getimagesize($imgpath);
		if ($t_imagewidth == '') {
			$t_imagewidth = $imgdms[0];
		}

		$sql4 = "update flc_content set con_image = 't', con_image_width = '$t_imagewidth', con_image_link = '$t_imagelink' where con_id = '$conid';";
		$result4 = mysql_query($sql4);

	}

	// upload video
	if ( !empty( $t_videolink ) ) {
		$t_videolink_validated = stripslashes ( $t_videolink );
		$sql6 = "update flc_content set con_video_link = '$t_videolink' where con_id = '$conid';";
		$result6 = mysql_query($sql6);
	}
	// upload media option
	if ( !empty( $t_media_option ) ) {
		$sql7 = "update flc_content set con_media_option = '$t_media_option' where con_id = '$conid';";
		$result7 = mysql_query($sql7);
	}






	if ($h_freemem == 't') { $sql9 = "update flc_page set pag_status = 'd' where pag_id = '$h_pagid';"; $result9 = mysql_query($sql9); }

	$sqlpagupd = "update flc_page set pag_editdate = '$nowdate', pag_edittime = '$nowtime' where pag_id = '$h_pagid';";
	$resultpagupd = mysql_query($sqlpagupd); // to update pag_update

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_page_column_add.php?id=$h_memid&page=$h_pagid&lang=$h_langcode\">";

	exit();
?>

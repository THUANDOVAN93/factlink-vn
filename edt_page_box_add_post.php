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
	$t_boxstatus = $_POST['t_boxstatus'];
	$t_boxsort = $_POST['t_boxsort'];
	$t_box1 = $_POST['t_box1'];
	$t_clf1 = $_POST['t_clf1'];
	$t_title1 = $_POST['t_title1'];
	$t_detail1 = $_POST['t_detail1'];
	$t_image1 = $_FILES['t_image1'];
	$t_imagewidth1 = $_POST['t_imagewidth1'];
	$t_imagelink1 = $_POST['t_imagelink1'];
	$t_box2 = $_POST['t_box2'];
	$t_clf2 = $_POST['t_clf2'];
	$t_title2 = $_POST['t_title2'];
	$t_detail2 = $_POST['t_detail2'];
	$t_image2 = $_FILES['t_image2'];
	$t_imagewidth2 = $_POST['t_imagewidth2'];
	$t_imagelink2 = $_POST['t_imagelink2'];
	$t_box3 = $_POST['t_box3'];
	$t_clf3 = $_POST['t_clf3'];
	$t_title3 = $_POST['t_title3'];
	$t_detail3 = $_POST['t_detail3'];
	$t_image3 = $_FILES['t_image3'];
	$t_imagewidth3 = $_POST['t_imagewidth3'];
	$t_imagelink3 = $_POST['t_imagelink3'];

	if ($_SESSION['vmd'] != $h_memid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql0 = "select * from flc_member where mem_id = '$h_memid';";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $memfolder = $dbarr0['mem_folder']; }

	if ($h_langcode == 'en') {

		$sql1 = "insert into flc_present_box (mem_id, pag_id, box_sort, box_status, box_type1, box_title1_color, box_title1_en, box_detail1_en,
						box_type2, box_title2_color, box_title2_en, box_detail2_en, box_type3, box_title3_color, box_title3_en, box_detail3_en)
						values ('$h_memid', '$h_pagid', '$t_boxsort', '$t_boxstatus', '$t_box1', '$t_clf1', '$t_title1', '$t_detail1',
						'$t_box2', '$t_clf2', '$t_title2', '$t_detail2', '$t_box3', '$t_clf3', '$t_title3', '$t_detail3');";

	} else if ($h_langcode == 'vn') {

		$sql1 = "insert into flc_present_box (mem_id, pag_id, box_sort, box_status, box_type1, box_title1_color, box_title1_vn, box_detail1_vn,
						box_type2, box_title2_color, box_title2_vn, box_detail2_vn, box_type3, box_title3_color, box_title3_vn, box_detail3_vn)
						values ('$h_memid', '$h_pagid', '$t_boxsort', '$t_boxstatus', '$t_box1', '$t_clf1', '$t_title1', '$t_detail1',
						'$t_box2', '$t_clf2', '$t_title2', '$t_detail2', '$t_box3', '$t_clf3', '$t_title3', '$t_detail3');";

	} else  {

		$sql1 = "insert into flc_present_box (mem_id, pag_id, box_sort, box_status, box_type1, box_title1_color, box_title1_jp, box_detail1_jp,
						box_type2, box_title2_color, box_title2_jp, box_detail2_jp, box_type3, box_title3_color, box_title3_jp, box_detail3_jp)
						values ('$h_memid', '$h_pagid', '$t_boxsort', '$t_boxstatus', '$t_box1', '$t_clf1', '$t_title1', '$t_detail1',
						'$t_box2', '$t_clf2', '$t_title2', '$t_detail2', '$t_box3', '$t_clf3', '$t_title3', '$t_detail3');";

	}

	$result1 = mysql_query($sql1);

	$sql3 = "select * from flc_present_box order by box_id desc limit 0,1;";
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) { $boxid = $dbarr3['box_id']; }

	if ($_FILES['t_image1']['size'] > 0) {
		$newfile = $h_memid."-".$h_pagid."-".$boxid."-B1.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_image1']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth1 == '') { $t_imagewidth1 = $imgdms[0]; }
		$sql4 = "update flc_present_box set box_image1 = 't', box_image1_width = '$t_imagewidth1', box_image1_link = '$t_imagelink1' where box_id = '$boxid';";
		$result4 = mysql_query($sql4);
	}

	if ($_FILES['t_image2']['size'] > 0) {
		$newfile = $h_memid."-".$h_pagid."-".$boxid."-B2.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_image2']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth2 == '') { $t_imagewidth2 = $imgdms[0]; }
		$sql4 = "update flc_present_box set box_image2 = 't', box_image2_width = '$t_imagewidth2', box_image2_link = '$t_imagelink2' where box_id = '$boxid';";
		$result4 = mysql_query($sql4);
	}

	if ($_FILES['t_image3']['size'] > 0) {
		$newfile = $h_memid."-".$h_pagid."-".$boxid."-B3.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_image3']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth3 == '') { $t_imagewidth3 = $imgdms[0]; }
		$sql4 = "update flc_present_box set box_image3 = 't', box_image3_width = '$t_imagewidth3', box_image3_link = '$t_imagelink3' where box_id = '$boxid';";
		$result4 = mysql_query($sql4);
	}

	$sqlpagupd = "update flc_page set pag_editdate = '$nowdate', pag_edittime = '$nowtime' where pag_id = '$h_pagid';";
	$resultpagupd = mysql_query($sqlpagupd); // to update pag_update

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_page_box_add.php?page=$h_pagid&lang=$h_langcode\">";

	exit();
?>

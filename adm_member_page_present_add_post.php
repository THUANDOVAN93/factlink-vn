<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_memid = $_POST['h_memid'];
	$h_langcode = $_POST['h_langcode'];
	$h_freemem = $_POST['h_freemem'];
	$t_setlang = $_POST['t_setlang'];
	$t_pagname = addslashes($_POST['t_pagname']);
	$t_pagpagetitle = addslashes($_POST['t_pagpagetitle']);
	$t_pagsort = addslashes($_POST['t_pagsort']);
	$t_clf = addslashes($_POST['t_clf']);
	$t_pagtitle = addslashes($_POST['t_pagtitle']);
	$t_pagdetail = addslashes($_POST['t_pagdetail']);
	$t_image = $_FILES['t_image'];
	$t_imagewidth = $_POST['t_imagewidth'];
	$t_imageside = $_POST['t_imageside'];
	$t_imagelink = $_POST['t_imagelink'];
	$t_tpk = addslashes($_POST['t_tpk']);
	
	/* Convert LineBreak character to string [br] */
	$t_pagname = str_replace('\\r\\n','[br]',($t_pagname));
	$t_pagtitle = str_replace('\\r\\n','[br]',($t_pagtitle));
	$t_pagdetail = str_replace('\\r\\n','[br]',($t_pagdetail));

	$sql0 = "select * from flc_member where mem_id = '$h_memid';";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $memfolder = $dbarr0['mem_folder']; }

	if ($h_langcode == 'en') {

		$sql1 = "insert into flc_page (pag_show_en, pag_name_en, pag_name_jp, pag_name_vn, pag_pagetitle_en, pag_title_color, pag_title_en, pag_detail_en, pag_sort, pag_type, mem_id)
						values ('$t_setlang', '$t_pagname', '$t_pagname', '$t_pagname', '$t_pagpagetitle', '$t_clf', '$t_pagtitle', '$t_pagdetail', '$t_pagsort', 'pst', '$h_memid');";
		$result1 = mysql_query($sql1);

		$sql2 = "select * from flc_page order by pag_id desc limit 0,1;";
		$result2 = mysql_query($sql2); while ($dbarr2 = mysql_fetch_array($result2)) { $pagid = $dbarr2['pag_id']; }

	} else if ($h_langcode == 'vn') {

		$sql1 = "insert into flc_page (pag_show_vn, pag_name_en, pag_name_jp, pag_name_vn, pag_pagetitle_vn, pag_title_color, pag_title_vn, pag_detail_vn, pag_sort, pag_type, mem_id)
						values ('$t_setlang', '$t_pagname', '$t_pagname', '$t_pagname', '$t_pagpagetitle', '$t_clf', '$t_pagtitle', '$t_pagdetail', '$t_pagsort', 'pst', '$h_memid');";
		$result1 = mysql_query($sql1);

		$sql2 = "select * from flc_page order by pag_id desc limit 0,1;";
		$result2 = mysql_query($sql2); while ($dbarr2 = mysql_fetch_array($result2)) { $pagid = $dbarr2['pag_id']; }

	} else  {

		$sql1 = "insert into flc_page (pag_show_jp, pag_name_en, pag_name_jp, pag_name_vn, pag_pagetitle_jp, pag_title_color, pag_title_jp, pag_detail_jp, pag_sort, pag_type, mem_id)
						values ('$t_setlang', '$t_pagname', '$t_pagname', '$t_pagname', '$t_pagpagetitle', '$t_clf', '$t_pagtitle', '$t_pagdetail', '$t_pagsort', 'pst', '$h_memid');";
		$result1 = mysql_query($sql1);

		$sql2 = "select * from flc_page order by pag_id desc limit 0,1;";
		$result2 = mysql_query($sql2); while ($dbarr2 = mysql_fetch_array($result2)) { $pagid = $dbarr2['pag_id']; }

	}

	$sql3 = "insert into flc_present (pag_id, mem_id, pst_template) values ('$pagid', '$h_memid', '$t_tpk');";
	$result3 = mysql_query($sql3);

	if ($_FILES['t_image']['size'] > 0) {
		$newfile = $h_memid."-".$pagid."-P.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth == '') { $t_imagewidth = $imgdms[0]; }
		$sql4 = "update flc_page set pag_image = 't', pag_image_width = '$t_imagewidth', pag_image_link = '$t_imagelink', pag_image_side = '$t_imageside' where pag_id = '$pagid';";
		$result4 = mysql_query($sql4);
	}

	if ($h_freemem == 't') { $sql9 = "update flc_page set pag_status = 'd' where pag_id = '$pagid';"; $result9 = mysql_query($sql9); }

	$sqlpagupd = "update flc_page set pag_editdate = '$nowdate', pag_edittime = '$nowtime' where pag_id = '$pagid';";
	$resultpagupd = mysql_query($sqlpagupd); // to update pag_update

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_page.php?id=$h_memid\">";

	exit();
?>

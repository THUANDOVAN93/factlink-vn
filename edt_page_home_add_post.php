<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_memid = $_POST['h_memid'];
	$h_langcode = $_POST['h_langcode'];
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
	$t_linetitle2 = addslashes($_POST['t_linetitle2']);
	$t_linedetail2 = addslashes($_POST['t_linedetail2']);
	$t_lineimage2 = $_FILES['t_lineimage2'];
	$t_lineimagewidth2 = $_POST['t_lineimagewidth2'];
	$t_lineimagelink2 = $_POST['t_lineimagelink2'];
	$t_linetitle3 = addslashes($_POST['t_linetitle3']);
	$t_linedetail3 = addslashes($_POST['t_linedetail3']);
	$t_lineimage3 = $_FILES['t_lineimage3'];
	$t_lineimagewidth3 = $_POST['t_lineimagewidth3'];
	$t_lineimagelink3 = $_POST['t_lineimagelink3'];
	$t_desc = addslashes($_POST['t_desc']);

	if ($_SESSION['vmd'] != $h_memid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql0 = "select * from flc_member where mem_id = '$h_memid';";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $memfolder = $dbarr0['mem_folder']; }

	$sql5 = "select * from flc_page where mem_id = '$h_memid' and pag_type = 'hom';";
	$result5 = mysql_query($sql5);
	while ($dbarr5 = mysql_fetch_array($result5)) { $pagid = $dbarr5['pag_id']; }

	if ($pagid != '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_page.php\">"; exit(); }

	if ($h_langcode == 'en') {

		$sql1 = "insert into flc_page (pag_show_en, pag_name_en, pag_name_jp, pag_name_vn, pag_pagetitle_en, pag_title_color, pag_title_en, pag_detail_en, pag_sort, pag_type, mem_id)
						values ('$t_setlang', '$t_pagname', '$t_pagname', '$t_pagname', '$t_pagpagetitle', '$t_clf', '$t_pagtitle', '$t_pagdetail', '$t_pagsort', 'hom', '$h_memid');";
		$result1 = mysql_query($sql1);

		$sql3 = "select * from flc_page order by pag_id desc limit 0,1;";
		$result3 = mysql_query($sql3);
		while ($dbarr3 = mysql_fetch_array($result3)) { $pagid = $dbarr3['pag_id']; }

		$sql2 = "insert into flc_home (hom_keytitle_color, hom_keytitle_en, hom_keydetail_en, hom_keytitle1_en, hom_keydetail1_en, hom_keytitle2_en, hom_keydetail2_en,
						hom_keytitle3_en, hom_keydetail3_en, hom_template, hom_linetitle_color, hom_linetitle_en, hom_linedetail_en, hom_linetitle1_en, hom_linedetail1_en,
						hom_linetitle2_en, hom_linedetail2_en, hom_linetitle3_en, hom_linedetail3_en, hom_description_en, pag_id, mem_id)
						values ('$t_clfkey', '$t_keytitle', '$t_keydetail', '$t_keytitle1', '$t_keydetail1', '$t_keytitle2', '$t_keydetail2', '$t_keytitle3', '$t_keydetail3', '$t_tpk', '$t_clfline',
						'$t_linetitle', '$t_linedetail', '$t_linetitle1', '$t_linedetail1', '$t_linetitle2', '$t_linedetail2', '$t_linetitle3', '$t_linedetail3', '$t_desc', '$pagid', '$h_memid');";

	} else if ($h_langcode == 'vn') {

		$sql1 = "insert into flc_page (pag_show_vn, pag_name_en, pag_name_jp, pag_name_vn, pag_pagetitle_vn, pag_title_color, pag_title_vn, pag_detail_vn, pag_sort, pag_type, mem_id)
						values ('$t_setlang', '$t_pagname', '$t_pagname', '$t_pagname', '$t_pagpagetitle', '$t_clf', '$t_pagtitle', '$t_pagdetail', '$t_pagsort', 'hom', '$h_memid');";
		$result1 = mysql_query($sql1);

		$sql3 = "select * from flc_page order by pag_id desc limit 0,1;";
		$result3 = mysql_query($sql3);
		while ($dbarr3 = mysql_fetch_array($result3)) { $pagid = $dbarr3['pag_id']; }

		$sql2 = "insert into flc_home (hom_keytitle_color, hom_keytitle_vn, hom_keydetail_vn, hom_keytitle1_vn, hom_keydetail1_vn, hom_keytitle2_vn, hom_keydetail2_vn,
						hom_keytitle3_vn, hom_keydetail3_vn, hom_template, hom_linetitle_color, hom_linetitle_vn, hom_linedetail_vn, hom_linetitle1_vn, hom_linedetail1_vn,
						hom_linetitle2_vn, hom_linedetail2_vn, hom_linetitle3_vn, hom_linedetail3_vn, hom_description_vn, pag_id, mem_id)
						values ('$t_clfkey', '$t_keytitle', '$t_keydetail', '$t_keytitle1', '$t_keydetail1', '$t_keytitle2', '$t_keydetail2', '$t_keytitle3', '$t_keydetail3', '$t_tpk', '$t_clfline',
						'$t_linetitle', '$t_linedetail', '$t_linetitle1', '$t_linedetail1', '$t_linetitle2', '$t_linedetail2', '$t_linetitle3', '$t_linedetail3', '$t_desc', '$pagid', '$h_memid');";

	} else  {

		$sql1 = "insert into flc_page (pag_show_jp, pag_name_en, pag_name_jp, pag_name_vn, pag_pagetitle_jp, pag_title_color, pag_title_jp, pag_detail_jp, pag_sort, pag_type, mem_id)
						values ('$t_setlang', '$t_pagname', '$t_pagname', '$t_pagname', '$t_pagpagetitle', '$t_clf', '$t_pagtitle', '$t_pagdetail', '$t_pagsort', 'hom', '$h_memid');";
		$result1 = mysql_query($sql1);

		$sql3 = "select * from flc_page order by pag_id desc limit 0,1;";
		$result3 = mysql_query($sql3);
		while ($dbarr3 = mysql_fetch_array($result3)) { $pagid = $dbarr3['pag_id']; }

		$sql2 = "insert into flc_home (hom_keytitle_color, hom_keytitle_jp, hom_keydetail_jp, hom_keytitle1_jp, hom_keydetail1_jp, hom_keytitle2_jp, hom_keydetail2_jp,
						hom_keytitle3_jp, hom_keydetail3_jp, hom_template, hom_linetitle_color, hom_linetitle_jp, hom_linedetail_jp, hom_linetitle1_jp, hom_linedetail1_jp,
						hom_linetitle2_jp, hom_linedetail2_jp, hom_linetitle3_jp, hom_linedetail3_jp, hom_description_jp, pag_id, mem_id)
						values ('$t_clfkey', '$t_keytitle', '$t_keydetail', '$t_keytitle1', '$t_keydetail1', '$t_keytitle2', '$t_keydetail2', '$t_keytitle3', '$t_keydetail3', '$t_tpk', '$t_clfline',
						'$t_linetitle', '$t_linedetail', '$t_linetitle1', '$t_linedetail1', '$t_linetitle2', '$t_linedetail2', '$t_linetitle3', '$t_linedetail3', '$t_desc', '$pagid', '$h_memid');";

	}

	$result2 = mysql_query($sql2);

	$sql5 = "select * from flc_home order by hom_id desc limit 0,1;";
	$result5 = mysql_query($sql5);
	while ($dbarr5 = mysql_fetch_array($result5)) { $homid = $dbarr5['hom_id']; }

	if ($_FILES['t_image']['size'] > 0) {
		$newfile = $h_memid."-".$pagid."-P.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth == '') { $t_imagewidth = $imgdms[0]; }
		$sql4 = "update flc_page set pag_image = 't', pag_image_width = '$t_imagewidth', pag_image_link = '$t_imagelink', pag_image_side = '$t_imageside' where pag_id = '$pagid';";
		$result4 = mysql_query($sql4);
	}

	if ($_FILES['t_lineimage1']['size'] > 0) {
		$newfile = $h_memid."-".$pagid."-H-1.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_lineimage1']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_lineimagewidth1 == '') { $t_lineimagewidth1 = $imgdms[0]; }
		$sql4 = "update flc_home set hom_lineimage1 = 't', hom_lineimage1_width = '$t_lineimagewidth1', hom_lineimage1_link = '$t_lineimagelink1'
						where hom_id = '$homid';";
		$result4 = mysql_query($sql4);
	}

	if ($_FILES['t_lineimage2']['size'] > 0) {
		$newfile = $h_memid."-".$pagid."-H-2.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_lineimage2']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_lineimagewidth2 == '') { $t_lineimagewidth2 = $imgdms[0]; }
		$sql4 = "update flc_home set hom_lineimage2 = 't', hom_lineimage2_width = '$t_lineimagewidth2', hom_lineimage2_link = '$t_lineimagelink2'
						where hom_id = '$homid';";
		$result4 = mysql_query($sql4);
	}

	if ($_FILES['t_lineimage3']['size'] > 0) {
		$newfile = $h_memid."-".$pagid."-H-3.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_lineimage3']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_lineimagewidth3 == '') { $t_lineimagewidth3 = $imgdms[0]; }
		$sql4 = "update flc_home set hom_lineimage3 = 't', hom_lineimage3_width = '$t_lineimagewidth3', hom_lineimage3_link = '$t_lineimagelink3'
						where hom_id = '$homid';";
		$result4 = mysql_query($sql4);
	}

	// --- Make File Section

	$dirpath = "home/$memfolder";
	$fileindex = fopen("$dirpath/home.php", "x");

	$old_umask = umask(0);
	chmod("$dirpath/home.php", 0777);
	umask($old_umask);

	$filecode = "<?php

	include_once(\"../../include/global_config.php\");

	mysql_query(\"use \$db_name;\");

	if (\$_COOKIE['vlang'] == '') { \$_COOKIE['vlang'] = \"jp\"; }

	\$sql0 = \"select * from flc_page where pag_type = 'hom' and mem_id = '$h_memid';\";
	\$result0 = mysql_query(\$sql0);
	while (\$dbarr0 = mysql_fetch_array(\$result0)) { \$pagshowen = \$dbarr0['pag_show_en']; \$pagshowjp = \$dbarr0['pag_show_jp']; \$pagshowvn = \$dbarr0['pag_show_vn']; }

	\$langarr = array();
	if (\$pagshowjp == 't') { \$langarr[0] = \"jp\"; } else { \$langarr[0] = \"\"; }
	if (\$pagshowvn == 't') { \$langarr[1] = \"vn\"; } else { \$langarr[1] = \"\"; }
	if (\$pagshowen == 't') { \$langarr[2] = \"en\"; } else { \$langarr[2] = \"\"; }

	for (\$i=0;\$i<=2;\$i++) {
		if (\$langarr[\$i] != '') { \$langset = \$langarr[\$i]; }
		if (\$langset == \$_COOKIE['vlang']) { \$i = \$i + 3; }
	}

	echo \"<meta http-equiv = \\\"refresh\\\" content = \\\"0;URL = ../../mem_home.php?id=$h_memid&page=$pagid&lang=\$langset\\\">\";
	exit();

?>";

	fwrite($fileindex, $filecode);
	fclose($fileindex);

	$sqlpagupd = "update flc_page set pag_editdate = '$nowdate', pag_edittime = '$nowtime' where pag_id = '$pagid';";
	$resultpagupd = mysql_query($sqlpagupd); // to update pag_update

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_page.php\">";

	exit();
?>

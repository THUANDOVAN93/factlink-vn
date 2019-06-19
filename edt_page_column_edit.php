<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_page_column_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_SESSION['vmd'];
	$conid = $_GET['con'];
	$langcode = $_GET['lang'];
	
	if ($langcode != 'en' && $langcode != 'jp' && $langcode != 'vn') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=4\">"; exit(); }
	
	$checkpackage = checkfreemem($memid);
	if ($checkpackage == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=5\">"; exit(); }
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "page_column_edit";
	$currentrec = $conid;
	$currentuserid = $_SESSION['vmd']; 
	$currentuserper = "mem";
	
	$sqlusl0 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl0 = mysql_query($sqlusl0);	
	
	$sqlusl1 = "select * from flc_uselog where usl_filepage = '$currentpage' and usl_filerec = '$currentrec';"; 
	$resultusl1 = mysql_query($sqlusl1);
	while ($dbarrusl1 = mysql_fetch_array($resultusl1)) { 
	
		$usltimestamp = $dbarrusl1['usl_timestamp'];
		
		if ($usltimestamp > $limittimestamp) { 
			
			$_SESSION['vlock_userid'] = $dbarrusl1['usl_userid'];
			$_SESSION['vlock_userper'] = $dbarrusl1['usl_userper'];
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_lock.php\">"; exit(); 
			
		} else { $usldel = "t"; }
		
	}
	
	if ($usldel == 't') { 
	
		$sqlusl2 = "delete from flc_uselog where usl_timestamp = '$usltimestamp';"; 
		$resultusl2 = mysql_query($sqlusl2);
		
	}
	
	$sqlusl3 = "insert into flc_uselog (usl_filepage, usl_filerec, usl_userid, usl_userper) values ('$currentpage', '$currentrec', '$currentuserid', '$currentuserper');"; 
	$resultusl3 = mysql_query($sqlusl3);
	
	// --------------------
	
	$sql0 = "select * from flc_member where mem_id = '$memid';"; 
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $memfolder = $dbarr0['mem_folder']; }
	
	$sql3 = "select * from flc_page where mem_id = '$memid' and pag_type = 'prf';"; 
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) { 
		$prfshowen = $dbarr3['pag_show_en']; 
		$prfshowvn = $dbarr3['pag_show_vn']; 
		$prfshowjp = $dbarr3['pag_show_jp']; 
	}
	
	if ($langcode == 'en') { if ($prfshowen != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=3\">"; exit(); } }
	if ($langcode == 'vn') { if ($prfshowvn != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=3\">"; exit(); } }
	if ($langcode == 'jp') { if ($prfshowjp != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=3\">"; exit(); } }
	
	$sql2 = "select * from flc_content where con_id = '$conid' and mem_id = '$memid';"; 
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
		
		$pagid = $dbarr2['pag_id']; 
		$contitlecolor = $dbarr2['con_title_color']; 
		$contitleen = $dbarr2['con_title_en']; 
		$contitlejp = $dbarr2['con_title_jp']; 
		$contitlevn = $dbarr2['con_title_vn']; 
		$consubtitleen = $dbarr2['con_subtitle_en']; 
		$consubtitlejp = $dbarr2['con_subtitle_jp']; 
		$consubtitlevn = $dbarr2['con_subtitle_vn']; 
		$condetailen = $dbarr2['con_detail_en']; 
		$condetailjp = $dbarr2['con_detail_jp']; 
		$condetailvn = $dbarr2['con_detail_vn']; 
		$conimage = $dbarr2['con_image']; 
		$conimagewidth = $dbarr2['con_image_width']; if ($conimagewidth == '0') { $conimagewidth = ""; }
		$conimagelink = $dbarr2['con_image_link']; 
		$conpattern = $dbarr2['con_pattern']; 
		$consort = $dbarr2['con_sort']; 
	
	}
	
	if ($conimage == 't') { 
		
		$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-".$conid."-C.jpg";
		if ($conimagewidth == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $conimagewidth; }
		if ($imgwidth > 740) { $imgwidth = 740; }
		$conimagepreview = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\"/>"; 
		
		if ($conimagelink == 't') { $conimagepreview = "<a href=\"".$imgpath."\" target=\"_blank\">".$conimagepreview."</a>"; }
	
	} else { $conimagedisable = "checked"; }
	
	if ($conimagelink == 't') { $conimagelink = "checked"; } else { $conimagelink = ""; }	
	
	$sqlptc = "select * from flc_pattern_content order by ptc_name_en asc;"; 
	$resultptc = mysql_query($sqlptc);
	while ($dbarrptc = mysql_fetch_array($resultptc)) {
	
		$ptcid = $dbarrptc['ptc_id'];
		$ptcname = $dbarrptc['ptc_name_en']; 
		if ($ptcid == $conpattern) { $ptcselected = "selected"; } else { $ptcselected = ""; }
		
		$tpl->assign("##ptcid##", $ptcid);
		$tpl->assign("##ptcname##", $ptcname);
		$tpl->assign("##ptcselected##", $ptcselected);
		$tpl->parse ("#####ROW#####", '.rows_ptc');
		
	}
	
	$sqlclf = "select * from flc_color_font order by clf_name_en asc;"; 
	$resultclf = mysql_query($sqlclf);
	while ($dbarrclf = mysql_fetch_array($resultclf)) {
	
		$clfid = $dbarrclf['clf_id'];
		$clfname = $dbarrclf['clf_name_en']; 
		$clfcode = $dbarrclf['clf_code']; 
		if ($clfcode == $contitlecolor) { $clfselected = "selected"; } else { $clfselected = ""; }
		
		$tpl->assign("##clfid##", $clfid);
		$tpl->assign("##clfname##", $clfname);
		$tpl->assign("##clfcode##", $clfcode);
		$tpl->assign("##clfselected##", $clfselected);
		$tpl->parse ("#####ROW#####", '.rows_clf');
		
	}
	
	$sql1 = "select * from flc_page where pag_id = '$pagid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) { $pagnameen = $dbarr1['pag_name_en']; $pagnamejp = $dbarr1['pag_name_jp']; $pagnamevn = $dbarr1['pag_name_vn']; }
	
	if ($langcode == 'en') { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "English Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Anh"; } else { $langcodefull = "英語のページ"; }
		
		$pagname = $pagnameen;
		$contitle = $contitleen;
		$consubtitle = $consubtitleen;
		$condetail = $condetailen;
	
	} else if ($langcode == 'vn') { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Vietnamese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Việt"; } else { $langcodefull = "ベトナム語のページ"; }
		
		$pagname = $pagnamevn;
		$contitle = $contitlevn;
		$consubtitle = $consubtitlevn;
		$condetail = $condetailvn;
		
	} else { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Japanese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Nhật"; } else { $langcodefull = "日本語のページ"; }
		
		$pagname = $pagnamejp;
		$contitle = $contitlejp;
		$consubtitle = $consubtitlejp;
		$condetail = $condetailjp;
		
	}
	
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##pagid##", $pagid);
	$tpl->assign("##conid##", $conid);
	$tpl->assign("##contitle##", $contitle);
	$tpl->assign("##consubtitle##", $consubtitle);
	$tpl->assign("##condetail##", $condetail);
	$tpl->assign("##conimagepreview##", $conimagepreview);
	$tpl->assign("##conimagewidth##", $conimagewidth);
	$tpl->assign("##conimagelink##", $conimagelink);
	$tpl->assign("##conimagedisable##", $conimagedisable);
	$tpl->assign("##consort##", $consort);
	$tpl->assign("##langcode##", $langcode);
	$tpl->assign("##langcodefull##", $langcodefull);
	$tpl->assign("##pagname##", $pagname);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
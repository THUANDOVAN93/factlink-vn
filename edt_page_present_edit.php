<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_page_present_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_SESSION['md'];
	$pagid = $_GET['page'];
	$langcode = $_GET['lang'];
	
	if ($langcode != 'en' && $langcode != 'jp' && $langcode != 'vn') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=4\">"; exit(); }
	
	$checkpackage = checkfreemem($memid);
	if ($checkpackage == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=5\">"; exit(); }
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "page_present_edit";
	$currentrec = $pagid;
	$currentuserid = $_SESSION['md']; 
	$currentuserper = "mem";
	
	$sqlusl0 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl0 = mysql_query($sqlusl0);
	
	$sqlusl1 = "select * from flc_uselog where usl_filepage = '$currentpage' and usl_filerec = '$currentrec';"; 
	$resultusl1 = mysql_query($sqlusl1);
	while ($dbarrusl1 = mysql_fetch_array($resultusl1)) { 
	
		$usltimestamp = $dbarrusl1['usl_timestamp'];
		
		if ($usltimestamp > $limittimestamp) { 
			
			$_SESSION['lock_userid'] = $dbarrusl1['usl_userid'];
			$_SESSION['lock_userper'] = $dbarrusl1['usl_userper'];
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
	
	$sql1 = "select * from flc_page where pag_id = '$pagid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
	
		$pagtype = $dbarr1['pag_type'];
		if ($pagtype != 'pst') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_page.php\">"; exit(); }
		
		if ($dbarr1['mem_id'] != $memid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_page.php\">"; exit(); }
		
		$pagnameen = stripslashes($dbarr1['pag_name_en']);
		$pagnamejp = stripslashes($dbarr1['pag_name_jp']);
		$pagnamevn = stripslashes($dbarr1['pag_name_vn']);
		$pagpagetitleen = stripslashes($dbarr1['pag_pagetitle_en']);
		$pagpagetitlejp = stripslashes($dbarr1['pag_pagetitle_jp']);
		$pagpagetitlevn = stripslashes($dbarr1['pag_pagetitle_vn']);
		$pagtitleen = stripslashes($dbarr1['pag_title_en']);
		$pagtitlejp = stripslashes($dbarr1['pag_title_jp']);
		$pagtitlevn = stripslashes($dbarr1['pag_title_vn']);
		$pagtitlecolor = $dbarr1['pag_title_color'];
		$pagdetailen = stripslashes($dbarr1['pag_detail_en']);
		$pagdetailjp = stripslashes($dbarr1['pag_detail_jp']);
		$pagdetailvn = stripslashes($dbarr1['pag_detail_vn']);
		$pagimage = $dbarr1['pag_image'];
		$pagimagewidth = $dbarr1['pag_image_width']; if ($pagimagewidth == '0') { $pagimagewidth = ""; }
		$pagimagelink = $dbarr1['pag_image_link'];
		$pagimageside = $dbarr1['pag_image_side']; if ($pagimageside == 'r') { $pagimagesidel = ""; $pagimagesider = "checked"; } else { $pagimagesidel = "checked"; $pagimagesider = ""; }
		$pagsort = $dbarr1['pag_sort'];
		$pagshowen = $dbarr1['pag_show_en'];
		$pagshowjp = $dbarr1['pag_show_jp'];
		$pagshowvn = $dbarr1['pag_show_vn'];
	
	}
	
	$sql2 = "select * from flc_present where pag_id = '$pagid';"; 
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
	
		$psttitleen = stripslashes($dbarr2['pst_title_en']);
		$psttitlejp = stripslashes($dbarr2['pst_title_jp']);
		$psttitlevn = stripslashes($dbarr2['pst_title_vn']);
		$psttitledetailen = stripslashes($dbarr2['pst_title_detail_en']);
		$psttitledetailjp = stripslashes($dbarr2['pst_title_detail_jp']);
		$psttitledetailvn = stripslashes($dbarr2['pst_title_detail_vn']);
		$pstbottomen = stripslashes($dbarr2['pst_bottom_en']);
		$pstbottomjp = stripslashes($dbarr2['pst_bottom_jp']);
		$pstbottomvn = stripslashes($dbarr2['pst_bottom_vn']);
		$pstbottomdetailen = stripslashes($dbarr2['pst_bottom_detail_en']);
		$pstbottomdetailjp = stripslashes($dbarr2['pst_bottom_detail_jp']);
		$pstbottomdetailvn = stripslashes($dbarr2['pst_bottom_detail_vn']);
		$psttemplate = $dbarr2['pst_template'];
	
	}
	
	if ($pagimage == 't') { 
		
		$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-P.jpg";
		if ($pagimagewidth == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $pagimagewidth; }
		if ($imgwidth > 740) { $imgwidth = 740; }
		$pagimagepreview = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\"/>"; 
		
		if ($pagimagelink == 't') { $pagimagepreview = "<a href=\"".$imgpath."\" target=\"_blank\">".$pagimagepreview."</a>"; }
	
	} else { $pagimagedisable = "checked"; }
	
	if ($pagimagelink == 't') { $pagimagelink = "checked"; } else { $pagimagelink = ""; }
	
	$sqlclf = "select * from flc_color_font order by clf_name_en asc;"; 
	$resultclf = mysql_query($sqlclf);
	while ($dbarrclf = mysql_fetch_array($resultclf)) {
	
		$clfid = $dbarrclf['clf_id'];
		$clfname = $dbarrclf['clf_name_en']; 
		$clfcode = $dbarrclf['clf_code']; 
		if ($clfcode == $pagtitlecolor) { $clfselected = "selected"; } else { $clfselected = ""; }
		
		$tpl->assign("##clfid##", $clfid);
		$tpl->assign("##clfname##", $clfname);
		$tpl->assign("##clfcode##", $clfcode);
		$tpl->assign("##clfselected##", $clfselected);
		$tpl->parse ("#####ROW#####", '.rows_clf');
		
	}
	
	$sqltpk = "select * from flc_template_key order by tpk_name_en asc;"; 
	$resulttpk = mysql_query($sqltpk);
	while ($dbarrtpk = mysql_fetch_array($resulttpk)) {
	
		$tpkid = $dbarrtpk['tpk_id'];
		$tpkname = $dbarrtpk['tpk_name_en']; 
		$tpktitlecolor = $dbarrtpk['tpk_title_color'];
		$tpkbgcolor = $dbarrtpk['tpk_bg_color'];
		if ($tpkid == $psttemplate) { $tpkselected = "selected"; } else { $tpkselected = ""; }
		
		$tpl->assign("##tpkid##", $tpkid);
		$tpl->assign("##tpkname##", $tpkname);
		$tpl->assign("##tpktitlecolor##", $tpktitlecolor);
		$tpl->assign("##tpkbgcolor##", $tpkbgcolor);
		$tpl->assign("##tpkselected##", $tpkselected);
		$tpl->parse ("#####ROW#####", '.rows_tpk');
		
	}
	
	if ($langcode == 'en') { 
	
		if ($pagshowen == 't') { $pagshow = "checked"; } else { $pagshow = ""; }
		
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "English Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Anh"; } else { $langcodefull = "英語のページ"; }
		$pagname = $pagnameen;
		$pagpagetitle = $pagpagetitleen;
		$pagtitle = $pagtitleen;
		$pagdetail = $pagdetailen;
		$psttitle = $psttitleen;
		$psttitledetail = $psttitledetailen;
		$pstbottom = $pstbottomen;
		$pstbottomdetail = $pstbottomdetailen;
	
	} else if ($langcode == 'vn') { 
	
		if ($pagshowvn == 't') { $pagshow = "checked"; } else { $pagshow = ""; }
		
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Vietnamese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Việt"; } else { $langcodefull = "ベトナム語のページ"; }
		$pagname = $pagnamevn;
		$pagpagetitle = $pagpagetitlevn;
		$pagtitle = $pagtitlevn;
		$pagdetail = $pagdetailvn;
		$psttitle = $psttitlevn;
		$psttitledetail = $psttitledetailvn;
		$pstbottom = $pstbottomvn;
		$pstbottomdetail = $pstbottomdetailvn;
		
	} else { 
	
		if ($pagshowjp == 't') { $pagshow = "checked"; } else { $pagshow = ""; }
		
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Japanese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Nhật"; } else { $langcodefull = "日本語のページ"; }
		$pagname = $pagnamejp;
		$pagpagetitle = $pagpagetitlejp;
		$pagtitle = $pagtitlejp;
		$pagdetail = $pagdetailjp;
		$psttitle = $psttitlejp;
		$psttitledetail = $psttitledetailjp;
		$pstbottom = $pstbottomjp;
		$pstbottomdetail = $pstbottomdetailjp;
		
	}
	
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##pagid##", $pagid);
	$tpl->assign("##langcode##", $langcode);
	$tpl->assign("##langcodefull##", $langcodefull);
	$tpl->assign("##pagname##", $pagname);
	$tpl->assign("##pagpagetitle##", $pagpagetitle);
	$tpl->assign("##pagtitle##", $pagtitle);
	$tpl->assign("##pagdetail##", $pagdetail);
	$tpl->assign("##pagsort##", $pagsort);
	$tpl->assign("##pagshow##", $pagshow);
	$tpl->assign("##pagstatus##", $pagstatus);
	$tpl->assign("##pagimagepreview##", $pagimagepreview);
	$tpl->assign("##pagimagewidth##", $pagimagewidth);
	$tpl->assign("##pagimagesidel##", $pagimagesidel);
	$tpl->assign("##pagimagesider##", $pagimagesider);
	$tpl->assign("##pagimagelink##", $pagimagelink);
	$tpl->assign("##pagimagedisable##", $pagimagedisable);
	$tpl->assign("##psttitle##", $psttitle);
	$tpl->assign("##psttitledetail##", $psttitledetail);
	$tpl->assign("##pstbottom##", $pstbottom);
	$tpl->assign("##pstbottomdetail##", $pstbottomdetail);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
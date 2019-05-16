<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_page_content_edit.html";
	$media_option_origin = array(
		'image' => 'image',
		'video' => 'video'
	);
	
	

	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_GET['id'];
	$pagid = $_GET['page'];
	$langcode = $_GET['lang'];
	
	// echo "<pre>".print_r($_COOKIE,true)."</pre>";
	
	if (!in_array($langcode,['en','jp','vn'])) {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=4\">"; exit();
	}
	
	$checkpackage = checkfreemem($memid);
	if ($checkpackage == '') { $freemem = "t"; } else { $freemem = ""; } 
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "page_content_edit";
	$currentrec = $pagid;
	$currentuserid = $_SESSION['vd']; 
	$currentuserper = "adm";
	
	$sqlusl0 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl0 = mysql_query($sqlusl0);
	
	$sqlusl1 = "select * from flc_uselog where usl_filepage = '$currentpage' and usl_filerec = '$currentrec';"; 
	$resultusl1 = mysql_query($sqlusl1);
	while ($dbarrusl1 = mysql_fetch_array($resultusl1)) { 
	
		$usltimestamp = $dbarrusl1['usl_timestamp'];
		
		if ($usltimestamp > $limittimestamp) { 
			
			$_SESSION['vlock_userid'] = $dbarrusl1['usl_userid'];
			$_SESSION['vlock_userper'] = $dbarrusl1['usl_userper'];
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_lock.php\">"; exit(); 
			
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
	while ($dbarr0 = mysql_fetch_array($result0)) { 
		
		if ($_COOKIE['vlang'] == 'en') { $memcomname = $dbarr0['mem_comname_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $memcomname = $dbarr0['mem_comname_vn']; }
		else { $memcomname = $dbarr0['mem_comname_jp']; } 
		$memfolder = $dbarr0['mem_folder'];
		
	}
	
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
		if ($pagtype != 'con') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_page.php\">"; exit(); }
		
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
		$pagtitlecolor = stripslashes($dbarr1['pag_title_color']);
		$pagdetailen = stripslashes($dbarr1['pag_detail_en']);
		$pagdetailjp = stripslashes($dbarr1['pag_detail_jp']);
		$pagdetailvn = stripslashes($dbarr1['pag_detail_vn']);
		$pagimage = $dbarr1['pag_image'];
		$pagvideolink = htmlentities($dbarr1['pag_video_link']);
		$pagmedia_option = $dbarr1['pag_media_option'];
		$pagimagewidth = $dbarr1['pag_image_width']; if ($pagimagewidth == '0') { $pagimagewidth = ""; }
		$pagimagelink = $dbarr1['pag_image_link'];
		$pagimageside = $dbarr1['pag_image_side']; if ($pagimageside == 'r') { $pagimagesidel = ""; $pagimagesider = "checked"; } else { $pagimagesidel = "checked"; $pagimagesider = ""; }
		$pagsort = stripslashes($dbarr1['pag_sort']);
		$pagshowen = stripslashes($dbarr1['pag_show_en']);
		$pagshowjp = stripslashes($dbarr1['pag_show_jp']);
		$pagshowvn = stripslashes($dbarr1['pag_show_vn']);
	
	}
	
	/* Convert [br] to actual [LineBreak] for <textarea> */
	$pagnameen = str_replace('[br]',PHP_EOL,$pagnameen);
	$pagnamejp = str_replace('[br]',PHP_EOL,$pagnamejp);
	$pagnamevn = str_replace('[br]',PHP_EOL,$pagnamevn);
	
	$pagtitleen = str_replace('[br]',PHP_EOL,$pagtitleen);
	$pagtitlejp = str_replace('[br]',PHP_EOL,$pagtitlejp);
	$pagtitlevn = str_replace('[br]',PHP_EOL,$pagtitlevn);
	
	$pagdetailen = str_replace('[br]',PHP_EOL,$pagdetailen);
	$pagdetailjp = str_replace('[br]',PHP_EOL,$pagdetailjp);
	$pagdetailvn = str_replace('[br]',PHP_EOL,$pagdetailvn);
	
	
	
	
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

	$meoselected_top_cr = '';
	foreach ($media_option_origin as $key => $option) {
		$tpl->assign("##meoname##", $option);
		$tpl->assign("##meovalue##", $option);
		if ( $pagmedia_option == $option ) {
			$meoselected_top_cr = 'selected';
		} else {
			$meoselected_top_cr = '';
		}
		$tpl->assign("##meoselected##", $meoselected_top_cr);
		$tpl->parse ("#####ROW#####", '.rows_meo');
	}

	if ($langcode == 'en') { 
	
		if ($pagshowen == 't') { $pagshow = "checked"; } else { $pagshow = ""; }
		
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "English Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Anh"; } else { $langcodefull = "英語のページ"; }
		$pagname = $pagnameen;
		$pagpagetitle = $pagpagetitleen;
		$pagtitle = $pagtitleen;
		$pagdetail = $pagdetailen;
	
	} else if ($langcode == 'vn') { 
	
		if ($pagshowvn == 't') { $pagshow = "checked"; } else { $pagshow = ""; }
		
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Vietnamese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Việt"; } else { $langcodefull = "ベトナム語のページ"; }
		$pagname = $pagnamevn;
		$pagpagetitle = $pagpagetitlevn;
		$pagtitle = $pagtitlevn;
		$pagdetail = $pagdetailvn;
		
	} else { 
	
		if ($pagshowjp == 't') { $pagshow = "checked"; } else { $pagshow = ""; }
		
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Japanese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Nhật"; } else { $langcodefull = "日本語のページ"; }
		$pagname = $pagnamejp;
		$pagpagetitle = $pagpagetitlejp;
		$pagtitle = $pagtitlejp;
		$pagdetail = $pagdetailjp;
		
	}
	
	
	
	
	
	$tpl->assign("##freemem##", $freemem);
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##memcomname##", $memcomname);
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
	$tpl->assign("##pagvideolink##", $pagvideolink);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
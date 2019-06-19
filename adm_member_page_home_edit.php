<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_page_home_edit.html";

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
	
	if ($langcode != 'en' && $langcode != 'jp' && $langcode != 'vn') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=4\">"; exit(); }
	
	$checkpackage = checkfreemem($memid);
	if ($checkpackage == '') { $freemem = "t"; } else { $freemem = ""; }
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "page_home_edit";
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
		if ($pagtype != 'hom') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_page.php\">"; exit(); }
		
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
		$pagsort = $dbarr1['pag_sort'];
		$pagshowen = $dbarr1['pag_show_en'];
		$pagshowjp = $dbarr1['pag_show_jp'];
		$pagshowvn = $dbarr1['pag_show_vn'];
	}
	
	if ($pagimage == 't') { 
		
		$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-P.jpg";
		if ($pagimagewidth == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $pagimagewidth; }
		if ($imgwidth > 740) { $imgwidth = 740; }
		$pagimagepreview = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\"/>"; 
		
		if ($pagimagelink == 't') { $pagimagepreview = "<a href=\"".$imgpath."\" target=\"_blank\">".$pagimagepreview."</a>"; }
	
	} else {
		//$pagimagedisable = "checked";
	}
	
	if ($pagimagelink == 't') { $pagimagelink = "checked"; } else { $pagimagelink = ""; }
	
	
	
	
	$sql2 = "select * from flc_home where mem_id = '$memid';"; 
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
	
		$homid = $dbarr2['hom_id'];
		$homtemplate = stripslashes($dbarr2['hom_template']);
		$homkeytitleen = stripslashes($dbarr2['hom_keytitle_en']);
		$homkeytitlejp = stripslashes($dbarr2['hom_keytitle_jp']);
		$homkeytitlevn = stripslashes($dbarr2['hom_keytitle_vn']);
		$homkeytitlecolor = stripslashes($dbarr2['hom_keytitle_color']);
		$homkeydetailen = stripslashes($dbarr2['hom_keydetail_en']);
		$homkeydetailjp = stripslashes($dbarr2['hom_keydetail_jp']);
		$homkeydetailvn = stripslashes($dbarr2['hom_keydetail_vn']);
		$homkeytitle1en = stripslashes($dbarr2['hom_keytitle1_en']);
		$homkeytitle1jp = stripslashes($dbarr2['hom_keytitle1_jp']);
		$homkeytitle1vn = stripslashes($dbarr2['hom_keytitle1_vn']);
		$homkeydetail1en = stripslashes($dbarr2['hom_keydetail1_en']);
		$homkeydetail1jp = stripslashes($dbarr2['hom_keydetail1_jp']);
		$homkeydetail1vn = stripslashes($dbarr2['hom_keydetail1_vn']);
		$homkeytitle2en = stripslashes($dbarr2['hom_keytitle2_en']);
		$homkeytitle2jp = stripslashes($dbarr2['hom_keytitle2_jp']);
		$homkeytitle2vn = stripslashes($dbarr2['hom_keytitle2_vn']);
		$homkeydetail2en = stripslashes($dbarr2['hom_keydetail2_en']);
		$homkeydetail2jp = stripslashes($dbarr2['hom_keydetail2_jp']);
		$homkeydetail2vn = stripslashes($dbarr2['hom_keydetail2_vn']);
		$homkeytitle3en = stripslashes($dbarr2['hom_keytitle3_en']);
		$homkeytitle3jp = stripslashes($dbarr2['hom_keytitle3_jp']);
		$homkeytitle3vn = stripslashes($dbarr2['hom_keytitle3_vn']);
		$homkeydetail3en = stripslashes($dbarr2['hom_keydetail3_en']);
		$homkeydetail3jp = stripslashes($dbarr2['hom_keydetail3_jp']);
		$homkeydetail3vn = stripslashes($dbarr2['hom_keydetail3_vn']);
		$homlinetitleen = stripslashes($dbarr2['hom_linetitle_en']);
		$homlinetitlejp = stripslashes($dbarr2['hom_linetitle_jp']);
		$homlinetitlevn = stripslashes($dbarr2['hom_linetitle_vn']);
		$homlinetitlecolor = stripslashes($dbarr2['hom_linetitle_color']);
		$homlinedetailen = stripslashes($dbarr2['hom_linedetail_en']);
		$homlinedetailjp = stripslashes($dbarr2['hom_linedetail_jp']);
		$homlinedetailvn = stripslashes($dbarr2['hom_linedetail_vn']);
		$homlinetitle1en = stripslashes($dbarr2['hom_linetitle1_en']);
		$homlinetitle1jp = stripslashes($dbarr2['hom_linetitle1_jp']);
		$homlinetitle1vn = stripslashes($dbarr2['hom_linetitle1_vn']);
		$homlinedetail1en = stripslashes($dbarr2['hom_linedetail1_en']);
		$homlinedetail1jp = stripslashes($dbarr2['hom_linedetail1_jp']);
		$homlinedetail1vn = stripslashes($dbarr2['hom_linedetail1_vn']);
		$homlineimage1 = $dbarr2['hom_lineimage1'];
		$homlineimage1width = $dbarr2['hom_lineimage1_width']; if ($homlineimage1width == '0') { $homlineimage1width = ""; }
		$homlineimage1link = stripslashes($dbarr2['hom_lineimage1_link']);
		$hommedia_option1_cr = $dbarr2['hom_media_option1'];
		$homvideo1_link_cr = $dbarr2['hom_linevideo1_link'];



		$homlinetitle2en = stripslashes($dbarr2['hom_linetitle2_en']);
		$homlinetitle2jp = stripslashes($dbarr2['hom_linetitle2_jp']);
		$homlinetitle2vn = stripslashes($dbarr2['hom_linetitle2_vn']);
		$homlinedetail2en = stripslashes($dbarr2['hom_linedetail2_en']);
		$homlinedetail2jp = stripslashes($dbarr2['hom_linedetail2_jp']);
		$homlinedetail2vn = stripslashes($dbarr2['hom_linedetail2_vn']);
		$homlineimage2 = $dbarr2['hom_lineimage2'];
		$homlineimage2width = $dbarr2['hom_lineimage2_width']; if ($homlineimage2width == '0') { $homlineimage2width = ""; }
		$homlineimage2link = stripslashes($dbarr2['hom_lineimage2_link']);
		$hommedia_option2_cr = $dbarr2['hom_media_option2'];
		$homvideo2_link_cr = $dbarr2['hom_linevideo2_link'];


		$homlinetitle3en = stripslashes($dbarr2['hom_linetitle3_en']);
		$homlinetitle3jp = stripslashes($dbarr2['hom_linetitle3_jp']);
		$homlinetitle3vn = stripslashes($dbarr2['hom_linetitle3_vn']);
		$homlinedetail3en = stripslashes($dbarr2['hom_linedetail3_en']);
		$homlinedetail3jp = stripslashes($dbarr2['hom_linedetail3_jp']);
		$homlinedetail3vn = stripslashes($dbarr2['hom_linedetail3_vn']);
		$homlineimage3 = $dbarr2['hom_lineimage3'];
		$homlineimage3width = $dbarr2['hom_lineimage3_width']; if ($homlineimage3width == '0') { $homlineimage3width = ""; }
		$homlineimage3link = stripslashes($dbarr2['hom_lineimage3_link']);
		$hommedia_option3_cr = $dbarr2['hom_media_option3'];
		$homvideo3_link_cr = $dbarr2['hom_linevideo3_link'];


		$homdescen = stripslashes($dbarr2['hom_description_en']);
		$homdescjp = stripslashes($dbarr2['hom_description_jp']);
		$homdescvn = stripslashes($dbarr2['hom_description_vn']);
	}

	$meoselected_top = '';
	$meoselected_1 = '';
	$meoselected_2 = '';
	$meoselected_3 = '';
	foreach ($media_option_origin as $key => $option) {
		
		$tpl->assign("##meoname##", $option);
		$tpl->assign("##meovalue##", $option);
		if ( $pagmedia_option == $option ) {
			$meoselected_top = 'selected';
		} else {
			$meoselected_top = '';
		}
		
		if ( $hommedia_option1_cr == $option ) {
			$meoselected_1 = 'selected';
		} else {
			$meoselected_1 = '';
		}
		
		if ( $hommedia_option2_cr == $option ) {
			$meoselected_2 = 'selected';
		} else {
			$meoselected_2 = '';
		}
		
		if ( $hommedia_option3_cr == $option ) {
			$meoselected_3 = 'selected';
		} else {
			$meoselected_3 = '';
		}
		$tpl->assign("##meoselected##", $meoselected_top);
		$tpl->assign("##meoselected1##", $meoselected_1);
		$tpl->assign("##meoselected2##", $meoselected_2);
		$tpl->assign("##meoselected3##", $meoselected_3);
		$tpl->parse ("#####ROW#####", '.rows_meo');
		$tpl->parse ("#####ROW#####", '.rows_meo1');
		$tpl->parse ("#####ROW#####", '.rows_meo2');
		$tpl->parse ("#####ROW#####", '.rows_meo3');
		
	}

	$tpl->assign("##homevideolink1##", htmlentities($homvideo1_link_cr));
	$tpl->assign("##homevideolink2##", htmlentities($homvideo2_link_cr));
	$tpl->assign("##homevideolink3##", htmlentities($homvideo3_link_cr));
	
	// line image 1
	if ($homlineimage1 == 't') { 
		
		$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-H-1.jpg";
		if ($homlineimage1width == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $homlineimage1width; }
		$homimagewidth1 = $imgwidth;
		if ($imgwidth > 740) { $imgwidth = 740; }
		$homimagepreview1 = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\"/>"; 
		
		if ($homlineimage1link == 't') { $homimagepreview1 = "<a href=\"".$imgpath."\" target=\"_blank\">".$homimagepreview1."</a>"; }
	
	} else { $homimagedisable1 = "checked"; }
	
	if ($homlineimage1link == 't') { $homimagelink1 = "checked"; } else { $homimagelink1 = ""; }
	
	// line image 2
	if ($homlineimage2 == 't') { 
		
		$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-H-2.jpg";
		if ($homlineimage2width == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $homlineimage2width; }
		$homimagewidth2 = $imgwidth;
		if ($imgwidth > 740) { $imgwidth = 740; }
		$homimagepreview2 = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\"/>"; 
		
		if ($homlineimage2link == 't') { $homimagepreview2 = "<a href=\"".$imgpath."\" target=\"_blank\">".$homimagepreview2."</a>"; }
	
	} else { $homimagedisable2 = "checked"; }
	
	if ($homlineimage2link == 't') { $homimagelink2 = "checked"; } else { $homimagelink2 = ""; }
	
	// line image 3
	if ($homlineimage3 == 't') { 
		
		$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-H-3.jpg";
		if ($homlineimage3width == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $homlineimage3width; }
		$homimagewidth3 = $imgwidth;
		if ($imgwidth > 740) { $imgwidth = 740; }
		$homimagepreview3 = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\"/>"; 
		
		if ($homlineimage3link == 't') { $homimagepreview3 = "<a href=\"".$imgpath."\" target=\"_blank\">".$homimagepreview3."</a>"; }
	
	} else { $homimagedisable3 = "checked"; }
	
	if ($homlineimage3link == 't') { $homimagelink3 = "checked"; } else { $homimagelink3 = ""; }
	
	$sqltpk = "select * from flc_template_key order by tpk_name_en asc;"; 
	$resulttpk = mysql_query($sqltpk);
	while ($dbarrtpk = mysql_fetch_array($resulttpk)) {
	
		$tpkid = $dbarrtpk['tpk_id'];
		$tpkname = $dbarrtpk['tpk_name_en']; 
		$tpktitlecolor = $dbarrtpk['tpk_title_color'];
		$tpkbgcolor = $dbarrtpk['tpk_bg_color'];
		if ($tpkid == $homtemplate) { $tpkselected = "selected"; } else { $tpkselected = ""; }
		
		$tpl->assign("##tpkid##", $tpkid);
		$tpl->assign("##tpkname##", $tpkname);
		$tpl->assign("##tpktitlecolor##", $tpktitlecolor);
		$tpl->assign("##tpkbgcolor##", $tpkbgcolor);
		$tpl->assign("##tpkselected##", $tpkselected);
		$tpl->parse ("#####ROW#####", '.rows_tpk');
		
	}
	
	$sqlclf = "select * from flc_color_font order by clf_name_en asc;"; 
	$resultclf = mysql_query($sqlclf);
	while ($dbarrclf = mysql_fetch_array($resultclf)) {
	
		$clfid = $dbarrclf['clf_id'];
		$clfname = $dbarrclf['clf_name_en']; 
		$clfcode = $dbarrclf['clf_code']; 
		if ($clfcode == $pagtitlecolor) { $clfselected = "selected"; } else { $clfselected = ""; }
		if ($clfcode == $homkeytitlecolor) { $clfkeyselected = "selected"; } else { $clfkeyselected = ""; }
		if ($clfcode == $homlinetitlecolor) { $clflineselected = "selected"; } else { $clflineselected = ""; }
		
		$tpl->assign("##clfid##", $clfid);
		$tpl->assign("##clfname##", $clfname);
		$tpl->assign("##clfcode##", $clfcode);
		$tpl->assign("##clfselected##", $clfselected);
		$tpl->parse ("#####ROW#####", '.rows_clf');
		
		$tpl->assign("##clfkeyid##", $clfid);
		$tpl->assign("##clfkeyname##", $clfname);
		$tpl->assign("##clfkeycode##", $clfcode);
		$tpl->assign("##clfkeyselected##", $clfkeyselected);
		$tpl->parse ("#####ROW#####", '.rows_clfkey');
		
		$tpl->assign("##clflineid##", $clfid);
		$tpl->assign("##clflinename##", $clfname);
		$tpl->assign("##clflinecode##", $clfcode);
		$tpl->assign("##clflineselected##", $clflineselected);
		$tpl->parse ("#####ROW#####", '.rows_clfline');
		
	}

	if ($langcode == 'en') { 
	
		if ($pagshowen == 't') { $pagshow = "checked"; } else { $pagshow = ""; }
		
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "English Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Anh"; } else { $langcodefull = "英語のページ"; }
		
		$pagname = $pagnameen;
		$pagpagetitle = $pagpagetitleen;
		$pagtitle = $pagtitleen;
		$pagdetail = $pagdetailen;
		$homkeytitle = $homkeytitleen;
		$homkeydetail = $homkeydetailen;
		$homkeytitle1 = $homkeytitle1en;
		$homkeydetail1 = $homkeydetail1en;
		$homkeytitle2 = $homkeytitle2en;
		$homkeydetail2 = $homkeydetail2en;
		$homkeytitle3 = $homkeytitle3en;
		$homkeydetail3 = $homkeydetail3en;
		$homlinetitle = $homlinetitleen;
		$homlinedetail = $homlinedetailen;
		$homlinetitle1 = $homlinetitle1en;
		$homlinedetail1 = $homlinedetail1en;
		$homlinetitle2 = $homlinetitle2en;
		$homlinedetail2 = $homlinedetail2en;
		$homlinetitle3 = $homlinetitle3en;
		$homlinedetail3 = $homlinedetail3en;
		$homdesc = $homdescen;
	
	} else if ($langcode == 'vn') { 
	
		if ($pagshowvn == 't') { $pagshow = "checked"; } else { $pagshow = ""; }
		
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Vietnamese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Việt"; } else { $langcodefull = "ベトナム語のページ"; }
		
		$pagname = $pagnamevn;
		$pagpagetitle = $pagpagetitlevn;
		$pagtitle = $pagtitlevn;
		$pagdetail = $pagdetailvn;
		$homkeytitle = $homkeytitlevn;
		$homkeydetail = $homkeydetailvn;
		$homkeytitle1 = $homkeytitle1vn;
		$homkeydetail1 = $homkeydetail1vn;
		$homkeytitle2 = $homkeytitle2vn;
		$homkeydetail2 = $homkeydetail2vn;
		$homkeytitle3 = $homkeytitle3vn;
		$homkeydetail3 = $homkeydetail3vn;
		$homlinetitle = $homlinetitlevn;
		$homlinedetail = $homlinedetailvn;
		$homlinetitle1 = $homlinetitle1vn;
		$homlinedetail1 = $homlinedetail1vn;
		$homlinetitle2 = $homlinetitle2vn;
		$homlinedetail2 = $homlinedetail2vn;
		$homlinetitle3 = $homlinetitle3vn;
		$homlinedetail3 = $homlinedetail3vn;
		$homdesc = $homdescvn;
		
	} else { 
	
		if ($pagshowjp == 't') { $pagshow = "checked"; } else { $pagshow = ""; }
		
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Japanese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Nhật"; } else { $langcodefull = "日本語のページ"; }
		
		$pagname = $pagnamejp;
		$pagpagetitle = $pagpagetitlejp;
		$pagtitle = $pagtitlejp;
		$pagdetail = $pagdetailjp;
		$homkeytitle = $homkeytitlejp;
		$homkeydetail = $homkeydetailjp;
		$homkeytitle1 = $homkeytitle1jp;
		$homkeydetail1 = $homkeydetail1jp;
		$homkeytitle2 = $homkeytitle2jp;
		$homkeydetail2 = $homkeydetail2jp;
		$homkeytitle3 = $homkeytitle3jp;
		$homkeydetail3 = $homkeydetail3jp;
		$homlinetitle = $homlinetitlejp;
		$homlinedetail = $homlinedetailjp;
		$homlinetitle1 = $homlinetitle1jp;
		$homlinedetail1 = $homlinedetail1jp;
		$homlinetitle2 = $homlinetitle2jp;
		$homlinedetail2 = $homlinedetail2jp;
		$homlinetitle3 = $homlinetitle3jp;
		$homlinedetail3 = $homlinedetail3jp;
		$homdesc = $homdescjp;
		
	}


	/* Convert [br] to actual [LineBreak] for <textarea> */
	$pagname = str_replace('[br]',PHP_EOL,$pagname);
	$pagpagetitle = str_replace('[br]',PHP_EOL,$pagpagetitle);
	$pagtitle = str_replace('[br]',PHP_EOL,$pagtitle);
	$pagdetail = str_replace('[br]',PHP_EOL,$pagdetail);
	$homkeytitle = str_replace('[br]',PHP_EOL,$homkeytitle);
	$homkeydetail = str_replace('[br]',PHP_EOL,$homkeydetail);
	$homkeytitle1 = str_replace('[br]',PHP_EOL,$homkeytitle1);
	$homkeydetail1 = str_replace('[br]',PHP_EOL,$homkeydetail1);
	$homkeytitle2 = str_replace('[br]',PHP_EOL,$homkeytitle2);
	$homkeydetail2 = str_replace('[br]',PHP_EOL,$homkeydetail2);
	$homkeytitle3 = str_replace('[br]',PHP_EOL,$homkeytitle3);
	$homkeydetail3 = str_replace('[br]',PHP_EOL,$homkeydetail3);
	$homlinetitle = str_replace('<br>',PHP_EOL,$homlinetitle);
	$homlinedetail = str_replace('[br]',PHP_EOL,$homlinedetail);
	$homlinetitle1 = str_replace('<br>',PHP_EOL,$homlinetitle1);
	$homlinedetail1 = str_replace('[br]',PHP_EOL,$homlinedetail1);
	$homlinetitle2 = str_replace('<br>',PHP_EOL,$homlinetitle2);
	$homlinedetail2 = str_replace('[br]',PHP_EOL,$homlinedetail2);
	$homlinetitle3 = str_replace('<br>',PHP_EOL,$homlinetitle3);
	$homlinedetail3 = str_replace('[br]',PHP_EOL,$homlinedetail3);
	$homdesc = str_replace('[br]',PHP_EOL,$homdesc);



	
	$tpl->assign("##freemem##", $freemem);
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##memcomname##", $memcomname);
	$tpl->assign("##pagid##", $pagid);
	$tpl->assign("##homid##", $homid);
	$tpl->assign("##langcode##", $langcode);
	$tpl->assign("##langcodefull##", $langcodefull);
	$tpl->assign("##pagname##", $pagname);
	$tpl->assign("##pagpagetitle##", $pagpagetitle);
	$tpl->assign("##pagtitle##", $pagtitle);
	$tpl->assign("##pagdetail##", $pagdetail);
	$tpl->assign("##pagsort##", $pagsort);
	$tpl->assign("##pagshow##", $pagshow);
	$tpl->assign("##pagimagepreview##", $pagimagepreview);
	$tpl->assign("##pagimagewidth##", $pagimagewidth);
	$tpl->assign("##pagimagesidel##", $pagimagesidel);
	$tpl->assign("##pagimagesider##", $pagimagesider);
	$tpl->assign("##pagimagelink##", $pagimagelink);
	//$tpl->assign("##pagimagedisable##", $pagimagedisable);
	$tpl->assign("##pagvideolink##", $pagvideolink);
	$tpl->assign("##homkeytitle##", $homkeytitle);
	$tpl->assign("##homkeydetail##", $homkeydetail);
	$tpl->assign("##homkeytitle1##", $homkeytitle1);
	$tpl->assign("##homkeydetail1##", $homkeydetail1);
	$tpl->assign("##homkeytitle2##", $homkeytitle2);
	$tpl->assign("##homkeydetail2##", $homkeydetail2);
	$tpl->assign("##homkeytitle3##", $homkeytitle3);
	$tpl->assign("##homkeydetail3##", $homkeydetail3);
	$tpl->assign("##homlinetitle##", $homlinetitle);
	$tpl->assign("##homlinedetail##", $homlinedetail);
	$tpl->assign("##homlinetitle1##", $homlinetitle1);
	$tpl->assign("##homlinedetail1##", $homlinedetail1);
	$tpl->assign("##homimagepreview1##", $homimagepreview1);
	$tpl->assign("##homimagewidth1##", $homimagewidth1);
	$tpl->assign("##homimagelink1##", $homimagelink1);
	$tpl->assign("##homimagedisable1##", $homimagedisable1);
	$tpl->assign("##homlinetitle2##", $homlinetitle2);
	$tpl->assign("##homlinedetail2##", $homlinedetail2);
	$tpl->assign("##homimagepreview2##", $homimagepreview2);
	$tpl->assign("##homimagewidth2##", $homimagewidth2);
	$tpl->assign("##homimagelink2##", $homimagelink2);
	$tpl->assign("##homimagedisable2##", $homimagedisable2);
	$tpl->assign("##homlinetitle3##", $homlinetitle3);
	$tpl->assign("##homlinedetail3##", $homlinedetail3);
	$tpl->assign("##homimagepreview3##", $homimagepreview3);
	$tpl->assign("##homimagewidth3##", $homimagewidth3);
	$tpl->assign("##homimagelink3##", $homimagelink3);
	$tpl->assign("##homimagedisable3##", $homimagedisable3);
	$tpl->assign("##homdesc##", $homdesc);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
	
	
?>
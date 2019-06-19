<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_page_box_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_SESSION['vmd'];
	$boxid = $_GET['box'];
	$langcode = $_GET['lang'];
	
	if ($langcode != 'en' && $langcode != 'jp' && $langcode != 'vn') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=4\">"; exit(); }
	
	$checkpackage = checkfreemem($memid);
	if ($checkpackage == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=5\">"; exit(); }
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "page_box_edit";
	$currentrec = $boxid;
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
	
	$sql2 = "select * from flc_present_box where box_id = '$boxid' and mem_id = '$memid';"; 
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
		
		$pagid = $dbarr2['pag_id']; 
		$boxtype1 = $dbarr2['box_type1']; 
		$boxtitle1color = $dbarr2['box_title1_color']; 
		$boxtitle1en = $dbarr2['box_title1_en']; 
		$boxtitle1jp = $dbarr2['box_title1_jp']; 
		$boxtitle1vn = $dbarr2['box_title1_vn']; 
		$boxdetail1en = $dbarr2['box_detail1_en']; 
		$boxdetail1jp = $dbarr2['box_detail1_jp']; 
		$boxdetail1vn = $dbarr2['box_detail1_vn']; 
		$boximage1 = $dbarr2['box_image1']; 
		$boximage1width = $dbarr2['box_image1_width']; if ($boximage1width == '0') { $boximage1width = ""; }
		$boximage1link = $dbarr2['box_image1_link']; 
		$boxtype2 = $dbarr2['box_type2']; 
		$boxtitle2color = $dbarr2['box_title2_color']; 
		$boxtitle2en = $dbarr2['box_title2_en']; 
		$boxtitle2jp = $dbarr2['box_title2_jp']; 
		$boxtitle2vn = $dbarr2['box_title2_vn']; 
		$boxdetail2en = $dbarr2['box_detail2_en']; 
		$boxdetail2jp = $dbarr2['box_detail2_jp']; 
		$boxdetail2vn = $dbarr2['box_detail2_vn']; 
		$boximage2 = $dbarr2['box_image2']; 
		$boximage2width = $dbarr2['box_image2_width']; if ($boximage2width == '0') { $boximage2width = ""; }
		$boximage2link = $dbarr2['box_image2_link']; 
		$boxtype3 = $dbarr2['box_type3']; 
		$boxtitle3color = $dbarr2['box_title3_color']; 
		$boxtitle3en = $dbarr2['box_title3_en']; 
		$boxtitle3jp = $dbarr2['box_title3_jp']; 
		$boxtitle3vn = $dbarr2['box_title3_vn']; 
		$boxdetail3en = $dbarr2['box_detail3_en']; 
		$boxdetail3jp = $dbarr2['box_detail3_jp']; 
		$boxdetail3vn = $dbarr2['box_detail3_vn']; 
		$boximage3 = $dbarr2['box_image3']; 
		$boximage3width = $dbarr2['box_image3_width']; if ($boximage3width == '0') { $boximage3width = ""; }
		$boximage3link = $dbarr2['box_image3_link']; 
		$boxsort = $dbarr2['box_sort']; 
	
	}
	
	if ($boximage1 == 't') { 
		
		$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-".$boxid."-B1.jpg";
		if ($boximage1width == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $boximage1width; }
		if ($imgwidth > 740) { $imgwidth = 740; }
		$boximage1preview = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\"/>"; 
		
		if ($boximage1link == 't') { $boximage1preview = "<a href=\"".$imgpath."\" target=\"_blank\">".$boximage1preview."</a>"; $boximage1link = "checked"; }
		else { $boximage1link = ""; }	
		
	} else { $boximage1disable = "checked"; }
	
	if ($boximage2 == 't') { 
		
		$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-".$boxid."-B2.jpg";
		if ($boximage2width == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $boximage2width; }
		if ($imgwidth > 740) { $imgwidth = 740; }
		$boximage2preview = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\"/>"; 
		
		if ($boximage2link == 't') { $boximage2preview = "<a href=\"".$imgpath."\" target=\"_blank\">".$boximage2preview."</a>"; $boximage2link = "checked"; }
		else { $boximage2link = ""; }	
		
	} else { $boximage2disable = "checked"; }
	
	if ($boximage3 == 't') { 
		
		$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-".$boxid."-B3.jpg";
		if ($boximage3width == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $boximage3width; }
		if ($imgwidth > 740) { $imgwidth = 740; }
		$boximage3preview = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\"/>"; 
		
		if ($boximage3link == 't') { $boximage3preview = "<a href=\"".$imgpath."\" target=\"_blank\">".$boximage3preview."</a>"; $boximage3link = "checked"; }
		else { $boximage3link = ""; }	
		
	} else { $boximage3disable = "checked"; }
	
	
	if ($boxtype1 == 'text') { $checkbox1_1 = "checked"; $image1enable = "disabled"; $imagewidth1enable = "disabled"; $imagelink1enable = "disabled"; $imagestatus1enable = "disabled"; }
	else if ($boxtype1 == 'image') { $checkbox1_2 = "checked"; $clf1enable = "disabled"; $title1enable = "disabled"; $detail1enable = "disabled"; }
	else { $clf1enable = "disabled"; $title1enable = "disabled"; $detail1enable = "disabled"; $image1enable = "disabled"; $imagewidth1enable = "disabled"; $imagelink1enable = "disabled"; $imagestatus1enable = "disabled"; }
	
	if ($boxtype2 == 'text') { $checkbox2_1 = "checked"; $image2enable = "disabled"; $imagewidth2enable = "disabled"; $imagelink2enable = "disabled"; $imagestatus2enable = "disabled"; }
	else if ($boxtype2 == 'image') { $checkbox2_2 = "checked"; $clf2enable = "disabled"; $title2enable = "disabled"; $detail2enable = "disabled"; }
	else { $clf2enable = "disabled"; $title2enable = "disabled"; $detail2enable = "disabled"; $image2enable = "disabled"; $imagewidth2enable = "disabled"; $imagelink2enable = "disabled"; $imagestatus2enable = "disabled"; }
	
	if ($boxtype3 == 'text') { $checkbox3_1 = "checked"; $image3enable = "disabled"; $imagewidth3enable = "disabled"; $imagelink3enable = "disabled"; $imagestatus3enable = "disabled"; }
	else if ($boxtype3 == 'image') { $checkbox3_2 = "checked"; $clf3enable = "disabled"; $title3enable = "disabled"; $detail3enable = "disabled"; }
	else { $clf3enable = "disabled"; $title3enable = "disabled"; $detail3enable = "disabled"; $image3enable = "disabled"; $imagewidth3enable = "disabled"; $imagelink3enable = "disabled"; $imagestatus3enable = "disabled"; }
	
	if ($boxtitle1color == '') { $boxtitle1color = "CC0000"; }
	if ($boxtitle2color == '') { $boxtitle2color = "CC0000"; }
	if ($boxtitle3color == '') { $boxtitle3color = "CC0000"; }
	
	$sqlclf = "select * from flc_color_font order by clf_name_en asc;"; 
	$resultclf = mysql_query($sqlclf);
	while ($dbarrclf = mysql_fetch_array($resultclf)) {
	
		$clfid = $dbarrclf['clf_id'];
		$clfname = $dbarrclf['clf_name_en']; 
		$clfcode = $dbarrclf['clf_code']; 
		if ($clfcode == $boxtitle1color) { $clfselected1 = "selected"; } else { $clfselected1 = ""; }
		if ($clfcode == $boxtitle2color) { $clfselected2 = "selected"; } else { $clfselected2 = ""; }
		if ($clfcode == $boxtitle3color) { $clfselected3 = "selected"; } else { $clfselected3 = ""; }
		
		$tpl->assign("##clfid1##", $clfid);
		$tpl->assign("##clfname1##", $clfname);
		$tpl->assign("##clfcode1##", $clfcode);
		$tpl->assign("##clfselected1##", $clfselected1);
		$tpl->parse ("#####ROW#####", '.rows_clf1');
		
		$tpl->assign("##clfid2##", $clfid);
		$tpl->assign("##clfname2##", $clfname);
		$tpl->assign("##clfcode2##", $clfcode);
		$tpl->assign("##clfselected2##", $clfselected2);
		$tpl->parse ("#####ROW#####", '.rows_clf2');
		
		$tpl->assign("##clfid3##", $clfid);
		$tpl->assign("##clfname3##", $clfname);
		$tpl->assign("##clfcode3##", $clfcode);
		$tpl->assign("##clfselected3##", $clfselected3);
		$tpl->parse ("#####ROW#####", '.rows_clf3');
		
	}
	
	$sql1 = "select * from flc_page where pag_id = '$pagid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) { $pagnameen = $dbarr1['pag_name_en']; $pagnamejp = $dbarr1['pag_name_jp']; $pagnamevn = $dbarr1['pag_name_vn']; }
	
	if ($langcode == 'en') { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "English Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Anh"; } else { $langcodefull = "英語のページ"; }
		$boxtitle1 = $boxtitle1en; 
		$boxdetail1 = $boxdetail1en;
		$boxtitle2 = $boxtitle2en; 
		$boxdetail2 = $boxdetail2en;
		$boxtitle3 = $boxtitle3en; 
		$boxdetail3 = $boxdetail3en;
		
	} else if ($langcode == 'vn') { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Vietnamese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Việt"; } else { $langcodefull = "ベトナム語のページ"; }
		$boxtitle1 = $boxtitle1vn; 
		$boxdetail1 = $boxdetail1vn;	
		$boxtitle2 = $boxtitle2vn; 
		$boxdetail2 = $boxdetail2vn;	
		$boxtitle3 = $boxtitle3vn; 
		$boxdetail3 = $boxdetail3vn;	
		
	} else { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Japanese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Nhật"; } else { $langcodefull = "日本語のページ"; }
		$boxtitle1 = $boxtitle1jp; 
		$boxdetail1 = $boxdetail1jp;
		$boxtitle2 = $boxtitle2jp; 
		$boxdetail2 = $boxdetail2jp;
		$boxtitle3 = $boxtitle3jp; 
		$boxdetail3 = $boxdetail3jp;
		
	}
	
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##pagid##", $pagid);
	$tpl->assign("##boxid##", $boxid);
	$tpl->assign("##boxtitle1##", $boxtitle1);
	$tpl->assign("##boxdetail1##", $boxdetail1);
	$tpl->assign("##boximage1preview##", $boximage1preview);
	$tpl->assign("##boximage1width##", $boximage1width);
	$tpl->assign("##boximage1link##", $boximage1link);
	$tpl->assign("##boximage1disable##", $boximage1disable);
	$tpl->assign("##title1enable##", $title1enable);
	$tpl->assign("##detail1enable##", $detail1enable);
	$tpl->assign("##clf1enable##", $clf1enable);
	$tpl->assign("##image1enable##", $image1enable);
	$tpl->assign("##imagewidth1enable##", $imagewidth1enable);
	$tpl->assign("##imagelink1enable##", $imagelink1enable);
	$tpl->assign("##imagestatus1enable##", $imagestatus1enable);
	$tpl->assign("##boxtitle2##", $boxtitle2);
	$tpl->assign("##boxdetail2##", $boxdetail2);
	$tpl->assign("##boximage2preview##", $boximage2preview);
	$tpl->assign("##boximage2width##", $boximage2width);
	$tpl->assign("##boximage2link##", $boximage2link);
	$tpl->assign("##boximage2disable##", $boximage2disable);
	$tpl->assign("##title2enable##", $title2enable);
	$tpl->assign("##detail2enable##", $detail2enable);
	$tpl->assign("##clf2enable##", $clf2enable);
	$tpl->assign("##image2enable##", $image2enable);
	$tpl->assign("##imagewidth2enable##", $imagewidth2enable);
	$tpl->assign("##imagelink2enable##", $imagelink2enable);
	$tpl->assign("##imagestatus2enable##", $imagestatus2enable);
	$tpl->assign("##boxtitle3##", $boxtitle3);
	$tpl->assign("##boxdetail3##", $boxdetail3);
	$tpl->assign("##boximage3preview##", $boximage3preview);
	$tpl->assign("##boximage3width##", $boximage3width);
	$tpl->assign("##boximage3link##", $boximage3link);
	$tpl->assign("##boximage3disable##", $boximage3disable);
	$tpl->assign("##title3enable##", $title3enable);
	$tpl->assign("##detail3enable##", $detail3enable);
	$tpl->assign("##clf3enable##", $clf3enable);
	$tpl->assign("##image3enable##", $image3enable);
	$tpl->assign("##imagewidth3enable##", $imagewidth3enable);
	$tpl->assign("##imagelink3enable##", $imagelink3enable);
	$tpl->assign("##imagestatus3enable##", $imagestatus3enable);
	$tpl->assign("##boxsort##", $boxsort);
	$tpl->assign("##langcode##", $langcode);
	$tpl->assign("##langcodefull##", $langcodefull);
	$tpl->assign("##checkbox1_1##", $checkbox1_1);
	$tpl->assign("##checkbox1_2##", $checkbox1_2);
	$tpl->assign("##checkbox2_1##", $checkbox2_1);
	$tpl->assign("##checkbox2_2##", $checkbox2_2);
	$tpl->assign("##checkbox3_1##", $checkbox3_1);
	$tpl->assign("##checkbox3_2##", $checkbox3_2);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
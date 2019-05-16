<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_page_profile_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_SESSION['vmd'];
	$pagid = $_GET['page'];
	$langcode = $_GET['lang'];
	
	if ($langcode != 'en' && $langcode != 'jp' && $langcode != 'vn') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=4\">"; exit(); }
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "page_profile_edit";
	$currentrec = $pagid;
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
	
	$sql1 = "select * from flc_page where pag_id = '$pagid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
	
		$pagtype = $dbarr1['pag_type'];
		if ($pagtype != 'prf') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_page.php\">"; exit(); }
		
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
		$pagprofilecolor = stripslashes($dbarr1['pag_profile_color']);
		$pagdetailen = stripslashes($dbarr1['pag_detail_en']);
		$pagdetailjp = stripslashes($dbarr1['pag_detail_jp']);
		$pagdetailvn = stripslashes($dbarr1['pag_detail_vn']);
		$pagimage = $dbarr1['pag_image'];
		$pagimagewidth = $dbarr1['pag_image_width']; if ($pagimagewidth == '0') { $pagimagewidth = ""; }
		$pagimagelink = $dbarr1['pag_image_link'];
		$pagimageside = $dbarr1['pag_image_side']; if ($pagimageside == 'r') { $pagimagesidel = ""; $pagimagesider = "checked"; } else { $pagimagesidel = "checked"; $pagimagesider = ""; }
		$pagsort = $dbarr1['pag_sort'];
		$pagshowen = stripslashes($dbarr1['pag_show_en']);
		$pagshowjp = stripslashes($dbarr1['pag_show_jp']);
		$pagshowvn = stripslashes($dbarr1['pag_show_vn']);
	
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
		if ($clfcode == $pagprofilecolor) { $clfdetailselected = "selected"; } else { $clfdetailselected = ""; }
		
		$tpl->assign("##clfid##", $clfid);
		$tpl->assign("##clfname##", $clfname);
		$tpl->assign("##clfcode##", $clfcode);
		$tpl->assign("##clfselected##", $clfselected);
		$tpl->parse ("#####ROW#####", '.rows_clf');
		
		$tpl->assign("##clfdetailid##", $clfid);
		$tpl->assign("##clfdetailname##", $clfname);
		$tpl->assign("##clfdetailcode##", $clfcode);
		$tpl->assign("##clfdetailselected##", $clfdetailselected);
		$tpl->parse ("#####ROW#####", '.rows_clfdetail');
		
	}
	
	$sql2 = "select * from flc_member where mem_id = '$memid';"; 
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
	
		$memid = $dbarr2['mem_id'];
		$memcomnameen = stripslashes($dbarr2['mem_comname_en']);
		$memcomnamejp = stripslashes($dbarr2['mem_comname_jp']);
		$memcomnamevn = stripslashes($dbarr2['mem_comname_vn']);
		$mempernameen = stripslashes($dbarr2['mem_pername_en']);
		$mempernamejp = stripslashes($dbarr2['mem_pername_jp']);
		$mempernamevn = stripslashes($dbarr2['mem_pername_vn']);
		$memposnameen = stripslashes($dbarr2['mem_posname_en']);
		$memposnamejp = stripslashes($dbarr2['mem_posname_jp']);
		$memposnamevn = stripslashes($dbarr2['mem_posname_vn']);
		$memaddlab1en = stripslashes($dbarr2['mem_addresslabel1_en']);
		$memaddlab1jp = stripslashes($dbarr2['mem_addresslabel1_jp']);
		$memaddlab1vn = stripslashes($dbarr2['mem_addresslabel1_vn']);
		$memadd1en = stripslashes($dbarr2['mem_address1_en']);
		$memadd1jp = stripslashes($dbarr2['mem_address1_jp']);
		$memadd1vn = stripslashes($dbarr2['mem_address1_vn']);
		$memine1 = stripslashes($dbarr2['mem_addressine1']);
		$memprv1 = stripslashes($dbarr2['mem_addressprv1']); if ($memprv1 == '001') { $ctydisable1 = ""; } else { $ctydisable1 = "disabled"; }
		$memcty1 = stripslashes($dbarr2['mem_addresscty1']);
		$memzip1 = stripslashes($dbarr2['mem_addresszip1']);
		$memaddlab2en = stripslashes($dbarr2['mem_addresslabel2_en']);
		$memaddlab2jp = stripslashes($dbarr2['mem_addresslabel2_jp']);
		$memaddlab2vn = stripslashes($dbarr2['mem_addresslabel2_vn']);
		$memadd2en = stripslashes($dbarr2['mem_address2_en']);
		$memadd2jp = stripslashes($dbarr2['mem_address2_jp']);
		$memadd2vn = stripslashes($dbarr2['mem_address2_vn']);
		$memine2 = stripslashes($dbarr2['mem_addressine2']);
		$memprv2 = stripslashes($dbarr2['mem_addressprv2']); if ($memprv2 == '001') { $ctydisable2 = ""; } else { $ctydisable2 = "disabled"; }
		$memcty2 = stripslashes($dbarr2['mem_addresscty2']);
		$memzip2 = stripslashes($dbarr2['mem_addresszip2']);
		$memaddlab3en = stripslashes($dbarr2['mem_addresslabel3_en']);
		$memaddlab3jp = stripslashes($dbarr2['mem_addresslabel3_jp']);
		$memaddlab3vn = stripslashes($dbarr2['mem_addresslabel3_vn']);
		$memadd3en = stripslashes($dbarr2['mem_address3_en']);
		$memadd3jp = stripslashes($dbarr2['mem_address3_jp']);
		$memadd3vn = stripslashes($dbarr2['mem_address3_vn']);
		$memine3 = stripslashes($dbarr2['mem_addressine3']);
		$memprv3 = stripslashes($dbarr2['mem_addressprv3']); if ($memprv3 == '001') { $ctydisable3 = ""; } else { $ctydisable3 = "disabled"; }
		$memcty3 = stripslashes($dbarr2['mem_addresscty3']);
		$memzip3 = stripslashes($dbarr2['mem_addresszip3']);
		$memaddlab4en = stripslashes($dbarr2['mem_addresslabel4_en']);
		$memaddlab4jp = stripslashes($dbarr2['mem_addresslabel4_jp']);
		$memaddlab4vn = stripslashes($dbarr2['mem_addresslabel4_vn']);
		$memadd4en = stripslashes($dbarr2['mem_address4_en']);
		$memadd4jp = stripslashes($dbarr2['mem_address4_jp']);
		$memadd4vn = stripslashes($dbarr2['mem_address4_vn']);
		$memine4 = stripslashes($dbarr2['mem_addressine4']);
		$memprv4 = stripslashes($dbarr2['mem_addressprv4']); if ($memprv4 == '001') { $ctydisable4 = ""; } else { $ctydisable4 = "disabled"; }
		$memcty4 = stripslashes($dbarr2['mem_addresscty4']);
		$memzip4 = stripslashes($dbarr2['mem_addresszip4']);
		$memaddlab5en = stripslashes($dbarr2['mem_addresslabel5_en']);
		$memaddlab5jp = stripslashes($dbarr2['mem_addresslabel5_jp']);
		$memaddlab5vn = stripslashes($dbarr2['mem_addresslabe5_vn']);
		$memadd5en = stripslashes($dbarr2['mem_address5_en']);
		$memadd5jp = stripslashes($dbarr2['mem_address5_jp']);
		$memadd5vn = stripslashes($dbarr2['mem_address5_vn']);
		$memine5 = stripslashes($dbarr2['mem_addressine5']);
		$memprv5 = stripslashes($dbarr2['mem_addressprv5']); if ($memprv5 == '001') { $ctydisable5 = ""; } else { $ctydisable5 = "disabled"; }
		$memcty5 = stripslashes($dbarr2['mem_addresscty5']);
		$memzip5 = stripslashes($dbarr2['mem_addresszip5']);
		$memtellab1en = stripslashes($dbarr2['mem_tellabel1_en']);
		$memtellab1jp = stripslashes($dbarr2['mem_tellabel1_jp']);
		$memtellab1vn = stripslashes($dbarr2['mem_tellabel1_vn']);
		$memtel1 = stripslashes($dbarr2['mem_telnum1']);
		$memtellab2en = stripslashes($dbarr2['mem_tellabel2_en']);
		$memtellab2jp = stripslashes($dbarr2['mem_tellabel2_jp']);
		$memtellab2vn = stripslashes($dbarr2['mem_tellabel2_vn']);
		$memtel2 = stripslashes($dbarr2['mem_telnum2']);
		$memtellab3en = stripslashes($dbarr2['mem_tellabel3_en']);
		$memtellab3jp = stripslashes($dbarr2['mem_tellabel3_jp']);
		$memtellab3vn = stripslashes($dbarr2['mem_tellabel3_vn']);
		$memtel3 = stripslashes($dbarr2['mem_telnum3']);
		$memtellab4en = stripslashes($dbarr2['mem_tellabel4_en']);
		$memtellab4jp = stripslashes($dbarr2['mem_tellabel4_jp']);
		$memtellab4vn = stripslashes($dbarr2['mem_tellabel4_vn']);
		$memtel5 = stripslashes($dbarr2['mem_telnum5']);
		$memtellab5en = stripslashes($dbarr2['mem_tellabel5_en']);
		$memtellab5jp = stripslashes($dbarr2['mem_tellabel5_jp']);
		$memtellab5vn = stripslashes($dbarr2['mem_tellabel5_vn']);
		$memtel5 = stripslashes($dbarr2['mem_telnum5']);
		$memmaillab1en = stripslashes($dbarr2['mem_maillabel1_en']);
		$memmaillab1jp = stripslashes($dbarr2['mem_maillabel1_jp']);
		$memmaillab1vn = stripslashes($dbarr2['mem_maillabel1_vn']);
		$memmail1 = stripslashes($dbarr2['mem_mail1']);
		$memmaillab2en = stripslashes($dbarr2['mem_maillabel2_en']);
		$memmaillab2jp = stripslashes($dbarr2['mem_maillabel2_jp']);
		$memmaillab2vn = stripslashes($dbarr2['mem_maillabel2_vn']);
		$memmail2 = stripslashes($dbarr2['mem_mail2']);
		$memmaillab3en = stripslashes($dbarr2['mem_maillabel3_en']);
		$memmaillab3jp = stripslashes($dbarr2['mem_maillabel3_jp']);
		$memmaillab3vn = stripslashes($dbarr2['mem_maillabel3_vn']);
		$memmail3 = stripslashes($dbarr2['mem_mail3']);
		$memmaillab4en = stripslashes($dbarr2['mem_maillabel4_en']);
		$memmaillab4jp = stripslashes($dbarr2['mem_maillabel4_jp']);
		$memmaillab4vn = stripslashes($dbarr2['mem_maillabel4_vn']);
		$memmail4 = stripslashes($dbarr2['mem_mail4']);
		$memmaillab5en = stripslashes($dbarr2['mem_maillabel5_en']);
		$memmaillab5jp = stripslashes($dbarr2['mem_maillabel5_jp']);
		$memmaillab5vn = stripslashes($dbarr2['mem_maillabel5_vn']);
		$memmail5 = stripslashes($dbarr2['mem_mail5']);
		$memurl = stripslashes($dbarr2['mem_url']);
		$memcomparenten = stripslashes($dbarr2['mem_comparent_en']);
		$memcomparentjp = stripslashes($dbarr2['mem_comparent_jp']);
		$memcomparentvn = stripslashes($dbarr2['mem_comparent_vn']);
		$memestdateen = stripslashes($dbarr2['mem_establishdate_en']);
		$memestdatejp = stripslashes($dbarr2['mem_establishdate_jp']);
		$memestdatevn = stripslashes($dbarr2['mem_establishdate_vn']);
		$memcapitalen = stripslashes($dbarr2['mem_capital_en']);
		$memcapitaljp = stripslashes($dbarr2['mem_capital_jp']);
		$memcapitalvn = stripslashes($dbarr2['mem_capital_vn']);
		$memshareholderen = stripslashes($dbarr2['mem_shareholder_en']);
		$memshareholderjp = stripslashes($dbarr2['mem_shareholder_jp']);
		$memshareholdervn = stripslashes($dbarr2['mem_shareholder_vn']);
		$memcategory = stripslashes($dbarr2['mem_category']); 
		$membanken = stripslashes($dbarr2['mem_bank_en']);
		$membankjp = stripslashes($dbarr2['mem_bank_jp']);
		$membankvn = stripslashes($dbarr2['mem_bank_vn']);
		$memaccdateen = stripslashes($dbarr2['mem_accountdate_en']);
		$memaccdatejp = stripslashes($dbarr2['mem_accountdate_jp']);
		$memaccdatevn = stripslashes($dbarr2['mem_accountdate_vn']);
		$mememployeeen = stripslashes($dbarr2['mem_employee_en']);
		$mememployeejp = stripslashes($dbarr2['mem_employee_jp']);
		$mememployeevn = stripslashes($dbarr2['mem_employee_vn']);
		$memboien = stripslashes($dbarr2['mem_boi_en']);
		$memboijp = stripslashes($dbarr2['mem_boi_jp']);
		$memboivn = stripslashes($dbarr2['mem_boi_vn']);
		$memisoen = stripslashes($dbarr2['mem_iso_en']);
		$memisojp = stripslashes($dbarr2['mem_iso_jp']);
		$memisovn = stripslashes($dbarr2['mem_iso_vn']);
		$memvalcusen = stripslashes($dbarr2['mem_valuecustomer_en']);
		$memvalcusjp = stripslashes($dbarr2['mem_valuecustomer_jp']);
		$memvalcusvn = stripslashes($dbarr2['mem_valuecustomer_vn']);
		$memseocom = stripslashes($dbarr2['mem_seocomdesc']);
		$memseokey = stripslashes($dbarr2['mem_seokeyword']);
		$membusinessen = stripslashes($dbarr2['mem_business_en']);
		$membusinessjp = stripslashes($dbarr2['mem_business_jp']);
		$membusinessvn = stripslashes($dbarr2['mem_business_vn']);
		$memproducten = stripslashes($dbarr2['mem_product_en']);
		$memproductjp = stripslashes($dbarr2['mem_product_jp']);
		$memproductvn = stripslashes($dbarr2['mem_product_vn']);
		$memconlab1en = stripslashes($dbarr2['mem_contentlabel1_en']);
		$memconlab1jp = stripslashes($dbarr2['mem_contentlabel1_jp']);
		$memconlab1vn = stripslashes($dbarr2['mem_contentlabel1_vn']);
		$memcon1en = stripslashes($dbarr2['mem_content1_en']);
		$memcon1jp = stripslashes($dbarr2['mem_content1_jp']);
		$memcon1vn = stripslashes($dbarr2['mem_content1_vn']);
		$memconlab2en = stripslashes($dbarr2['mem_contentlabel2_en']);
		$memconlab2jp = stripslashes($dbarr2['mem_contentlabel2_jp']);
		$memconlab2vn = stripslashes($dbarr2['mem_contentlabel2_vn']);
		$memcon2en = stripslashes($dbarr2['mem_content2_en']);
		$memcon2jp = stripslashes($dbarr2['mem_content2_jp']);
		$memcon2vn = stripslashes($dbarr2['mem_content2_vn']);
		$memconlab3en = stripslashes($dbarr2['mem_contentlabel3_en']);
		$memconlab3jp = stripslashes($dbarr2['mem_contentlabel3_jp']);
		$memconlab3vn = stripslashes($dbarr2['mem_contentlabel3_vn']);
		$memcon3en = stripslashes($dbarr2['mem_content3_en']);
		$memcon3jp = stripslashes($dbarr2['mem_content3_jp']);
		$memcon3vn = stripslashes($dbarr2['mem_content3_vn']);
		$memconlab4en = stripslashes($dbarr2['mem_contentlabel4_en']);
		$memconlab4jp = stripslashes($dbarr2['mem_contentlabel4_jp']);
		$memconlab4vn = stripslashes($dbarr2['mem_contentlabel4_vn']);
		$memcon4en = stripslashes($dbarr2['mem_content4_en']);
		$memcon4jp = stripslashes($dbarr2['mem_content4_jp']);
		$memcon4vn = stripslashes($dbarr2['mem_content4_vn']);
		$memconlab5en = stripslashes($dbarr2['mem_contentlabel5_en']);
		$memconlab5jp = stripslashes($dbarr2['mem_contentlabel5_jp']);
		$memconlab5vn = stripslashes($dbarr2['mem_contentlabel5_vn']);
		$memcon5en = stripslashes($dbarr2['mem_content5_en']);
		$memcon5jp = stripslashes($dbarr2['mem_content5_jp']);
		$memcon5vn = stripslashes($dbarr2['mem_content5_vn']);
		$memfooteren = stripslashes($dbarr2['mem_footer_en']);
		$memfooterjp = stripslashes($dbarr2['mem_footer_jp']);
		$memfootervn = stripslashes($dbarr2['mem_footer_vn']);
		$memsort = stripslashes($dbarr2['mem_sort']);
		$mempackage = stripslashes($dbarr2['mem_package']);
		
	}
	
	if ($langcode == 'en') { $sql1 = "select * from flc_ie order by ine_name_en asc;"; }
	else if ($langcode == 'vn') { $sql1 = "select * from flc_ie order by ine_name_vn asc;"; }
	else { $sql1 = "select * from flc_ie order by ine_name_jp asc;"; }
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($langcode == 'en') { $inename = $dbarr1['ine_name_en']; }
		else if ($langcode == 'vn') { $inename = $dbarr1['ine_name_vn']; }
		else { $inename = $dbarr1['ine_name_jp']; }
		$ineid = $dbarr1['ine_id'];
		
		if ($ineid == $memine1) { $ineselected1 = "selected"; $inedefault1 = ""; } else { $ineselected1 = ""; $inedefault1 = "selected"; }
		if ($ineid == $memine2) { $ineselected2 = "selected"; $inedefault2 = ""; } else { $ineselected2 = ""; $inedefault2 = "selected"; }
		if ($ineid == $memine3) { $ineselected3 = "selected"; $inedefault3 = ""; } else { $ineselected3 = ""; $inedefault3 = "selected"; }
		if ($ineid == $memine4) { $ineselected4 = "selected"; $inedefault4 = ""; } else { $ineselected4 = ""; $inedefault4 = "selected"; }
		if ($ineid == $memine5) { $ineselected5 = "selected"; $inedefault5 = ""; } else { $ineselected5 = ""; $inedefault5 = "selected"; }
		
		$tpl->assign("##ineid1##", $ineid);
		$tpl->assign("##inename1##", $inename);
		$tpl->assign("##ineselected1##", $ineselected1);
		$tpl->parse ("#####ROW#####", '.rows_ine1');
		
		$tpl->assign("##ineid2##", $ineid);
		$tpl->assign("##inename2##", $inename);
		$tpl->assign("##ineselected2##", $ineselected2);
		$tpl->parse ("#####ROW#####", '.rows_ine2');
		
		$tpl->assign("##ineid3##", $ineid);
		$tpl->assign("##inename3##", $inename);
		$tpl->assign("##ineselected3##", $ineselected3);
		$tpl->parse ("#####ROW#####", '.rows_ine3');
		
		$tpl->assign("##ineid4##", $ineid);
		$tpl->assign("##inename4##", $inename);
		$tpl->assign("##ineselected4##", $ineselected4);
		$tpl->parse ("#####ROW#####", '.rows_ine4');
		
		$tpl->assign("##ineid5##", $ineid);
		$tpl->assign("##inename5##", $inename);
		$tpl->assign("##ineselected5##", $ineselected5);
		$tpl->parse ("#####ROW#####", '.rows_ine5');
		
	}
	
	if ($langcode == 'en') { $sql2 = "select * from flc_province order by prv_name_en asc;"; }
	else if ($langcode == 'vn') { $sql2 = "select * from flc_province order by prv_name_vn asc;"; }
	else { $sql2 = "select * from flc_province order by prv_name_jp asc;"; }
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
		
		if ($langcode == 'en') { $prvname = $dbarr2['prv_name_en']; }
		else if ($langcode == 'vn') { $prvname = $dbarr2['prv_name_vn']; }
		else { $prvname = $dbarr2['prv_name_jp']; }
		$prvid = $dbarr2['prv_id'];
		
		if ($prvid == $memprv1) { $prvselected1 = "selected"; $prvdefault1 = ""; } else { $prvselected1 = ""; $prvdefault1 = "selected"; }
		if ($prvid == $memprv2) { $prvselected2 = "selected"; $prvdefault2 = ""; } else { $prvselected2 = ""; $prvdefault2 = "selected"; }
		if ($prvid == $memprv3) { $prvselected3 = "selected"; $prvdefault3 = ""; } else { $prvselected3 = ""; $prvdefault3 = "selected"; }
		if ($prvid == $memprv4) { $prvselected4 = "selected"; $prvdefault4 = ""; } else { $prvselected4 = ""; $prvdefault4 = "selected"; }
		if ($prvid == $memprv5) { $prvselected5 = "selected"; $prvdefault5 = ""; } else { $prvselected5 = ""; $prvdefault5 = "selected"; }
		
		$tpl->assign("##prvid1##", $prvid);
		$tpl->assign("##prvname1##", $prvname);
		$tpl->assign("##prvselected1##", $prvselected1);
		$tpl->parse ("#####ROW#####", '.rows_prv1');
		
		$tpl->assign("##prvid2##", $prvid);
		$tpl->assign("##prvname2##", $prvname);
		$tpl->assign("##prvselected2##", $prvselected2);
		$tpl->parse ("#####ROW#####", '.rows_prv2');
		
		$tpl->assign("##prvid3##", $prvid);
		$tpl->assign("##prvname3##", $prvname);
		$tpl->assign("##prvselected3##", $prvselected3);
		$tpl->parse ("#####ROW#####", '.rows_prv3');
		
		$tpl->assign("##prvid4##", $prvid);
		$tpl->assign("##prvname4##", $prvname);
		$tpl->assign("##prvselected4##", $prvselected4);
		$tpl->parse ("#####ROW#####", '.rows_prv4');
		
		$tpl->assign("##prvid5##", $prvid);
		$tpl->assign("##prvname5##", $prvname);
		$tpl->assign("##prvselected5##", $prvselected5);
		$tpl->parse ("#####ROW#####", '.rows_prv5');
		
	}
	
	$sql3 = "select * from flc_country where cty_id != '1' order by cty_order asc;"; 
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) {
		
		if ($langcode == 'en') { $ctyname = $dbarr3['cty_name_en']; }
		else if ($langcode == 'vn') { $ctyname = $dbarr3['cty_name_vn']; }
		else { $ctyname = $dbarr3['cty_name_jp']; }
		$ctyid = $dbarr3['cty_id'];
		
		if ($ctyid == $memcty1) { $ctyselected1 = "selected"; $ctydefault1 = ""; } else { $ctyselected1 = ""; $ctydefault1 = "selected"; }
		if ($ctyid == $memcty2) { $ctyselected2 = "selected"; $ctydefault2 = ""; } else { $ctyselected2 = ""; $ctydefault2 = "selected"; }
		if ($ctyid == $memcty3) { $ctyselected3 = "selected"; $ctydefault3 = ""; } else { $ctyselected3 = ""; $ctydefault3 = "selected"; }
		if ($ctyid == $memcty4) { $ctyselected4 = "selected"; $ctydefault4 = ""; } else { $ctyselected4 = ""; $ctydefault4 = "selected"; }
		if ($ctyid == $memcty5) { $ctyselected5 = "selected"; $ctydefault5 = ""; } else { $ctyselected5 = ""; $ctydefault5 = "selected"; }
		
		$tpl->assign("##ctyid1##", $ctyid);
		$tpl->assign("##ctyname1##", $ctyname);
		$tpl->assign("##ctyselected1##", $ctyselected1);
		$tpl->parse ("#####ROW#####", '.rows_cty1');
		
		$tpl->assign("##ctyid2##", $ctyid);
		$tpl->assign("##ctyname2##", $ctyname);
		$tpl->assign("##ctyselected2##", $ctyselected2);
		$tpl->parse ("#####ROW#####", '.rows_cty2');
		
		$tpl->assign("##ctyid3##", $ctyid);
		$tpl->assign("##ctyname3##", $ctyname);
		$tpl->assign("##ctyselected3##", $ctyselected3);
		$tpl->parse ("#####ROW#####", '.rows_cty3');
		
		$tpl->assign("##ctyid4##", $ctyid);
		$tpl->assign("##ctyname4##", $ctyname);
		$tpl->assign("##ctyselected4##", $ctyselected4);
		$tpl->parse ("#####ROW#####", '.rows_cty4');
		
		$tpl->assign("##ctyid5##", $ctyid);
		$tpl->assign("##ctyname5##", $ctyname);
		$tpl->assign("##ctyselected5##", $ctyselected5);
		$tpl->parse ("#####ROW#####", '.rows_cty5');
		
	}
	
	$sql4_1 = "select * from flc_country where cty_id = '1';";
	$result4_1 = mysql_query($sql4_1);
	while ($dbarr4_1 = mysql_fetch_array($result4_1)) { 
		if ($langcode == 'en') { $ctyname_1 = $dbarr4_1['cty_name_en']; $ctynamedefault = "Vietnam"; } 
		else if ($langcode == 'vn') { $ctyname_1 = $dbarr4_1['cty_name_vn']; $ctynamedefault = "Việt Nam"; }
		else { $ctyname_1 = $dbarr4_1['cty_name_jp']; $ctynamedefault = "ベトナム"; }
	}
	
	if ($memcty1 == '1') { $ctyselected1_1 = "selected"; $ctydefault1 = ""; } else { $ctyselected1_1 = ""; $ctydefault1 = "selected"; }
	if ($memcty2 == '1') { $ctyselected2_1 = "selected"; $ctydefault2 = ""; } else { $ctyselected2_1 = ""; $ctydefault2 = "selected"; }
	if ($memcty3 == '1') { $ctyselected3_1 = "selected"; $ctydefault3 = ""; } else { $ctyselected3_1 = ""; $ctydefault3 = "selected"; }
	if ($memcty4 == '1') { $ctyselected4_1 = "selected"; $ctydefault4 = ""; } else { $ctyselected4_1 = ""; $ctydefault4 = "selected"; }
	if ($memcty5 == '1') { $ctyselected5_1 = "selected"; $ctydefault5 = ""; } else { $ctyselected5_1 = ""; $ctydefault5 = "selected"; }
	
	/*$memcategory = explode(" ",$memcategory);
	$catcnt = count($memcategory);
	
	$sqlcat = "select * from flc_category where cat_pos != 'm' order by cat_order asc;"; 
	$resultcat = mysql_query($sqlcat);
	while ($dbarrcat = mysql_fetch_array($resultcat)) {
	
		$catid = $dbarrcat['cat_id'];
		$catpos = $dbarrcat['cat_pos'];
		$catunder = $dbarrcat['cat_under'];
		
		if ($_COOKIE['vlang'] == 'en') { $catname = $dbarrcat['cat_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $catname = $dbarrcat['cat_name_vn']; }
		else { $catname = $dbarrcat['cat_name_jp']; }
		
		if ($catpos == 's') { 
		
			$sqlcatunder = "select * from flc_category where cat_id = '$catunder';"; 
			$resultcatunder = mysql_query($sqlcatunder);
			while ($dbarrcatunder = mysql_fetch_array($resultcatunder)) { 
				if ($_COOKIE['vlang'] == 'en') { $catundername = $dbarrcatunder['cat_name_en']; }
				else if ($_COOKIE['vlang'] == 'vn') { $catundername = $dbarrcatunder['cat_name_vn']; }
				else { $catundername = $dbarrcatunder['cat_name_jp']; }
			}
			
			$catname = $catundername."　・ ".$catname; 
			
		}
		
		//$catselected = "";
		//for ($i=0;$i<=$catcnt;$i++) { if ($catid == $memcategory[$i]) { $catselected = "selected"; } }
		
		if ($catid == $memcategory[0]) { $catselected = "selected"; $catdefault = ""; } else { $catselected = ""; $catdefault = "selected"; }
		//if ($catid == $memcategory[1]) { $catsub1selected = "selected"; $catsub1default = ""; } else { $catsub1selected = ""; $catsub1default = "selected"; }
		//if ($catid == $memcategory[2]) { $catsub2selected = "selected"; $catsub2default = ""; } else { $catsub2selected = ""; $catsub2default = "selected"; }
		
		$tpl->assign("##catid##", $catid);
		$tpl->assign("##catname##", $catname);
		$tpl->assign("##catselected##", $catselected);
		$tpl->parse ("#####ROW#####", '.rows_cat');
		
	}*/
	
	$comname_jpk = "";
	
	if ($langcode == 'en') { 
	
		if ($pagshowen == 't') { $pagshow = "checked"; } else { $pagshow = ""; }
		
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "English Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Anh"; } else { $langcodefull = "英語のページ"; }
		$pagname = $pagnameen;
		$pagpagetitle = $pagpagetitleen;
		$pagtitle = $pagtitleen;
		$pagdetail = $pagdetailen;
		$memcomname = $memcomnameen;
		$membusiness = $membusinessen;
		$memproduct = $memproducten;
		$mempername = $mempernameen;
		$memposname = $memposnameen;
		$memaddlab1 = $memaddlab1en;
		$memadd1 = $memadd1en;
		$memaddlab2 = $memaddlab2en;
		$memadd2 = $memadd2en;
		$memaddlab3 = $memaddlab3en;
		$memadd3 = $memadd3en;
		$memaddlab4 = $memaddlab4en;
		$memadd4 = $memadd4en;
		$memaddlab5 = $memaddlab5en;
		$memadd5 = $memadd5en;
		$memtellab1 = $memtellab1en;
		$memtellab2 = $memtellab2en;
		$memtellab3 = $memtellab3en;
		$memtellab4 = $memtellab4en;
		$memtellab5 = $memtellab5en;
		$memmaillab1 = $memmaillab1en;
		$memmaillab2 = $memmaillab2en;
		$memmaillab3 = $memmaillab3en;
		$memmaillab4 = $memmaillab4en;
		$memmaillab5 = $memmaillab5en;
		$memestdate = $memestdateen;
		$memaccdate = $memaccdateen;
		$memcapital = $memcapitalen;
		$mememployee = $mememployeeen;
		$memboi = $memboien;
		$memiso = $memisoen;
		$memcomparent = $memcomparenten;
		$memshareholder = $memshareholderen;
		$membank = $membanken;
		$memvalcus = $memvalcusen;
		$memconlab1 = $memconlab1en;
		$memcon1 = $memcon1en;
		$memconlab2 = $memconlab2en;
		$memcon2 = $memcon2en;
		$memconlab3 = $memconlab3en;
		$memcon3 = $memcon3en;
		$memconlab4 = $memconlab4en;
		$memcon4 = $memcon4en;
		$memconlab5 = $memconlab5en;
		$memcon5 = $memcon5en;
		$memfooter = $memfooteren;
		
		$val_langlocal = $lb_en;
		
		$box_conname_en = "";
		$box_conpos_en = "";
	
	} else if ($langcode == 'vn') { 
		
		if ($pagshowvn == 't') { $pagshow = "checked"; } else { $pagshow = ""; }
		
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Vietnamese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Việt"; } else { $langcodefull = "ベトナム語のページ"; }
		$pagname = $pagnamevn;
		$pagpagetitle = $pagpagetitlevn;
		$pagtitle = $pagtitlevn;
		$pagdetail = $pagdetailvn;
		$memcomname = $memcomnamevn;
		$membusiness = $membusinessvn;
		$memproduct = $memproductvn;
		$mempername = $mempernamevn;
		$memposname = $memposnamevn;
		$memaddlab1 = $memaddlab1vn;
		$memadd1 = $memadd1vn;
		$memaddlab2 = $memaddlab2vn;
		$memadd2 = $memadd2vn;
		$memaddlab3 = $memaddlab3vn;
		$memadd3 = $memadd3vn;
		$memaddlab4 = $memaddlab4vn;
		$memadd4 = $memadd4vn;
		$memaddlab5 = $memaddlab5vn;
		$memadd5 = $memadd5vn;
		$memtellab1 = $memtellab1vn;
		$memtellab2 = $memtellab2vn;
		$memtellab3 = $memtellab3vn;
		$memtellab4 = $memtellab4vn;
		$memtellab5 = $memtellab5vn;
		$memmaillab1 = $memmaillab1vn;
		$memmaillab2 = $memmaillab2vn;
		$memmaillab3 = $memmaillab3vn;
		$memmaillab4 = $memmaillab4vn;
		$memmaillab5 = $memmaillab5vn;
		$memestdate = $memestdatevn;
		$memaccdate = $memaccdatevn;
		$memcapital = $memcapitalvn;
		$mememployee = $mememployeevn;
		$memboi = $memboivn;
		$memiso = $memisovn;
		$memcomparent = $memcomparentvn;
		$memshareholder = $memshareholdervn;
		$membank = $membankvn;
		$memvalcus = $memvalcusvn;
		$memconlab1 = $memconlab1vn;
		$memcon1 = $memcon1vn;
		$memconlab2 = $memconlab2vn;
		$memcon2 = $memcon2vn;
		$memconlab3 = $memconlab3vn;
		$memcon3 = $memcon3vn;
		$memconlab4 = $memconlab4vn;
		$memcon4 = $memcon4vn;
		$memconlab5 = $memconlab5vn;
		$memcon5 = $memcon5vn;
		$memfooter = $memfootervn;
		
		$val_langlocal = $lb_vn;
		
		$box_conname_en = "<tr>
            <td colspan=\"3\"><img src=\"images/blank.png\" width=\"740\" height=\"10\" /></td>
          </tr>
          <tr bgcolor=\"#EEEEEE\">
            <td><div align=\"right\"><strong>".$lb_prf_pername." [".$lb_en."]</strong></div></td>
            <td>&nbsp;</td>
            <td><input name=\"t_pername_en\" type=\"text\" class=\"box_normal\" id=\"t_pername_en\" value=\"".$mempernameen."\" maxlength=\"85\" /></td>
          </tr>";
		  
		  $box_conpos_en = "<tr>
            <td colspan=\"3\"><img src=\"images/blank.png\" width=\"740\" height=\"10\" /></td>
          </tr>
          <tr bgcolor=\"#EEEEEE\">
            <td><div align=\"right\"><strong>".$lb_prf_posname." [".$lb_en."]</strong></div></td>
            <td>&nbsp;</td>
            <td><input name=\"t_posname_en\" type=\"text\" class=\"box_normal\" id=\"t_posname_en\" value=\"".$memposnameen."\" maxlength=\"85\" /></td>
          </tr>";
		
	} else { 
		
		if ($pagshowjp == 't') { $pagshow = "checked"; } else { $pagshow = ""; }
		
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Japanese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Nhật"; } else { $langcodefull = "日本語のページ"; }
		$pagname = $pagnamejp;
		$pagpagetitle = $pagpagetitlejp;
		$pagtitle = $pagtitlejp;
		$pagdetail = $pagdetailjp;
		$memcomname = $memcomnamejp;
		$membusiness = $membusinessjp;
		$memproduct = $memproductjp;
		$mempername = $mempernamejp;
		$memposname = $memposnamejp;
		$memaddlab1 = $memaddlab1jp;
		$memadd1 = $memadd1jp;
		$memaddlab2 = $memaddlab2jp;
		$memadd2 = $memadd2jp;
		$memaddlab3 = $memaddlab3jp;
		$memadd3 = $memadd3jp;
		$memaddlab4 = $memaddlab4jp;
		$memadd4 = $memadd4jp;
		$memaddlab5 = $memaddlab5jp;
		$memadd5 = $memadd5jp;
		$memtellab1 = $memtellab1jp;
		$memtellab2 = $memtellab2jp;
		$memtellab3 = $memtellab3jp;
		$memtellab4 = $memtellab4jp;
		$memtellab5 = $memtellab5jp;
		$memmaillab1 = $memmaillab1jp;
		$memmaillab2 = $memmaillab2jp;
		$memmaillab3 = $memmaillab3jp;
		$memmaillab4 = $memmaillab4jp;
		$memmaillab5 = $memmaillab5jp;
		$memestdate = $memestdatejp;
		$memaccdate = $memaccdatejp;
		$memcapital = $memcapitaljp;
		$mememployee = $mememployeejp;
		$memboi = $memboijp;
		$memiso = $memisojp;
		$memcomparent = $memcomparentjp;
		$memshareholder = $memshareholderjp;
		$membank = $membankjp;
		$memvalcus = $memvalcusjp;
		$memconlab1 = $memconlab1jp;
		$memcon1 = $memcon1jp;
		$memconlab2 = $memconlab2jp;
		$memcon2 = $memcon2jp;
		$memconlab3 = $memconlab3jp;
		$memcon3 = $memcon3jp;
		$memconlab4 = $memconlab4jp;
		$memcon4 = $memcon4jp;
		$memconlab5 = $memconlab5jp;
		$memcon5 = $memcon5jp;
		$memfooter = $memfooterjp;
		
		$val_langlocal = $lb_jp;
		
		$box_conname_en = "<tr>
            <td colspan=\"3\"><img src=\"images/blank.png\" width=\"740\" height=\"10\" /></td>
          </tr>
          <tr bgcolor=\"#EEEEEE\">
            <td><div align=\"right\"><strong>".$lb_prf_pername." [".$lb_en."]</strong></div></td>
            <td>&nbsp;</td>
            <td><input name=\"t_pername_en\" type=\"text\" class=\"box_normal\" id=\"t_pername_en\" value=\"".$mempernameen."\" maxlength=\"85\" /></td>
          </tr>";
		  
		  $box_conpos_en = "<tr>
            <td colspan=\"3\"><img src=\"images/blank.png\" width=\"740\" height=\"10\" /></td>
          </tr>
          <tr bgcolor=\"#EEEEEE\">
            <td><div align=\"right\"><strong>".$lb_prf_posname." [".$lb_en."]</strong></div></td>
            <td>&nbsp;</td>
            <td><input name=\"t_posname_en\" type=\"text\" class=\"box_normal\" id=\"t_posname_en\" value=\"".$memposnameen."\" maxlength=\"85\" /></td>
          </tr>";
		
		/*$comname_jpk = "<tr>
          <td valign=\"top\" bgcolor=\"#999999\" class=\"white_b\"><strong>".$lb_mem_comnamejpk."</strong></td>
          <td valign=\"top\" bgcolor=\"#FFFFFF\"><input name=\"t_comname_jpk\" type=\"text\" class=\"box_normal\" id=\"t_comname_jpk\" maxlength=\"85\" value=\"".$memcomnamejpk."\"/></td>
        </tr>";*/
		
	}
	
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##pagid##", $pagid);
	$tpl->assign("##memid##", $memid);
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
	$tpl->assign("##pagimagedisable##", $pagimagedisable);
	$tpl->assign("##memfooter##", $memfooter);
	$tpl->assign("##memcomname##", $memcomname);
	$tpl->assign("##membusiness##", $membusiness);
	$tpl->assign("##memproduct##", $memproduct);
	$tpl->assign("##memaddlab1##", $memaddlab1);
	$tpl->assign("##mempername##", $mempername);
	$tpl->assign("##memposname##", $memposname);
	$tpl->assign("##memadd1##", $memadd1);
	$tpl->assign("##memzip1##", $memzip1);
	$tpl->assign("##memaddlab2##", $memaddlab2);
	$tpl->assign("##memadd2##", $memadd2);
	$tpl->assign("##memzip2##", $memzip2);
	$tpl->assign("##memaddlab3##", $memaddlab3);
	$tpl->assign("##memadd3##", $memadd3);
	$tpl->assign("##memzip3##", $memzip3);
	$tpl->assign("##memaddlab4##", $memaddlab4);
	$tpl->assign("##memadd4##", $memadd4);
	$tpl->assign("##memzip4##", $memzip4);
	$tpl->assign("##memaddlab5##", $memaddlab5);
	$tpl->assign("##memadd5##", $memadd5);
	$tpl->assign("##memzip5##", $memzip5);
	$tpl->assign("##memtellab1##", $memtellab1);
	$tpl->assign("##memtel1##", $memtel1);
	$tpl->assign("##memtellab2##", $memtellab2);
	$tpl->assign("##memtel2##", $memtel2);
	$tpl->assign("##memtellab3##", $memtellab3);
	$tpl->assign("##memtel3##", $memtel3);
	$tpl->assign("##memtellab4##", $memtellab4);
	$tpl->assign("##memtel4##", $memtel4);
	$tpl->assign("##memtellab5##", $memtellab5);
	$tpl->assign("##memtel5##", $memtel5);
	$tpl->assign("##memmaillab1##", $memmaillab1);
	$tpl->assign("##memmail1##", $memmail1);
	$tpl->assign("##memmaillab2##", $memmaillab2);
	$tpl->assign("##memmail2##", $memmail2);
	$tpl->assign("##memmaillab3##", $memmaillab3);
	$tpl->assign("##memmail3##", $memmail3);
	$tpl->assign("##memmaillab4##", $memmaillab4);
	$tpl->assign("##memmail4##", $memmail4);
	$tpl->assign("##memmaillab5##", $memmaillab5);
	$tpl->assign("##memmail5##", $memmail5);
	$tpl->assign("##memurl##", $memurl);
	$tpl->assign("##memseocom##", $memseocom);
	$tpl->assign("##memseokey##", $memseokey);
	$tpl->assign("##memestdate##", $memestdate);
	$tpl->assign("##memcapital##", $memcapital);
	$tpl->assign("##memcomparent##", $memcomparent);
	$tpl->assign("##memshareholder##", $memshareholder);
	$tpl->assign("##mememployee##", $mememployee);
	$tpl->assign("##memaccdate##", $memaccdate);
	$tpl->assign("##membank##", $membank);
	$tpl->assign("##memboi##", $memboi);
	$tpl->assign("##memiso##", $memiso);
	$tpl->assign("##memvalcus##", $memvalcus);
	$tpl->assign("##memconlab1##", $memconlab1);
	$tpl->assign("##memcon1##", $memcon1);
	$tpl->assign("##memconlab2##", $memconlab2);
	$tpl->assign("##memcon2##", $memcon2);
	$tpl->assign("##memconlab3##", $memconlab3);
	$tpl->assign("##memcon3##", $memcon3);
	$tpl->assign("##memconlab4##", $memconlab4);
	$tpl->assign("##memcon4##", $memcon4);
	$tpl->assign("##memconlab5##", $memconlab5);
	$tpl->assign("##memcon5##", $memcon5);
	$tpl->assign("##memcat##", $memcategory[0]);
	$tpl->assign("##memsort##", $memsort);
	$tpl->assign("##mempackage##", $mempackage);
	$tpl->assign("##inedefault1##", $inedefault1);
	$tpl->assign("##inedefault2##", $inedefault2);
	$tpl->assign("##inedefault3##", $inedefault3);
	$tpl->assign("##inedefault4##", $inedefault4);
	$tpl->assign("##inedefault5##", $inedefault5);
	$tpl->assign("##prvdefault1##", $prvdefault1);
	$tpl->assign("##prvdefault2##", $prvdefault2);
	$tpl->assign("##prvdefault3##", $prvdefault3);
	$tpl->assign("##prvdefault4##", $prvdefault4);
	$tpl->assign("##prvdefault5##", $prvdefault5);
	$tpl->assign("##ctyselected1_1##", $ctyselected1_1);
	$tpl->assign("##ctyselected2_1##", $ctyselected2_1);
	$tpl->assign("##ctyselected3_1##", $ctyselected3_1);
	$tpl->assign("##ctyselected4_1##", $ctyselected4_1);
	$tpl->assign("##ctyselected5_1##", $ctyselected5_1);
	$tpl->assign("##ctynamedefault##", $ctynamedefault);
	$tpl->assign("##ctyname_1##", $ctyname_1);
	$tpl->assign("##ctydefault1##", $ctydefault1);
	$tpl->assign("##ctydefault2##", $ctydefault2);
	$tpl->assign("##ctydefault3##", $ctydefault3);
	$tpl->assign("##ctydefault4##", $ctydefault4);
	$tpl->assign("##ctydefault5##", $ctydefault5);
	$tpl->assign("##ctydisable1##", $ctydisable1);
	$tpl->assign("##ctydisable2##", $ctydisable2);
	$tpl->assign("##ctydisable3##", $ctydisable3);
	$tpl->assign("##ctydisable4##", $ctydisable4);
	$tpl->assign("##ctydisable5##", $ctydisable5);
	$tpl->assign("##box_conname_en##", $box_conname_en);
	$tpl->assign("##box_conpos_en##", $box_conpos_en);
	$tpl->assign("##val_langlocal##", $val_langlocal);
	//$tpl->assign("##catdefault##", $catdefault);
	//$tpl->assign("##catsub1default##", $catsub1default);
	//$tpl->assign("##catsub2default##", $catsub2default);
	//$tpl->assign("##comname_jpk##", $comname_jpk);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
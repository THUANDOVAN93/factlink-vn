<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_page_home_add.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_SESSION['vmd'];
	$langcode = $_GET['lang'];
	
	if ($langcode != 'en' && $langcode != 'jp' && $langcode != 'vn') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=4\">"; exit(); }	
	
	$checkpackage = checkfreemem($memid);
	if ($checkpackage == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=5\">"; exit(); }
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "page_home_add";
	$currentrec = $memid;
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
	
	$sql0 = "select * from flc_page where mem_id = '$memid' and pag_type = 'prf';"; 
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { 
		$prfshowen = $dbarr0['pag_show_en']; 
		$prfshowvn = $dbarr0['pag_show_vn']; 
		$prfshowjp = $dbarr0['pag_show_jp']; 
	}
	
	if ($langcode == 'en') { if ($prfshowen != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=3\">"; exit(); } }
	if ($langcode == 'vn') { if ($prfshowvn != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=3\">"; exit(); } }
	if ($langcode == 'jp') { if ($prfshowjp != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=3\">"; exit(); } }
	
	$sql3 = "select * from flc_home where mem_id = '$memid';"; 
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) { $homid = $dbarr3['hom_id']; }
	
	$sql4 = "select * from flc_page where mem_id = '$memid' and pag_type = 'hom';"; 
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) { $pagid = $dbarr4['pag_id']; }
	
	if ($pagid != '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_page_home_edit.php?page=$pagid&lang=$langcode\">"; exit(); }
		
	$sqltpk = "select * from flc_template_key order by tpk_name_en asc;"; 
	$resulttpk = mysql_query($sqltpk);
	while ($dbarrtpk = mysql_fetch_array($resulttpk)) {
	
		$tpkid = $dbarrtpk['tpk_id'];
		$tpkname = $dbarrtpk['tpk_name_en']; 
		$tpktitlecolor = $dbarrtpk['tpk_title_color'];
		$tpkbgcolor = $dbarrtpk['tpk_bg_color'];
		if ($tpkid == $defaulttpkid) { $tpkselected = "selected"; } else { $tpkselected = ""; }
		
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
		if ($clfid == $defaultclfid) { $clfselected = "selected"; } else { $clfselected = ""; }
		
		$tpl->assign("##clfid##", $clfid);
		$tpl->assign("##clfname##", $clfname);
		$tpl->assign("##clfcode##", $clfcode);
		$tpl->assign("##clfselected##", $clfselected);
		$tpl->parse ("#####ROW#####", '.rows_clf');
		
		$tpl->assign("##clfkeyid##", $clfid);
		$tpl->assign("##clfkeyname##", $clfname);
		$tpl->assign("##clfkeycode##", $clfcode);
		$tpl->assign("##clfkeyselected##", $clfselected);
		$tpl->parse ("#####ROW#####", '.rows_clfkey');
		
		$tpl->assign("##clflineid##", $clfid);
		$tpl->assign("##clflinename##", $clfname);
		$tpl->assign("##clflinecode##", $clfcode);
		$tpl->assign("##clflineselected##", $clfselected);
		$tpl->parse ("#####ROW#####", '.rows_clfline');
		
	}
	
	if ($langcode == 'en') { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "English Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Anh"; } else { $langcodefull = "英語のページ"; }
		$val_pagname = "Home";
	
	} else if ($langcode == 'vn') { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Vietnamese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Việt"; } else { $langcodefull = "ベトナム語のページ"; }
		$val_pagname = "Trang chủ";
		
	} else { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Japanese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Nhật"; } else { $langcodefull = "日本語のページ"; }
		$val_pagname = "ホーム";
		
	}
	
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##langcode##", $langcode);
	$tpl->assign("##langcodefull##", $langcodefull);
	$tpl->assign("##val_pagname##", $val_pagname);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
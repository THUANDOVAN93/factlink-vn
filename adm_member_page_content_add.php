<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_page_content_add.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_GET['id'];
	$langcode = $_GET['lang'];
	
	if ($langcode != 'en' && $langcode != 'jp' && $langcode != 'vn') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=4\">"; exit(); }
	
	$checkpackage = checkfreemem($memid);
	if ($checkpackage == '') { $freemem = "t"; } else { $freemem = ""; }
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$sql0 = "select * from flc_member where mem_id = '$memid';"; 
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { 
		
		if ($_COOKIE['vlang'] == 'en') { $memcomname = $dbarr0['mem_comname_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $memcomname = $dbarr0['mem_comname_vn']; }
		else { $memcomname = $dbarr0['mem_comname_jp']; } 
		
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
		
	}
	
	if ($langcode == 'en') { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "English Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Anh"; } else { $langcodefull = "英語のページ"; }
		
	} else if ($langcode == 'vn') { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Vietnamese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Việt"; } else { $langcodefull = "ベトナム語のページ"; }
		
	} else { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Japanese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Nhật"; } else { $langcodefull = "日本語のページ"; }
				
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
	
	$tpl->assign("##freemem##", $freemem);
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##memcomname##", $memcomname);
	$tpl->assign("##langcode##", $langcode);
	$tpl->assign("##langcodefull##", $langcodefull);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure_memerror.html"; 
	$url2 = "mem_error.html";
	if ($_COOKIE['vlang'] == 'en') { $url6 = "menu_en.html"; } else if ($_COOKIE['vlang'] == 'vn') { $url6 = "menu_vn.html"; } else { $url6 = "menu_jp.html"; }
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "menu_tpl" => $url6));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	if ($_COOKIE['vlang'] == 'en') { $errtext = "Page not found."; }
	else if ($_COOKIE['vlang'] == 'vn') { $errtext = "Page not found."; }
	else { $errtext = "ページの該当なし。"; }
	
	$tpl->assign("##errtext##", $errtext);
	
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
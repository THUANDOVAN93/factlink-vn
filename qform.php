<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure.html"; 
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	$pagecode = "ctt";
	if ($_COOKIE['lang'] == 'en') { $url6 = "menu_en.html"; $url2 = "qform1_en.html"; } else if ($_COOKIE['lang'] == 'th') { $url6 = "menu_th.html"; $url2 = "qform1_th.html"; } else { $url6 = "menu_jp.html"; $url2 = "qform1_jp.html"; }
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "right_tpl" => $url3, "left_tpl" => $url4, "top_tpl" => $url5, "menu_tpl" => $url6));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	
	
	// Random security number
	$random = random(0);
	$confirmcode = $random[1].$random[2].$random[3].$random[4];
	
	$tpl->assign("##confirmcode##", $confirmcode);
	$tpl->assign("##randomnum##", $random[0]);
	$tpl->assign("##langcode##", $_COOKIE['lang']);
	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
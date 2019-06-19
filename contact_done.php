<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure.html"; 
	$url2 = "contact_done.html";
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	$pagecode = "ctt";
	if ($_COOKIE['vlang'] == 'en') { $url6 = "menu_en.html"; } else if ($_COOKIE['vlang'] == 'vn') { $url6 = "menu_vn.html"; } else { $url6 = "menu_jp.html"; }
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "right_tpl" => $url3, "left_tpl" => $url4, "top_tpl" => $url5, "menu_tpl" => $url6));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	if ($_COOKIE['vlang'] == 'en') { $fintext = "Your inquiry has been sent. Please wait for reply."; }
	else if ($_COOKIE['vlang'] == 'vn') { $fintext = "Your inquiry has been sent. Please wait for reply."; }
	else { $fintext = "お問い合わせ送信完了しました　返答をお待ちください。"; }
	
	$fintext = "<img src=\"images/icon_done_01.png\" width=\"20\" height=\"20\" align=\"absmiddle\" /> <strong>".$fintext."</strong>";
	
	$tpl->assign("##fintext##", $fintext);
	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
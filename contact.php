<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure-new.html"; 
	$url2 = "contact.html";
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	$pagecode = "ctt";
	/* Set default language cookie */
	if(empty($_COOKIE['vlang'])) {
		$_COOKIE['vlang'] = 'en';
	}
	
	/* Prevent unknown cookie language value */
	if(!in_array($_COOKIE['vlang'],['en','jp','vn'])) {
		$_COOKIE['vlang'] = 'en';
	}
	
	
	if ($_COOKIE['vlang'] == 'en') {
		$url6 = "menu-html_en.html";
		$url7 = "contact_en.html";
	} else if ($_COOKIE['vlang'] == 'vn') {
		$url6 = "menu-html_vn.html";
		$url7 = "contact_vn.html";
	} else {
		$url6 = "menu-html_jp.html";
		$url7 = "contact_jp.html";
	}
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "right_tpl" => $url3, "left_tpl" => $url4, "top_tpl" => $url5, "menu_tpl" => $url6, "desc_tpl" => $url7));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	
	// Random security number
	$random = random(0);
	$confirmcode = $random[1].$random[2].$random[3].$random[4];
	
	$tpl->assign("##confirmcode##", $confirmcode);
	$tpl->assign("##randomnum##", $random[0]);
	$tpl->assign("##captcha_site_key##", $captchaSiteKey);
	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DESC_AREA##", "desc_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
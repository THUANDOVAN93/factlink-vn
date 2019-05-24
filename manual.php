<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure-new.html"; 
	$url2 = "manual.html";
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	$pagecode = "mnl";

	if (empty($_COOKIE['vlang'])) {
		$_COOKIE['vlang'] = 'en';
	}
	
	if (!in_array($_COOKIE['vlang'],['en','jp','vn'])) {
		$_COOKIE['vlang'] = 'en';
	}

	$templateMenu = "menu-html_".$_COOKIE['vlang'].".html";
	$typeManualPage = $_GET['page'];
	if (empty($typeManualPage) || !isset($typeManualPage)) {
		$typeManualPage = "primary";
	}
	$templateContent = "manual-".$typeManualPage."-".$_COOKIE['vlang'].".html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "right_tpl" => $url3, "left_tpl" => $url4, "top_tpl" => $url5, "menu_tpl" => $templateMenu, "desc_tpl" => $templateContent));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	
	
	$tpl->assign("##langcode##", $_COOKIE['vlang']);
	
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
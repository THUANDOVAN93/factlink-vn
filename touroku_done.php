<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure.html"; 
	$url2 = "touroku_done.html";
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	$pagecode = "reg";

	if ($_COOKIE['vlang'] == 'en') {
		$url6 = "menu_en.html";
	} elseif ($_COOKIE['vlang'] == 'vn') {
		$url6 = "menu_vn.html";
	} else {
		$url6 = "menu_jp.html";
	}
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "right_tpl" => $url3, "left_tpl" => $url4, "top_tpl" => $url5, "menu_tpl" => $url6));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	if ($_COOKIE['vlang'] == 'en') { $fintext = "<font color=\"#FF0000\"><strong>Register done.</strong></font></br>Please check your registered e-mail for registration information. If you not found any in Inbox, please check in your Junk Mail or contact us at (+84) 888 767 138."; }
	else if ($_COOKIE['vlang'] == 'vn') { $fintext = "<font color=\"#FF0000\"><strong>Register done.</strong></font></br>Please check your registered e-mail for registration information. If you not found any in Inbox, please check in your Junk Mail or contact us at (+84) 888 767 138."; }
	else { $fintext = "<font color=\"#FF0000\"><strong>登録済み。</strong></font></br>会員登録情報にご登録のE-Mailをご確認ください　受信ボックスに送信されていないようでしたらジャンクメールをご確認していただくか、または (+84) 888 767 138 までご連絡ください。"; }
	
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
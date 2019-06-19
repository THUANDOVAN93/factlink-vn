<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure_error.html"; 
	$url2 = "error.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$code = $_GET['code'];
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	if ($code == '1') {
	
		if ($_COOKIE['vlang'] == 'en') { $errtext = "Permission denied, or account has been leaved for long time."; }
		else if ($_COOKIE['vlang'] == 'vn') { $errtext = "Permission denied, or account has been leaved for long time."; }
		else { $errtext = "承認が拒否されました　またはアカウントが長期間使用されていません。"; }
	
	} else if ($code == '2') {
	
		if ($_COOKIE['vlang'] == 'en') { $errtext = "Permission denied."; }
		else if ($_COOKIE['vlang'] == 'vn') { $errtext = "ไม่สามารถเข้าถึงได้"; }
		else { $errtext = "承認が拒否されました。"; }
	
	} else if ($code == '3') {
	
		if ($_COOKIE['vlang'] == 'en') { $errtext = "Cannot execute request when 'Company Profile Page' of this language disabled."; }
		else if ($_COOKIE['vlang'] == 'vn') { $errtext = "Cannot execute request when 'Company Profile Page' of this language disabled."; }
		else { $errtext = "Cannot execute request when 'Company Profile Page' of this language disabled."; }
	
	} else if ($code == '4') {
	
		if ($_COOKIE['vlang'] == 'en') { $errtext = "Language not available."; }
		else if ($_COOKIE['vlang'] == 'vn') { $errtext = "Language not available."; }
		else { $errtext = "言語が適切ではありません。"; }
	
	} else if ($code == '5') {
	
		if ($_COOKIE['vlang'] == 'en') { $errtext = "This function has been limited for Basic Member only."; }
		else if ($_COOKIE['vlang'] == 'vn') { $errtext = "This function has been limited for Basic Member only."; }
		else { $errtext = "この機能は有料会員限定となっています。"; }
	
	}
	
	$tpl->assign("##errtext##", $errtext);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
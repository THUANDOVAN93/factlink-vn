<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_support.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_SESSION['vmd'];
	$case = $_GET['case'];
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vmd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	if ($case == '1') { 
		$casesubjecten = "Inquiry about Basic Member."; 
		$casesubjectvn = "Inquiry about Basic Member."; 
		$casesubjectjp = "ベーシック会員についてのお問い合わせ。"; 
	} else if ($case == '2') { 
		$casesubjecten = "Inquiry about Category Banner."; 
		$casesubjectvn = "Inquiry about Category Banner."; 
		$casesubjectjp = "業種別バナーについてのお問い合わせ。"; 
	} else if ($case == '3') { 
		$casesubjecten = "Inquiry about Basic Banner."; 
		$casesubjectvn = "Inquiry about Basic Banner."; 
		$casesubjectjp = "ベーシックバナーについてのお問い合わせ。"; 
	}
	
	// language
	if ($_COOKIE['vlang'] == 'en') { $casesubject = $casesubjecten; } 
	else if ($_COOKIE['vlang'] == 'vn') { $casesubject = $casesubjectvn; } 
	else { $casesubject = $casesubjectjp; } 
	
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##case##", $case);
	$tpl->assign("##casesubject##", $casesubject);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
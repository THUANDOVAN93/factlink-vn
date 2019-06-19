<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['p'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_tempmain_add.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['d'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$sqltpk = "select * from flc_template_key order by tpk_name_en asc;"; 
	$resulttpk = mysql_query($sqltpk);
	while ($dbarrtpk = mysql_fetch_array($resulttpk)) {
	
		$tpkid = $dbarrtpk['tpk_id'];
		$tpkname = $dbarrtpk['tpk_name_en']; 
		$tpktitlecolor = $dbarrtpk['tpk_title_color'];
		$tpkbgcolor = $dbarrtpk['tpk_bg_color'];
		if ($tpkid == '001') { $tpkselected = "selected"; } else { $tpkselected = ""; }
		
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
		if ($clfid == '001') { $clfselected = "selected"; } else { $clfselected = ""; }
		
		$tpl->assign("##clfid##", $clfid);
		$tpl->assign("##clfname##", $clfname);
		$tpl->assign("##clfcode##", $clfcode);
		$tpl->assign("##clfselected##", $clfselected);
		$tpl->parse ("#####ROW#####", '.rows_clf');
		
	}
	
	$tpl->assign("##admid##", $_SESSION['d']);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
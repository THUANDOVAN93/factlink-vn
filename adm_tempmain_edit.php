<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['p'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_tempmain_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$tpmid = $_GET['id'];
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "tempmain_edit";
	$currentrec = $tpmid;
	$currentuserid = $_SESSION['d']; 
	$currentuserper = "adm";
	
	$sqlusl0 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl0 = mysql_query($sqlusl0);
	
	$sqlusl1 = "select * from flc_uselog where usl_filepage = '$currentpage' and usl_filerec = '$currentrec';"; 
	$resultusl1 = mysql_query($sqlusl1);
	while ($dbarrusl1 = mysql_fetch_array($resultusl1)) { 
	
		$usltimestamp = $dbarrusl1['usl_timestamp'];
		
		if ($usltimestamp > $limittimestamp) { 
			
			$_SESSION['lock_userid'] = $dbarrusl1['usl_userid'];
			$_SESSION['lock_userper'] = $dbarrusl1['usl_userper'];
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_lock.php\">"; exit(); 
			
		} else { $usldel = "t"; }
		
	}
	
	if ($usldel == 't') { 
	
		$sqlusl2 = "delete from flc_uselog where usl_timestamp = '$usltimestamp';"; 
		$resultusl2 = mysql_query($sqlusl2);
		
	}
	
	$sqlusl3 = "insert into flc_uselog (usl_filepage, usl_filerec, usl_userid, usl_userper) values ('$currentpage', '$currentrec', '$currentuserid', '$currentuserper');"; 
	$resultusl3 = mysql_query($sqlusl3);
	
	// --------------------
	
	$sql1 = "select * from flc_template_main where tpm_id = '$tpmid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		$tpmnameen = $dbarr1['tpm_name_en']; 
		$tpmnamefile = $dbarr1['tpm_name_file']; 
		$tpmtpkid = $dbarr1['tpk_id']; 
		$tpmclfid = $dbarr1['clf_id']; 
		
	}
	
	$sqltpk = "select * from flc_template_key order by tpk_name_en asc;"; 
	$resulttpk = mysql_query($sqltpk);
	while ($dbarrtpk = mysql_fetch_array($resulttpk)) {
	
		$tpkid = $dbarrtpk['tpk_id'];
		$tpkname = $dbarrtpk['tpk_name_en']; 
		$tpktitlecolor = $dbarrtpk['tpk_title_color'];
		$tpkbgcolor = $dbarrtpk['tpk_bg_color'];
		if ($tpkid == $tpmtpkid) { $tpkselected = "selected"; } else { $tpkselected = ""; }
		
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
		if ($clfid == $tpmclfid) { $clfselected = "selected"; } else { $clfselected = ""; }
		
		$tpl->assign("##clfid##", $clfid);
		$tpl->assign("##clfname##", $clfname);
		$tpl->assign("##clfcode##", $clfcode);
		$tpl->assign("##clfselected##", $clfselected);
		$tpl->parse ("#####ROW#####", '.rows_clf');
		
	}
	
	$tpl->assign("##admid##", $_SESSION['d']);
	$tpl->assign("##tpmid##", $tpmid);
	$tpl->assign("##tpmnameen##", $tpmnameen);
	$tpl->assign("##tpmnamefile##", $tpmnamefile);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_package_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$pckid = $_GET['id'];
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "package_edit";
	$currentrec = $pckid;
	$currentuserid = $_SESSION['vd']; 
	$currentuserper = "adm";
	
	$sqlusl0 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl0 = mysql_query($sqlusl0);
	
	$sqlusl1 = "select * from flc_uselog where usl_filepage = '$currentpage' and usl_filerec = '$currentrec';"; 
	$resultusl1 = mysql_query($sqlusl1);
	while ($dbarrusl1 = mysql_fetch_array($resultusl1)) { 
	
		$usltimestamp = $dbarrusl1['usl_timestamp'];
		
		if ($usltimestamp > $limittimestamp) { 
			
			$_SESSION['vlock_userid'] = $dbarrusl1['usl_userid'];
			$_SESSION['vlock_userper'] = $dbarrusl1['usl_userper'];
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
	
	$sql1 = "select * from flc_package where pck_id = '$pckid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		$pcknameen = $dbarr1['pck_name_en']; 
		$pckmonth = $dbarr1['pck_month']; 
		$pcktype = $dbarr1['pck_type'];
		
		if ($pcktype == 'b') { $pcktypemem = ""; $pcktypeban = "checked"; }
		else { $pcktypemem = "checked"; $pcktypeban = ""; }
		
	}
	
	$tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->assign("##pckid##", $pckid);
	$tpl->assign("##pcknameen##", $pcknameen);
	$tpl->assign("##pckmonth##", $pckmonth);
	$tpl->assign("##pcktypemem##", $pcktypemem);
	$tpl->assign("##pcktypeban##", $pcktypeban);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
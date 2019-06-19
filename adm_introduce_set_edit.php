<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_introduce_set_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$insid = $_GET['id'];
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "introduce_set_edit";
	$currentrec = $insid;
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
	
	$sql1 = "select * from flc_introduce_set where ins_id = '$insid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) { 
		$ins1 = $dbarr1['ins_1']; 
		$ins2 = $dbarr1['ins_2']; 
		$ins3 = $dbarr1['ins_3']; 
	}	
	
	if ($_COOKIE['vlang'] == 'en') { $sql1 = "select * from flc_introduce order by int_name_en asc;"; }
	else if ($_COOKIE['vlang'] == 'vn') { $sql1 = "select * from flc_introduce order by int_name_vn asc;"; }
	else { $sql1 = "select * from flc_introduce order by int_name_jp asc;"; }
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($_COOKIE['vlang'] == 'en') { $intname = $dbarr1['int_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $intname = $dbarr1['int_name_vn']; }
		else { $intname = $dbarr1['int_name_jp']; }
		$intid = $dbarr1['int_id'];
		
		if ($intid == $ins1) { $intselected1 = "selected"; $intdefault1 = ""; } else { $intselected1 = ""; $intdefault1 = "selected"; }
		if ($intid == $ins2) { $intselected2 = "selected"; $intdefault2 = ""; } else { $intselected2 = ""; $intdefault2 = "selected"; }
		if ($intid == $ins3) { $intselected3 = "selected"; $intdefault3 = ""; } else { $intselected3 = ""; $intdefault3 = "selected"; }
		
		$tpl->assign("##intid1##", $intid);
		$tpl->assign("##intname1##", $intname);
		$tpl->assign("##intselected1##", $intselected1);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
		$tpl->assign("##intid2##", $intid);
		$tpl->assign("##intname2##", $intname);
		$tpl->assign("##intselected2##", $intselected2);
		$tpl->parse ("#####ROW#####", '.rows_2');
		
		$tpl->assign("##intid3##", $intid);
		$tpl->assign("##intname3##", $intname);
		$tpl->assign("##intselected3##", $intselected3);
		$tpl->parse ("#####ROW#####", '.rows_3');
		
	}
	
	$tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->assign("##insid##", $insid);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
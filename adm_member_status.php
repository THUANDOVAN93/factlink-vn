<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_status.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_GET['id'];
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "member_status";
	$currentrec = $memid;
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
	
	$sql1 = "select * from flc_member where mem_id = '$memid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) { 
	
		if ($_COOKIE['vlang'] == 'en') { $memcomname = $dbarr1['mem_comname_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $memcomname = $dbarr1['mem_comname_vn']; }
		else { $memcomname = $dbarr1['mem_comname_jp']; }
		$memstatus = $dbarr1['mem_status'];
		$mem_mailop_mag=$dbarr1['mem_mailop_mag'];
		if ($memstatus == 'd') { $memenable = ""; $memdisable = "checked"; }
		else { $memenable = "checked"; $memdisable = ""; }
		if ($mem_mailop_mag == '0') { $mailnable = ""; $maildisable = "checked"; }
		else { $mailnable = "checked"; $maildisable = ""; }
		
	}
	
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##memcomname##", $memcomname);
	$tpl->assign("##memenable##", $memenable);
	$tpl->assign("##mailnable##", $mailnable);
	$tpl->assign("##maildisable##", $maildisable);
	$tpl->assign("##memdisable##", $memdisable);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
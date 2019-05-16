<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_template_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_SESSION['vmd'];
	
	$checkpackage = checkfreemem($memid);
	if ($checkpackage == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=5\">"; exit(); }
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "template_edit";
	$currentrec = $memid;
	$currentuserid = $_SESSION['vmd']; 
	$currentuserper = "mem";
	
	$sqlusl0 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl0 = mysql_query($sqlusl0);
	
	$sqlusl1 = "select * from flc_uselog where usl_filepage = '$currentpage' and usl_filerec = '$currentrec';"; 
	$resultusl1 = mysql_query($sqlusl1);
	while ($dbarrusl1 = mysql_fetch_array($resultusl1)) { 
	
		$usltimestamp = $dbarrusl1['usl_timestamp'];
		
		if ($usltimestamp > $limittimestamp) { 
			
			$_SESSION['vlock_userid'] = $dbarrusl1['usl_userid'];
			$_SESSION['vlock_userper'] = $dbarrusl1['usl_userper'];
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_lock.php\">"; exit(); 
			
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
	while ($dbarr1 = mysql_fetch_array($result1)) { $memtpm = $dbarr1['mem_template']; }
	
	$sqltpm = "select * from flc_template_main order by tpm_name_en asc;"; 
	$resulttpm = mysql_query($sqltpm);
	while ($dbarrtpm = mysql_fetch_array($resulttpm)) {
	
		$tpmid = $dbarrtpm['tpm_id'];
		$tpmname = $dbarrtpm['tpm_name_en']; 
		$tpmfile = $dbarrtpm['tpm_name_file']; 
		if ($tpmid == $memtpm) { $tpmchecked = "checked=\"checked\""; } else { $tpmchecked = ""; }
		
		$tpl->assign("##tpmid##", $tpmid);
		$tpl->assign("##tpmname##", $tpmname);
		$tpl->assign("##tpmfile##", $tpmfile);
		$tpl->assign("##tpmchecked##", $tpmchecked);
		$tpl->parse ("#####ROW#####", '.rows_tpm');
		
	}
	
	$tpl->assign("##memid##", $memid);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
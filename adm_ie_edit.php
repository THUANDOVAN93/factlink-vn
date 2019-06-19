<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_ie_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$ineid = $_GET['id'];
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "ie_edit";
	$currentrec = $ineid;
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
	
	$sql1 = "select * from flc_ie where ine_id = '$ineid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		$inenameen = $dbarr1['ine_name_en']; 
		$inenamejp = $dbarr1['ine_name_jp']; 
		$inenamevn = $dbarr1['ine_name_vn']; 
		$sector = $dbarr1['sector']; 
		
//............................START SHOW CHECK RADIO BUTTON.....................................		
		
if ($sector == 'north') { 
 $sector1 = 'checked="checked"'; 
}else 
if($sector == 'central') { 
$sector2 = 'checked="checked"'; 
}else 
if($sector == 'south') { 
 $sector3 = 'checked="checked"'; 
}

$tpl->assign("##sector1##", $sector1);
$tpl->assign("##sector2##", $sector2);
$tpl->assign("##sector3##", $sector3);

//.............................END SHOW CHECK RADIO BUTTON....................................			
		
	}
	
	        $tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->assign("##ineid##", $ineid);
	$tpl->assign("##inenameen##", $inenameen);
	$tpl->assign("##inenamejp##", $inenamejp);
	$tpl->assign("##inenamevn##", $inenamevn);
	$tpl->assign("##ineset##", $ineset);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
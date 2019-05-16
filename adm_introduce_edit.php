<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_introduce_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$intid = $_GET['id'];
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "introduce_edit";
	$currentrec = $intid;
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
	
	$sql1 = "select * from flc_introduce where int_id = '$intid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) { 
		$intnameen = $dbarr1['int_name_en'];
		$intnamevn = $dbarr1['int_name_vn'];
		$intnamejp = $dbarr1['int_name_jp']; 
		$inttitleen = $dbarr1['int_title_en']; 
		$inttitlevn = $dbarr1['int_title_vn']; 
		$inttitlejp = $dbarr1['int_title_jp']; 
		$intdetailen = $dbarr1['int_detail_en']; 
		$intdetailvn = $dbarr1['int_detail_vn']; 
		$intdetailjp = $dbarr1['int_detail_jp'];
		$intlink = $dbarr1['int_link'];
		$intimage = $dbarr1['int_image']; 
		//$intimagewidth = $dbarr1['int_image_width']; 
	}
	/* Convert [br] to actual [LineBreak] for <textarea> */
	$intnameen = str_replace('[br]',PHP_EOL,$intnameen);
	$intnamevn = str_replace('[br]',PHP_EOL,$intnamevn);
	$intnamejp = str_replace('[br]',PHP_EOL,$intnamejp);
	$inttitleen = str_replace('[br]',PHP_EOL,$inttitleen);
	$inttitlevn = str_replace('[br]',PHP_EOL,$inttitlevn);
	$inttitlejp = str_replace('[br]',PHP_EOL,$inttitlejp);
	$intdetailen = str_replace('[br]',PHP_EOL,$intdetailen);
	$intdetailvn = str_replace('[br]',PHP_EOL,$intdetailvn);
	$intdetailjp = str_replace('[br]',PHP_EOL,$intdetailjp);
	$intlink = str_replace('[br]',PHP_EOL,$intlink);
	
	
	
	
	if ($intimage == 't') { 
		
		$imgpath = "images/introduce/".$intid."-T.jpg";
		$imgwidth = 160; 
		$intimagepreview = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\"/>"; 
	
	} else { $intimagedisable = "checked"; }
	
	$tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->assign("##intid##", $intid);
	$tpl->assign("##intnameen##", $intnameen);
	$tpl->assign("##intnamejp##", $intnamejp);
	$tpl->assign("##intnamevn##", $intnamevn);
	$tpl->assign("##inttitleen##", $inttitleen);
	$tpl->assign("##inttitlejp##", $inttitlejp);
	$tpl->assign("##inttitlevn##", $inttitlevn);
	$tpl->assign("##intdetailen##", $intdetailen);
	$tpl->assign("##intdetailjp##", $intdetailjp);
	$tpl->assign("##intdetailvn##", $intdetailvn);
	$tpl->assign("##intimagepreview##", $intimagepreview);
	$tpl->assign("##intimagedisable##", $intimagedisable);
	$tpl->assign("##intlink##", $intlink);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_bulcat_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_GET['id'];
	$bucid = $_GET['buc'];
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "member_bulcat_edit";
	$currentrec = $bucid;
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
	
	$sql1 = "select * from flc_bulletin_cate where buc_id = '$bucid';";  
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) { 
		
		$bucname = stripslashes($dbarr1['buc_name']);
		$buctexten = stripslashes($dbarr1['buc_text_en']);
		$buctextjp = stripslashes($dbarr1['buc_text_jp']);
		$buctextvn = stripslashes($dbarr1['buc_text_vn']);
		$bucimage = stripslashes($dbarr1['buc_image']);
		$bucfiletype = $dbarr1['buc_filetype']; 
		$bucwidth = $dbarr1['buc_width'];
		$buclink = $dbarr1['buc_link'];
		$bucside = $dbarr1['buc_side']; 
	
	}
	
	$bucpath = "images/bulletin/C".$bucid.".".$bucfiletype;
	
	$bucimagepreview = "<img src=\"".$bucpath."\" width=\"".$bucwidth."\" border=\"0\"/>"; 
	
	$sql2 = "select * from flc_member where mem_id = '$memid';";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) { $memcategory = $dbarr2['mem_category']; $mempackage = $dbarr2['mem_package']; }
	
	if ($memcategory != '') { $memcategory = explode(" ", $memcategory); $memcate = $memcategory[0]; } 
	
	$tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##bucid##", $bucid);
	$tpl->assign("##bucname##", $bucname);
	$tpl->assign("##buctexten##", $buctexten);
	$tpl->assign("##buctextjp##", $buctextjp);
	$tpl->assign("##buctextvn##", $buctextvn);
	$tpl->assign("##buclink##", $buclink);
	$tpl->assign("##bucimagepreview##", $bucimagepreview);
	$tpl->assign("##memcate##", $memcate);
	$tpl->assign("##mempackage##", $mempackage);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
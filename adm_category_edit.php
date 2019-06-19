<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_category_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$catid = $_GET['id'];
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "category_edit";
	$currentrec = $catid;
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
	
	$sql2 = "select * from flc_category where cat_id = '$catid';"; 
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
		
		$catnameen = $dbarr2['cat_name_en']; 
		$catnamejp = $dbarr2['cat_name_jp']; 
		$catnamevn = $dbarr2['cat_name_vn'];
		$catdesen = $dbarr2['cat_des_en'];
		$catdesjp = $dbarr2['cat_des_jp'];
		$catdesvn = $dbarr2['cat_des_vn'];
		$catpos = $dbarr2['cat_pos'];
		$catunder = $dbarr2['cat_under'];
		
	}
	
	if ($catpos == 'm') { $posnormal = ""; $posmain = "checked"; $possub = ""; $catunderdisable = "disabled"; }
	else if ($catpos == 's') { $posnormal = ""; $posmain = ""; $possub = "checked"; $catunderdisable = ""; } 
	else { $posnormal = "checked"; $posmain = ""; $possub = ""; $catunderdisable = "disabled"; } 
	
	$sql1 = "select * from flc_category where cat_pos = 'm' order by cat_order asc;"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
				
		if ($_COOKIE['vlang'] == 'en') { $mcatname = $dbarr1['cat_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $mcatname = $dbarr1['cat_name_vn']; }
		else { $mcatname = $dbarr1['cat_name_jp']; }
		$mcatid = $dbarr1['cat_id'];
		
		if ($mcatid == $catunder) { $mcatselect = "selected"; $mcatdefault = ""; } else { $mcatselect = ""; $mcatdefault = "selected"; }
		
		$tpl->assign("##mcatid##", $mcatid);
		$tpl->assign("##mcatname##", $mcatname);
		$tpl->assign("##mcatselect##", $mcatselect);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	$tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->assign("##catid##", $catid);
	$tpl->assign("##catnameen##", $catnameen);
	$tpl->assign("##catnamejp##", $catnamejp);
	$tpl->assign("##catnamevn##", $catnamevn);
	$tpl->assign("##catdesvn##", $catdesvn);
	$tpl->assign("##catdesen##", $catdesen);
	$tpl->assign("##catdesjp##", $catdesjp);
	$tpl->assign("##posnormal##", $posnormal);
	$tpl->assign("##posmain##", $posmain);
	$tpl->assign("##possub##", $possub);
	$tpl->assign("##catunderdisable##", $catunderdisable);
	$tpl->assign("##mcatdefault##", $mcatdefault);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
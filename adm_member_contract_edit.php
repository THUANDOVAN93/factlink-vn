<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_contract_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_GET['id'];
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "member_contract_edit";
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
		$mempackage = $dbarr1['mem_package']; 
		$memstartdate = $dbarr1['mem_startdate']; 
		$memsort = $dbarr1['mem_sort']; //if ($memsort == 0) { $sortfixdisable = "disabled"; }
		$memcategory = explode(" ", $dbarr1['mem_category']); 
		$memcate = $memcategory[0];
		
	}
	
	$sql2 = "select * from flc_package where pck_type = 'm' order by pck_name_en asc;"; 
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
		
		$pckname = $dbarr2['pck_name_en']; 
		$pckid = $dbarr2['pck_id'];
		
		if ($mempackage == $pckid) { $pckselected = "selected"; $pckdefault = ""; } else { $pckselected = ""; $pckdefault = "selected"; }
		
		$tpl->assign("##pckid##", $pckid);
		$tpl->assign("##pckname##", $pckname);
		$tpl->assign("##pckselected##", $pckselected);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	if ($memstartdate != '') {
		
		$startdate = explode(" ",$memstartdate);
		$sday = selectday($startdate[0]);
		$smonth = selectmonth($startdate[1]);
		$syear = $startdate[2];
	
	} else {
	
		$sday = selectday("");
		$smonth = selectmonth("");
		$syear = date("Y");
	
	}
	
	$sql3 = "select * from flc_bulletin_cate where mem_id = '$memid';"; 
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) { $bucsort = $dbarr3['buc_sort']; }
	
	$sqlcat = "select * from flc_category where cat_pos != 'm' order by cat_order asc;"; 
	$resultcat = mysql_query($sqlcat);
	while ($dbarrcat = mysql_fetch_array($resultcat)) {
	
		$catid = $dbarrcat['cat_id'];
		$catpos = $dbarrcat['cat_pos'];
		$catunder = $dbarrcat['cat_under'];
		
		if ($_COOKIE['vlang'] == 'en') { $catname = $dbarrcat['cat_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $catname = $dbarrcat['cat_name_vn']; }
		else { $catname = $dbarrcat['cat_name_jp']; }
		
		if ($catpos == 's') { 
		
			$sqlcatunder = "select * from flc_category where cat_id = '$catunder';"; 
			$resultcatunder = mysql_query($sqlcatunder);
			while ($dbarrcatunder = mysql_fetch_array($resultcatunder)) { 
				if ($_COOKIE['vlang'] == 'en') { $catundername = $dbarrcatunder['cat_name_en']; }
				else if ($_COOKIE['vlang'] == 'vn') { $catundername = $dbarrcatunder['cat_name_vn']; }
				else { $catundername = $dbarrcatunder['cat_name_jp']; }
			}
			
			$catname = $catundername."　・ ".$catname; 
			
		}
		
		if ($catid == $memcate) { $catselected = "selected"; $catdefault = ""; } else { $catselected = ""; $catdefault = "selected"; }
		
		$tpl->assign("##catid##", $catid);
		$tpl->assign("##catname##", $catname);
		$tpl->assign("##catselected##", $catselected);
		$tpl->parse ("#####ROW#####", '.rows_cat');
		
	}
	
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##memsort##", $memsort);
	$tpl->assign("##memcat##", $memcate);
	$tpl->assign("##memcomname##", $memcomname);
	$tpl->assign("##mempackage##", $mempackage);
	$tpl->assign("##pckdefault##", $pckdefault);
	$tpl->assign("##sday##", $sday);
	$tpl->assign("##smonth##", $smonth);
	$tpl->assign("##syear##", $syear);
	//$tpl->assign("##sortfixdisable##", $sortfixdisable);
	$tpl->assign("##catdefault##", $catdefault);
	$tpl->assign("##bucsort##", $bucsort);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
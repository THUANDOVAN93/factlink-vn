<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_mail.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_GET['id'];
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$sql1 = "select * from flc_member where mem_id = '$memid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) { 
	
		if ($_COOKIE['vlang'] == 'en') { $memcomname = $dbarr1['mem_comname_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $memcomname = $dbarr1['mem_comname_vn']; }
		else { $memcomname = $dbarr1['mem_comname_jp']; }
		
	}
	
	$start = $_GET['start'];
	$limit = 50;
	
	$pagesql = "select * from flc_mail where mem_id = '$memid';";
	$page = pagecal($limit, $start, $pagesql, "adm_member_mail.php", "?id=$memid");
	
	$sql1 = "select * from flc_mail where mem_id = '$memid' order by mal_id desc limit $start,$limit;";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
	
		$inrid = $dbarr1['mal_id'];
		$inrsubj = $dbarr1['mal_subj'];
		$inrbox = $dbarr1['mal_box'];
		$inrdate = $dbarr1['mal_date'];
		$inrstatus = $dbarr1['mal_status'];
		
		if ($inrbox == 'i') { $inrin = "<img src=\"images/icon_done_01.png\" width=\"20\" height=\"20\" />"; $inrout = ""; }
		else { $inrin = ""; $inrout = "<img src=\"images/icon_done_01.png\" width=\"20\" height=\"20\" />"; }
		
		if ($inrstatus == 'n') { $inrstatus = "mailunread"; $inrstatusalt = "New"; } else { $inrstatus = "mailread"; $inrstatusalt = ""; }
		
		if ($inrstatus == 'd') { $inrsubj = "<del>".$inrsubj."</del>"; }
		
		$tpl->assign("##inrid##", $inrid);
		$tpl->assign("##inrsubj##", $inrsubj);
		$tpl->assign("##inrdate##", $inrdate);
		$tpl->assign("##inrstatus##", $inrstatus);
		$tpl->assign("##inrstatusalt##", $inrstatusalt);
		$tpl->assign("##inrin##", $inrin);
		$tpl->assign("##inrout##", $inrout);
		$tpl->parse ("#####ROW#####", '.rows_1');
	
	}
	
	$tpl->assign("##page##", $page);
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##memcomname##", $memcomname);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_ie.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$start = $_GET['start'];
	$limit = 50;
	
	$pagesql = "select * from flc_ie;";
	$page = pagecal($limit, $start, $pagesql, "adm_ie.php", "");
	
	if ($_COOKIE['vlang'] == 'en') { $sql1 = "select * from flc_ie order by ine_name_en asc limit $start,$limit;"; }
	else if ($_COOKIE['vlang'] == 'vn') { $sql1 = "select * from flc_ie order by ine_name_vn asc limit $start,$limit;"; }
	else { $sql1 = "select * from flc_ie order by ine_name_jp asc limit $start,$limit;"; }
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($_COOKIE['vlang'] == 'en') { $inename = $dbarr1['ine_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $inename = $dbarr1['ine_name_vn']; }
		else { $inename = $dbarr1['ine_name_jp']; }
		$ineid = $dbarr1['ine_id'];
		
		$tpl->assign("##ineid##", $ineid);
		$tpl->assign("##start##", $_GET['start']);
		$tpl->assign("##inename##", $inename);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
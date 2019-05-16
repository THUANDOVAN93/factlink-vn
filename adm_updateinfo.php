<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_updateinfo.html";
	
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
	
	$pagesql = "select * from flc_upinfo;";
	$page = pagecal($limit, $start, $pagesql, "adm_updateinfo.php", "");
	
	$sql1 = "select * from flc_upinfo order by uif_id desc limit $start,$limit;";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		$uifid = $dbarr1['uif_id'];
		$uifname = $dbarr1['uif_name'];
		$uifdate = $dbarr1['uif_date'];
		$uifshow = $dbarr1['uif_show'];
		
		if ($uifshow == 't') { $uifshow = "<a href=\"adm_updateinfo_set_disable.php?id=".$uifid."\"><img src=\"images/icon_enable_01.png\" alt=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
		else { $uifshow = "<a href=\"adm_updateinfo_set_enable.php?id=".$uifid."\"><img src=\"images/icon_disable_01.png\" alt=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
		
		$tpl->assign("##uifid##", $uifid);
		$tpl->assign("##uifname##", $uifname);
		$tpl->assign("##uifdate##", $uifdate);
		$tpl->assign("##uifshow##", $uifshow);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
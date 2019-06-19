<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_magazine.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['d'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$start = $_GET['start'];
	$limit = 50;
	
	$pagesql = "select * from flc_magazine;";
	$page = pagecal($limit, $start, $pagesql, "adm_magazine.php", "");
	
	$sql1 = "select * from flc_magazine order by mag_id desc limit $start,$limit;"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		$magid = $dbarr1['mag_id'];
		$magsubject = $dbarr1['mag_subject'];
		$magdate = $dbarr1['mag_date'];
		$magstatus = $dbarr1['mag_status'];
		
		if ($magstatus == 's') {
			$magstatus = "<img src=\"images/finsh.jpg\" width=\"50\" height=\"20\" border=\"0\"/>";
		} else {
			$magstatus = "<a href=\"adm_magazine_send.php?id=".$magid."\"><img src=\"images/send.jpg\" width=\"50\" height=\"20\" border=\"0\" alt=\"".$lb_alt_send."\"/></a>";
		}
		
		$tpl->assign("##magid##", $magid);
		$tpl->assign("##start##", $start);
		$tpl->assign("##magsubject##", $magsubject);
		$tpl->assign("##magdate##", $magdate);
		$tpl->assign("##magstatus##", $magstatus);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
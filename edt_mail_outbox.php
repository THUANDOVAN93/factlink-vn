<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_mail_outbox.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_SESSION['vmd'];
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vmd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$start = $_GET['start'];
	$limit = 40;
	
	$pagesql = "select * from flc_mail where mem_id = '$memid' and mal_box = 'o' and mal_status != 'd';";
	$page = pagecal($limit, $start, $pagesql, "edt_mail_outbox.php", "");
	
	$sql1 = "select * from flc_mail where mem_id = '$memid' and mal_box = 'o' and mal_status != 'd' order by mal_id desc limit $start,$limit;";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
	
		$mobid = $dbarr1['mal_id'];
		$mobsubj = $dbarr1['mal_subj'];
		$mobdate = $dbarr1['mal_date'];
		
		$tpl->assign("##mobid##", $mobid);
		$tpl->assign("##mobsubj##", $mobsubj);
		$tpl->assign("##mobdate##", $mobdate);
		$tpl->assign("##pageid##", $start);
		$tpl->parse ("#####ROW#####", '.rows_1');
	
	}
	
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
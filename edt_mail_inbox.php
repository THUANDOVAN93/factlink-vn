<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_mail_inbox.html";
	
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
	
	$pagesql = "select * from flc_mail where mem_id = '$memid' and mal_box = 'i' and mal_status != 'd' and mal_warning !='t';";
	$page = pagecal($limit, $start, $pagesql, "edt_mail_inbox.php", "");
	
	$sql1 = "select * from flc_mail where mem_id = '$memid' and mal_box = 'i' and mal_status != 'd'  order by mal_id desc limit $start,$limit;";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
	
		$inrid = $dbarr1['mal_id'];
		$inrsubj = $dbarr1['mal_subj'];
		$inrdate = $dbarr1['mal_date'];
		$inrstatus = $dbarr1['mal_status'];
		
		if ($inrstatus == 'n') { $inrstatus = "mailunread"; $inrstatusalt = "New"; } else { $inrstatus = "mailread"; $inrstatusalt = ""; }
		
		$tpl->assign("##inrid##", $inrid);
		$tpl->assign("##inrsubj##", $inrsubj);
		$tpl->assign("##inrdate##", $inrdate);
		$tpl->assign("##inrstatus##", $inrstatus);
		$tpl->assign("##inrstatusalt##", $inrstatusalt);
		$tpl->assign("##pageid##", $start);
		$tpl->parse ("#####ROW#####", '.rows_1');
	
	}
	
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
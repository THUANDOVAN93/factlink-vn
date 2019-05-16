<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_mail_delete.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$inrid = $_GET['id'];
	$pageid = $_GET['pageid'];
	$box = $_GET['box'];
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vmd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$sql1 = "select * from flc_mail where mal_id = '$inrid';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
	
		$memid = $dbarr1['mem_id']; if ($_SESSION['vmd'] != $memid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }
		$inrsubject = $dbarr1['mal_subj'];
		$inrcontent = html($dbarr1['mal_detail']);
		$inrname = $dbarr1['mal_from_name'];
		$inrmail = $dbarr1['mal_from_mail'];
		$mobname = $dbarr1['mal_to_name'];
		$mobmail = $dbarr1['mal_to_mail'];
	
	}
	
	if ($box == 'out') { 
		$linkback = "edt_mail_outbox.php"; 
		$relname = $mobname; 
		$relmail = $mobmail; 
		$reldirection = "TO :";
	} else { 
		$linkback = "edt_mail_inbox.php"; 
		$relname = $inrname; 
		$relmail = $inrmail; 
		$reldirection = "FROM :";
	}
	
	$tpl->assign("##pageid##", $pageid);
	$tpl->assign("##linkback##", $linkback);
	$tpl->assign("##box##", $box);
	$tpl->assign("##inrid##", $inrid);
	$tpl->assign("##inrsubject##", $inrsubject);
	$tpl->assign("##inrcontent##", $inrcontent);
	$tpl->assign("##relname##", $relname);
	$tpl->assign("##relmail##", $relmail);
	$tpl->assign("##reldirection##", $reldirection);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_mail_outbox_view.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$mobid = $_GET['id'];
	$pageid = $_GET['pageid'];
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vmd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$sql1 = "select * from flc_mail where mal_id = '$mobid';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
	
		$memid = $dbarr1['mem_id']; if ($_SESSION['vmd'] != $memid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }
		$mobsubj = $dbarr1['mal_subj'];
		$mobdetail = html($dbarr1['mal_detail']);
		$mobreceiver = $dbarr1['mal_to_name'];
		$mobmail = $dbarr1['mal_to_mail'];
	
	}
	
	$tpl->assign("##pageid##", $pageid);
	$tpl->assign("##mobsubj##", $mobsubj);
	$tpl->assign("##mobdetail##", $mobdetail);
	$tpl->assign("##mobreceiver##", $mobreceiver);
	$tpl->assign("##mobmail##", $mobmail);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
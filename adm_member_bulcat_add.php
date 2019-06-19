<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_bulcat_add.html";
	
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
	
	$sql1 = "select * from flc_bulletin_cate where mem_id = '$memid';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) { $bucid = $dbarr1['buc_id']; }
	
	if ($bucid != '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_bulcat_edit.php?id=$memid&buc=$bucid\">"; exit(); }
	
	$sql2 = "select * from flc_member where mem_id = '$memid';";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) { $memcomnameen = $dbarr2['mem_comname_en']; $memcategory = $dbarr2['mem_category']; $mempackage = $dbarr2['mem_package']; }
	
	if ($memcategory != '') { $memcategory = explode(" ", $memcategory); $memcate = $memcategory[0]; } 
	
	$tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##memcate##", $memcate);
	$tpl->assign("##mempackage##", $mempackage);
	$tpl->assign("##memcomnameen##", $memcomnameen);
	$tpl->assign("##catdefault##", $catdefault);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_lock.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	$usluserid = $_SESSION['vlock_userid']; 
	
	if ($_SESSION['vlock_userper'] == 'adm') {
		
		$sql1 = "select * from flc_user where usr_id = '$usluserid';"; 
		$result1 = mysql_query($sql1);
		while ($dbarr1 = mysql_fetch_array($result1)) { $usluseren = $dbarr1['usr_name_en']; $usluserjp = $dbarr1['usr_name_jp']; $usluservn = $dbarr1['usr_name_vn'];}
		
	} else if ($_SESSION['vlock_userper'] == 'mem') {
		
		$sql2 = "select * from flc_member where mem_id = '$usluserid';"; 
		$result2 = mysql_query($sql2);
		while ($dbarr2 = mysql_fetch_array($result2)) { $usluseren = $dbarr2['mem_comname_en']; $usluserjp = $dbarr2['mem_comname_jp']; $usluservn = $dbarr2['mem_comname_vn']; }
		
	} else { $usluseren = "ANONYMOUS"; $usluserjp = "ANONYMOUS"; $usluservn = "ANONYMOUS"; }
	
	if ($_COOKIE['vlang'] == 'en') { $locktext = "The data you need can't access, because it's using by </br><strong>".$usluseren."</strong>"; }
	else if ($_COOKIE['vlang'] == 'vn') { $locktext = "The data you need can't access, because it's using by </br><strong>".$usluseren."</strong>"; }
	else { $locktext = "<strong>".$usluserjp."</strong></br>により現在使用されているので、アクセスできません。"; } 
	
	// -------------------------
	
	$tpl->assign("##locktext##", $locktext);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_mail_products_manager.html";
	
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
	
	// $pagesql = "select * from flc_magazine;";
	// $page = pagecal($limit, $start, $pagesql, "adm_magazine.php", "");
	
	// $sql1 = "select * from flc_magazine order by mag_id desc limit $start,$limit;"; 
	// $result1 = mysql_query($sql1);
	// while ($dbarr1 = mysql_fetch_array($result1)) {
		
	// 	$magid = $dbarr1['mag_id'];
	// 	$magsubject = $dbarr1['mag_subject'];
	// 	$magdate = $dbarr1['mag_date'];
	// 	$magstatus = $dbarr1['mag_status'];
		
	// 	if ($magstatus == 's') {
	// 		$magstatus = "<img src=\"images/finsh.jpg\" width=\"50\" height=\"20\" border=\"0\"/>";
	// 	} else {
	// 		$magstatus = "<a href=\"adm_magazine_send.php?id=".$magid."\"><img src=\"images/send.jpg\" width=\"50\" height=\"20\" border=\"0\" alt=\"".$lb_alt_send."\"/></a>";
	// 	}
		
	// 	$tpl->assign("##magid##", $magid);
	// 	$tpl->assign("##start##", $start);
	// 	$tpl->assign("##magsubject##", $magsubject);
	// 	$tpl->assign("##magdate##", $magdate);
	// 	$tpl->assign("##magstatus##", $magstatus);
	// 	$tpl->parse ("#####ROW#####", '.rows_1');
		
	// }

	$sql6 = "select * from flc_mail where mal_case = '4' and mal_send = 'n' order by mal_id desc;";
	$result6 = mysql_query($sql6);
	while ($dbarr6 = mysql_fetch_array($result6)) {
		
		$inrid = $dbarr6['mal_id'];
		$inrsubj = $dbarr6['mal_subj']; 
		$inrdate = $dbarr6['mal_date']; 
		$inrstatus = $dbarr6['mal_status']; 
		$inrmemid = $dbarr6['mem_id'];
		$mal_send = $dbarr6['mal_send'];
		
		$sql1 = "select * from flc_member where mem_id = '$inrmemid';";
		$result1 = mysql_query($sql1);
		while ($dbarr1 = mysql_fetch_array($result1)) { 
		
			if ($_COOKIE['vlang'] == 'en') { $memcomname = $dbarr1['mem_comname_en']; }
			else if ($_COOKIE['vlang'] == 'vn') { $memcomname = $dbarr1['mem_comname_vn']; }
			else { $memcomname = $dbarr1['mem_comname_jp']; }
			//icon_sendmail_01.png icon_sendmail_02.png
		
		}
		
		if ($inrstatus == 'n') { $inrstatus = "enable"; $inrstatusalt = "New"; } else { $inrstatus = "disable"; $inrstatusalt = ""; }
		if($mal_send==''||$mal_send=='n'){ $isenmail="wait.jpg";}else if($mal_send=='y'){$isenmail="approve.jpg";}
		$tpl->assign("##sendmail##", $isenmail);
		$tpl->assign("##inrid##", $inrid);
		$tpl->assign("##inrmemid##", $inrmemid);
		$tpl->assign("##inrsubj##", $inrsubj);
		$tpl->assign("##inrdate##", $inrdate);
		$tpl->assign("##inrstatus##", $inrstatus);
		$tpl->assign("##memcomname##", $memcomname);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
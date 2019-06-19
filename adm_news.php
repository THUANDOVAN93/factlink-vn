<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_news.html";
	
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
	
	$qyear = date("Y") - 2;
	
	$pagesql = "select * from flc_news where nws_year >= '$qyear';";
	$page = pagecal($limit, $start, $pagesql, "adm_news.php", "");
	
	if ($_COOKIE['vlang'] == 'en') { $sql1 = "select * from flc_news where nws_year >= '$qyear' order by nws_year desc, nws_month desc, nws_day desc, nws_id desc limit $start,$limit;"; }
	else if ($_COOKIE['vlang'] == 'vn') { $sql1 = "select * from flc_news where nws_year >= '$qyear' order by nws_year desc, nws_month desc, nws_day desc, nws_id desc limit $start,$limit;"; }
	else { $sql1 = "select * from flc_news where nws_year >= '$qyear' order by nws_year desc, nws_month desc, nws_day desc, nws_id desc limit $start,$limit;"; }
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($_COOKIE['vlang'] == 'en') { $nwstitle = $dbarr1['nws_title_en']; }
				
		else if ($_COOKIE['vlang'] == 'vn') { $nwstitle = $dbarr1['nws_title_vn']; }
		else { $nwstitle = $dbarr1['nws_title_jp']; }
		$nwsid = $dbarr1['nws_id'];
		$nwsyear = $dbarr1['nws_year'];
		$nwsmonth = $dbarr1['nws_month'];
		$nwsday = $dbarr1['nws_day'];
		$nwsshow = $dbarr1['nws_show'];
		$nwsstatus = $dbarr1['nws_status']; 
		$nwstitle = stripslashes($dbarr1['nws_title_en']);
		$nwstitle = stripslashes($dbarr1['nws_title_vn']);
		$nwstitle = stripslashes($dbarr1['nws_title_jp']);
		
		

		
		if ($_COOKIE['vlang'] == 'jp') { $newsdate = $nwsyear."年".$nwsmonth."月".$nwsday."日"; }
		else { $newsdate = $nwsday." ".mcvzerotosub($nwsmonth)." ".$nwsyear; }
		
		if ($nwsstatus == 'd') { $nwstitle = "<del>".$nwstitle."</del>"; }
		
		if ($nwsshow == 't') { $nwsshow = "<a href=\"adm_news_set_disable.php?id=".$nwsid."\"><img src=\"images/icon_enable_01.png\" alt=\"".$lb_alt_show."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
		else { $nwsshow = "<a href=\"adm_news_set_enable.php?id=".$nwsid."\"><img src=\"images/icon_disable_01.png\" alt=\"".$lb_alt_hide."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
		
		$tpl->assign("##nwsid##", $nwsid);
		$tpl->assign("##nwstitle##", $nwstitle);
		$tpl->assign("##newsdate##", $newsdate);
		$tpl->assign("##nwsshow##", $nwsshow);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
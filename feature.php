<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure.html"; 
	$url2 = "feature.html";
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	$pagecode = "fea";
	if ($_COOKIE['vlang'] == 'en') { $url6 = "menu_en.html"; } else if ($_COOKIE['vlang'] == 'vn') { $url6 = "menu_vn.html"; } else { $url6 = "menu_jp.html"; }
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "right_tpl" => $url3, "left_tpl" => $url4, "top_tpl" => $url5, "menu_tpl" => $url6));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	$start = $_GET['start'];
	$limit = 50;
	
	$pagesql = "select * from flc_feature where fea_archive != '0';";
	$page = pagecal($limit, $start, $pagesql, "adm_feature.php", "");
	
	$sql1 = "select * from flc_feature where fea_archive != '0' order by fea_timestamp desc limit $start,$limit;"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($_COOKIE['vlang'] == 'en') { $featitle = $dbarr1['fea_title_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $featitle = $dbarr1['fea_title_vn']; }
		else { $featitle = $dbarr1['fea_title_jp']; }
		$feaid = $dbarr1['fea_id'];
		
		$tpl->assign("##feaid##", $feaid);
		$tpl->assign("##featitle##", $featitle);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
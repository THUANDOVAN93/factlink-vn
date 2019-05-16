<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure-new.html"; 
	$url2 = "news.html";
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	$pagecode = "nws";
	/* Set default language cookie */
	if(empty($_COOKIE['vlang'])) {
		$_COOKIE['vlang'] = 'en';
	}
	
	/* Prevent unknown cookie language value */
	if(!in_array($_COOKIE['vlang'],['en','jp','vn'])) {
		$_COOKIE['vlang'] = 'en';
	}
	if ($_COOKIE['vlang'] == 'en') { $url6 = "menu-html_en.html"; } else if ($_COOKIE['vlang'] == 'vn') { $url6 = "menu-html_vn.html"; } else { $url6 = "menu-html_jp.html"; }
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "right_tpl" => $url3, "left_tpl" => $url4, "top_tpl" => $url5, "menu_tpl" => $url6));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	$newsdatey = $_GET['y'];
	$newsdatem = $_GET['m'];
	
	if ($newsdatey == '') { $newsdatey = date("Y"); }
	if ($newsdatem == '') { $newsdatem = date("m"); }
	
	$sql1 = "select * from flc_news where nws_year = '$newsdatey' and nws_month = '$newsdatem' and nws_status != 'd' 
					order by nws_year desc, nws_month desc, nws_day desc, nws_id desc;"; 
	$result1 = mysql_query($sql1);
	$nwscnt = mysql_num_rows($result1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		$nwsid = $dbarr1['nws_id'];
		$nwgid = $dbarr1['nwg_id'];
		$nwstitle = $dbarr1['nws_title_jp'];
		$nwssum = html($dbarr1['nws_compend_jp']);
		$nwsday = $dbarr1['nws_day'];
		$nwsmonth = $dbarr1['nws_month'];
		$nwsyear = $dbarr1['nws_year'];
		
		$sql2 = "select * from flc_news_genre where nwg_id = '$nwgid';"; 
		$result2 = mysql_query($sql2);
		while ($dbarr2 = mysql_fetch_array($result2)) { $nwgname = "【".$dbarr2['nwg_name_jp']."】"; }
		
		$nwstitle = $nwgname." ".$nwstitle;
		$nwsnewsdate = $nwsyear."年".$nwsmonth."月".$nwsday."日";
		
		$nwsline = "<img src=\"images/line_frame_01.png\" width=\"780\" height=\"20\" />"; 
		
		$linecnt = $linecnt + 1; 
		if ($linecnt == $nwscnt) { $nwsline = "<img src=\"images/line_frame_02.png\" width=\"780\" height=\"20\" />"; }
		
		$tpl->assign("##nwsid##", $nwsid);
		$tpl->assign("##nwstitle##", $nwstitle);
		$tpl->assign("##nwssum##", $nwssum);
		$tpl->assign("##nwsnewsdate##", $nwsnewsdate);
		$tpl->assign("##nwsline##", $nwsline);
		$tpl->parse ("#####ROW#####", '.rows_1');
	
	}
	
	for ($i=1;$i<=24;$i++) {
	
		if ($i == 1) { $ndy = date("Y"); $ndm = date("m"); } else { $ndm = $ndm - 1; if ($ndm == 0) { $ndy = $ndy - 1; $ndm = 12; } }
		
		$newsdateyear = addzero2($ndy); 
		$newsdatemonth = addzero2($ndm);
		$newsdatename = $newsdateyear."年".$newsdatemonth."月";
		if ($newsdatey == $newsdateyear && $newsdatem == $newsdatemonth) { $newsdateselected = "selected"; } else { $newsdateselected = ""; }
		
		$tpl->assign("##newsdatename##", $newsdatename);
		$tpl->assign("##newsdateyear##", $newsdateyear);
		$tpl->assign("##newsdatemonth##", $newsdatemonth);
		$tpl->assign("##newsdateselected##", $newsdateselected);
		$tpl->parse ("#####ROW#####", '.rows_newsdate');
	
	}
	
	$tpl->assign("##nwscnt##", $nwscnt);
	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
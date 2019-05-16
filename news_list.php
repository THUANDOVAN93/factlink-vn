<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure-new.html"; 
	$url2 = "news_list.html";
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
	if ($_COOKIE['vlang'] == 'en') { $url6 = "menu-html_en.html"; $url7 = "news_jp.html"; } else if ($_COOKIE['vlang'] == 'vn') { $url6 = "menu-html_vn.html"; $url7 = "news_jp.html"; } else { $url6 = "menu-html_jp.html"; $url7 = "news_jp.html"; }
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "right_tpl" => $url3, "left_tpl" => $url4, "top_tpl" => $url5, "menu_tpl" => $url6, "desc_tpl" => $url7));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	$start = $_GET['start'];
	$limit = 50;
	
	$qyear = date("Y") - 2;
	
	$pagesql = "select * from flc_news where nws_year >= '$qyear' and nws_status != 'd';";
	$page = pagecal($limit, $start, $pagesql, "news_list.php", "");
	
	if ($_COOKIE['vlang'] == 'en') {
		$sql1 = "select * from flc_news where nws_year >= '$qyear' and nws_status != 'd' order by nws_year desc, nws_month desc, nws_day desc, nws_id desc limit $start,$limit;";
	}
	elseif ( $_COOKIE['vlang'] == 'vn' ) {
		$sql1 = "select * from flc_news where nws_year >= '$qyear' and nws_status != 'd' order by nws_year desc, nws_month desc, nws_day desc, nws_id desc limit $start,$limit;";
	}
	else {
		$sql1 = "select * from flc_news where nws_year >= '$qyear' and nws_status != 'd' order by nws_year desc, nws_month desc, nws_day desc, nws_id desc limit $start,$limit;";
	}

	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ( $_COOKIE['vlang'] == 'en' ) {
			$nwstitle = stripslashes($dbarr1['nws_title_en']);
		} elseif ( $_COOKIE['vlang'] == 'vn' ) {
			$nwstitle = stripslashes($dbarr1['nws_title_vn']);
		} else {
			$nwstitle = stripslashes($dbarr1['nws_title_jp']);
		}
		$nwsid = $dbarr1['nws_id'];
		$nwsyear = $dbarr1['nws_year'];
		$nwsmonth = $dbarr1['nws_month'];
		$nwsday = $dbarr1['nws_day'];
		$nwsshow = $dbarr1['nws_show'];

		if ( $_COOKIE['vlang'] == 'jp' ) {
			$newsdate = $nwsyear."年".$nwsmonth."月".$nwsday."日";
		} else {
			$newsdate = $nwsday." ".mcvzerotosub($nwsmonth)." ".$nwsyear;
		}

		$nwsshow = "<span><img src=\"images/icon_enable_01.png\" alt=\"sticky\" width=\"20\" height=\"20\" border=\"0\" /></span>";
		
		$tpl->assign("##nwsid##", $nwsid);
		$tpl->assign("##nwstitle##", $nwstitle);
		$tpl->assign("##newsdate##", $newsdate);
		$tpl->assign("##nwsshow##", $nwsshow);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	$tpl->assign("##tt_news##", "NEW");
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DESC_AREA##", "desc_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
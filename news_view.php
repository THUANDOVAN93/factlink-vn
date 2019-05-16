<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure-new.html"; 
	$url2 = "news_view.html";
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
	
	$nwsid = $_GET['id'];
	
	$sql1 = "select * from flc_news where nws_id = '$nwsid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		$nweid = $dbarr1['nwe_id'];
		$nwgid = $dbarr1['nwg_id'];
		$nwsday = $dbarr1['nws_day'];
		$nwsmonth = $dbarr1['nws_month'];
		$nwsyear = $dbarr1['nws_year'];

		if ( $_COOKIE['vlang'] == 'en' ) {
			$nwstitle = $dbarr1['nws_title_en'];
			$nwssum = html($dbarr1['nws_compend_en']);
			$nwsdetail = html($dbarr1['nws_detail_en']);
			$monthName = mcvnumtofull($nwsmonth);
			$nwsnewsdate = $nwsday." ".$monthName." ".$nwsyear;
		} elseif ( $_COOKIE['vlang'] == 'vn' ) {
			$nwstitle = $dbarr1['nws_title_vn'];
			$nwssum = html($dbarr1['nws_compend_vn']);
			$nwsdetail = html($dbarr1['nws_detail_vn']);
			$nwsnewsdate = $nwsday." - ".$nwsmonth." - ".$nwsyear;
		} else {
			$nwstitle = $dbarr1['nws_title_jp'];
			$nwssum = html($dbarr1['nws_compend_jp']);
			$nwsdetail = html($dbarr1['nws_detail_jp']);
			$nwsnewsdate = $nwsyear."年".$nwsmonth."月".$nwsday."日";
		}
		
		$sql2 = "select * from flc_news_genre where nwg_id = '$nwgid';"; 
		$result2 = mysql_query($sql2);
		while ($dbarr2 = mysql_fetch_array($result2)) {

			if ( $_COOKIE['vlang'] == 'en' ) {
				$nwgname = $dbarr2['nwg_name_en'];
			} elseif ( $_COOKIE['vlang'] == 'vn' ) {
				$nwgname = $dbarr2['nwg_name_vn'];
			} else {
				$nwgname = $dbarr2['nwg_name_jp'];
			}
		}
		
		$sql3 = "select * from flc_news_editor where nwe_id = '$nweid';"; 
		$result3 = mysql_query($sql3);
		while ($dbarr3 = mysql_fetch_array($result3)) {
			if ( $_COOKIE['vlang'] == 'en' ) {
				$nwename = $dbarr3['nwe_name_en'];
			} elseif ( $_COOKIE['vlang'] == 'vn' ) {
				$nwename = $dbarr3['nwe_name_vn'];
			} else {
				$nwename = $dbarr3['nwe_name_jp'];
			}
		}

		$nwstitle = $nwgname." ".$nwstitle;	
	}
	
	$tpl->assign("##nwstitle##", stripslashes($nwstitle));
	$tpl->assign("##nwssum##", stripslashes($nwssum));
	$tpl->assign("##nwsdetail##", stripslashes($nwsdetail));
	$tpl->assign("##nwsnewsdate##", $nwsnewsdate);
	$tpl->assign("##nwename##", stripslashes($nwename)); 
	
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
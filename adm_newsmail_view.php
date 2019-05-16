<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_newsmail_view.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$nwsid = $_GET['id'];
	
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
	

	
			$result2 = mysql_query("select * from  flc_news where nws_id = '$nwsid';");
		while ($dbarr2 = mysql_fetch_array($result2)) { 
		
	//	if ($_COOKIE['vlang'] == 'jp') { $newsdate = $nwsyear."年".$nwsmonth."月".$nwsday."日"; }
	//	else { $newsdate = $nwsday." ".mcvzerotosub($nwsmonth)." ".$nwsyear; }
		
		if ($_COOKIE['vlang'] == 'en') {
			$nwstitle = $dbarr1['nws_title_en'];
		} else if ($_COOKIE['vlang'] == 'vn') {
			$nwstitle = $dbarr1['nws_title_vn'];
		} else {
			$nwstitle = $dbarr1['nws_title_jp'];
		}
		
		$nwsid = $dbarr1['nws_id'];
		$nwsyear = $dbarr1['nws_year'];
		$nwsmonth = $dbarr1['nws_month'];
		$nwsday = $dbarr1['nws_day'];
		$nwsshow = $dbarr1['nws_show'];
		$nwsstatus = $dbarr1['nws_status']; 
		$newsdate = $dbarr1['nws_date'];

	
		// $nwstitle = $dbarr2['nws_title_en'];
		$nwstitle = html($dbarr2['nws_title_jp']);
		// $nwstitle = $dbarr2['nws_title_vn'];
	
		// $nwscompend = $dbarr2['nws_compend_en']; 
		$nwscompend = html($dbarr2['nws_compend_jp']);
		// $nwscompend = $dbarr2['nws_compend_vn'];
			
		// $nwsdetail = html($dbarr2['nws_detail_en']); 
		$nwsdetail = html($dbarr2['nws_detail_jp']); 
		// $nwsdetail = html($dbarr2['nws_detail_vn']); 
		
	
		
		
		$tpl->assign("##nwsid##", $nwsid);
		$tpl->assign("##nwstitle##", $nwstitle);
		$tpl->assign("##nwscompend##", $nwscompend);
		$tpl->assign("##nwsdetail##", $nwsdetail);
		$tpl->assign("##newsdate##", $newsdate);
		$tpl->assign("##nwsshow##", $nwsshow);
		$tpl->assign("##nwstitle##", $nwstitle);
		
		
		
	$tpl->assign("##lang##", lclangswitch($lang, $langlocal));
	$tpl->assign("##setlangjp##", "adm_newsmail_view.php?lang=jp&nsmid=$nsmid");
	$tpl->assign("##setlanglc##", "adm_newsmail_view.php?lang=$langlocal&nsmid=$nsmid");
	$tpl->assign("##setlangen##", "adm_newsmail_view.php?lang=en&nsmid=$nsmid");
	$tpl->assign("##langlabeljp##", $langlabel_jp);
	$tpl->assign("##langlabellc##", $langlabel_lc);
	$tpl->assign("##langlabelen##", $langlabel_en);
	$tpl->assign("##text_titlebar##", $txtb_index);
	
	}
	
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
	
?>
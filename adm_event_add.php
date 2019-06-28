<?php

	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') {

		echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">";
		exit();
	}
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$langCode = $_COOKIE['vlang'];
	$url1 = "adm_structure.html"; 
	$url2 = "adm_event_add.html";
	$urlActionAddEvent = "adm_event_add_post.php";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array(
		"main_tpl" => $url1,
		"detail_tpl" => $url2
	));
	
	mysql_query("use $db_name;");
	
	include_once("./include/global_admvalue.php");
	
	$currentuserid = $_SESSION['vd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);

	// Buil URL Event Heare
	$sqlGetNews = "select `nws_id`, `nws_title_en`, `nws_title_jp`, `nws_title_vn` from flc_news order by nws_year desc, nws_month desc, nws_day desc, nws_id desc limit 0,10;";
	$news = mysql_query($sqlGetNews);

	while ($new = mysql_fetch_array($news)) {

		if ($langCode == "en") {

			$newTit = $new['nws_title_en'];
		} elseif ($langCode == "vn") {

			$newTit = $new['nws_title_vn'];
		} else {

			$newTit = $new['nws_title_jp'];
		}

		$tpl->assign("##newId##", $new['nws_id']);
		$tpl->assign("##newTit##", $newTit);
		$tpl->parse ("#####ROW#####", '.rows_news');
	}


	// Buil URL Event Heare
	
	
	$tpl->assign("##urlActionAddEvent##", $urlActionAddEvent);
	$tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
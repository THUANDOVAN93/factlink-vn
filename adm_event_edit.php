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
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_event_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array(
		"main_tpl" => $url1,
		"detail_tpl" => $url2
	));
	
	mysql_query("use $db_name;");
	
	$eventId = $_GET['id'];
	
	include_once("./include/global_admvalue.php");
	
	$sqlGetEvent = "SELECT * FROM flc_events WHERE id = '$eventId';";
	$events = mysql_query($sqlGetEvent);
	while ($event = mysql_fetch_array($events)) {

		$eventNewId = $event['event_new_id'];

		$tpl->assign("##eventtitleen##", $event['event_name_en']);
		$tpl->assign("##eventtitlevn##", $event['event_name_vn']);
		$tpl->assign("##eventtitlejp##", $event['event_name_jp']);

		$tpl->assign("##eventdetailen##", $event['event_desc_en']);
		$tpl->assign("##eventdetailvn##", $event['event_desc_vn']);
		$tpl->assign("##eventdetailjp##", $event['event_desc_jp']);

		if ($event['status'] == 'd') {
			$tpl->assign("##eventstatus##", "checked");
		} else {
			$tpl->assign("##eventstatus##", "");
		}
		$tpl->assign("##urlActionEditEvent##", "adm_event_edit_post.php?id=".$event['id']);
		
		$urlMediaEvent = "images/events/ev-".$event['id'].".jpg";
		$tpl->assign("##urlMediaEvent##", $urlMediaEvent);
	}

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

		if ($eventNewId == $new['nws_id']) {
			$tpl->assign("##selected##", "selected");
		} else {
			$tpl->assign("##selected##", "");
		}

		$tpl->assign("##newId##", $new['nws_id']);
		$tpl->assign("##newTit##", $newTit);
		$tpl->parse ("#####ROW#####", '.rows_news');
	}

	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
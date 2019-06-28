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
	$url2 = "adm_events.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array(
		"main_tpl" => $url1,
		"detail_tpl" => $url2
	));
	
	mysql_query("use $db_name;");
	
	include_once("./include/global_admvalue.php");
		
	$currentUserID = $_SESSION['vd'];
	
	$sqlRemoveUser = "delete from flc_uselog where usl_userid = '$currentUserID';"; 
	$resultusl1 = mysql_query($sqlRemoveUser);
	
	$start = $_GET['start'];
	$limit = 50;
	$langCode = $_COOKIE['vlang'];
	$addEventUrl = "adm_event_add.php";
	$viewEventUrlTemp = "adm_event_view.php";
	$editEventUrlTemp = "adm_event_edit.php";
	$removeEventUrlTemp = "adm_event_delete_post.php";
	
	$devidePageSql = "select * from flc_events";
	$page = pagecal($limit, $start, $devidePageSql, "adm_events.php", "");

	$getEventsSql = "select * from flc_events limit $start,$limit;";
	$events = mysql_query($getEventsSql);

	while ($event = mysql_fetch_array($events)) {
		
		if ($langCode == 'en') {

			$eventTit = $event['event_name_en'];
		} elseif ($langCode == 'vn') {

			$eventTit = $event['event_name_vn'];
		} else {

			$eventTit = $event['event_name_jp'];
		}

		if ($event['status'] == '') {

			$eventStatusHtml = "<a href=\"adm_event_set_disable.php?id=".$event['id']."\"><img src=\"images/icon_enable_01.png\" alt=\"".$lb_alt_show."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		} else {

			$eventStatusHtml = "<a href=\"adm_event_set_enable.php?id=".$event['id']."\"><img src=\"images/icon_disable_01.png\" alt=\"".$lb_alt_hide."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		}

		$editEventUrl = $editEventUrlTemp."?id=".$event['id'];
		$removeEventUrl = $removeEventUrlTemp."?id=".$event['id'];
		
		$tpl->assign("##eventId##", $event['id']);
		$tpl->assign("##eventTit##", $eventTit);
		$tpl->assign("##editEventUrl##", $editEventUrl);
		$tpl->assign("##removeEventUrl##", $removeEventUrl);
		$tpl->assign("##eventStatusHtml##", $eventStatusHtml);
		$tpl->parse ("#####ROW#####", '.rows_events');
	}
	
	$tpl->assign("##addEventUrl##", $addEventUrl);
	$tpl->assign("##page##", $page);
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
<?php
	ini_set("session.gc_maxlifetime", "18000");
	session_start();

	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }

	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	// Escape special charactars
	$_GET = array_map('mysql_real_escape_string',$_GET);

	$url1 = "adm_structure.html";
	$url2 = "adm_bancat.html";

	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));

	mysql_query("use $db_name;");

	$bantype =  $_GET['type'];

	// --- Global Template Section
	include_once("./include/global_admvalue.php");

	// --- Check Use Log

	$currentuserid = $_SESSION['vd'];

	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';";
	$resultusl1 = mysql_query($sqlusl1);

	// --------------------


	$type = $_GET['type'];
	$start = $_GET['start'];
	$limit = 50;

	$sqlcat = "select * from flc_category where cat_pos != 'm' order by cat_order asc;";
	$resultcat = mysql_query($sqlcat);
	while ($dbarrcat = mysql_fetch_array($resultcat)) {

		$catid = $dbarrcat['cat_id'];
		$catpos = $dbarrcat['cat_pos'];
		$catunder = $dbarrcat['cat_under'];

		if ($_COOKIE['vlang'] == 'en') { $catname = $dbarrcat['cat_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $catname = $dbarrcat['cat_name_vn']; }
		else { $catname = $dbarrcat['cat_name_jp']; }

		if ($catpos == 's') {

			$sqlcatunder = "select * from flc_category where cat_id = '$catunder';";
			$resultcatunder = mysql_query($sqlcatunder);
			while ($dbarrcatunder = mysql_fetch_array($resultcatunder)) {
				if ($_COOKIE['vlang'] == 'en') { $catundername = $dbarrcatunder['cat_name_en']; }
				else if ($_COOKIE['vlang'] == 'vn') { $catundername = $dbarrcatunder['cat_name_vn']; }
				else { $catundername = $dbarrcatunder['cat_name_jp']; }
			}

			$catname = $catundername."　・ ".$catname;

		}

		if ($catid == $_SESSION['vsearchbaccateid']) { $catselected = "selected"; $catdefault = ""; } else { $catselected = ""; $catdefault = "selected"; }

		$tpl->assign("##catid##", $catid);
		$tpl->assign("##catname##", $catname);
		$tpl->assign("##catselected##", $catselected);
		$tpl->parse ("#####ROW#####", '.rows_cat');

	}

	$pagesql = $_SESSION['vsearchbac'].";";
	$page = pagecal($limit, $start, $pagesql, "adm_bancat.php", "?type=$type");

	$sql1 = $_SESSION['vsearchbac']." order by bac_name asc limit $start,$limit;";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {

		$bacid = $dbarr1['bac_id'];
		$bacname = $dbarr1['bac_name'];
		$bacstart = $dbarr1['bac_startdate'];
		$bacend = $dbarr1['bac_enddate'];
		$bacsort = $dbarr1['bac_sort'];
		$bacstatus = $dbarr1['bac_status'];

		if  ($bacend != '') {

			$tempenddate = explode(" ", $bacend);
			$bacenddate = explode("-", date("Y-m-d", strtotime("-1 day", mktime(0,0,0,addzero2(mcvsubtonum($tempenddate[1])),$tempenddate[0],$tempenddate[2]))));
			$baccontract = $bacstart." - ".$bacenddate[2]." ".mcvzerotosub($bacenddate[1])." ".$bacenddate[0];

		} else { $baccontract = ""; }

		if ($bacstatus != 'd') { $bacstatus = "<a href=\"adm_bancat_set_disable.php?id=".$bacid."&type=".$type."\"><img src=\"images/icon_enable_01.png\" alt=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
		else { $bacstatus = "<a href=\"adm_bancat_set_enable.php?id=".$bacid."&type=".$type."\"><img src=\"images/icon_disable_01.png\" alt=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }

		$tpl->assign("##bacid##", $bacid);
		$tpl->assign("##bacname##", $bacname);
		$tpl->assign("##baccontract##", $baccontract);
		$tpl->assign("##bactype##", $type);
		$tpl->assign("##bacsort##", $bacsort);
		$tpl->assign("##bacstatus##", $bacstatus);
		$tpl->assign("##baccatname##", $baccatname);
		$tpl->parse ("#####ROW#####", '.rows_1');

	}

	$tpl->assign("##bactype##", $type);
	$tpl->assign("##catdefault##", $catdefault);
	$tpl->assign("##page##", $page);

	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>

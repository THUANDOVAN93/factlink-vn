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
	$url2 = "adm_bancat_add.html";

	$tpl = new rFastTemplate("template");
	$tpl->define (array(
		"main_tpl" => $url1,
		"detail_tpl" => $url2
	));

	mysql_query("use $db_name;");
	// Escape special charactars
	$_GET = array_map('mysql_real_escape_string',$_GET);
	
	$bactype =  $_GET['type'];

	// --- Global Template Section
	include_once("./include/global_admvalue.php");

	// --- Check Use Log

	$currentuserid = $_SESSION['vd'];

	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';";
	$resultusl1 = mysql_query($sqlusl1);

	$sql2 = "select * from flc_package where pck_type = 'b' order by pck_name_en asc;";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {

		$pckname = $dbarr2['pck_name_en'];
		$pckid = $dbarr2['pck_id'];

		if ($bacpackage == $pckid) {
			$pckselected = "selected";
			$pckdefault = "";
		} else {
			$pckselected = "";
			$pckdefault = "selected";
		}

		$tpl->assign("##pckid##", $pckid);
		$tpl->assign("##pckname##", $pckname);
		$tpl->assign("##pckselected##", $pckselected);
		$tpl->parse ("#####ROW#####", '.rows_1');

	}

	$sday = selectday("");
	$smonth = selectmonth("");
	$syear = date("Y");

	$sqlcat = "select * from flc_category where cat_pos != 'm' order by cat_order asc;";
	$resultcat = mysql_query($sqlcat);
	while ($dbarrcat = mysql_fetch_array($resultcat)) {

		$catid = $dbarrcat['cat_id'];
		$catpos = $dbarrcat['cat_pos'];
		$catunder = $dbarrcat['cat_under'];

		if ($_COOKIE['vlang'] == 'en') {

			$catname = $dbarrcat['cat_name_en'];
		} elseif ($_COOKIE['vlang'] == 'vn') {

			$catname = $dbarrcat['cat_name_vn'];
		} else {
			
			$catname = $dbarrcat['cat_name_jp'];
		}

		if ($catpos == 's') {

			$sqlcatunder = "select * from flc_category where cat_id = '$catunder';";
			$resultcatunder = mysql_query($sqlcatunder);
			while ($dbarrcatunder = mysql_fetch_array($resultcatunder)) {
				if ($_COOKIE['vlang'] == 'en') {

					$catundername = $dbarrcatunder['cat_name_en'];
				} elseif ($_COOKIE['vlang'] == 'vn') {

					$catundername = $dbarrcatunder['cat_name_vn'];
				} else {

					$catundername = $dbarrcatunder['cat_name_jp'];
				}
			}

			$catname = $catundername."　・ ".$catname;
		}

		$tpl->assign("##catid##", $catid);
		$tpl->assign("##catname##", $catname);
		$tpl->assign("##catselected##", $catselected);
		$tpl->parse ("#####ROW#####", '.rows_cat');

	}

	if ($bactype == 'spc') {
		$posleft = "disabled";
		$posright = "disabled";
		$poscheck = "";
		$bacwidth = "450";
		$bacheight = "120";
		$spcdisable = "disabled";
	} else {
		$posleft = "";
		$posright = "";
		$poscheck = "checked";
		$bacwidth = "180";
		$bacheight = "86";
	}

	$tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->assign("##bactype##", $bactype);
	$tpl->assign("##bacwidth_en##", $bacwidth);
	$tpl->assign("##bacheight_en##", $bacheight);
	$tpl->assign("##bacwidth_jp##", $bacwidth);
	$tpl->assign("##bacheight_jp##", $bacheight);
	$tpl->assign("##bacwidth_vn##", $bacwidth);
	$tpl->assign("##bacheight_vn##", $bacheight);
	$tpl->assign("##spcdisable##", $spcdisable);
	$tpl->assign("##pckdefault##", $pckdefault);
	$tpl->assign("##sday##", $sday);
	$tpl->assign("##smonth##", $smonth);
	$tpl->assign("##syear##", $syear);

	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>

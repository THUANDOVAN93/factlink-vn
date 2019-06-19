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

	// Escape special charactars
	$_GET = array_map('mysql_real_escape_string',$_GET);
	
	$url1 = "adm_structure.html";
	$url2 = "adm_bancat_edit.html";

	$tpl = new rFastTemplate("template");
	$tpl->define (array(
		"main_tpl" => $url1,
		"detail_tpl" => $url2
	));

	mysql_query("use $db_name;");

	$bacid =  $_GET['id'];
	$bactype =  $_GET['type'];

	// --- Global Template Section
	include_once("./include/global_admvalue.php");

	// --- Check Use Log
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");

	$currentpage = "bancat_edit";
	$currentrec = $bacid;
	$currentuserid = $_SESSION['vd'];
	$currentuserper = "adm";

	$sqlusl0 = "delete from flc_uselog where usl_userid = '$currentuserid';";
	$resultusl0 = mysql_query($sqlusl0) or die(mysql_error());

	$sqlusl1 = "select * from flc_uselog where usl_filepage = '$currentpage' and usl_filerec = '$currentrec';";
	$resultusl1 = mysql_query($sqlusl1) or die(mysql_error());
	while ($dbarrusl1 = mysql_fetch_array($resultusl1)) {

		$usltimestamp = $dbarrusl1['usl_timestamp'];

		if ($usltimestamp > $limittimestamp) {

			$_SESSION['vlock_userid'] = $dbarrusl1['usl_userid'];
			$_SESSION['vlock_userper'] = $dbarrusl1['usl_userper'];
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_lock.php\">";
			exit();

		} else {
			$usldel = "t";
		}
	}

	if ($usldel == 't') {

		$sqlusl2 = "delete from flc_uselog where usl_timestamp = '$usltimestamp';";
		$resultusl2 = mysql_query($sqlusl2) or die(mysql_error());

	}

	$sqlusl3 = "insert into flc_uselog (usl_filepage, usl_filerec, usl_userid, usl_userper) values ('$currentpage', '$currentrec', '$currentuserid', '$currentuserper');";
	$resultusl3 = mysql_query($sqlusl3) or die(mysql_error());

	$sql1 = "select * from flc_banner_cate where bac_id = '$bacid';";
	$result1 = mysql_query($sql1) or die(mysql_error());
	while ($dbarr1 = mysql_fetch_array($result1)) {

		$baccatid = $dbarr1['cat_id'];
		$bacname = $dbarr1['bac_name'];
		$bacfiletype_en = $dbarr1['bac_filetype_en'];
		$bacwidth_en = $dbarr1['bac_width_en'];
		$bacheight_en = $dbarr1['bac_height_en'];
		$baclink_en = $dbarr1['bac_link_en'];
		$bacfiletype_jp = $dbarr1['bac_filetype_jp'];
		$bacwidth_jp = $dbarr1['bac_width_jp'];
		$bacheight_jp = $dbarr1['bac_height_jp'];
		$baclink_jp = $dbarr1['bac_link_jp'];
		$bacfiletype_vn = $dbarr1['bac_filetype_vn'];
		$bacwidth_vn = $dbarr1['bac_width_vn'];
		$bacheight_vn = $dbarr1['bac_height_vn'];
		$baclink_vn = $dbarr1['bac_link_vn'];
		$bacpackage = $dbarr1['bac_package'];
		$bacstartdate = $dbarr1['bac_startdate'];
	}

	if ($bacstartdate != '') {

		$startdate = explode(" ",$bacstartdate);
		$sday = selectday($startdate[0]);
		$smonth = selectmonth($startdate[1]);
		$syear = $startdate[2];

	} else {

		$sday = selectday("");
		$smonth = selectmonth("");
		$syear = date("Y");

	}

	// REFACTOR CODE
	foreach ($langCodeAllowed as $key => $langValue) {

		${"bacpath_$langValue"} = "images/banner/C".$bacid."_".$langValue.".".${"bacfiletype_$langValue"};

		if (${"bacfiletype_$langValue"} == 'swf') {
			${"bacimagepreview_$langValue"} = "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0\" width=\"".${"bacwidth_$langValue"}."\" height=\"".${"bacheight_$langValue"}."\">
			<param name=\"movie\" value=\"".${"bacpath_$langValue"}."\" />
			<param name=\"quality\" value=\"high\" />
			<embed src=\"".${"bacpath_$langValue"}."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"".${"bacwidth_$langValue"}."\" height=\"".${"bacheight_$langValue"}."\"></embed>
			</object>";
		} elseif (${"bacfiletype_$langValue"} == 'mp4') {

			${"bacimagepreview_$langValue"} = "<a href=\"".${"banlink_$langValue"}."\" target=\"_blank\"><video width=\"".${"bacwidth_$langValue"}."\" height=\"".${"bacheight_$langValue"}."\" autoplay muted loop>
			<source src=\"".${"bacpath_$langValue"}."\" type=\"video/mp4\">
			</video></a>";
		} else {

			${"bacimagepreview_$langValue"} = "<img src=\"".${"bacpath_$langValue"}."\" width=\"".${"bacwidth_$langValue"}."\" border=\"0\"/>";
		}

	}
	// END REFECTOR

	// //EN
	// $bacpath_en = "images/banner/C".$bacid."_en.".$bacfiletype_en;
	// if ($bacfiletype_en == 'swf') {

	// 	$bacimagepreview_en = "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0\" width=\"".$bacwidth_en."\" height=\"".$bacheight_en."\">
	// 					  <param name=\"movie\" value=\"".$bacpath_en."\" />
	// 					  <param name=\"quality\" value=\"high\" />
	// 					  <embed src=\"".$bacpath_en."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"".$bacwidth_en."\" height=\"".$bacheight_en."\"></embed>
	// 					</object>";

	// } else { $bacimagepreview_en = "<img src=\"".$bacpath_en."\" width=\"".$bacwidth_en."\" border=\"0\"/>"; }

	// //JP
	// $bacpath_jp = "images/banner/C".$bacid."_jp.".$bacfiletype_jp;
	// if ($bacfiletype_jp == 'swf') {

	// 	$bacimagepreview_jp = "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0\" width=\"".$bacwidth_jp."\" height=\"".$bacheight_jp."\">
	// 					  <param name=\"movie\" value=\"".$bacpath_jp."\" />
	// 					  <param name=\"quality\" value=\"high\" />
	// 					  <embed src=\"".$bacpath_jp."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"".$bacwidth_jp."\" height=\"".$bacheight_jp."\"></embed>
	// 					</object>";

	// } else { $bacimagepreview_jp = "<img src=\"".$bacpath_jp."\" width=\"".$bacwidth_jp."\" border=\"0\"/>"; }

	// //VN
	// $bacpath_vn = "images/banner/C".$bacid."_vn.".$bacfiletype_vn;
	// if ($bacfiletype_vn == 'swf') {

	// 	$bacimagepreview_vn = "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0\" width=\"".$bacwidth_vn."\" height=\"".$bacheight_vn."\">
	// 					  <param name=\"movie\" value=\"".$bacpath_vn."\" />
	// 					  <param name=\"quality\" value=\"high\" />
	// 					  <embed src=\"".$bacpath_vn."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"".$bacwidth_vn."\" height=\"".$bacheight_vn."\"></embed>
	// 					</object>";

	// } else { $bacimagepreview_vn = "<img src=\"".$bacpath_vn."\" width=\"".$bacwidth_vn."\" border=\"0\"/>"; }


	$sql2 = "select * from flc_package where pck_type = 'b' order by pck_name_en asc;";
	$result2 = mysql_query($sql2) or die(mysql_error());
	while ($dbarr2 = mysql_fetch_array($result2)) {

		$pckname = $dbarr2['pck_name_en'];
		$pckid = $dbarr2['pck_id'];

		if ($bacpackage == $pckid) { $pckselected = "selected"; $pckdefault = ""; } else { $pckselected = ""; $pckdefault = "selected"; }

		$tpl->assign("##pckid##", $pckid);
		$tpl->assign("##pckname##", $pckname);
		$tpl->assign("##pckselected##", $pckselected);
		$tpl->parse ("#####ROW#####", '.rows_1');

	}

	$sqlcat = "select * from flc_category where cat_pos != 'm' order by cat_order asc;";
	$resultcat = mysql_query($sqlcat) or die(mysql_error());
	while ($dbarrcat = mysql_fetch_array($resultcat)) {

		$catid = $dbarrcat['cat_id'];
		$catpos = $dbarrcat['cat_pos'];
		$catunder = $dbarrcat['cat_under'];

		if ($_COOKIE['vlang'] == 'en') { $catname = $dbarrcat['cat_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $catname = $dbarrcat['cat_name_vn']; }
		else { $catname = $dbarrcat['cat_name_jp']; }

		if ($catpos == 's') {

			$sqlcatunder = "select * from flc_category where cat_id = '$catunder';";
			$resultcatunder = mysql_query($sqlcatunder) or die(mysql_error());
			while ($dbarrcatunder = mysql_fetch_array($resultcatunder)) {
				if ($_COOKIE['vlang'] == 'en') { $catundername = $dbarrcatunder['cat_name_en']; }
				else if ($_COOKIE['vlang'] == 'vn') { $catundername = $dbarrcatunder['cat_name_vn']; }
				else { $catundername = $dbarrcatunder['cat_name_jp']; }
			}

			$catname = $catundername."　・ ".$catname;

		}

		if ($catid == $baccatid) { $catselected = "selected"; $catdefault = ""; } else { $catselected = ""; $catdefault = "selected"; }

		$tpl->assign("##catid##", $catid);
		$tpl->assign("##catname##", $catname);
		$tpl->assign("##catselected##", $catselected);
		$tpl->parse ("#####ROW#####", '.rows_cat');

	}

	if ($bactype == 'spc') { $spcdisable = "disabled"; }

	$tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->assign("##bacid##", $bacid);
	$tpl->assign("##bactype##", $bactype);
	$tpl->assign("##bacname##", $bacname);
	$tpl->assign("##baclink_en##", $baclink_en);
	$tpl->assign("##baclink_jp##", $baclink_jp);
	$tpl->assign("##baclink_vn##", $baclink_vn);
	$tpl->assign("##bacpackage##", $bacpackage);
	$tpl->assign("##bacimagepreview_en##", $bacimagepreview_en);
	$tpl->assign("##bacimagepreview_jp##", $bacimagepreview_jp);
	$tpl->assign("##bacimagepreview_vn##", $bacimagepreview_vn);
	$tpl->assign("##bacwidth_en##", $bacwidth_en);
	$tpl->assign("##bacwidth_jp##", $bacwidth_jp);
	$tpl->assign("##bacwidth_vn##", $bacwidth_vn);
	$tpl->assign("##bacheight_en##", $bacheight_en);
	$tpl->assign("##bacheight_jp##", $bacheight_jp);
	$tpl->assign("##bacheight_vn##", $bacheight_vn);
	$tpl->assign("##spcdisable##", $spcdisable);
	$tpl->assign("##pckdefault##", $pckdefault);
	$tpl->assign("##catdefault##", $catdefault);
	$tpl->assign("##sday##", $sday);
	$tpl->assign("##smonth##", $smonth);
	$tpl->assign("##syear##", $syear);

	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>

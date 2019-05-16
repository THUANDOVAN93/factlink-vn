<?php
	ini_set("session.gc_maxlifetime", "18000");
	session_start();

	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }

	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	$url1 = "adm_structure.html";
	$url2 = "adm_banner_edit.html";

	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));

	// Escape special charactars
	$_GET = array_map('mysql_real_escape_string',$_GET);
	
	mysql_query("use $db_name;");

	$banid =  $_GET['id'];
	$bantype =  $_GET['type'];

	// --- Global Template Section
	include_once("./include/global_admvalue.php");

	// --- Check Use Log

	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");

	$currentpage = "banner_edit";
	$currentrec = $banid;
	$currentuserid = $_SESSION['vd'];
	$currentuserper = "adm";

	$sqlusl0 = "delete from flc_uselog where usl_userid = '$currentuserid';";
	$resultusl0 = mysql_query($sqlusl0);

	$sqlusl1 = "select * from flc_uselog where usl_filepage = '$currentpage' and usl_filerec = '$currentrec';";
	$resultusl1 = mysql_query($sqlusl1);
	while ($dbarrusl1 = mysql_fetch_array($resultusl1)) {

		$usltimestamp = $dbarrusl1['usl_timestamp'];

		if ($usltimestamp > $limittimestamp) {

			$_SESSION['vlock_userid'] = $dbarrusl1['usl_userid'];
			$_SESSION['vlock_userper'] = $dbarrusl1['usl_userper'];
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_lock.php\">"; exit();

		} else { $usldel = "t"; }

	}

	if ($usldel == 't') {

		$sqlusl2 = "delete from flc_uselog where usl_timestamp = '$usltimestamp';";
		$resultusl2 = mysql_query($sqlusl2);

	}

	$sqlusl3 = "insert into flc_uselog (usl_filepage, usl_filerec, usl_userid, usl_userper) values ('$currentpage', '$currentrec', '$currentuserid', '$currentuserper');";
	$resultusl3 = mysql_query($sqlusl3);

	// --------------------

	/*if ($_COOKIE['vlang'] == 'en') { $sql1 = "select * from flc_member order by mem_comname_en asc;";  }
	else if ($_COOKIE['vlang'] == 'vn') { $sql1 = "select * from flc_member order by mem_comname_vn asc;";  }
	else { $sql1 = "select * from flc_member order by mem_comname_jp asc;";  }
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {

		if ($_COOKIE['vlang'] == 'en') { $memcomname = $dbarr1['mem_comname_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $memcomname = $dbarr1['mem_comname_vn']; }
		else { $memcomname = $dbarr1['mem_comname_jp']; }
		$memid = $dbarr1['mem_id'];

		$tpl->assign("##memid##", $memid);
		$tpl->assign("##memcomname##", $memcomname);
		$tpl->parse ("#####ROW#####", '.rows_mem');

	}*/

	$sql1 = "select * from flc_banner where ban_id = '$banid';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {

		$banname = $dbarr1['ban_name'];
		$banfiletype_en = $dbarr1['ban_filetype_en'];
		$banwidth_en = $dbarr1['ban_width_en'];
		$banheight_en = $dbarr1['ban_height_en'];
		$banlink_en = $dbarr1['ban_link_en'];
		$banfiletype_jp = $dbarr1['ban_filetype_jp'];
		$banwidth_jp = $dbarr1['ban_width_jp'];
		$banheight_jp = $dbarr1['ban_height_jp'];
		$banlink_jp = $dbarr1['ban_link_jp'];
		$banfiletype_vn = $dbarr1['ban_filetype_vn'];
		$banwidth_vn = $dbarr1['ban_width_vn'];
		$banheight_vn = $dbarr1['ban_height_vn'];
		$banlink_vn = $dbarr1['ban_link_vn'];
		$banpage = $dbarr1['ban_page'];
		$banside = $dbarr1['ban_side'];
		$banpackage = $dbarr1['ban_package'];
		$banstartdate = $dbarr1['ban_startdate'];

	}

	if ($banstartdate != '') {

		$startdate = explode(" ",$banstartdate);
		$sday = selectday($startdate[0]);
		$smonth = selectmonth($startdate[1]);
		$syear = $startdate[2];

	} else {

		$sday = selectday("");
		$smonth = selectmonth("");
		$syear = date("Y");

	}

	if ($banside == 'l') { $posleft = "checked"; $posright = ""; }
	else if ($banside == 'r') { $posleft = ""; $posright = "checked"; }

	if ($bantype == 'spc') { $posdisable = "disabled"; } else { $posdisable = ""; }

	// EN
	$banpath_en = "images/banner/".$banid."_en.".$banfiletype_en;
	if ($banfiletype_en == 'swf') {

		$banimagepreview_en = "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0\" width=\"".$banwidth_en."\" height=\"".$banheight_en."\">
						  <param name=\"movie\" value=\"".$banpath_en."\" />
						  <param name=\"quality\" value=\"high\" />
						  <embed src=\"".$banpath_en."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"".$banwidth_en."\" height=\"".$banheight_en."\"></embed>
						</object>";

	} else { $banimagepreview_en = "<img src=\"".$banpath_en."\" width=\"".$banwidth_en."\" border=\"0\"/>"; }

	// JP
	$banpath_jp = "images/banner/".$banid."_jp.".$banfiletype_jp;
	if ($banfiletype_jp == 'swf') {

		$banimagepreview_jp = "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0\" width=\"".$banwidth_jp."\" height=\"".$banheight_jp."\">
						  <param name=\"movie\" value=\"".$banpath_jp."\" />
						  <param name=\"quality\" value=\"high\" />
						  <embed src=\"".$banpath_jp."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"".$banwidth_jp."\" height=\"".$banheight_jp."\"></embed>
						</object>";

	} else { $banimagepreview_jp = "<img src=\"".$banpath_jp."\" width=\"".$banwidth_jp."\" border=\"0\"/>"; }

	//VN
	$banpath_vn = "images/banner/".$banid."_vn.".$banfiletype_vn;
	if ($banfiletype_vn == 'swf') {

		$banimagepreview_vn = "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0\" width=\"".$banwidth_vn."\" height=\"".$banheight_vn."\">
						  <param name=\"movie\" value=\"".$banpath_vn."\" />
						  <param name=\"quality\" value=\"high\" />
						  <embed src=\"".$banpath_vn."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"".$banwidth_vn."\" height=\"".$banheight_vn."\"></embed>
						</object>";

	} else { $banimagepreview_vn = "<img src=\"".$banpath_vn."\" width=\"".$banwidth_vn."\" border=\"0\"/>"; }

	$sql2 = "select * from flc_package where pck_type = 'b' order by pck_name_en asc;";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {

		$pckname = $dbarr2['pck_name_en'];
		$pckid = $dbarr2['pck_id'];

		if ($banpackage == $pckid) { $pckselected = "selected"; $pckdefault = ""; } else { $pckselected = ""; $pckdefault = "selected"; }

		$tpl->assign("##pckid##", $pckid);
		$tpl->assign("##pckname##", $pckname);
		$tpl->assign("##pckselected##", $pckselected);
		$tpl->parse ("#####ROW#####", '.rows_1');

	}

	if ($_COOKIE['vlang'] == 'en') { $sql3 = "select * from flc_pospage order by psp_name_en asc;";  }
	else if ($_COOKIE['vlang'] == 'vn') { $sql3 = "select * from flc_pospage order by psp_name_vn asc;";  }
	else { $sql3 = "select * from flc_pospage order by psp_name_jp asc;";  }
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) {

		if ($_COOKIE['vlang'] == 'en') { $pspname = $dbarr3['psp_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $pspname = $dbarr3['psp_name_vn']; }
		else { $pspname = $dbarr3['psp_name_jp']; }
		$pspcode = $dbarr3['psp_code'];

		if ($banpage == $pspcode) { $pspselected = "selected"; $pspdefault = ""; } else { $pspselected = ""; $pspdefault = "selected"; }

		$tpl->assign("##pspcode##", $pspcode);
		$tpl->assign("##pspname##", $pspname);
		$tpl->assign("##pspselected##", $pspselected);
		$tpl->parse ("#####ROW#####", '.rows_pospage');

	}

	if ($bantype == 'spc') { $spcdisable = "disabled"; }

	$tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->assign("##banid##", $banid);
	$tpl->assign("##bantype##", $bantype);
	$tpl->assign("##banname##", $banname);
	$tpl->assign("##banlink_en##", $banlink_en);
	$tpl->assign("##banlink_jp##", $banlink_jp);
	$tpl->assign("##banlink_vn##", $banlink_vn);
	$tpl->assign("##banpage##", $banpage);
	$tpl->assign("##banside##", $banside);
	$tpl->assign("##banpackage##", $banpackage);
	$tpl->assign("##banimagepreview_en##", $banimagepreview_en);
	$tpl->assign("##banimagepreview_jp##", $banimagepreview_jp);
	$tpl->assign("##banimagepreview_vn##", $banimagepreview_vn);
	$tpl->assign("##posleft##", $posleft);
	$tpl->assign("##posright##", $posright);
	$tpl->assign("##posdisable##", $posdisable);
	$tpl->assign("##banwidth_en##", $banwidth_en);
	$tpl->assign("##banwidth_jp##", $banwidth_jp);
	$tpl->assign("##banwidth_vn##", $banwidth_vn);
	$tpl->assign("##banheight_en##", $banheight_en);
	$tpl->assign("##banheight_jp##", $banheight_jp);
	$tpl->assign("##banheight_vn##", $banheight_vn);
	$tpl->assign("##spcdisable##", $spcdisable);
	$tpl->assign("##pckdefault##", $pckdefault);
	$tpl->assign("##pspdefault##", $pspdefault);
	$tpl->assign("##sday##", $sday);
	$tpl->assign("##smonth##", $smonth);
	$tpl->assign("##syear##", $syear);

	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>

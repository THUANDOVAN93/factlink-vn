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
	$url2 = "adm_bulletin_edit.html";

	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));

	mysql_query("use $db_name;");

	$bulid = $_GET['id'];

	// --- Global Template Section
	include_once("./include/global_admvalue.php");

	// --- Check Use Log

	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");

	$currentpage = "bulletin_edit";
	$currentrec = $bulid;
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

	$sql1 = "select * from flc_bulletin where bul_id = '$bulid';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {

		$bulname = $dbarr1['bul_name'];
		$bultexten = $dbarr1['bul_text_en'];
		$bultextjp = $dbarr1['bul_text_jp'];
		$bultextvn = $dbarr1['bul_text_vn'];
		$bulimage = $dbarr1['bul_image'];
		$bulfiletype = $dbarr1['bul_filetype'];
		$bulwidth = $dbarr1['bul_width'];
		$bullink = $dbarr1['bul_link'];
		$bulpage = $dbarr1['bul_page'];
		$bulside = $dbarr1['bul_side'];
		$bulsort = $dbarr1['bul_sort'];

	}

	if ($bulside == 'l') { $posleft = "checked"; $posright = ""; }
	else if ($bulside == 'r') { $posleft = ""; $posright = "checked"; }

	$bulpath = "images/bulletin/".$bulid.".".$bulfiletype;

	$bulimagepreview = "<img src=\"".$bulpath."\" width=\"".$bulwidth."\" border=\"0\"/>";

	if ($_COOKIE['vlang'] == 'en') { $sql3 = "select * from flc_pospage order by psp_name_en asc;";  }
	else if ($_COOKIE['vlang'] == 'vn') { $sql3 = "select * from flc_pospage order by psp_name_vn asc;";  }
	else { $sql3 = "select * from flc_pospage order by psp_name_jp asc;";  }
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) {

		if ($_COOKIE['vlang'] == 'en') { $pspname = $dbarr3['psp_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $pspname = $dbarr3['psp_name_vn']; }
		else { $pspname = $dbarr3['psp_name_jp']; }
		$pspcode = $dbarr3['psp_code'];

		if ($bulpage == $pspcode) { $pspselected = "selected"; $pspdefault = ""; } else { $pspselected = ""; $pspdefault = "selected"; }

		$tpl->assign("##pspcode##", $pspcode);
		$tpl->assign("##pspname##", $pspname);
		$tpl->assign("##pspselected##", $pspselected);
		$tpl->parse ("#####ROW#####", '.rows_pospage');

	}

	$tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->assign("##bulid##", $bulid);
	$tpl->assign("##bulname##", $bulname);
	$tpl->assign("##bultexten##", $bultexten);
	$tpl->assign("##bultextjp##", $bultextjp);
	$tpl->assign("##bultextvn##", $bultextvn);
	$tpl->assign("##bullink##", $bullink);
	$tpl->assign("##bulsort##", $bulsort);
	$tpl->assign("##pospage##", $bulpage);
	$tpl->assign("##posside##", $bulside);
	$tpl->assign("##bulimagepreview##", $bulimagepreview);
	$tpl->assign("##posleft##", $posleft);
	$tpl->assign("##posright##", $posright);
	$tpl->assign("##pspdefault##", $pspdefault);

	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>

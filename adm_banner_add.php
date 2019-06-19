<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_banner_add.html";
	
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
	
	$sday = selectday("");
	$smonth = selectmonth("");
	$syear = date("Y");
	
	if ($_COOKIE['vlang'] == 'en') { $sql3 = "select * from flc_pospage order by psp_name_en asc;";  }
	else if ($_COOKIE['vlang'] == 'vn') { $sql3 = "select * from flc_pospage order by psp_name_vn asc;";  }
	else { $sql3 = "select * from flc_pospage order by psp_name_jp asc;";  }
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) { 
	
		if ($_COOKIE['vlang'] == 'en') { $pspname = $dbarr3['psp_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $pspname = $dbarr3['psp_name_vn']; }
		else { $pspname = $dbarr3['psp_name_jp']; }
		$pspcode = $dbarr3['psp_code']; 
		
		$tpl->assign("##pspcode##", $pspcode);
		$tpl->assign("##pspname##", $pspname);
		$tpl->parse ("#####ROW#####", '.rows_pospage');
		
	}
	
	if ($bantype == 'spc') { $posleft = "disabled"; $posright = "disabled"; $poscheck = ""; $banwidth = "450"; $banheight = "120"; $spcdisable = "disabled"; }
	else { $posleft = ""; $posright = ""; $poscheck = "checked"; $banwidth = "180"; $banheight = "86"; }
	
	$tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->assign("##bantype##", $bantype);
	$tpl->assign("##posleft##", $posleft);
	$tpl->assign("##posright##", $posright);
	$tpl->assign("##poscheck##", $poscheck);
	$tpl->assign("##banwidth_en##", $banwidth);
	$tpl->assign("##banheight_en##", $banheight);
	$tpl->assign("##banwidth_jp##", $banwidth);
	$tpl->assign("##banheight_jp##", $banheight);
	$tpl->assign("##banwidth_vn##", $banwidth);
	$tpl->assign("##banheight_vn##", $banheight);
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
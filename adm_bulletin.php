<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_bulletin.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$start = $_GET['start'];
	$limit = 50;
	
	$pagesql = $_SESSION['vsearchbul'].";";
	$page = pagecal($limit, $start, $pagesql, "adm_bulletin.php", "");
	
	$sql1 = $_SESSION['vsearchbul']." order by bul_sort asc, bul_name asc limit $start,$limit;";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		$bulid = $dbarr1['bul_id'];
		$bulname = $dbarr1['bul_name']; 
		$bulpage = $dbarr1['bul_page']; 
		$bulside = $dbarr1['bul_side']; 
		$bulsort = $dbarr1['bul_sort']; 
		$bulstatus = $dbarr1['bul_status'];
		
		$sql2 = "select * from flc_pospage where psp_code = '$bulpage';";
		$result2 = mysql_query($sql2);
		while ($dbarr2 = mysql_fetch_array($result2)) { 
		
			if ($_COOKIE['vlang'] == 'en') { $bulpage = $dbarr2['psp_name_en']; }
			else if ($_COOKIE['vlang'] == 'vn') { $bulpage = $dbarr2['psp_name_vn']; }
			else { $bulpage = $dbarr2['psp_name_jp']; }
		
		}
		
		if ($bulside != '') { $bulpage = $bulpage." - ".strtoupper($bulside); } else {$bulpage = $bulpage; }
				
		if ($bulstatus != 'd') { $bulstatus = "<a href=\"adm_bulletin_set_disable.php?id=".$bulid."\"><img src=\"images/icon_enable_01.png\" alt=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
		else { $bulstatus = "<a href=\"adm_bulletin_set_enable.php?id=".$bulid."\"><img src=\"images/icon_disable_01.png\" alt=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
		
		$tpl->assign("##bulid##", $bulid);
		$tpl->assign("##bulname##", $bulname);
		$tpl->assign("##bulpage##", $bulpage);
		$tpl->assign("##bulsort##", $bulsort);
		$tpl->assign("##bulstatus##", $bulstatus);
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
		
		if ($pspcode == $_SESSION['vsearchbulpage']) { $pspselected = "selected"; $pspdefault = ""; } else { $pspselected = ""; $pspdefault = "selected"; }
		
		$tpl->assign("##pspcode##", $pspcode);
		$tpl->assign("##pspname##", $pspname);
		$tpl->assign("##pspselected##", $pspselected);
		$tpl->parse ("#####ROW#####", '.rows_pospage');
		
	}
	
	if ($_SESSION['vsearchbulside'] == 'l') { $posleft = "checked"; $posright = ""; } else { $posleft = ""; $posright = "checked"; }
	
	$tpl->assign("##posleft##", $posleft);
	$tpl->assign("##posright##", $posright);
	$tpl->assign("##pspdefault##", $pspdefault);
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
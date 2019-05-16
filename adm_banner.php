<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_banner.html";
	
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
	
	$type = $_GET['type'];
	$start = $_GET['start'];
	$limit = 50;
	
	if ($type == 'spc') {
	
		$pagesql = $_SESSION['vsearchbanspc'].";";
		$page = pagecal($limit, $start, $pagesql, "adm_banner.php", "?type=$type");
		
		$sql1 = $_SESSION['vsearchbanspc']." order by ban_name asc limit $start,$limit;";
		$result1 = mysql_query($sql1);
		while ($dbarr1 = mysql_fetch_array($result1)) {
			
			$banid = $dbarr1['ban_id'];
			$banname = $dbarr1['ban_name']; 
			$banpage = $dbarr1['ban_page']; 
			$banstart = $dbarr1['ban_startdate']; 
			$banend = $dbarr1['ban_enddate'];
			$banstatus = $dbarr1['ban_status'];
			$bansort = "0";
			
			if  ($banend != '') {
	
				$tempenddate = explode(" ", $banend);
				$banenddate = explode("-", date("Y-m-d", strtotime("-1 day", mktime(0,0,0,addzero2(mcvsubtonum($tempenddate[1])),$tempenddate[0],$tempenddate[2]))));
				$bancontract = $banstart." - ".$banenddate[2]." ".mcvzerotosub($banenddate[1])." ".$banenddate[0];
				
			} else { $bancontract = ""; }
			
			$sql2 = "select * from flc_pospage where psp_code = '$banpage';";
			$result2 = mysql_query($sql2);
			while ($dbarr2 = mysql_fetch_array($result2)) { 
			
				if ($_COOKIE['vlang'] == 'en') { $banpage = $dbarr2['psp_name_en']; }
				else if ($_COOKIE['vlang'] == 'vn') { $banpage = $dbarr2['psp_name_vn']; }
				else { $banpage = $dbarr2['psp_name_jp']; }
			
			}
					
			if ($banstatus != 'd') { $banstatus = "<a href=\"adm_banner_set_disable.php?id=".$banid."&type=".$type."\"><img src=\"images/icon_enable_01.png\" alt=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $banstatus = "<a href=\"adm_banner_set_enable.php?id=".$banid."&type=".$type."\"><img src=\"images/icon_disable_01.png\" alt=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			
			$tpl->assign("##banid##", $banid);
			$tpl->assign("##banname##", $banname);
			$tpl->assign("##banpage##", $banpage);
			$tpl->assign("##bancontract##", $bancontract);
			$tpl->assign("##bantype##", $type);
			$tpl->assign("##bansort##", $bansort);
			$tpl->assign("##banstatus##", $banstatus);
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
			
			if ($pspcode == $_SESSION['vsearchbanspcpage']) { $pspselected = "selected"; $pspdefault = ""; } else { $pspselected = ""; $pspdefault = "selected"; }
			
			$tpl->assign("##pspcode##", $pspcode);
			$tpl->assign("##pspname##", $pspname);
			$tpl->assign("##pspselected##", $pspselected);
			$tpl->parse ("#####ROW#####", '.rows_pospage');
			
		}
		
		$posdisable = "disabled"; $posleft = ""; $posright = ""; 
		
		$tpl->assign("##posleft##", $posleft);
		$tpl->assign("##posright##", $posright);
		$tpl->assign("##posdisable##", $posdisable);
		$tpl->assign("##pspdefault##", $pspdefault);
		$tpl->assign("##bantype##", $type);
		$tpl->assign("##page##", $page);
		
	} else {
		
		$pagesql = $_SESSION['vsearchbanbsc'].";";
		$page = pagecal($limit, $start, $pagesql, "adm_banner.php", "?type=$type");
		
		$sql1 = $_SESSION['vsearchbanbsc']." order by ban_sort asc, ban_name asc limit $start,$limit;";
		$result1 = mysql_query($sql1);
		while ($dbarr1 = mysql_fetch_array($result1)) {
			
			$banid = $dbarr1['ban_id'];
			$banname = $dbarr1['ban_name']; 
			$banpage = $dbarr1['ban_page']; 
			$banside = $dbarr1['ban_side']; 
			$banstart = $dbarr1['ban_startdate']; 
			$banend = $dbarr1['ban_enddate'];
			$banstatus = $dbarr1['ban_status'];
			$bansort = "<a href=\"adm_banner_sort.php?id=".$banid."\">".$dbarr1['ban_sort']."</a>";
			
			if  ($banend != '') {
	
				$tempenddate = explode(" ", $banend);
				$banenddate = explode("-", date("Y-m-d", strtotime("-1 day", mktime(0,0,0,addzero2(mcvsubtonum($tempenddate[1])),$tempenddate[0],$tempenddate[2]))));
				$bancontract = $banstart." - ".$banenddate[2]." ".mcvzerotosub($banenddate[1])." ".$banenddate[0];
				
			} else { $bancontract = ""; }
			
			$sql2 = "select * from flc_pospage where psp_code = '$banpage';";
			$result2 = mysql_query($sql2);
			while ($dbarr2 = mysql_fetch_array($result2)) { 
			
				if ($_COOKIE['vlang'] == 'en') { $banpage = $dbarr2['psp_name_en']; }
				else if ($_COOKIE['vlang'] == 'vn') { $banpage = $dbarr2['psp_name_vn']; }
				else { $banpage = $dbarr2['psp_name_jp']; }
			
			}
			
			if ($banside != '') { $banpage = $banpage." - ".strtoupper($banside); } else { $banpage = $banpage; }
					
			if ($banstatus != 'd') { $banstatus = "<a href=\"adm_banner_set_disable.php?id=".$banid."&type=".$type."\"><img src=\"images/icon_enable_01.png\" alt=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $banstatus = "<a href=\"adm_banner_set_enable.php?id=".$banid."&type=".$type."\"><img src=\"images/icon_disable_01.png\" alt=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			
			$tpl->assign("##banid##", $banid);
			$tpl->assign("##banname##", $banname);
			$tpl->assign("##banpage##", $banpage);
			$tpl->assign("##bancontract##", $bancontract);
			$tpl->assign("##bantype##", $type);
			$tpl->assign("##bansort##", $bansort);
			$tpl->assign("##banstatus##", $banstatus);
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
			
			if ($pspcode == $_SESSION['vsearchbanbscpage']) { $pspselected = "selected"; $pspdefault = ""; } else { $pspselected = ""; $pspdefault = "selected"; }
			
			$tpl->assign("##pspcode##", $pspcode);
			$tpl->assign("##pspname##", $pspname);
			$tpl->assign("##pspselected##", $pspselected);
			$tpl->parse ("#####ROW#####", '.rows_pospage');
			
		}
		
		if ($_SESSION['vsearchbanbscside'] == 'l') { $posleft = "checked"; $posright = ""; } else { $posleft = ""; $posright = "checked"; }
		
		$tpl->assign("##posleft##", $posleft);
		$tpl->assign("##posright##", $posright);
		$tpl->assign("##posdisable##", $posdisable);
		$tpl->assign("##pspdefault##", $pspdefault);
		$tpl->assign("##bantype##", $type);
		$tpl->assign("##page##", $page);
		
	}
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
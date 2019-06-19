<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_searchcate.html";
	
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
	
	$pagesql = $_SESSION['vsearchcate'].";";
	$page = pagecal($limit, $start, $pagesql, "adm_member_searchcate.php", "");
	
	if ($_COOKIE['vlang'] == 'en') { $sql1 = $_SESSION['vsearchcate']." order by mem_sort asc, mem_comname_en asc limit $start,$limit;"; }
	else if ($_COOKIE['vlang'] == 'vn') { $sql1 = $_SESSION['vsearchcate']." order by mem_sort asc, mem_comname_vn asc limit $start,$limit;"; }
	else { $sql1 = $_SESSION['vsearchcate']." order by mem_sort asc, mem_comname_jp asc limit $start,$limit;"; }
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($_COOKIE['vlang'] == 'en') { $memcomname = $dbarr1['mem_comname_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $memcomname = $dbarr1['mem_comname_vn']; }
		else { $memcomname = $dbarr1['mem_comname_jp']; }
		$memid = $dbarr1['mem_id'];
		$memstart = $dbarr1['mem_startdate']; 
		$memend = $dbarr1['mem_enddate'];
		$memsort = $dbarr1['mem_sort'];
		$memstatus = $dbarr1['mem_status'];
		
		if  ($memend != '') {
	
			$tempenddate = explode(" ", $memend);
			$memenddate = explode("-", date("Y-m-d", strtotime("-1 day", mktime(0,0,0,addzero2(mcvsubtonum($tempenddate[1])),$tempenddate[0],$tempenddate[2]))));
			$memcontract = $memstart." - ".$memenddate[2]." ".mcvzerotosub($memenddate[1])." ".$memenddate[0];
			
		} else { $memcontract = ""; }
		
		if ($memstatus == 'd') { $memstatus = "<span class=\"red_n\">DISABLE</span>"; }
		else { $memstatus = "<span class=\"green_n\">ENABLE</span>"; }
		
		if ($_SESSION['vsearchcatetype'] == 'basic') { $sortedit = "<a href=\"adm_member_sort.php?id=".$memid."\">".$memsort."</a>"; } else { $sortedit = $memsort; }
		
		$tpl->assign("##memid##", $memid);
		$tpl->assign("##memcomname##", $memcomname);
		$tpl->assign("##memcontract##", $memcontract);
		$tpl->assign("##sortedit##", $sortedit);
		$tpl->assign("##status##", $memstatus);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
		
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
		
		if ($catid == $_SESSION['vsearchcateid']) { $catselected = "selected"; $catdefault = ""; } else { $catselected = ""; $catdefault = "selected"; }
		
		$tpl->assign("##catid##", $catid);
		$tpl->assign("##catname##", $catname);
		$tpl->assign("##catselected##", $catselected);
		$tpl->parse ("#####ROW#####", '.rows_cat');
		
	}
	
	if ($_SESSION['vsearchcatetype'] == 'free') { $typefree = "checked"; $typebasic = ""; } else { $typefree = ""; $typebasic = "checked"; }
	
	$tpl->assign("##catdefault##", $catdefault);
	$tpl->assign("##typebasic##", $typebasic);
	$tpl->assign("##typefree##", $typefree);
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
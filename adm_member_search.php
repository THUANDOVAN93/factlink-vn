<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_search.html";
	
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
	
	$pagesql = $_SESSION['vsearch'].";";
	$page = pagecal($limit, $start, $pagesql, "adm_member_search.php", "");
	
	if ($_COOKIE['vlang'] == 'en') { $sql1 = $_SESSION['vsearch']." order by mem_comname_en asc limit $start,$limit;"; }
	else if ($_COOKIE['vlang'] == 'vn') { $sql1 = $_SESSION['vsearch']." order by mem_comname_vn asc limit $start,$limit;"; }
	else { $sql1 = $_SESSION['vsearch']." order by mem_comname_jp asc limit $start,$limit;"; }
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($_COOKIE['vlang'] == 'en') { $memcomname = $dbarr1['mem_comname_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $memcomname = $dbarr1['mem_comname_vn']; }
		else { $memcomname = $dbarr1['mem_comname_jp']; }
		$memid = $dbarr1['mem_id'];
		$memstart = $dbarr1['mem_startdate']; 
		$memend = $dbarr1['mem_enddate'];
		$memstatus = $dbarr1['mem_status'];
		
		if  ($memend != '') {
	
			$tempenddate = explode(" ", $memend);
			$memenddate = explode("-", date("Y-m-d", strtotime("-1 day", mktime(0,0,0,addzero2(mcvsubtonum($tempenddate[1])),$tempenddate[0],$tempenddate[2]))));
			$memcontract = $memstart." - ".$memenddate[2]." ".mcvzerotosub($memenddate[1])." ".$memenddate[0];
			
		} else { $memcontract = ""; }
		
		if ($memstatus == 'd') { $memstatus = "<span class=\"red_n\">DISABLE</span>"; }
		else { $memstatus = "<span class=\"green_n\">ENABLE</span>"; }
		
		$tpl->assign("##memid##", $memid);
		$tpl->assign("##memcomname##", $memcomname);
		$tpl->assign("##memcontract##", $memcontract);
		$tpl->assign("##status##", $memstatus);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	if ($_SESSION['vsearchtype'] == 'basic') { $typefree = ""; $typebasic = "checked"; $typeall = ""; } 
	else if ($_SESSION['vsearchtype'] == 'free') { $typefree = "checked"; $typebasic = ""; $typeall = ""; } 
	else { $typefree = ""; $typebasic = ""; $typeall = "checked"; }
	
	$tpl->assign("##searchword##", $_SESSION['vsearchword']);
	$tpl->assign("##typebasic##", $typebasic);
	$tpl->assign("##typefree##", $typefree);
	$tpl->assign("##typeall##", $typeall);
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
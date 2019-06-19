<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_del.html";
	
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
	
	if ($type == 'basic') { $sqltype = " where mem_package != ''"; $paratype = "?type=".$type; }
	else if ($type == 'free') { $sqltype = " where mem_package = ''"; $paratype = "?type=".$type; }
	else { $sqltype = ""; $paratype = ""; }
	
	$pagesql = "select * from flc_member".$sqltype.";";
	$page = pagecal($limit, $start, $pagesql, "adm_member_del.php", $paratype);
	
	$sql1 = "select * from flc_member".$sqltype." order by mem_id desc limit $start,$limit;"; 
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
		$tpl->assign("##start##", $_GET['start']);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	$tpl->assign("##type##", $type);
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
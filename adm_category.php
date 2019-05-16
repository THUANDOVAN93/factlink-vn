<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_category.html";
	
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
	
	$pagesql = "select * from flc_category;";
	$page = pagecal($limit, $start, $pagesql, "adm_category.php", "");
	
	$sql1 = "select * from flc_category order by cat_order asc limit $start,$limit;"; 
	$result1 = mysql_query($sql1);
	$n=0;
	while ($dbarr1 = mysql_fetch_array($result1)) {
		$n++;
		if ($_COOKIE['vlang'] == 'en') { $catname = $dbarr1['cat_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $catname = $dbarr1['cat_name_vn']; }
		else { $catname = $dbarr1['cat_name_jp']; }
		$catid = $dbarr1['cat_id'];
		$catorder = $dbarr1['cat_order'];
		if ($dbarr1['cat_pos'] == 's') { $catname = "　・ ".$catname; }
		
		$tpl->assign("##catid##", $catid);
		$tpl->assign("##n##", $n);
		$tpl->assign("##catname##", $catname);
		$tpl->assign("##catorder##", $catorder);
		$tpl->assign("##catset##", $catset);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_category_add.html";
	
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
	
	$sql1 = "select * from flc_category where cat_pos = 'm' order by cat_order asc;"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
				
		if ($_COOKIE['vlang'] == 'en') { $mcatname = $dbarr1['cat_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $mcatname = $dbarr1['cat_name_vn']; }
		else { $mcatname = $dbarr1['cat_name_jp']; }
		$mcatid = $dbarr1['cat_id'];
		
		$tpl->assign("##mcatid##", $mcatid);
		$tpl->assign("##mcatname##", $mcatname);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	$tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->assign("##catunderdisable##", "disabled");
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_product_category_add.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));

	$type = $_GET['type'];
	$start = $_GET['start'];
	$limit = 50;
	$lang = $_COOKIE['vlang'];

	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);

	$sqlGetMainCat = "select * from flc_product_category where CatPos = 'm' order by CatOrder asc;";
	$rsGetMainCat =  mysql_query($sqlGetMainCat);
	while ( $catItem = mysql_fetch_array($rsGetMainCat) ) {

		if ( $lang == 'en' ) {
			$catName = $catItem['CategoryNameEN'];
		} elseif ( $lang == 'vn' ) {
			$catName = $catItem['CategoryNameVN'];
		} else {
			$catName = $catItem['CategoryNameJP'];
		}
		$catId = $catItem['CategoryID'];

		$tpl->assign("##mcatid##", $catId);
		$tpl->assign("##mcatname##", $catName);
		$tpl->parse("#####ROW#####", ".main_cat");

	}
	
	// --------------------
		
	
	$tpl->assign("##admid##", $currentuserid);
	$tpl->assign("##page##", $page);
	$tpl->assign("##catunderdisable##", "disabled");
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
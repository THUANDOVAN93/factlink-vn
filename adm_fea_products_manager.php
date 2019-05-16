<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_fea_products_manager.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);

	// --- Check Category Selected
	$catSelectedId = '';
	$sqlGetCatSelected = "select * from flc_product_category where CatFeatured = 1";

	$rsCountCat = mysql_query($sqlGetCatSelected);
	$numCat = mysql_num_rows($rsCountCat);
	if ($numCat > 0) {

		$getCatSelected = mysql_fetch_array($rsCountCat);
		$catSelectedId = $getCatSelected['CategoryID'];

	}
	
	$sql1 = "select * from flc_product_category";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		if ( $_COOKIE['vlang'] == 'en' ) {
			$catName = $dbarr1['CategoryNameEN'];
			$catDesc = $dbarr1['DescEN'];
		} elseif ( $_COOKIE['vlang'] == 'vn' ) {
			$catName = $dbarr1['CategoryNameVN'];
			$catDesc = $dbarr1['DescVN'];
		} else {
			$catName = $dbarr1['CategoryNameJP'];
			$catDesc = $dbarr1['DescJP'];
		}
		$catId = $dbarr1['CategoryID'];
		
		$classCatSelected = "";
		if ($catSelectedId == $dbarr1['CategoryID']) {
			$classCatSelected = "selected";
		}
		$tpl->assign ('##catselected##', $classCatSelected);
		$tpl->assign ('##productcatId##', $catId);
		$tpl->assign ('##productcatname##', $catName);
		$tpl->assign("##admid##", $currentuserid);
		$tpl->parse ("#####ROW#####", '.rows_fea_product');
	}

	
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
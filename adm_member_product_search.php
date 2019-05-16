<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_product_search.html";
	
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
	$lang = $_COOKIE['vlang'];
	
	$pagesql = $_SESSION['vsearch'].";";
	$page = pagecal($limit, $start, $pagesql, "adm_member_product_search.php", "");
	
	$sql1 = $_SESSION['vsearch']." order by ProductID desc limit $start,$limit;";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($lang == 'en') {
			$productname = $dbarr1['ProductNameEN'];
		}
		else if($lang == 'vn') {
			$productname = $dbarr1['ProductNameVN'];
		}
		else {
			$productname = $dbarr1['ProductNameJP'];
		}

		$productId = $dbarr1['ProductID'];
		
		$tpl->assign("##productid##", $productId);
		$tpl->assign("##productname##", $productname);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}

	$sql2 = "select * from flc_product_category";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
		if ( $_COOKIE['vlang'] == 'en' ) {
			$catName = $dbarr2['CategoryNameEN'];
			$catDesc = $dbarr2['DescEN'];
		} elseif ( $_COOKIE['vlang'] == 'vn' ) {
			$catName = $dbarr2['CategoryNameVN'];
			$catDesc = $dbarr2['DescVN'];
		} else {
			$catName = $dbarr2['CategoryNameJP'];
			$catDesc = $dbarr2['DescJP'];
		}
		$catId = $dbarr2['CategoryID'];
		
		$classCatSelected = "";
		if ($catSelectedId == $dbarr2['CategoryID']) {
			$classCatSelected = "selected";
		}
		$tpl->assign ('##catselected##', $classCatSelected);
		$tpl->assign ('##productcatId##', $catId);
		$tpl->assign ('##productcatname##', $catName);
		$tpl->assign("##admid##", $currentuserid);
		$tpl->parse ("#####ROW#####", '.rows_cat_search');
	}

	$sqlSelectSupplier = "select mem_id, mem_comname_en, mem_comname_jp, mem_comname_vn from flc_member";
	$supplierList = mysql_query($sqlSelectSupplier);
	while ($supplierItem = mysql_fetch_array($supplierList)) {
		if ($lang == 'en') {
			$supplierName = $supplierItem['mem_comname_en'];
		} elseif ($lang == 'vn') {
			$supplierName = $supplierItem['mem_comname_vn'];
		} else {
			$supplierName = $supplierItem['mem_comname_jp'];
		}

		$tpl->assign("##supplierid##", $supplierItem['mem_id']);
		$tpl->assign("##suppliername##", $supplierName);
		$tpl->parse ("#####ROW#####", '.rows_supplier');
	}

	
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
<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_page_product_add.html";
	
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
	$lang = $_COOKIE['vlang'];

	$sqlSelectCat = "select * from flc_product_category where Active = 1";
	$catList = mysql_query($sqlSelectCat);
	while ($catItem = mysql_fetch_array($catList)) {
		if ($lang == 'en') {
			$catName = $catItem['CategoryNameEN'];
			$catDesc = $catItem['DescEN'];
		} elseif ($lang == ['vn']) {
			$catName = $catItem['CategoryNameVN'];
			$catDesc = $catItem['DescVN'];
		} else {
			$catName = $catItem['CategoryNameJP'];
			$catDesc = $catItem['DescJP'];
		}

		$catId =  $catItem['CategoryID'];
		$tpl->assign('##catid##', $catId);
		$tpl->assign('##catname##', $catName);
		$tpl->assign('##catdesc##', $catDesc);
		$tpl->assign('##catselected##', '');
		$tpl->parse ("#####ROW#####", '.rows_cat');
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
	
	$tpl->assign("##admid##", $currentuserid);
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
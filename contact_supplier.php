<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure-new.html"; 
	$url2 = "contact_supplier.html";
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	$pagecode = "ctt";

	
	/* Set default language cookie */
	if(empty($_COOKIE['vlang'])) {
		$_COOKIE['vlang'] = 'en';
	}
	
	/* Prevent unknown cookie language value */
	if(!in_array($_COOKIE['vlang'],['en','jp','vn'])) {
		$_COOKIE['vlang'] = 'en';
	}
	
	$lang = $_COOKIE['vlang'];

	if ($lang == 'en') {
		$url6 = "menu-html_en.html";
		$url7 = "contact_en.html";
	} else if ($lang == 'vn') {
		$url6 = "menu-html_vn.html";
		$url7 = "contact_vn.html";
	} else {
		$url6 = "menu-html_jp.html";
		$url7 = "contact_jp.html";
	}
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "right_tpl" => $url3, "left_tpl" => $url4, "top_tpl" => $url5, "menu_tpl" => $url6, "desc_tpl" => $url7));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	// Get Supplier Infor
	$getProductId = (int)$_GET['pid'];
	$sqlGetProduct = sprintf("select p.*, m.mem_comname_en, m.mem_comname_jp, m.mem_comname_vn from flc_products p, flc_member m where ProductID = %d and p.SupplierID = m.mem_id;", mysql_real_escape_string($getProductId));
	$rsGetProduct = mysql_query( $sqlGetProduct );
	while ( $productItem = mysql_fetch_array( $rsGetProduct ) ) {
		if ( $lang == "en" ) {
			$productName = $productItem['ProductNameEN'];
			$supplierName = $productItem['mem_comname_en'];
		} else if ( $lang = "vn" ) {
			$productName = $productItem['ProductNameVN'];
			$supplierName = $productItem['mem_comname_vn'];
		} else {
			$productName = $productItem['ProductNameJP'];
			$supplierName = $productItem['mem_comname_jp'];
		}

		$tpl->assign("##productname##", $productName);
		$tpl->assign("##productid##", $productItem['ProductID']);
		$tpl->assign("##supname##", $supplierName);
		$tpl->assign("##supid##", $productItem['SupplierID']);
	}

	
	// Random security number
	$random = random(0);
	$confirmcode = $random[1].$random[2].$random[3].$random[4];
	
	$tpl->assign("##confirmcode##", $confirmcode);
	$tpl->assign("##randomnum##", $random[0]);
	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DESC_AREA##", "desc_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_product_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));

	$_POST = array_map('mysql_real_escape_string',$_POST);

	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$lang = $_COOKIE['vlang'];

	$productId = (int)$_POST['t_product_id'];
	$productIdFormat = sprintf("%08d", $productId);
	$sqlSelectProduct = "select p.*, m.mem_folder from flc_products p, flc_member m where ProductID = $productIdFormat and p.SupplierID = m.mem_id";
	$rsSelectProduct = mysql_query($sqlSelectProduct);
	while ( $productItem = mysql_fetch_array( $rsSelectProduct ) ) {
		$productNameEn = $productItem['ProductNameEN'];
		$productNameVn = $productItem['ProductNameVN'];
		$productNameJp = $productItem['ProductNameJP'];


		$productStatus = $productItem['Status'];

		$productDescEn = $productItem['ProductDescEN'];
		$productDescVn = $productItem['ProductDescVN'];
		$productDescJp = $productItem['ProductDescJP'];

		$catIdCurrent = $productItem['CategoryID'];
		$supIdCurrent = $productItem['SupplierID'];

		$supplierFolder = $productItem['mem_folder'];
	}

	if ($productStatus == "1") {
		$tpl->assign("##active_selected##", "selected");
		$tpl->assign("##disable_selected##", "");
	} else {
		$tpl->assign("##active_selected##", "");
		$tpl->assign("##disable_selected##", "selected");
	}



	$tpl->assign("##product_id##", $productIdFormat);

	$tpl->assign("##productname_en##", $productNameEn);
	$tpl->assign("##productname_vn##", $productNameVn);
	$tpl->assign("##productname_jp##", $productNameJp);

	$tpl->assign("##productdesc_en##", $productDescEn);
	$tpl->assign("##productdesc_vn##", $productDescVn);
	$tpl->assign("##productdesc_jp##", $productDescJp);

	// Build Image link Current
	$sourceProductImage = "/home/".$supplierFolder."/products/";
	$imgProductLink = $sourceProductImage.$productId."-L.jpg";
	$tpl->assign("##productImgCr##", $imgProductLink);

	// Build Thumbnail Image link Current
	$imgProductThumb1 = $sourceProductImage.$productId."-1-T.jpg";
	$imgProductThumb2 = $sourceProductImage.$productId."-2-T.jpg";
	$imgProductThumb3 = $sourceProductImage.$productId."-3-T.jpg";
	$imgProductThumb4 = $sourceProductImage.$productId."-4-T.jpg";
	$tpl->assign("##productThumbCr1##", $imgProductThumb1);
	$tpl->assign("##productThumbCr2##", $imgProductThumb2);
	$tpl->assign("##productThumbCr3##", $imgProductThumb3);
	$tpl->assign("##productThumbCr4##", $imgProductThumb4);





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

		if ($catId == $catIdCurrent) {
			$selected = "selected";
		} else {
			$selected = "";
		}

		$tpl->assign("##catselected##", $selected);
		$tpl->assign('##catid##', $catId);
		$tpl->assign('##catname##', $catName);
		$tpl->assign('##catdesc##', $catDesc);
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

		$supId = $supplierItem['mem_id'];

		if ($supId == $supIdCurrent) {
			$selected = "selected";
		} else {
			$selected = "";
		}

		$tpl->assign("##supselected##", $selected);

		$tpl->assign("##supplierid##", $supId);
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
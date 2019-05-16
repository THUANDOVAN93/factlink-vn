<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure-bootstrap.html";
	//$url1 = "structure-new.html";
	$url2 = "product-detail.html";
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
	
	$lang =  $_COOKIE['vlang'];

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
	
	$getProductId = (int)$_GET['proid'];
	$tpl->assign("##productid##",$getProductId);
	mysql_query("use $db_name;");

	$productId = mysql_real_escape_string($getProductId);

	$sqlGetProduct = sprintf("select p.*, m.mem_folder, m.mem_comname_en, m.mem_comname_jp,
	m.mem_comname_vn, m.mem_address1_en, m.mem_address1_jp, m.mem_address1_vn, m.mem_address2_en, m.mem_address2_jp, m.mem_address2_vn, m.mem_url, m.mem_establishdate_en, m.mem_establishdate_jp, m.mem_establishdate_vn, m.mem_business_en, m.mem_business_jp, m.mem_business_vn, m.mem_product_vn, m.mem_product_en, m.mem_product_jp from flc_products p, flc_member m where p.ProductID = %d and p.SupplierID = m.mem_id", $productId);
	$rsProduct = mysql_query($sqlGetProduct);

	while ($productItem = mysql_fetch_array($rsProduct)) {
		// Bulid image link
		$memFolder = $productItem['mem_folder'];
		$sourceImage = 'home/'.$memFolder.'/products/';
		$imgLink = $sourceImage.$productItem['ProductID'].'-L.jpg';

		// Set default image if not exit product image
		if (!file_exists($imgLink)) {
			$imgLink = "image/products/product.png";
		}

		// Bulid image thumbnail link
		$imgThumbLink1 =  $sourceImage.$productItem['ProductID'].'-1-T.jpg';
		$imgThumbLink2 =  $sourceImage.$productItem['ProductID'].'-2-T.jpg';
		$imgThumbLink3 =  $sourceImage.$productItem['ProductID'].'-3-T.jpg';
		$imgThumbLink4 =  $sourceImage.$productItem['ProductID'].'-4-T.jpg';

		// Set default thumbnail
		$showThumbClass1 = "";
		$showThumbClass2 = "";
		$showThumbClass3 = "";
		$showThumbClass4 = "";
		if (!file_exists($imgThumbLink1)) {
			$showThumbClass1 = "d-none";
			
		}
		if (!file_exists($imgThumbLink2)) {
			$showThumbClass2 = "d-none";
			
		}
		if (!file_exists($imgThumbLink3)) {
			$showThumbClass3 = "d-none";
		}
		if (!file_exists($imgThumbLink4)) {
			$showThumbClass4 = "d-none";
		}
		$tpl->assign("##showthumbclass1##", $showThumbClass1);
		$tpl->assign("##showthumbclass2##", $showThumbClass2);
		$tpl->assign("##showthumbclass3##", $showThumbClass3);
		$tpl->assign("##showthumbclass4##", $showThumbClass4);
		

		// Stock Status
		
		$stockStatus = $productItem['Status'];

		if ( $stockStatus == 1 ) {
			if ( $lang == 'vn' ) {
				$status = 'Có sẵn';
			} elseif ( $lang == 'en' ) {
				$status = 'Available';
			} else {
				$status = '在庫あり';
			}
			$statusClass = 'text-success';
		} else {
			if ( $lang == 'vn' ) {
				$status = 'Không có sẵn';
			} elseif ( $lang == 'en' ) {
				$status = 'Unavailable';
			} else {
				$status = '在庫なし';
			}
			$statusClass = 'text-danger';
		}

		// --- Disable for DENKA COMPANY
		if ( $stockStatus == 1 ) {
			$visibilityStatusClass = "d-block";
		} else {
			$visibilityStatusClass = "d-none";
		}
		// if ($productItem['SupplierID'] == '50587') {
			
		// 	if ( $stockStatus == 1 ) {
		// 		$visibilityStatusClass = "d-block";
		// 	} else {
		// 		$visibilityStatusClass = "d-none";
		// 	}
			
		// }

		$tpl->assign("##status##", $status);
		$tpl->assign("##statusclass##", $statusClass);
		$tpl->assign("##vs_status_class##", $visibilityStatusClass);


		if ($lang == 'en') {
			$productName = $productItem['ProductNameEN'];
			$productDes = $productItem['ProductDescEN']; 
			$supplierName = $productItem['mem_comname_en'];
			$supplierDesc = html($productItem['mem_business_en']);
			$supplierAddress = $productItem['mem_address1_en'];
			$supplierSetup = $productItem['mem_establishdate_en'];
			$memProduct = $productItem['mem_product_en'];
		} elseif ($lang == 'vn') {
			$productName = $productItem['ProductNameVN'];
			$productDes = $productItem['ProductDescVN'];
			$supplierName = $productItem['mem_comname_vn'];
			$supplierDesc = html($productItem['mem_business_vn']);
			$supplierAddress = $productItem['mem_address1_vn'];
			$supplierSetup = $productItem['mem_establishdate_vn'];
			$memProduct = $productItem['mem_product_vn'];
		} else {
			$productName = $productItem['ProductNameJP'];
			$productDes = $productItem['ProductDescJP'];
			$supplierName = $productItem['mem_comname_jp'];
			$supplierDesc = html($productItem['mem_business_jp']);
			$supplierAddress = $productItem['mem_address1_jp'];
			$supplierSetup = $productItem['mem_establishdate_jp'];
			$memProduct = $productItem['mem_product_jp'];
		}
		$memProduct = html($memProduct);

		if ($productName == "") {
			$productName = $productItem['ProductNameEN'];
		}
		if ($productDes == "") {
			$productDes = $productItem['ProductDescEN']; 
		}

		$supplierUrl = html($productItem['mem_url']);
		$supplierId = (int)$productItem['SupplierID'];
		$productSKU = "#".$getProductId;
		$catId = $productItem['CategoryID'];

		$tpl->assign("##mainproductimage##", $imgLink);
		$tpl->assign("##productthumbimage1##", $imgThumbLink1);
		$tpl->assign("##productthumbimage2##", $imgThumbLink2);
		$tpl->assign("##productthumbimage3##", $imgThumbLink3);
		$tpl->assign("##productthumbimage4##", $imgThumbLink4);

		$tpl->assign("##productsku##", $productSKU);
		$tpl->assign("##productname##", $productName);
		$tpl->assign("##productdesc##", $productDes);
		$tpl->assign("##suppliername##", $supplierName);
		$tpl->assign("##supplierdesc##", $supplierDesc);
		$tpl->assign("##supplieraddress##", $supplierAddress);
		$tpl->assign("##suppliersetup##", $supplierSetup);
		$tpl->assign("##supplierurl##", $supplierUrl);
		$tpl->assign("##memproduct##", $memProduct);
	
	}

	// Build Breadcrumb

	$sqlGetCatInfo = sprintf("select * from flc_product_category where CategoryID = %d;", $catId);

	$rsGetCatInfo = mysql_query($sqlGetCatInfo);
	while ( $catInfor = mysql_fetch_array($rsGetCatInfo) ) {
		if ($lang == "en") {
			$subBreadcrumbName1 = $catInfor['CategoryNameEN'];
		} elseif ($lang == "vn") {
			$subBreadcrumbName1 = $catInfor['CategoryNameVN'];
		} else {
			$subBreadcrumbName1 = $catInfor['CategoryNameJP'];
		}

		$catUnder = $catInfor['CatUnder'];
		$mainCatId = $catInfor['CatUnder'];
	}
	if ( $catUnder == "" ) {

		// Is Main Category
		$subBreadcrumbLink1 = "products_list.php?id=$catId&start=0";
		$subBreadcrumbLink2 = "";
		$subBreadcrumbName2 = "";
		$classBreadcrumb2 = "d-none";
		
	} else {

		// Is Sub Category -- get parent cat
		
		$sqlGetParentCat = sprintf("select * from flc_product_category where CategoryID = %d;", $mainCatId);
		$rsGetParentCat = mysql_query($sqlGetParentCat);
		while ( $catParent = mysql_fetch_array($rsGetParentCat) ) {
			if ($lang == "en") {
				$subBreadcrumbName2 = $catParent['CategoryNameEN'];
			} elseif ($lang == "vn") {
				$subBreadcrumbName2 = $catParent['CategoryNameVN'];
			} else {
				$subBreadcrumbName2 = $catParent['CategoryNameJP'];
			}

			$parentCatId = $catParent['CategoryID'];
		}

		$subBreadcrumbLink1 = "products_list.php?id=$catId&start=0";
		$subBreadcrumbLink2 = "products_list.php?id=$parentCatId&start=0";
		$classBreadcrumb2 = "d-block";
	}

	$rootBreadcrumbLink = "products_list.php?start=0";

	$tpl->assign("##rootBreadcrumbLink##", $rootBreadcrumbLink);
	$tpl->assign("##subBreadcrumbLink1##", $subBreadcrumbLink1);
	$tpl->assign("##subBreadcrumbName1##", $subBreadcrumbName1);
	$tpl->assign("##subBreadcrumbLink2##", $subBreadcrumbLink2);
	$tpl->assign("##subBreadcrumbName2##", $subBreadcrumbName2);
	$tpl->assign("##classBreadcrumb2##", $classBreadcrumb2);
	// End Build Breadcrumb

	// Build Link Supplier Page
	$supplierIdFormat = sprintf("%08d", $supplierId);
	$sqlGetPage = "select pag_id from flc_page where pag_type = 'prf' and mem_id = $supplierIdFormat";
	$rsGetPage = mysql_query($sqlGetPage);
	$getPage = mysql_fetch_array($rsGetPage);
	$pageId = $getPage['pag_id'];
	$supPageUrl = "mem_profile.php?id=".$supplierIdFormat."&page=".$pageId."&lang=".$lang;
	$tpl->assign("##suppageurl##", $supPageUrl);


	// Build product of supplier
	$sqlGetProductOfSup = sprintf("select * from flc_products where SupplierID = %d order by ProductID desc limit 0,6", mysql_real_escape_string($supplierIdFormat));
	$rsGetProductOfSup = mysql_query($sqlGetProductOfSup);
	while ( $productSupItem = mysql_fetch_array($rsGetProductOfSup) ) {

		$sourceImage = 'home/'.$memFolder.'/products/';
		$imgSupLink = $sourceImage.$productSupItem['ProductID'].'-L.jpg';
		$productSupLink =  "product_detail.php?proid=".$productSupItem['ProductID'];
		if ( $lang == "vn" ) {

			$productSupName = $productSupItem['ProductNameVN'];
		} elseif ( $lang == "en") {

			$productSupName = $productSupItem['ProductNameEN'];
		} else {

			$productSupName = $productSupItem['ProductNameJP'];
		}
		if ( $productSupName == "" ) {

			$productSupName = $productSupItem['ProductNameEN'];
		}


		$tpl->assign("##productsupname##", $productSupName);
		$tpl->assign("##productsupimg##", $imgSupLink);
		$tpl->assign("##productsuplink##", $productSupLink);
		$tpl->parse("#####ROW#####", ".rows_product_supplier");
		
	}




	
	// --- Global Template Section	
	//include_once("./include/global_value.php");
	include_once("./include/beta/global_value.php");
	
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
<?php

	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	//$url1 = "structure-new.html"; 
	$url1 = "structure-bootstrap.html"; 
	$url2 = "products-list.html";
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

	$catId = (int)mysql_real_escape_string($_GET['id']);
	$start = (int)mysql_real_escape_string($_GET['start']);
	$limit = 24;
	

	
	if (isset($catId) && !empty($catId)) {

		$sqlPagin = sprintf("select * from flc_products where CategoryID = %d", $catId);
		$page = pagecal($limit, $start, $sqlPagin, "products_list.php", "?id=".$catId);

		$sqlGetProductByCat = sprintf("select p.*, c.CategoryNameJP, c.CategoryNameVN, c.CategoryNameEN, m.mem_folder, m.mem_comname_en, m.mem_comname_jp, m.mem_comname_vn from flc_products p, flc_product_category c, flc_member m where p.CategoryID = %d and p.SupplierID = m.mem_id and p.CategoryID = c.CategoryID order by ProductID desc limit $start,$limit;", $catId);

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

			$sqlGetSubCat = sprintf("select CategoryID from flc_product_category where CatUnder = %d", $catId);
			$rsGetSubCat = mysql_query($sqlGetSubCat);

			$listCategoryId = array($catId);
			while ( $subCatItem = mysql_fetch_array( $rsGetSubCat ) ) {
				$listCategoryId[] = (int)$subCatItem['CategoryID'];
			}

			foreach ($listCategoryId as $key => $categoryId) {

				$sqlPagin = sprintf("select * from flc_products where CategoryID = %d", $categoryId);
				$page = pagecal($limit, $start, $sqlPagin, "products_list.php", "?id=".$categoryId);

				$sqlGetProductByCat = sprintf("select p.*, c.CategoryNameJP, c.CategoryNameVN, c.CategoryNameEN, m.mem_folder, m.mem_comname_en, m.mem_comname_jp, m.mem_comname_vn from flc_products p, flc_product_category c, flc_member m where p.CategoryID = %d and p.SupplierID = m.mem_id and p.CategoryID = c.CategoryID order by ProductID desc limit $start,$limit;", $categoryId);

				$rsGetProductByCat =  mysql_query($sqlGetProductByCat);
				$totalProduct = mysql_num_rows($rsGetProductByCat);

				$htmlNotFound = "";
				if ( $totalProduct > 0 ) {

					while ( $productItem = mysql_fetch_array($rsGetProductByCat) ) {
						if ( $lang == 'en' ) {
							$productName = $productItem['ProductNameEN'];
							$productDesc = $productItem['ProductDescEN'];
							$supName = $productItem['mem_comname_en'];
						} else if ( $lang == 'vn' ) {
							$productName = $productItem['ProductNameVN'];
							$productDesc = $productItem['ProductDescVN'];
							$supName = $productItem['mem_comname_vn'];
						} else {
							$productName = $productItem['ProductNameJP'];
							$productDesc = $productItem['ProductDescJP'];
							$supName = $productItem['mem_comname_jp'];
						}

						// BUILD IMAGE LINK
						$sourceImage = 'home/'.$productItem['mem_folder'].'/products/';
						$imgLink = $sourceImage.$productItem['ProductID'].'-L.jpg';

						if (!file_exists($imgLink)) {
							$imgLink = 'image/products/product.png';
						}

						$tpl->assign("##proid##", $productItem['ProductID']);
						$tpl->assign("##productname##", $productName);
						$tpl->assign("##productlink##", $imgLink);
						$tpl->assign("##productdesc##", $productDesc);
						$tpl->assign("##supname##", $supName);
						$tpl->assign("##show_category_class##", "d-none");
						$tpl->assign("##show_more_class##", "d-none");
						$tpl->parse("#####ROW#####", ".product_list");
					}

				} else {

					$htmlNotFound = "<p>No Product Found !</p>";

				}
			}
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

			$rsGetProductByCat =  mysql_query($sqlGetProductByCat);
			$totalProduct = mysql_num_rows($rsGetProductByCat);
			$htmlNotFound = "";
			if ( $totalProduct > 0 ) {

				while ( $productItem = mysql_fetch_array($rsGetProductByCat) ) {
					if ( $lang == 'en' ) {
						$productName = $productItem['ProductNameEN'];
						$productDesc = $productItem['ProductDescEN'];
						$supName = $productItem['mem_comname_en'];
					} else if ( $lang == 'vn' ) {
						$productName = $productItem['ProductNameVN'];
						$productDesc = $productItem['ProductDescVN'];
						$supName = $productItem['mem_comname_vn'];
					} else {
						$productName = $productItem['ProductNameJP'];
						$productDesc = $productItem['ProductDescJP'];
						$supName = $productItem['mem_comname_jp'];
					}

					// BUILD IMAGE LINK
					$sourceImage = 'home/'.$productItem['mem_folder'].'/products/';
					$imgLink = $sourceImage.$productItem['ProductID'].'-L.jpg';

					if (!file_exists($imgLink)) {
						$imgLink = 'image/products/product.png';
					}

					$tpl->assign("##proid##", $productItem['ProductID']);
					$tpl->assign("##productname##", $productName);
					$tpl->assign("##productlink##", $imgLink);
					$tpl->assign("##productdesc##", $productDesc);
					$tpl->assign("##supname##", $supName);
					$tpl->assign("##show_category_class##", "d-none");
					$tpl->assign("##show_more_class##", "d-none");
					$tpl->parse("#####ROW#####", ".product_list");
				}

			} else {

				$htmlNotFound = "<p>No Product Found !</p>";

			}
		}

	} else {

		$sqlPagin = "select * from flc_products;";
		$page = pagecal($limit, $start, $sqlPagin, "products_list.php", "");

		$sqlGetProductByCat = "select a.* from 
		(select p.*, cc.CategoryNameJP, cc.CategoryNameVN,
		cc.CategoryNameEN, mm.mem_folder, mm.mem_comname_en, mm.mem_comname_jp, mm.mem_comname_vn, 
		case 
			when @CategoryID != p.CategoryID then @rownum := 1
			else @rownum := @rownum + 1
			end as rank,
		@CategoryID := p.CategoryID
		from 
		flc_products p, flc_product_category cc, flc_member mm, 
		(select @rownum := 0 , @CategoryID := NULL) r
		where p.CategoryID = cc.CategoryID and mm.mem_id = p.SupplierID
		order by p.CategoryID asc
		limit $start, $limit 
		) a
		where a.rank <= 4;";

		$subBreadcrumbLink1 = "";
		$subBreadcrumbName1 = "";
		$subBreadcrumbLink2 = "";
		$subBreadcrumbName2 = "";
		$classBreadcrumb1 = "d-none";
		$classBreadcrumb2 = "d-none";		

		// Edit by thuando

		$rsGetProductByCat =  mysql_query($sqlGetProductByCat);
		$totalProduct = mysql_num_rows($rsGetProductByCat);
		$htmlNotFound = "";
		if ($totalProduct > 0) {

			$productList = array();
			while ( $productItem = mysql_fetch_array($rsGetProductByCat) ) {
				$productList[] = $productItem;
			}
			
			foreach ($productList as $key => $productItem) {
				$showCatClass = 'd-none';
				$showMoreClass = 'd-none';

				if ($lang == 'en') {
					$productName = $productItem['ProductNameEN'];
					$productDesc = $productItem['ProductDescEN'];
					$supName = $productItem['mem_comname_en'];
					$categoryName = $productItem['CategoryNameEN'];
				} elseif ($lang == 'vn') {
					$productName = $productItem['ProductNameVN'];
					$productDesc = $productItem['ProductDescVN'];
					$supName = $productItem['mem_comname_vn'];
					$categoryName = $productItem['CategoryNameVN'];
				} else {
					$productName = $productItem['ProductNameJP'];
					$productDesc = $productItem['ProductDescJP'];
					$supName = $productItem['mem_comname_jp'];
					$categoryName = $productItem['CategoryNameJP'];
				}

				// BUILD IMAGE LINK
				$sourceImage = 'home/'.$productItem['mem_folder'].'/products/';
				$imgLink = $sourceImage.$productItem['ProductID'].'-L.jpg';

				if (!file_exists($imgLink)) {
					$imgLink = 'image/products/product.png';
				}

				if ( $key === 0 ) {
					$showCatClass = 'd-flex';
				} elseif ( $productList[$key]['CategoryID'] !== $productList[$key-1]['CategoryID'] ) {
					$showCatClass = 'd-flex';
				} else {
					$showCatClass = 'd-none';
				}

				if ( $productList[$key]['CategoryID'] !== $productList[$key+1]['CategoryID'] ) {
					$showMoreClass = 'd-flex';
				} else {
					$showMoreClass = 'd-none';
				}

				$catId = $productItem['CategoryID'];

				$linkShowAllProduct = 'products_list.php?id='.$catId.'&start=0';

				$tpl->assign("##proid##", $productItem['ProductID']);
				$tpl->assign("##linkshowallproduct##", $linkShowAllProduct);
				$tpl->assign("##productname##", $productName);
				$tpl->assign("##productlink##", $imgLink);
				$tpl->assign("##productdesc##", $productDesc);
				$tpl->assign("##categoryname##", $categoryName);
				$tpl->assign("##supname##", $supName);
				$tpl->assign("##show_category_class##", $showCatClass);
				$tpl->assign("##show_more_class##", $showMoreClass);
				$tpl->parse("#####ROW#####", ".product_list");
			}
		} else {

			$htmlNotFound = "<p>No Product Found !</p>";

		}
	}

	$tpl->assign("##noproductfound##", $htmlNotFound);

	$tpl->assign("##pag##", $page);
	$rsPagin = mysql_query($sqlPagin);
	$getPagin = mysql_fetch_array($rsPagin);

	// Build Breadcrumb
	$rootBreadcrumbLink = "products_list.php?start=0";


	$tpl->assign("##rootBreadcrumbLink##", $rootBreadcrumbLink);
	$tpl->assign("##subBreadcrumbLink1##", $subBreadcrumbLink1);
	$tpl->assign("##subBreadcrumbName1##", $subBreadcrumbName1);
	$tpl->assign("##subBreadcrumbLink2##", $subBreadcrumbLink2);
	$tpl->assign("##subBreadcrumbName2##", $subBreadcrumbName2);
	$tpl->assign("##classBreadcrumb2##", $classBreadcrumb2);

	
	// --- Global Template Section	
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
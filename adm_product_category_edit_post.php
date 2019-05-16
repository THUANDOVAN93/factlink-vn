<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$adminId = $_POST['h_admid'];

	$catId = (int)$_POST['t_cat_id'];
	$catNameEn = $_POST['t_title_en'];
	$catNameVn = $_POST['t_title_vn'];

	$catLevel = $_POST['t_pos'];
	$catParent = $_POST['t_under'];
	$catMakeOrderId = $_POST['t_position'];


	$catNameJp = $_POST['t_title_jp'];
	$catDescEn = $_POST['t_desc_en'];
	$catDescVn = $_POST['t_desc_vn'];
	$catDescJp = $_POST['t_desc_jp'];


	if ($_SESSION['vd'] != $adminId) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	// Check if change main or sub --> change sort herer
	$sqlGetCatCurrentInfo = "select * from flc_product_category where CategoryID = $catId";
	$rsGetCatCurrent = mysql_query($sqlGetCatCurrentInfo);
	while ( $catItem = mysql_fetch_array($rsGetCatCurrent) ) {
		$catPosCurrent = $catItem['CatPos'];
		$catOrderCurrent = (int)$catItem['CatOrder'];
	}

	if ( $catLevel == 'm' ) {

		if ($catMakeOrderId == '') {
			$catOrderHook = 1;
			$catOrderMaterial = 1;
		} else {
			$sqlCatHook = "select * from flc_product_category where CategoryID = $catMakeOrderId";
			$rsCatHook = mysql_query($sqlCatHook);
			while ( $catHookItem = mysql_fetch_array($rsCatHook) ) {
				$catOrderHook = $catHookItem['CatOrder'];
			}
			// After Category
			$catOrderHook += 1;
			$catOrderMaterial = $catOrderHook;
		}

	} else {
		$catOrderMaterial = 0;
		$catOrderHook = $catOrderCurrent;
	}

	// update position of all category after category change
	if ( $catOrderCurrent !== $catOrderMaterial ) {
		$sqlUpdatePosition = "update flc_product_category set CatOrder = CatOrder+1 where CatOrder >= $catOrderHook";
		// if (!mysql_query($sqlUpdatePosition)) {
 	// 		exit($sqlUpdatePosition.'--Can not update position after.');
		// }
	}

	// Check if edit category have sub
	$sqlGetSubCategoryInfo = "select * from flc_product_category where CatUnder = $catId;";
	$rsGetSubCategoryInfo = mysql_query($sqlGetSubCategoryInfo);
	if ( $rsGetSubCategoryInfo && mysql_num_rows( $rsGetSubCategoryInfo ) > 0 ) {
		$listIdCatChangeToSub = array();
		while ( $subCategoryItem = mysql_fetch_array($rsGetSubCategoryInfo) ) {
			$listIdCatChangeToSub[] = $subCategoryItem['CategoryID'];
		}
		$listIdCatChangeToSubFormat = implode(",", $listIdCatChangeToSub);
		$sqlUpdateSubCat = "update flc_product_category set CatUnder = '$catParent' where CategoryID IN ($listIdCatChangeToSubFormat);";
		mysql_query($sqlUpdateSubCat);
	}

	
	
	// End change sort here
	$sqlUpdateCat = "update flc_product_category set CategoryNameJP = '$catNameJp', CategoryNameVN = '$catNameVn', CategoryNameEN = '$catNameEn', DescJP = '$catDescJp', DescVN = '$catDescVn', DescEN = '$catDescEn', CatPos = '$catLevel', CatUnder = '$catParent', CatOrder = '$catOrderMaterial' where CategoryID = $catId;";
	if (!mysql_query($sqlUpdateCat)) {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit();
	}


	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_products_categorys_manager.php?start=0\">";
	exit();
?>

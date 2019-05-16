<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$product_name_key = $_POST['product_name_key'];
	$product_sku_key = $_POST['product_sku_key'];
	$cat_key = $_POST['cat_key'];
	$sup_key = $_POST['sup_key'];

	$_SESSION['vsearchword'] = $product_name_key;


	$sql =  "select * from flc_products where ";
	$sqlRule = "";
	$haveSqlRule = false;

	if ($product_sku_key !== "") {
		$sqlRule = $sqlRule." ProductID = '$product_sku_key' ";
		$haveSqlRule = true;
	}

	if ($product_name_key !== "") {
		if ($haveSqlRule) {
			$sqlRule = $sqlRule." and (ProductNameEN like '%$product_name_key%' or ProductNameJP like '%$product_name_key%' or ProductNameVN like '%$product_name_key%') ";
		} else {
			$sqlRule = $sqlRule." (ProductNameEN like '%$product_name_key%' or ProductNameJP like '%$product_name_key%' or ProductNameVN like '%$product_name_key%') ";
		}
		$haveSqlRule = true;
	}

	if ($cat_key !== "") {
		if ($haveSqlRule) {
			$sqlRule = $sqlRule." and CategoryID = '$cat_key' ";
		} else {
			$sqlRule = $sqlRule." CategoryID = '$cat_key' ";
		}
		$haveSqlRule = true;
	}

	if ($sup_key !== "") {
		if ($haveSqlRule) {
			$sqlRule = $sqlRule." and SupplierID = '$sup_key' ";
		} else {
			$sqlRule = $sqlRule." SupplierID = '$sup_key' ";
		}
	}

	$sql = $sql.$sqlRule;


	$_SESSION['vsearch'] = $sql;

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_product_search.php?start=0\">";
	exit();
?>

<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];

	$catNameEn = $_POST['t_title_en'];
	$catNameVn = $_POST['t_title_vn'];
	$catNameJp = $_POST['t_title_jp'];

	$catPos = $_POST['t_pos'];
	$catUnder = $_POST['t_under'];

	$catDescEn = $_POST['t_desc_en'];
	$catDescVn = $_POST['t_desc_vn'];
	$catDescJp = $_POST['t_desc_jp'];
	$CatOrderInProPag = $_POST['t_cat_order_product_page'];


	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql0 = "select * from flc_product_category where CatPos = 'm' order by CatOrder DESC  limit 0,1;";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) {
		$catOrder = $dbarr0['CatOrder'] + 1;
	}
	if ($catOrder == '') { $catOrder = 1; }

	if ($catPos != 's') { $catUnder = ""; }

	if ($catPos == 's') { $catOrder = 0; }


	$sqlInsertCat = "insert into flc_product_category (CategoryNameJP, CategoryNameVN, CategoryNameEN, DescJP, DescVN, DescEN, CatPos, CatUnder, CatOrder, CatOrderInProPag)
		values ('$catNameJp', '$catNameVn', '$catNameEn', '$catDescJp', '$catDescVn', '$catDescEn', '$catPos', '$catUnder', '$catOrder', '$CatOrderInProPag');";
	if (!mysql_query($sqlInsertCat)) {
		exit("Can not insert category");
	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_products_categorys_manager.php?start=0\">";
	exit();
?>

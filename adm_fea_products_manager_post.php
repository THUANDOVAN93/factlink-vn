<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$_POST = array_map('mysql_real_escape_string',$_POST);

	$feaCatId = $_POST['t_fea_cat'];
	$qtyFeaProduct = $_POST['t_qty_product'];
	
	mysql_query("use $db_name;");
	
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);

	// --- Check Old Featured Category
	$sqlSelectFeaOld = "select CategoryID from flc_product_category where CatFeatured = 1;";
	$rsSelectFeaOld = mysql_query($sqlSelectFeaOld);
	$feaOldItem = mysql_fetch_array($rsSelectFeaOld);
	$feaCatOldId = $feaOldItem['CategoryID'];
	if ($feaCatOldId) {

		$sqlRemoteFeaOld = "update flc_product_category set CatFeatured = 0 where CategoryID = $feaCatOldId;";
		mysql_query($sqlRemoteFeaOld);
		
	}

	$sqlUpdateFeaPro = "update flc_product_category set CatFeatured = 1 where CategoryID = $feaCatId";
	mysql_query($sqlUpdateFeaPro);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_fea_products_manager.php\">"; exit();
?>
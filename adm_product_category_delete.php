<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");

	$h_admid = $_POST['h_admid'];
	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$catId = $_POST['t_product_cat_id'];
	$sqlDelCat = "delete from flc_product_category where CategoryID = '$catId';";
	if (!mysql_query($sqlDelCat)) {
		exit("Can not delete product product");
	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_products_categorys_manager.php?start=0\">";
	exit();
?>

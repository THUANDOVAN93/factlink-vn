<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_products_manager.html";
	
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
	
	$start = $_GET['start'];
	$limit = 20;

	$sqlPagin = "select p.* from flc_products p left join flc_product_category c on p.CategoryId = c.CategoryId";
	$page =  pagecal($limit, $start, $sqlPagin, "adm_products_manager.php", "");
	$tpl->assign("##page##", $page);

	$sql1 = "select p.*, c.CategoryNameJP,  c.CategoryNameVN,  c.CategoryNameEN from flc_products p left join flc_product_category c on p.CategoryId = c.CategoryId order by p.ProductID desc limit $start,$limit;";
	
	$result1 = mysql_query($sql1);
	// while ($dbarr1 = mysql_fetch_array($result1)) {
	while ($dbarr1 = mysql_fetch_array($result1)) {
		if ( $_COOKIE['vlang'] == 'en' ) {
			$productName = $dbarr1['ProductNameEN'];
			$productDesc = $dbarr1['ProductDescEN'];
			$productCatName = $dbarr1['CategoryNameEN'];
		} elseif ( $_COOKIE['vlang'] == 'vn' ) {
			$productName = $dbarr1['ProductNameVN'];
			$productDesc = $dbarr1['ProductDescVN'];
			$productCatName = $dbarr1['CategoryNameEN'];
		} else {
			$productName = $dbarr1['ProductNameJP'];
			$productDesc = $dbarr1['ProductDescJP'];
			$productCatName = $dbarr1['CategoryNameJP'];
		}
		$productId = $dbarr1['ProductID'];
		$productImg = $dbarr1['Picture'];

		$tpl->assign("##productid##", $productId);
		$tpl->assign("##productname##", $productName);
		$tpl->assign("##productname##", $productName);
		$tpl->assign("##productimg##", $productImg);
		$tpl->assign("##productcatname##", $productCatName);
		$tpl->assign("##start##", $_GET['start']);
		$tpl->assign("##admid##", $currentuserid);
		$tpl->parse ("#####ROW#####", '.rows_1');
	}
	
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
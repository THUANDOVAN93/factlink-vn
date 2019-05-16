<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_products_categorys_manager.html";
	
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
	$limitMainCat = 10;

	$sqlPagin = "select * from flc_product_category where catPos = 'm'";
	$page = pagecal($limitMainCat, $start, $sqlPagin, "adm_products_categorys_manager.php", "");
	$tpl->assign("##page##", $page);

	$sql1 = "select * from flc_product_category where catPos = 'm' order by CatOrder asc limit $start,$limitMainCat;";
	$result1 = mysql_query($sql1);

	while ($dbarr1 = mysql_fetch_array($result1)) {

		if ($_COOKIE['vlang'] == 'en') {
			$catName = $dbarr1['CategoryNameEN'];
			$catDesc = $dbarr1['DescEN'];
		} elseif ($_COOKIE['vlang'] == 'vn') {
			$catName = $dbarr1['CategoryNameVN'];
			$catDesc = $dbarr1['DescVN'];
		} else {
			$catName = $dbarr1['CategoryNameJP'];
			$catDesc = $dbarr1['DescJP'];
		}

		$catId = $dbarr1['CategoryID'];
		$catParentOrder = $dbarr1['CatOrder'];//debug
		

		$tpl->assign ('##productcatId##', $catId);
		$tpl->assign ('##productcatOrder##', $catParentOrder);
		$tpl->assign ('##productcatname##', $catName);
		$tpl->assign("##admid##", $currentuserid);
		$tpl->parse ("#####ROW#####", '.rows_1');


		$catParentId = $dbarr1['CategoryID'];
		$sql2 = "select * from flc_product_category where catPos = 's' and catUnder = $catParentId;";
		$result2 = mysql_query($sql2);
		while ($dbarr2 = mysql_fetch_array($result2)) {

			if ( $_COOKIE['vlang'] == 'en' ) {
				$catName = $dbarr2['CategoryNameEN'];
				$catDesc = $dbarr2['DescEN'];
			} elseif ( $_COOKIE['vlang'] == 'vn' ) {
				$catName = $dbarr2['CategoryNameVN'];
				$catDesc = $dbarr2['DescVN'];
			} else {
				$catName = $dbarr2['CategoryNameJP'];
				$catDesc = $dbarr2['DescJP'];
			}
			$catName = "　・ ".$catName;
			$catId = $dbarr2['CategoryID'];
			

			$tpl->assign ('##productcatId##', $catId);
			$tpl->assign ('##productcatOrder##', '');
			$tpl->assign ('##productcatname##', $catName);
			$tpl->assign("##admid##", $currentuserid);
			$tpl->parse ("#####ROW#####", '.rows_1');

		}
		
	}

	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
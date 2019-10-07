<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_product_category_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));

	$_POST = array_map('mysql_real_escape_string',$_POST);
	$productCatId = (int)$_POST['t_product_cat_id'];

	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$lang = $_COOKIE['vlang'];

	$sqlSelectCat = "select * from flc_product_category where CategoryID = $productCatId";
	$rsSelectCat = mysql_query($sqlSelectCat);
	while ( $catItem = mysql_fetch_array($rsSelectCat) ) {
		$catNameVn = $catItem['CategoryNameVN'];
		$catDescVn = $catItem['DescVN'];
		$catNameEn = $catItem['CategoryNameEN'];
		$catDescEn = $catItem['DescEN'];
		$catNameJp = $catItem['CategoryNameJP'];
		$catDescJp = $catItem['DescJP'];

		$catPos = $catItem['CatPos'];
		$catUnder = $catItem['CatUnder'];
		$catOrder = $catItem['CatOrder'];
		$CatOrderInProPag = $catItem['CatOrderInProPag'];

		$tpl->assign("##catid##", $catItem['CategoryID']);
		$tpl->assign("##catnamevn##", $catNameVn);
		$tpl->assign("##catdescvn##", $catDescVn);
		$tpl->assign("##catnameen##", $catNameEn);
		$tpl->assign("##catdescen##", $catDescEn);
		$tpl->assign("##catnamejp##", $catNameJp);
		$tpl->assign("##catdescjp##", $catDescJp);
		$tpl->assign("##CatOrderInProPag##", $CatOrderInProPag);
	}


	if ($catPos == 'm') {
		$posMain = "checked";
		$posSub = "";
		$catUnderDisable = "disabled";
		$catPosDisable = "";
	} elseif ($catPos == 's') {
		$posMain = "";
		$posSub = "checked";
		$catUnderDisable = "";
		$catPosDisable = "disabled";
	}


	$tpl->assign("##posmain##", $posMain);
	$tpl->assign("##possub##", $posSub);
	$tpl->assign("##catunderdisable##", $catUnderDisable);
	$tpl->assign("##catposdisable##", $catPosDisable);

	// Buil sub selected

	$sql1 = "select * from flc_product_category where CatPos = 'm' and CategoryID != $productCatId order by CatOrder asc;"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
				
		if ($lang == 'en') {
			$mCatName = $dbarr1['CategoryNameEN'];
		} elseif ($lang == 'vn') {
			$mCatName = $dbarr1['CategoryNameVN'];
		} else {
			$mCatName = $dbarr1['CategoryNameJP'];
		}
		$mCatId = $dbarr1['CategoryID'];
		$mCatOrder = $dbarr1['CatOrder'];
		
		if ($mCatId == $catUnder) {
			$mCatSelect = "selected";
			$mCatDefault = "";
		} else {
			$mCatSelect = "";
			$mCatDefault = "selected";
		}

		$tpl->assign("##mcatid##", $mCatId);
		$tpl->assign("##mcatname##", $mCatName);
		$tpl->assign("##mcatdefault##", $mCatDefault);
		$tpl->assign("##mcatselect##", $mCatSelect);
		$tpl->parse ("#####ROW#####", '.main_cat');

		if ( ($catOrder - 1) == $mCatOrder ) {
			$mCatPosBeforeSelect = "selected";
			$mCatPosBeforeDefault = "";
		} else {
			$mCatPosBeforeSelect = "";
			$mCatPosBeforeDefault = "selected";
		}
		$tpl->assign("##mcatid##", $mCatId);
		$tpl->assign("##mcatname##", $mCatName);
		$tpl->assign("##mcatposbeforedefault##", $mCatPosBeforeDefault);
		$tpl->assign("##mcatposbeforeselect##", $mCatPosBeforeSelect);
		$tpl->parse ("#####ROW#####", '.main_position');
	}

	$tpl->assign("##admid##", $currentuserid);
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
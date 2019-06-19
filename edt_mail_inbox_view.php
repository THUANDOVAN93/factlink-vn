<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_mail_inbox_view.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$inrid = $_GET['id'];
	$pageid = $_GET['pageid'];
	$memid = $_SESSION['vmd'];
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vmd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$sql1 = "select * from flc_mail where mal_id = '$inrid';";
	//$sql1 = "select m.*, p.ProductNameEN from flc_mail m, flc_products p where mal_id = '$inrid' and m.product_id = p.ProductID;";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
	
		$memid = $dbarr1['mem_id']; if ($_SESSION['vmd'] != $memid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }
		$inrsubject = $dbarr1['mal_subj'];
		$inrcontent = html($dbarr1['mal_detail']);
		$inrcompany = $dbarr1['mal_company'];
		$inrdepartment = $dbarr1['mal_department'];
		$inrname = $dbarr1['mal_from_name'];
		$inrmail = $dbarr1['mal_from_mail'];
		$inrtel = $dbarr1['mal_tel'];
		$inrfax = $dbarr1['mal_fax'];
		$inrproductId = $dbarr1['product_id'];
	}

	if (isset($inrproductId) && !empty($inrproductId)) {
		$sqlGetProduct = "select ProductNameEN from flc_products where ProductID = '$inrproductId';";
		$rsGetProduct = mysql_query($sqlGetProduct);
		while ( $productItem = mysql_fetch_array($rsGetProduct) ) {
			$productName = $productItem['ProductNameEN'];
		}
	}
	
	$sql2 = "update flc_mail set  mal_status = '', mal_warning = '', mal_warningdate = '' where mal_id = '$inrid';";
	$result2 = mysql_query($sql2);
	
	$tpl->assign("##pageid##", $pageid);
	$tpl->assign("##inrid##", $inrid);
	$tpl->assign("##inrsubject##", $inrsubject);
	$tpl->assign("##inrcontent##", $inrcontent);
	$tpl->assign("##inrcompany##", $inrcompany);
	$tpl->assign("##inrproduct##", $productName);
	$tpl->assign("##inrdepartment##", $inrdepartment);
	$tpl->assign("##inrname##", $inrname);
	$tpl->assign("##inrtel##", $inrtel);
	$tpl->assign("##inrfax##", $inrfax);
	$tpl->assign("##inrmail##", $inrmail);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
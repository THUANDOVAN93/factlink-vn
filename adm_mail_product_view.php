<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_mail_product_view.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$inrid = $_GET['id'];
	
	// --- Global Template Section	
	//include_once("./include/global_edtvalue.php");
	include_once("./include/global_admvalue.php");
	
	$sql1 = "select m.*, p.ProductNameJP, p.ProductNameVN, p.ProductNameEN  from flc_mail m, flc_products p where mal_id = '$inrid' and m.product_id = p.ProductID;";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
	
		$mem_id = $dbarr1['mem_id'];
		$product_id = $dbarr1['product_id'];
		$inrsubject = $dbarr1['mal_subj'];
		$inrcontent = html($dbarr1['mal_detail']);
		$inrcompany = $dbarr1['mal_company'];
		$inrname = $dbarr1['mal_from_name'];
		$inrmail = $dbarr1['mal_from_mail'];
		$inrtel = $dbarr1['mal_tel'];
		$inrfax = $dbarr1['mal_fax'];
		$mal_id = $dbarr1['mal_id'];

		if ($_COOKIE['vlang'] == 'en') {
			$product_name = $dbarr1['ProductNameEN'];
		} elseif ($_COOKIE['vlang'] == 'vn') {
			$product_name = $dbarr1['ProductNameVN'];
		} else {
			$product_name = $dbarr1['ProductNameJP'];
		}
	}
	
	$tpl->assign("##inrid##", $inrid);
	$tpl->assign("##inrsubject##", $inrsubject);
	$tpl->assign("##inrcontent##", $inrcontent);
	$tpl->assign("##inrcompany##", $inrcompany);
	$tpl->assign("##inrname##", $inrname);
	$tpl->assign("##inrtel##", $inrtel);
	$tpl->assign("##inrfax##", $inrfax);
	$tpl->assign("##inrmail##", $inrmail);
	$tpl->assign("##mal_id##", $mal_id);
	$tpl->assign("##mem_id##", $mem_id);
	$tpl->assign("##productname##", $product_name);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
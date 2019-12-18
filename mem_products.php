<?php 
	
	session_start();
	
												
	ini_set("session.gc_maxlifetime", "18000");
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "mem_structure.html"; 
	$url2 = "mem_products.html"; 
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");

	$_GET = array_map('mysql_real_escape_string',$_GET);

	$memid = $_GET['id'];
	$pagid = $_GET['page'];
	$langcode = $_GET['lang'];
	$catIdGet = $_GET['cat'];
	
	// --- Global Template Section	
	include_once("./include/global_memvalue.php");
	
	$sql1 = "select * from flc_member where mem_id = '$memid';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($dbarr1['mem_status'] == 'd') { if ($_SESSION['vp'] != 'exe' && $_SESSION['vp'] != 'adm') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } }
		
		$memcomnameen = $dbarr1['mem_comname_en'];
		$memcomnamejp = $dbarr1['mem_comname_jp'];
		$memcomnamevn = $dbarr1['mem_comname_vn'];
		$memsubdescen = $dbarr1['mem_subdesc_en'];
		$memsubdescjp = $dbarr1['mem_subdesc_jp'];
		$memsubdescvn = $dbarr1['mem_subdesc_vn'];
		$memfooteren = $dbarr1['mem_footer_en'];
		$memfooterjp = $dbarr1['mem_footer_jp'];
		$memfootervn = $dbarr1['mem_footer_vn'];
		$memtemplate = $dbarr1['mem_template'];
		$memfolder = $dbarr1['mem_folder'];
		$memseocom = $dbarr1['mem_seocomdesc'];
		$memseokey = $dbarr1['mem_seokeyword'];
		$memstatus = $dbarr1['mem_status'];
	
	}	
	
	$sql2 = "select * from flc_template_main where tpm_id = '$memtemplate';";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) { $tpmcode = $dbarr2['tpm_name_file']; } if ($tpmcode == '') { $tpmcode = "red"; }
	
	
	$sql3 = "select * from flc_page where mem_id = '$memid' and pag_type = 'pro';";
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) { $prfshowid = $dbarr3['pag_id']; $prfshowen = $dbarr3['pag_show_en']; $prfshowjp = $dbarr3['pag_show_jp']; $prfshowvn = $dbarr3['pag_show_vn']; }
	
	if ($langcode == 'en') { if ($prfshowen != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } }
	else if ($langcode == 'jp') { if ($prfshowjp != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } }
	else if ($langcode == 'vn') { if ($prfshowvn != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } }
	else { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); }
	
	
	$sql4 = "select * from flc_page where mem_id = '$memid' and pag_id = '$pagid';";
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) {
		
		$pagcheck = "t";
		
		if ($dbarr4['pag_status'] == 'd') { if ($_SESSION['vp'] != 'exe' && $_SESSION['vp'] != 'adm') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } }
		
		if ($dbarr4['pag_type'] != 'pro') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); }
		
		if ($langcode == 'en' && $dbarr4['pag_show_en'] != 't') { 
			if ($prfshowen == 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_products.php?id=".$memid."&page=".$prfshowid."&lang=en&start=0\">"; exit(); }
			else { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } 
		}
		
		if ($langcode == 'jp' && $dbarr4['pag_show_jp'] != 't') { 
			if ($prfshowjp == 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_products.php?id=".$memid."&page=".$prfshowid."&lang=jp&start=0\">"; exit(); }
			else { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } 
		}
		
		if ($langcode == 'vn' && $dbarr4['pag_show_vn'] != 't') { 
			if ($prfshowvn == 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_products.php?id=".$memid."&page=".$prfshowid."&lang=vn&start=0\">"; exit(); }
			else { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php?id\">"; exit(); } 
		}
		
		if ($dbarr4['pag_show_en'] == 't' || $prfshowen == 't') { $langen = "<a href=\"mem_products.php?id=".$memid."&page=".$pagid."&lang=en&start=0\"><img src=\"images/tpl_".$memlangpicen."\" title=\"English\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
		else { $langen = "<img src=\"images/tpl_en_00.png\" width=\"24\" height=\"24\" border=\"0\" />"; }
		
		if ($dbarr4['pag_show_jp'] == 't' || $prfshowjp == 't') { $langjp = "<a href=\"mem_products.php?id=".$memid."&page=".$pagid."&lang=jp&start=0\"><img src=\"images/tpl_".$memlangpicjp."\" title=\"日本語\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
		else { $langjp = "<img src=\"images/tpl_jp_00.png\" width=\"24\" height=\"24\" border=\"0\" />"; }
		
		if ($dbarr4['pag_show_vn'] == 't' || $prfshowvn == 't') { $langvn = "<a href=\"mem_products.php?id=".$memid."&page=".$pagid."&lang=vn&start=0\"><img src=\"images/tpl_".$memlangpicvn."\" title=\"Việt Nam\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
		else { $langvn = "<img src=\"images/tpl_vn_00.png\" width=\"24\" height=\"24\" border=\"0\" />"; }
		
		$pagpagetitleen = $dbarr4['pag_pagetitle_en'];
		$pagpagetitlejp = $dbarr4['pag_pagetitle_jp'];
		$pagpagetitlevn = $dbarr4['pag_pagetitle_vn'];
		$pagtitleen = $dbarr4['pag_title_en'];
		$pagtitlejp = $dbarr4['pag_title_jp'];
		$pagtitlevn = $dbarr4['pag_title_vn'];
		$pagtitlecolor = "#".$dbarr4['pag_title_color'];
		$pagdetailen = $dbarr4['pag_detail_en'];
		$pagdetailjp = $dbarr4['pag_detail_jp'];
		$pagdetailvn = $dbarr4['pag_detail_vn'];
		$pagimage = $dbarr4['pag_image'];
		$pagimagewidth = $dbarr4['pag_image_width'];
		$pagimagelink = $dbarr4['pag_image_link'];
		$pagimageside = $dbarr4['pag_image_side']; 
		if ($pagimageside == 'r') { $imgside = "colimg-defright"; $imgsidefull = "colimg-defright-full"; } else { $imgside = "colimg-defleft"; $imgsidefull = "colimg-defleft-full"; }
		
		if ($pagimage == 't') { 
			
			$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-P.jpg";
			if ($pagimagewidth == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $pagimagewidth; }
			if ($imgwidth > 760) { $imgwidth = 760; }
			if ($imgwidth >= 755) { $imgclass = $imgsidefull; } else { $imgclass = $imgside; } 
			$pagimage = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" />"; 
			if ($pagimagelink == 't') { $pagimage = "<a href=\"".$imgpath."\" target=\"_blank\">".$pagimage."</a>"; }
		}
		
	}
	
	if ($pagcheck != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); }
	
	// language
	if ($langcode == 'en') { 
		$memsubdesc = $memsubdescen; 
		$memfooter = $memfooteren;
		$memcomname = $memcomnameen;
		$pagpagetitle = $pagpagetitleen;
		$pagtitle = $pagtitleen;
		$pagdetail = $pagdetailen;
		
	} 
	
	else if ($langcode == 'vn') { 
		$memsubdesc = $memsubdescvn; 
		$memfooter = $memfootervn;
		$memcomname = $memcomnamevn;
		$pagpagetitle = $pagpagetitlevn;
		$pagtitle = $pagtitlevn;
		$pagdetail = $pagdetailvn;
		
	} 
	
	else { 
		$memsubdesc = $memsubdescjp; 
		$memfooter = $memfooterjp;
		$memcomname = $memcomnamejp;
		$pagpagetitle = $pagpagetitlejp;
		$pagtitle = $pagtitlejp;
		$pagdetail = $pagdetailjp;
		
	} 
	
	$pagtitle = "<font color=\"".$pagtitlecolor."\"><h2 class=\"h2_title\">".subhtml($pagtitle)."</h2></font>";
	$pagdetail = $pagimage.$pagtitle.html($pagdetail);

	// Render Product List
	$start = $_GET['start'];
	if (empty($start)) {
		$start = 0;
	}
	$limit = 6; // limit category
	
	

	$productList = array();

	// Router single category
	if ( isset($catIdGet) && !empty($catIdGet) ) {

		$sqlSelectProductsPagin = "select p.ProductID from flc_products p, flc_product_category c where SupplierId = '$memid' and p.CategoryID = c.CategoryID and c.CategoryID = $catIdGet";
		
		$page = "";

		$tpl->assign("##page##", $page);

		$sqlSelectProducts = "select p.*, c.CategoryNameJP, c.CategoryNameVN, c.CategoryNameEN from flc_products p, flc_product_category c where SupplierId = '$memid' and p.CategoryID = c.CategoryID and c.CategoryID = $catIdGet order by c.CategoryID desc";

		$rsProducts = mysql_query($sqlSelectProducts);

		for($i = 0; $productList[$i] = mysql_fetch_array($rsProducts); $i++);
		array_pop($productList);

		$sourceImage = 'home/'.$memfolder.'/products/';
		foreach ($productList as $key => $productItem) {

			if ( $langcode == 'en' ) {
				$productName = $productItem['ProductNameEN'];
				$catName = $productItem['CategoryNameEN'];
			} else if ( $langcode == 'vn' ) {
				$productName = $productItem['ProductNameVN'];
				$catName = $productItem['CategoryNameVN'];
			} else {
				$productName = $productItem['ProductNameJP'];
				$catName = $productItem['CategoryNameJP'];
			}

			// Bulid image link
			$productId = $productItem['ProductID'];
			$imgLink = $sourceImage.$productId.'-L.jpg';

			if ( $productList[$key]['CategoryID'] ==  $productList[$key-1]['CategoryID']) {
				$tpl->assign("##classcat##", "none");
			} else {
				$tpl->assign("##classcat##", "block");
			}

			// Bulid product link
			$proLink = "product_detail.php?proid=".$productId;

			// Bulid contact link
			$contactSupLink = "contact_supplier.php?pid=".$productId;

			$showMore = "";
			
			$tpl->assign("##showmore##", $showMore);
			$tpl->assign("##catname##", $catName);
			$tpl->assign("##productname##", $productName);
			$tpl->assign("##productimagelink##", $imgLink);
			$tpl->assign("##productdetaillink##", $proLink);
			$tpl->assign("##contactsuplink##", $contactSupLink);
			$tpl->parse ("#####ROW#####", '.rows_products');

		}

		unset($productList);
		unset($lastProductOfCat);

	} else {

		$sqlSelectProductsPagin = "select p.CategoryID from flc_products p, flc_product_category c where p.SupplierId = '$memid' and p.CategoryID = c.CategoryID group by c.CategoryID";
		$page = pagecal($limit, $start, $sqlSelectProductsPagin, "mem_products.php", "?id=".$memid."&page=".$pagid."&lang=".$langcode);

		$tpl->assign("##page##", $page);

		$sqlGetCategory = "select p.CategoryID from flc_products p, flc_product_category c where p.SupplierId = '$memid' and p.CategoryID = c.CategoryID group by c.CategoryID order by c.CatOrderInProPag desc limit $start,$limit;";
		$rsGetCategory = mysql_query($sqlGetCategory);
		//$categoryCount = mysql_quer
		$categorys = array();
		while ( $getCategory = mysql_fetch_array($rsGetCategory) ) {
			$categorys[] = $getCategory['CategoryID'];
		}

		foreach ($categorys as $categoryItem) {

			$sqlSelectProducts = "select p.*, c.CategoryNameJP, c.CategoryNameVN, c.CategoryNameEN from flc_products p, flc_product_category c where SupplierId = '$memid' and p.CategoryID = c.CategoryID and c.CategoryID = $categoryItem order by c.CategoryID desc limit 0,4";


			$rsProducts = mysql_query($sqlSelectProducts);
			$totalProductPerCat = mysql_num_rows($rsProducts);

			for($i = 0; $productList[$i] = mysql_fetch_array($rsProducts); $i++);
			array_pop($productList);

			$totalProduct = sizeof($productList);
			$sourceImage = 'home/'.$memfolder.'/products/';
			$lastProductOfCat = end($productList);
			foreach ($productList as $key => $productItem) {

				if ( $langcode == 'en' ) {
					$productName = $productItem['ProductNameEN'];
					$catName = $productItem['CategoryNameEN'];
				} else if ( $langcode == 'vn' ) {
					$productName = $productItem['ProductNameVN'];
					$catName = $productItem['CategoryNameVN'];
				} else {
					$productName = $productItem['ProductNameJP'];
					$catName = $productItem['CategoryNameJP'];
				}

				// Bulid image link
				$productId = $productItem['ProductID'];
				$imgLink = $sourceImage.$productId.'-L.jpg';

				if ( $productList[$key]['CategoryID'] ==  $productList[$key-1]['CategoryID']) {
					$tpl->assign("##classcat##", "none");
				} else {
					$tpl->assign("##classcat##", "block");
				}

				// Bulid product link
				$proLink = "product_detail.php?proid=".$productId;

				// Bulid contact link
				$contactSupLink = "contact_supplier.php?pid=".$productId;

				$showMore = "";
				$catIdForward = $categoryItem;
				if ($productItem == $lastProductOfCat) {
					$showMoreLink = "mem_products.php?id=$memid&page=$pagid&cat=$catIdForward&lang=$langcode&start=$start";
					$showMore = "<td style = \"display : block; text-align: right;\"><a href=\"".$showMoreLink."\">SHOW MORE</a></td>";
				}
				
				$tpl->assign("##showmore##", $showMore);
				$tpl->assign("##catname##", $catName);
				$tpl->assign("##productname##", $productName);
				$tpl->assign("##productimagelink##", $imgLink);
				$tpl->assign("##productdetaillink##", $proLink);
				$tpl->assign("##contactsuplink##", $contactSupLink);
				$tpl->parse ("#####ROW#####", '.rows_products');

			}


			unset($productList);
			unset($lastProductOfCat);
		}
	}

	// Customize CSS For Special Company
	if ($memid == "00001109") {
		$memsubdesc = "<p style=\"margin: 0;padding-left: 25px;line-height: 18px;\">".$memsubdesc."</p>";
		$memcomname = "<span style=\"display: inline-block;width: 25px;\"></span>".$memcomname;
	}
	if (!empty($memPackage) && !empty($pagpagetitle)) {
		$metaTitle = $pagpagetitle;
	}
	
	$tpl->assign("##metaTitle##", $metaTitle);
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##pagid##", $pagid);
	$tpl->assign("##pagdetail##", $pagdetail);
	$tpl->assign("##pagpagetitle##", $pagpagetitle);
	$tpl->assign("##pagtitlecolor##", $pagtitlecolor);
	$tpl->assign("##memcomname##", $memcomname);
	$tpl->assign("##memsubdesc##", $memsubdesc);
	$tpl->assign("##memfooter##", $memfooter);
	$tpl->assign("##memseocom##", $memseocom);
	$tpl->assign("##memseokey##", $memseokey);
	$tpl->assign("##tpmcode##", $tpmcode);
	$tpl->assign("##langcode##", $langcode);
	$tpl->assign("##langen##", $langen);
	$tpl->assign("##langjp##", $langjp);
	$tpl->assign("##langvn##", $langvn);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
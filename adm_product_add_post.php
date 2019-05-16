<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);

	$h_admid = $_POST['h_admid'];
	$t_productName_en = $_POST['t_title_en'];
	$t_productName_jp = $_POST['t_title_jp'];
	$t_productName_vn = $_POST['t_title_vn'];
	$t_productCatId = $_POST['t_product_cat'];
	$t_productSupplierId = $_POST['t_supplier'];
	$t_image = $_FILES['t_image'];

	$t_imagethumb1 = $_FILES['t_image_thumb_01'];
	$t_imagethumb2 = $_FILES['t_image_thumb_02'];
	$t_imagethumb3 = $_FILES['t_image_thumb_03'];
	$t_imagethumb4 = $_FILES['t_image_thumb_04'];
	$t_productDes_en = $_POST['t_detail_en'];
	$t_productDes_jp = $_POST['t_detail_jp'];
	$t_productDes_vn = $_POST['t_detail_vn'];


	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	// --- Check Have Product Page

	$sqlCountProductPage = "select count(*) as count from flc_page where mem_id = '$t_productSupplierId' and pag_type = 'pro';";
	$rsNumProductPage = mysql_query($sqlCountProductPage);
	$numProductPage = mysql_fetch_array($rsNumProductPage);
	$totalProductPage = (int)$numProductPage['count'];

	// --- Check First Product
	// $sqlCountProduct = "select count(*) as count from flc_products where SupplierID = '$t_productSupplierId'";
	// $rsNumProduct = mysql_query($sqlCountProduct);
	// $numProduct = mysql_fetch_array($rsNumProduct);
	// $totalProduct = (int)$numProduct['count'];

	// --- Check Order Page
	$sqlGetBotPage = "select pag_sort from flc_page where mem_id = '$t_productSupplierId' order by pag_sort desc limit 0,1;";
	$rsGetBotPage = mysql_query($sqlGetBotPage);
	$fetchGetBotPage = mysql_fetch_array($rsGetBotPage);
	$numSortBotPage = (int)$fetchGetBotPage['pag_sort'];
	$sortProductPage = $numSortBotPage-1;

	// --- Add Product Page

	if ($totalProductPage == 0) {
		$sqlInsertProductPage = "insert into flc_page (mem_id, pag_type, pag_name_en, pag_name_jp, pag_name_vn, pag_sort, pag_show_en, pag_show_jp, pag_show_vn)
						values ('$t_productSupplierId', 'pro', 'Products', '製品', 'Sản Phẩm', $sortProductPage, 't', 't', 't');";

		if (!mysql_query($sqlInsertProductPage)) {
			exit("Can not insert product page");
		}
	}


	$sqlInsertProduct = "insert into flc_products (CategoryID, SupplierID, ProductNameJP, ProductNameVN, ProductNameEN, ProductDescJP, ProductDescVN, ProductDescEN)
					values ('$t_productCatId', '$t_productSupplierId', '$t_productName_jp', '$t_productName_vn', '$t_productName_en', '$t_productDes_jp', '$t_productDes_vn', '$t_productDes_en');";
	if (mysql_query($sqlInsertProduct)) {
		$productIdInserted = mysql_insert_id($link);
	} else {
		exit("Can not insert product");
	}
	$sqlSupplierInfo = "select mem_folder from flc_member where mem_id = '$t_productSupplierId' limit 0,1;";
	$result3 = mysql_query($sqlSupplierInfo);
	$row = mysql_fetch_assoc($result3);
	$supplierFolder = $row['mem_folder'];

	// CREATE IMAGE FILE PRODUCT
	if ($t_image['size'] > 0) {
		$newfile = $productIdInserted."-L.jpg";
		$imgpath = "home/".$supplierFolder."/products";
		$imgpathFull = $imgpath.'/'.$newfile;
		if (!file_exists($imgpath)) {
		    mkdir($imgpath, 0777, true);
		    move_uploaded_file($t_image['tmp_name'], $imgpathFull);
		} else {
			move_uploaded_file($t_image['tmp_name'], $imgpathFull);
		}
	}

	// CREATE IMAGE THUMBNAIL PRODUCT

	for ($i=1; $i < 5; $i++) { 
		
		if (${'t_imagethumb'.$i}['size'] > 0) {
			$newfile = $productIdInserted."-".$i."-T.jpg";
			$imgpath = "home/".$supplierFolder."/products";
			$imgpathFull = $imgpath.'/'.$newfile;
			if (!file_exists($imgpath)) {
			    mkdir($imgpath, 0777, true);
			    move_uploaded_file(${'t_imagethumb'.$i}['tmp_name'], $imgpathFull);
			} else {
				move_uploaded_file(${'t_imagethumb'.$i}['tmp_name'], $imgpathFull);
			}
		}

	}
	
	// END BY THUANDO

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_products_manager.php?start=0\">";
	exit();
?>

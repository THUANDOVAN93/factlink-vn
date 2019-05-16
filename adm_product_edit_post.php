<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");

	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$t_product_id = $_POST['t_product_id'];

	$t_productName_en = $_POST['t_title_en'];
	$t_productName_jp = $_POST['t_title_jp'];
	$t_productName_vn = $_POST['t_title_vn'];

	$t_product_status = (int)$_POST['t_product_status'];


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

	$sqlGetSupCr = "select p.SupplierID, m.mem_folder from flc_products p, flc_member m where p.ProductID = $t_product_id and p.SupplierID = m.mem_id;";
	$rsGetSupCr = mysql_query($sqlGetSupCr);
	$getSupCr = mysql_fetch_array($rsGetSupCr);

	$memFolderCr = $getSupCr['mem_folder'];
	$supIdCr = sprintf("%08s", $getSupCr['SupplierID']);

	$sqlUpdateProduct = "update `flc_products` set `CategoryID`= '$t_productCatId',`SupplierID`= '$t_productSupplierId',`ProductNameJP`= '$t_productName_jp',`ProductNameVN`= '$t_productName_vn',`ProductNameEN`= '$t_productName_en',`ProductDescJP`= '$t_productDes_jp',`ProductDescVN`= '$t_productDes_vn',`ProductDescEN`= '$t_productDes_en',`Status`= $t_product_status where `ProductID` = '$t_product_id';";
	if (!mysql_query($sqlUpdateProduct)) {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit();
	}



	// UPDATE IMAGE PRODUCT

	$sqlGetSup = "select mem_folder from flc_member where mem_id = $t_productSupplierId";
	$rsGetSup = mysql_query($sqlGetSup);
	$getSup =  mysql_fetch_array($rsGetSup);
	$supplierFolder = $getSup['mem_folder'];
	
	$product_id = (int)$t_product_id;
	$sourceMedia = "home/".$supplierFolder."/products";
	$sourceMediaOld = "home/".$memFolderCr."/products";

	// Check if edit is new supplier MISS UPLOAD NEWFILE PRODUCT FOR sub

	if ($supIdCr !== $t_productSupplierId) {

		// Remove product image old supplier
		$oldfile = $product_id."-L.jpg";
		$imgPathOld = $sourceMediaOld.'/'.$oldfile;
		$imgPathNew = $sourceMedia.'/'. $product_id."-L.jpg";

		if (!is_dir($sourceMedia)) {
			mkdir($sourceMedia, 0777, true);
		}

		if (is_file($imgPathOld)) {

			if (!rename($imgPathOld, $imgPathNew)) {
				exit("rename fail");
			}
		
		}

		// Remove product thumbnail old supplier
		for ($i=1; $i < 5; $i++) { 
			
			$oldfile = $product_id."-".$i."-T.jpg";
			$imgPathOld = $sourceMediaOld.'/'.$oldfile;
			$imgPathNew = $sourceMedia.'/'.$product_id."-".$i."-T.jpg";

			if (is_file($imgPathOld)) {

				if (!rename($imgPathOld, $imgPathNew)) {
					exit("rename fail");
				}
			}
		}

		
	} 

	if ($t_image['size'] > 0) {

		$newfile = $product_id."-L.jpg";
		$imgpathFull = $sourceMedia.'/'.$newfile;
		if (!file_exists($sourceMedia)) {
		    mkdir($sourceMedia, 0777, true);
		    move_uploaded_file($t_image['tmp_name'], $imgpathFull);
		} else {
			move_uploaded_file($t_image['tmp_name'], $imgpathFull);
		}

	}

	// UPDATE 4 THUMBNAIL PRODUCT

	for ($i=1; $i < 5; $i++) { 
		
		if (${'t_imagethumb'.$i}['size'] > 0) {
			$newfile = $product_id."-".$i."-T.jpg";
			$imgpathFull = $sourceMedia.'/'.$newfile;
			if (!file_exists($sourceMedia)) {

			    mkdir($sourceMedia, 0777, true);
			    move_uploaded_file(${'t_imagethumb'.$i}['tmp_name'], $imgpathFull);

			} else {

				move_uploaded_file(${'t_imagethumb'.$i}['tmp_name'], $imgpathFull);

			}
		}

	}

	




	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_products_manager.php?start=0\">";
	exit();
?>

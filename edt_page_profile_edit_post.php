<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_memid = $_POST['h_memid'];
	$h_langcode = $_POST['h_langcode'];
	$h_pagid = $_POST['h_pagid'];
	$h_prfid = $_POST['h_prfid'];
	$h_memcat = $_POST['h_memcat'];
	$h_memsort = $_POST['h_memsort'];
	$h_mempackage = $_POST['h_mempackage'];
	//$t_setlang = $_POST['t_setlang'];
	$t_pagname = addslashes($_POST['t_pagname']);
	$t_pagpagetitle = addslashes($_POST['t_pagpagetitle']);
	$t_pagsort = addslashes($_POST['t_pagsort']);
	$t_clf = addslashes($_POST['t_clf']);
	$t_clfdetail = addslashes($_POST['t_clfdetail']);
	$t_pagtitle = addslashes($_POST['t_pagtitle']);
	$t_pagdetail = addslashes($_POST['t_pagdetail']);
	$t_image = $_FILES['t_image'];
	$t_imagewidth = $_POST['t_imagewidth'];
	$t_imageside = $_POST['t_imageside'];
	$t_imagelink = $_POST['t_imagelink'];
	$t_imagedisable = $_POST['t_imagedisable'];
	$t_comname = addslashes($_POST['t_comname']);
	$t_pername = addslashes($_POST['t_pername']);
	$t_posname = addslashes($_POST['t_posname']);
	$t_pername_en = addslashes($_POST['t_pername_en']);
	$t_posname_en = addslashes($_POST['t_posname_en']);
	$t_business = addslashes($_POST['t_business']);
	$t_product = addslashes($_POST['t_product']);
	$t_comaddlab1 = addslashes($_POST['t_comaddlab1']);
	$t_comadd1 = addslashes($_POST['t_comadd1']);
	$t_ine1 = addslashes($_POST['t_ine1']);
	$t_prv1 = addslashes($_POST['t_prv1']);
	$t_cty1 = addslashes($_POST['t_cty1']);
	$t_zip1 = addslashes($_POST['t_zip1']);
	$t_comaddlab2 = addslashes($_POST['t_comaddlab2']);
	$t_comadd2 = addslashes($_POST['t_comadd2']);
	$t_ine2 = addslashes($_POST['t_ine2']);
	$t_prv2 = addslashes($_POST['t_prv2']);
	$t_cty2 = addslashes($_POST['t_cty2']);
	$t_zip2 = addslashes($_POST['t_zip2']);
	$t_comaddlab3 = addslashes($_POST['t_comaddlab3']);
	$t_comadd3 = addslashes($_POST['t_comadd3']);
	$t_ine3 = addslashes($_POST['t_ine3']);
	$t_prv3 = addslashes($_POST['t_prv3']);
	$t_cty3 = addslashes($_POST['t_cty3']);
	$t_zip3 = addslashes($_POST['t_zip3']);
	$t_comaddlab4 = addslashes($_POST['t_comaddlab4']);
	$t_comadd4 = addslashes($_POST['t_comadd4']);
	$t_ine4 = addslashes($_POST['t_ine4']);
	$t_prv4 = addslashes($_POST['t_prv4']);
	$t_cty4 = addslashes($_POST['t_cty4']);
	$t_zip4 = addslashes($_POST['t_zip4']);
	$t_comaddlab5 = addslashes($_POST['t_comaddlab5']);
	$t_comadd5 = addslashes($_POST['t_comadd5']);
	$t_ine5 = addslashes($_POST['t_ine5']);
	$t_prv5 = addslashes($_POST['t_prv5']);
	$t_cty5 = addslashes($_POST['t_cty5']);
	$t_zip5 = addslashes($_POST['t_zip5']);
	$t_comtellab1 = addslashes($_POST['t_comtellab1']);
	$t_comtel1 = addslashes($_POST['t_comtel1']);
	$t_comtellab2 = addslashes($_POST['t_comtellab2']);
	$t_comtel2 = addslashes($_POST['t_comtel2']);
	$t_comtellab3 = addslashes($_POST['t_comtellab3']);
	$t_comtel3 = addslashes($_POST['t_comtel3']);
	$t_comtellab4 = addslashes($_POST['t_comtellab4']);
	$t_comtel4 = addslashes($_POST['t_comtel4']);
	$t_comtellab5 = addslashes($_POST['t_comtellab5']);
	$t_comtel5 = addslashes($_POST['t_comtel5']);
	$t_commaillab1 = addslashes($_POST['t_commaillab1']);
	$t_commail1 = addslashes($_POST['t_commail1']);
	$t_commaillab2 = addslashes($_POST['t_commaillab2']);
	$t_commail2 = addslashes($_POST['t_commail2']);
	$t_commaillab3 = addslashes($_POST['t_commaillab3']);
	$t_commail3 = addslashes($_POST['t_commail3']);
	$t_commaillab4 = addslashes($_POST['t_commaillab4']);
	$t_commail4 = addslashes($_POST['t_commail4']);
	$t_commaillab5 = addslashes($_POST['t_commaillab5']);
	$t_commail5 = addslashes($_POST['t_commail5']);
	$t_url = addslashes($_POST['t_url']);
	$t_establish = addslashes($_POST['t_establishdate']);
	$t_capital = addslashes($_POST['t_capital']);
	$t_comparent = addslashes($_POST['t_comparent']);
	$t_shareholder = addslashes($_POST['t_shareholder']);
	$t_employee = addslashes($_POST['t_employee']);
	$t_accountdate = addslashes($_POST['t_accountdate']);
	$t_bank = addslashes($_POST['t_bank']);
	$t_boi = addslashes($_POST['t_boi']);
	$t_iso = addslashes($_POST['t_iso']);
	$t_valcus = addslashes($_POST['t_valcus']);
	$t_conlab1 = addslashes($_POST['t_conlab1']);
	$t_con1 = addslashes($_POST['t_con1']);
	$t_conlab2 = addslashes($_POST['t_conlab2']);
	$t_con2 = addslashes($_POST['t_con2']);
	$t_conlab3 = addslashes($_POST['t_conlab3']);
	$t_con3 = addslashes($_POST['t_con3']);
	$t_conlab4 = addslashes($_POST['t_conlab4']);
	$t_con4 = addslashes($_POST['t_con4']);
	$t_conlab5 = addslashes($_POST['t_conlab5']);
	$t_con5 = addslashes($_POST['t_con5']);
	$t_footer = addslashes($_POST['t_footer']);

	if ($_SESSION['vmd'] != $h_memid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql0 = "select * from flc_member where mem_id = '$h_memid';";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $memfolder = $dbarr0['mem_folder']; }

	//-----

	if ($h_langcode == 'en') {

		$sql1 = "update flc_page set pag_name_en = '$t_pagname', pag_pagetitle_en = '$t_pagpagetitle', pag_title_color = '$t_clf', pag_profile_color = '$t_clfdetail',
						pag_title_en = '$t_pagtitle', pag_detail_en = '$t_pagdetail', pag_sort = '$t_pagsort', pag_editdate = '$nowdate', pag_edittime = '$nowtime', pag_show_en = 't'
						where pag_id = '$h_pagid';";

		$sql2 = "update flc_member set mem_comname_en = '$t_comname', mem_pername_en = '$t_pername', mem_posname_en = '$t_posname',
						mem_addresslabel1_en = '$t_comaddlab1', mem_address1_en = '$t_comadd1', mem_addressine1 = '$t_ine1', mem_addressprv1 = '$t_prv1', mem_addresscty1 = '$t_cty1', mem_addresszip1 = '$t_zip1',
						mem_addresslabel2_en = '$t_comaddlab2', mem_address2_en = '$t_comadd2', mem_addressine2 = '$t_ine2', mem_addressprv2 = '$t_prv2', mem_addresscty2 = '$t_cty2', mem_addresszip2 = '$t_zip2',
						mem_addresslabel3_en = '$t_comaddlab3', mem_address3_en = '$t_comadd3', mem_addressine3 = '$t_ine3', mem_addressprv3 = '$t_prv3', mem_addresscty3 = '$t_cty3', mem_addresszip3 = '$t_zip3',
						mem_addresslabel4_en = '$t_comaddlab4', mem_address4_en = '$t_comadd4', mem_addressine4 = '$t_ine4', mem_addressprv4 = '$t_prv4', mem_addresscty4 = '$t_cty4', mem_addresszip4 = '$t_zip4',
						mem_addresslabel5_en = '$t_comaddlab5', mem_address5_en = '$t_comadd5', mem_addressine5 = '$t_ine5', mem_addressprv5 = '$t_prv5', mem_addresscty5 = '$t_cty5', mem_addresszip5 = '$t_zip5',
						mem_tellabel1_en = '$t_comtellab1', mem_telnum1 = '$t_comtel1', mem_tellabel2_en = '$t_comtellab2', mem_telnum2 = '$t_comtel2',
						mem_tellabel3_en = '$t_comtellab3', mem_telnum3 = '$t_comtel3', mem_tellabel4_en = '$t_comtellab4', mem_telnum4 = '$t_comtel4',
						mem_tellabel5_en = '$t_comtellab5', mem_telnum5 = '$t_comtel5',
						mem_maillabel1_en = '$t_commaillab1', mem_mail1 = '$t_commail1', mem_maillabel2_en = '$t_commaillab2', mem_mail2 = '$t_commail2',
						mem_maillabel3_en = '$t_commaillab3', mem_mail3 = '$t_commail3', mem_maillabel4_en = '$t_commaillab4', mem_mail4 = '$t_commail4',
						mem_maillabel5_en = '$t_commaillab5', mem_mail5 = '$t_commail5',
						mem_url = '$t_url', mem_establishdate_en = '$t_establish', mem_capital_en = '$t_capital',
						mem_comparent_en = '$t_comparent', mem_shareholder_en = '$t_shareholder', mem_employee_en = '$t_employee', mem_accountdate_en = '$t_accountdate',
						mem_bank_en = '$t_bank', mem_boi_en = '$t_boi', mem_iso_en = '$t_iso', mem_valuecustomer_en = '$t_valcus', mem_business_en = '$t_business',
						mem_product_en = '$t_product',
						mem_contentlabel1_en = '$t_conlab1', mem_content1_en = '$t_con1', mem_contentlabel2_en = '$t_conlab2', mem_content2_en = '$t_con2',
						mem_contentlabel3_en = '$t_conlab3', mem_content3_en = '$t_con3', mem_contentlabel4_en = '$t_conlab4', mem_content4_en = '$t_con4',
						mem_contentlabel5_en = '$t_conlab5', mem_content5_en = '$t_con5', mem_footer_en = '$t_footer' where mem_id = '$h_memid';";

		//if ($t_setlang != 't') { $sql4 = "update flc_page set pag_show_en = '' where mem_id = '$h_memid';"; $result4 = mysql_query($sql4); }

	} else if ($h_langcode == 'vn') {

		$sql1 = "update flc_page set pag_name_vn = '$t_pagname', pag_pagetitle_vn = '$t_pagpagetitle', pag_title_color = '$t_clf', pag_profile_color = '$t_clfdetail',
						pag_title_vn = '$t_pagtitle', pag_detail_vn = '$t_pagdetail', pag_sort = '$t_pagsort', pag_editdate = '$nowdate', pag_edittime = '$nowtime', pag_show_vn = 't'
						where pag_id = '$h_pagid';";

		$sql2 = "update flc_member set mem_comname_vn = '$t_comname', mem_pername_vn = '$t_pername', mem_posname_vn = '$t_posname', mem_pername_en = '$t_pername_en', mem_posname_en = '$t_posname_en',
						mem_addresslabel1_vn = '$t_comaddlab1', mem_address1_vn = '$t_comadd1', mem_addressine1 = '$t_ine1', mem_addressprv1 = '$t_prv1', mem_addresscty1 = '$t_cty1', mem_addresszip1 = '$t_zip1',
						mem_addresslabel2_vn = '$t_comaddlab2', mem_address2_vn = '$t_comadd2', mem_addressine2 = '$t_ine2', mem_addressprv2 = '$t_prv2', mem_addresscty2 = '$t_cty2', mem_addresszip2 = '$t_zip2',
						mem_addresslabel3_vn = '$t_comaddlab3', mem_address3_vn = '$t_comadd3', mem_addressine3 = '$t_ine3', mem_addressprv3 = '$t_prv3', mem_addresscty3 = '$t_cty3', mem_addresszip3 = '$t_zip3',
						mem_addresslabel4_vn = '$t_comaddlab4', mem_address4_vn = '$t_comadd4', mem_addressine4 = '$t_ine4', mem_addressprv4 = '$t_prv4', mem_addresscty4 = '$t_cty4', mem_addresszip4 = '$t_zip4',
						mem_addresslabel5_vn = '$t_comaddlab5', mem_address5_vn = '$t_comadd5', mem_addressine5 = '$t_ine5', mem_addressprv5 = '$t_prv5', mem_addresscty5 = '$t_cty5', mem_addresszip5 = '$t_zip5',
						mem_tellabel1_vn = '$t_comtellab1', mem_telnum1 = '$t_comtel1', mem_tellabel2_vn = '$t_comtellab2', mem_telnum2 = '$t_comtel2',
						mem_tellabel3_vn = '$t_comtellab3', mem_telnum3 = '$t_comtel3', mem_tellabel4_vn = '$t_comtellab4', mem_telnum4 = '$t_comtel4',
						mem_tellabel5_vn = '$t_comtellab5', mem_telnum5 = '$t_comtel5',
						mem_maillabel1_vn = '$t_commaillab1', mem_mail1 = '$t_commail1', mem_maillabel2_vn = '$t_commaillab2', mem_mail2 = '$t_commail2',
						mem_maillabel3_vn = '$t_commaillab3', mem_mail3 = '$t_commail3', mem_maillabel4_vn = '$t_commaillab4', mem_mail4 = '$t_commail4',
						mem_maillabel5_vn = '$t_commaillab5', mem_mail5 = '$t_commail5',
						mem_url = '$t_url', mem_establishdate_vn = '$t_establish', mem_capital_vn = '$t_capital',
						mem_comparent_vn = '$t_comparent', mem_shareholder_vn = '$t_shareholder', mem_employee_vn = '$t_employee', mem_accountdate_vn = '$t_accountdate',
						mem_bank_vn = '$t_bank', mem_boi_vn = '$t_boi', mem_iso_vn = '$t_iso', mem_valuecustomer_vn = '$t_valcus', mem_business_vn = '$t_business',
						mem_product_vn = '$t_product',
						mem_contentlabel1_vn = '$t_conlab1', mem_content1_vn = '$t_con1', mem_contentlabel2_vn = '$t_conlab2', mem_content2_vn = '$t_con2',
						mem_contentlabel3_vn = '$t_conlab3', mem_content3_vn = '$t_con3', mem_contentlabel4_vn = '$t_conlab4', mem_content4_vn = '$t_con4',
						mem_contentlabel5_vn = '$t_conlab5', mem_content5_vn = '$t_con5', mem_footer_vn = '$t_footer' where mem_id = '$h_memid';";

		//if ($t_setlang != 't') { $sql4 = "update flc_page set pag_show_vn = '' where mem_id = '$h_memid';"; $result4 = mysql_query($sql4); }

	} else  {

		$sql1 = "update flc_page set pag_name_jp = '$t_pagname', pag_pagetitle_jp = '$t_pagpagetitle', pag_title_color = '$t_clf', pag_profile_color = '$t_clfdetail',
						pag_title_jp = '$t_pagtitle', pag_detail_jp = '$t_pagdetail', pag_sort = '$t_pagsort', pag_editdate = '$nowdate', pag_edittime = '$nowtime', pag_show_jp = 't'
						where pag_id = '$h_pagid';";

		$sql2 =  "update flc_member set mem_comname_jp = '$t_comname', mem_pername_jp = '$t_pername', mem_posname_jp = '$t_posname', mem_pername_en = '$t_pername_en', mem_posname_en = '$t_posname_en',
						mem_addresslabel1_jp = '$t_comaddlab1', mem_address1_jp = '$t_comadd1', mem_addressine1 = '$t_ine1', mem_addressprv1 = '$t_prv1', mem_addresscty1 = '$t_cty1', mem_addresszip1 = '$t_zip1',
						mem_addresslabel2_jp = '$t_comaddlab2', mem_address2_jp = '$t_comadd2', mem_addressine2 = '$t_ine2', mem_addressprv2 = '$t_prv2', mem_addresscty2 = '$t_cty2', mem_addresszip2 = '$t_zip2',
						mem_addresslabel3_jp = '$t_comaddlab3', mem_address3_jp = '$t_comadd3', mem_addressine3 = '$t_ine3', mem_addressprv3 = '$t_prv3', mem_addresscty3 = '$t_cty3', mem_addresszip3 = '$t_zip3',
						mem_addresslabel4_jp = '$t_comaddlab4', mem_address4_jp = '$t_comadd4', mem_addressine4 = '$t_ine4', mem_addressprv4 = '$t_prv4', mem_addresscty4 = '$t_cty4', mem_addresszip4 = '$t_zip4',
						mem_addresslabel5_jp = '$t_comaddlab5', mem_address5_jp = '$t_comadd5', mem_addressine5 = '$t_ine5', mem_addressprv5 = '$t_prv5', mem_addresscty5 = '$t_cty5', mem_addresszip5 = '$t_zip5',
						mem_tellabel1_jp = '$t_comtellab1', mem_telnum1 = '$t_comtel1', mem_tellabel2_jp = '$t_comtellab2', mem_telnum2 = '$t_comtel2',
						mem_tellabel3_jp = '$t_comtellab3', mem_telnum3 = '$t_comtel3', mem_tellabel4_jp = '$t_comtellab4', mem_telnum4 = '$t_comtel4',
						mem_tellabel5_jp = '$t_comtellab5', mem_telnum5 = '$t_comtel5',
						mem_maillabel1_jp = '$t_commaillab1', mem_mail1 = '$t_commail1', mem_maillabel2_jp = '$t_commaillab2', mem_mail2 = '$t_commail2',
						mem_maillabel3_jp = '$t_commaillab3', mem_mail3 = '$t_commail3', mem_maillabel4_jp = '$t_commaillab4', mem_mail4 = '$t_commail4',
						mem_maillabel5_jp = '$t_commaillab5', mem_mail5 = '$t_commail5',
						mem_url = '$t_url', mem_establishdate_jp = '$t_establish', mem_capital_jp = '$t_capital',
						mem_comparent_jp = '$t_comparent', mem_shareholder_jp = '$t_shareholder', mem_employee_jp = '$t_employee', mem_accountdate_jp= '$t_accountdate',
						mem_bank_jp = '$t_bank', mem_boi_jp = '$t_boi', mem_iso_jp = '$t_iso', mem_valuecustomer_jp = '$t_valcus', mem_business_jp = '$t_business',
						mem_product_jp = '$t_product',
						mem_contentlabel1_jp = '$t_conlab1', mem_content1_jp = '$t_con1', mem_contentlabel2_jp = '$t_conlab2', mem_content2_jp = '$t_con2',
						mem_contentlabel3_jp = '$t_conlab3', mem_content3_jp = '$t_con3', mem_contentlabel4_jp = '$t_conlab4', mem_content4_jp = '$t_con4',
						mem_contentlabel5_jp = '$t_conlab5', mem_content5_jp = '$t_con5', mem_footer_jp = '$t_footer' where mem_id = '$h_memid';";

		//if ($t_setlang != 't') { $sql4 = "update flc_page set pag_show_jp = '' where mem_id = '$h_memid';"; $result4 = mysql_query($sql4); }

	}

	$result1 = mysql_query($sql1);
	$result2 = mysql_query($sql2);

	// image

	if ($_FILES['t_image']['size'] > 0) {
		$t_imagedisable = "";
		$newfile = $h_memid."-".$h_pagid."-P.jpg";
		$imgpath = "home/".$memfolder."/".$newfile;
		move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath);
		$old_umask = umask(0); chmod($imgpath, 0777); umask($old_umask);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth == '') { $t_imagewidth = $imgdms[0]; }
		$sql3 = "update flc_page set pag_image = 't' where pag_id = '$h_pagid';";
		$result3 = mysql_query($sql3);
	}

	if ($t_imagedisable == 't') { $sql5 = "update flc_page set pag_image = '', pag_image_width = '', pag_image_link = '', pag_image_side = '' where pag_id = '$h_pagid';"; }
	else { $sql5 = "update flc_page set pag_image_width = '$t_imagewidth', pag_image_link = '$t_imagelink', pag_image_side = '$t_imageside' where pag_id = '$h_pagid';"; }
	$result5 = mysql_query($sql5);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_page.php\">";

	exit();
?>

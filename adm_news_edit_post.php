<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$h_nwsid = $_POST['h_nwsid'];
	$t_nwg = $_POST['t_nwg'];
	$t_nwe = $_POST['t_nwe'];
	$t_title_en = addslashes($_POST['t_title_en']);
	$t_title_jp = addslashes($_POST['t_title_jp']);
	$t_title_vn = addslashes($_POST['t_title_vn']);
	$t_detail_en = addslashes($_POST['t_detail_en']);
	$t_detail_jp = addslashes($_POST['t_detail_jp']);
	$t_detail_vn = addslashes($_POST['t_detail_vn']);
	$t_memo = addslashes($_POST['t_memo']);
	$t_day = $_POST['t_day'];
	$t_month = $_POST['t_month']; $t_month = addzero2(mcvsubtonum($t_month));
	$t_year = $_POST['t_year'];
	$t_show = $_POST['t_show'];
	$t_status = $_POST['t_status'];

	$metaTitleEN = "";
	$metaTitleJP = "";
	$metaTitleVN = "";
	if (!empty($_POST['meta_title_en'])) {
		$metaTitleEN = addslashes($_POST['meta_title_en']);
	}
	if (!empty($_POST['meta_title_jp'])) {
		$metaTitleJP = addslashes($_POST['meta_title_jp']);
	}
	if (!empty($_POST['meta_title_vn'])) {
		$metaTitleVN = addslashes($_POST['meta_title_vn']);
	}

	$metaDescEN = "";
	$metaDescJP = "";
	$metaDescVN = "";
	if (!empty($_POST['meta_desc_en'])) {
		$metaDescEN = addslashes($_POST['meta_desc_en']);
	}
	if (!empty($_POST['meta_desc_jp'])) {
		$metaDescJP = addslashes($_POST['meta_desc_jp']);
	}
	if (!empty($_POST['meta_desc_vn'])) {
		$metaDescVN = addslashes($_POST['meta_desc_vn']);
	}
	
	/* Convert LineBreak character to string [br] */
	$t_title_jp = str_replace('\\r\\n','[br]', stripcslashes($t_title_jp));
	$t_detail_jp = str_replace('\\r\\n','[br]', stripcslashes($t_detail_jp));

	$t_title_en = str_replace('\\r\\n','[br]', stripcslashes($t_title_en));
	$t_detail_en = str_replace('\\r\\n','[br]', stripcslashes($t_detail_en));

	$t_title_vn = str_replace('\\r\\n','[br]', stripcslashes($t_title_vn));
	$t_detail_vn = str_replace('\\r\\n','[br]', stripcslashes($t_detail_vn));

	$t_memo = str_replace('\\r\\n','[br]', stripcslashes($t_memo));

	if ($_SESSION['vd'] != $h_admid) {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">";
		exit();
	}

	$sql1 = "update flc_news set nwg_id = '$t_nwg', nwe_id = '$t_nwe', nws_title_en = '$t_title_en', nws_title_jp = '$t_title_jp', nws_title_vn = '$t_title_vn', nws_detail_en = '$t_detail_en', nws_detail_jp = '$t_detail_jp', nws_detail_vn = '$t_detail_vn', nws_year = '$t_year', nws_month = '$t_month', nws_day = '$t_day', nws_show = '$t_show', nws_status = '$t_status', nws_memo = '$t_memo' where nws_id = '$h_nwsid';";
	mysql_query($sql1);

	// UPDATE SEO DATA HERE
	$metaSeoArray = array(
		'meta_title' => array(
			'en' => $metaTitleEN, 
			'jp' => $metaTitleJP,
			'vn' => $metaTitleVN
		),
		'meta_desc' => array(
			'en' => $metaDescEN, 
			'jp' => $metaDescJP,
			'vn' => $metaDescVN
		)
	);
	$metaSeoJson = json_encode($metaSeoArray, JSON_UNESCAPED_UNICODE);

	$sql2 = "SELECT * FROM flc_pag_metadata WHERE pag_id = '$h_nwsid' AND attribute_code = 'new' AND attribute_name = 'seo';";
	$rs2 = mysql_query($sql2);

	if (mysql_num_rows($rs2) == 0) {
		$sql3 = "INSERT INTO flc_pag_metadata (
		pag_id, attribute_code, attribute_name, attribute_value
		) VALUES 
		('$h_nwsid', 'new', 'seo', '$metaSeoJson') ;";
		mysql_query($sql3);
	} else {
		$sql4 = "UPDATE flc_pag_metadata SET attribute_value = '$metaSeoJson' WHERE pag_id = '$h_nwsid' AND attribute_code = 'new' AND attribute_name = 'seo';";
		mysql_query($sql4);

	}
	// END UPDATE SEO DATA

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_news.php?start=0\">";
	exit();
?>

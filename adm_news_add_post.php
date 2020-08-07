<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$t_nwg = $_POST['t_nwg'];
	$t_nwe = $_POST['t_nwe'];
	$t_title_en = addslashes($_POST['t_title_en']);
	$t_title_jp = addslashes($_POST['t_title_jp']);
	$t_title_vn = addslashes($_POST['t_title_vn']);
	$t_detail_en = addslashes($_POST['t_detail_en']);
	$t_detail_jp = addslashes($_POST['t_detail_jp']);
	$t_detail_vn = addslashes($_POST['t_detail_vn']);
	$t_memo = addslashes($_POST['t_memo']);

	// META TAG
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
	
	$t_day = $_POST['t_day'];
	$t_month = $_POST['t_month']; $t_month = addzero2(mcvsubtonum($t_month));
	$t_year = $_POST['t_year'];
	$t_show = $_POST['t_show'];
	$t_status = $_POST['t_status'];
	$pageCode = "new";

	if ($_SESSION['vd'] != $h_admid) {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">";
		exit();
	}

	/* Convert LineBreak character to string [br] */
	$t_title_en = str_replace('\\r\\n','[br]',stripcslashes($t_title_en));
	$t_detail_en = str_replace('\\r\\n','[br]',stripcslashes($t_detail_en));

	$t_title_jp = str_replace('\\r\\n','[br]',stripcslashes($t_title_jp));
	$t_detail_jp = str_replace('\\r\\n','[br]',stripcslashes($t_detail_jp));

	$t_title_vn = str_replace('\\r\\n','[br]',stripcslashes($t_title_vn));
	$t_detail_vn = str_replace('\\r\\n','[br]',stripcslashes($t_detail_vn));

	$t_memo = str_replace('\\r\\n','[br]',stripcslashes($t_memo));

	$metaTitle = str_replace('\\r\\n','[br]',stripcslashes($metaTitle));
	$metaDesc = str_replace('\\r\\n','[br]',stripcslashes($metaDesc));
	
	// query insert NEW table
	$sql1 = "INSERT INTO flc_news (
	nwg_id, nwe_id, nws_title_en, nws_title_jp, nws_title_vn, 
	nws_detail_en, nws_detail_jp, nws_detail_vn, nws_year, nws_month, nws_day,nws_date, nws_time, nws_show, nws_status, nws_memo
	) VALUES (
	'$t_nwg', '$t_nwe', '$t_title_en', '$t_title_jp', '$t_title_vn', 
	'$t_detail_en', '$t_detail_jp', '$t_detail_vn', '$t_year', '$t_month', '$t_day', '$nowdate', '$nowtime', '$t_show', '$t_status', '$t_memo'
	);";
	
	// input data here

	// Prepare Json data
	$metaSeoArray = array(
		'meta_title' => array(
			'en' => $metaTitleEN." | Fact-Link Vietnam", 
			'jp' => $metaTitleJP." | Fact-Link Vietnam",
			'vn' => $metaTitleVN." | Fact-Link Vietnam"
		),
		'meta_desc' => array(
			'en' => $metaDescEN, 
			'jp' => $metaDescJP,
			'vn' => $metaDescVN
		)
	);
	
	$metaSeoJson = json_encode($metaSeoArray, JSON_UNESCAPED_UNICODE);

	mysql_query("SET AUTOCOMMIT=OFF;");
	mysql_query("START TRANSACTION;");

	$flagTransQuery = true;
	$flagFirstQuery = false;
	$flagSecondQuery = false;

	$flagFirstQuery = mysql_query($sql1);
	if ($flagFirstQuery) {
		$latestNewId = mysql_insert_id();
		$sql2 = "INSERT INTO flc_pag_metadata (
		pag_id, attribute_code, attribute_name, attribute_value
		) VALUES 
		('$latestNewId', '$pageCode', 'seo', '$metaSeoJson') ;";
		$flagSecondQuery = mysql_query($sql2);
	}


	if (!$flagFirstQuery || !$flagSecondQuery) {
		$flagTransQuery = false;
	}

	if ($flagTransQuery) {
		mysql_query("COMMIT;");
	} else {
		mysql_query("ROLLBACK;");
	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_news.php?start=0\">";
	exit();
?>

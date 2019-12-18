<?php
ini_set("session.gc_maxlifetime", "18000");
session_start();

if($_SESSION['vp'] != 'exe') {
	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">";
	exit();
}

include_once("../include/global_config.php");

mysql_query("use $db_name;");

if (count($_POST) == 0) {
	echo "Form is empty";
	exit();
}

$companyId = $_POST['id'];
$pageCode = 'all';

$sqlCompany = "SELECT mem_comname_en, mem_comname_vn, mem_comname_jp FROM flc_member WHERE mem_id = '$companyId';";
$resultCompany = mysql_query($sqlCompany);
while ($company = mysql_fetch_assoc($resultCompany)) {
	$companyNameEn = $company['mem_comname_en'];
	$companyNameVn = $company['mem_comname_vn'];
	$companyNameJp = $company['mem_comname_jp'];
}

// Prepare Json data
$metaSeoArray = array(
	'meta_title' => array(
		'en' => $companyNameEn." | Fact-Link Vietnam", 
		'jp' => $companyNameVn." | Fact-Link Vietnam",
		'vn' => $companyNameJp." | Fact-Link Vietnam"
	),
	'meta_desc' => array(
		'en' => $_POST['metaDescEn'], 
		'jp' => $_POST['metaDescJp'],
		'vn' => $_POST['metaDescVn']
	)
);

$metaSeoJson = json_encode($metaSeoArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

$sqlCheckSeo = "SELECT * FROM flc_pag_metadata WHERE pag_id = '$companyId' AND attribute_code = '$pageCode' AND attribute_name = 'seo';";
$resultCheckSeo = mysql_query($sqlCheckSeo);

if (mysql_num_rows($resultCheckSeo) == 0) {
	$sql2 = "INSERT INTO flc_pag_metadata (
	pag_id, attribute_code, attribute_name, attribute_value
	) VALUES 
	('$companyId', '$pageCode', 'seo', '$metaSeoJson') ;";
} elseif (mysql_num_rows($resultCheckSeo) == 1) {
	$sql2 = "UPDATE flc_pag_metadata SET attribute_value = '$metaSeoJson' WHERE pag_id = '$companyId' AND attribute_code = '$pageCode' AND attribute_name = 'seo';";
} else {
	echo "ERROR UPDATE SEO";
	exit();
}
mysql_query($sql2);

header("Location: ../adm_member_page.php?id=$companyId");
?>
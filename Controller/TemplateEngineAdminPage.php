<?php
ini_set("session.gc_maxlifetime", "18000");
session_start();

require_once __DIR__.'/../vendor/autoload.php';
include_once("../include/global_config.php");

mysql_query("use $db_name;");
	
if ($_SESSION['vp'] != 'exe') {
	echo "<meta http-equiv = \"refresh\" content = \"0;URL = ../adm_login.html\">";
	exit();
}

$companyId = $_GET['id'];

$sqlCompany = "SELECT * FROM flc_member WHERE mem_id = '$companyId';";
$resultCompany = mysql_query($sqlCompany);
while ($company = mysql_fetch_assoc($resultCompany)) {
	$companyName = $company['mem_comname_en'];
	$companyNational = $company['mem_national'];
	$companyPackage = $company['mem_package'];
	$companyAddress = $company['mem_address1_en'];
	$companyEmail = $company['mem_contactmail'];
	$metaDesc = $company['mem_seocomdesc'];
}

$sqlSeoTag = "SELECT attribute_value FROM flc_pag_metadata WHERE pag_id = '$companyId' AND attribute_code = 'all' AND attribute_name = 'seo' LIMIT 1;";
$resultSeoTag = mysql_query($sqlSeoTag);
while ($metaTag = mysql_fetch_assoc($resultSeoTag)) {
	$metaDescArr = json_decode($metaTag['attribute_value'], true);
}
$metaDescEn = $metaDescArr['meta_desc']['en'];
$metaDescJp = $metaDescArr['meta_desc']['jp'];
$metaDescVn = $metaDescArr['meta_desc']['vn'];

if (empty($metaDescEn)) {
	$metaDescEn = $metaDesc;
}
if (empty($metaDescJp)) {
	$metaDescJp = $metaDesc;
}
if (empty($metaDescVn)) {
	$metaDescVn = $metaDesc;
}

if (empty($companyPackage)) {
	$companyPackage = "Free Member";
} else {
	$companyPackage = "Paid Member";
}

switch ($companyNational) {
	case 'jp':
		$companyNational = "JAPAN";
		break;
	
	case 'en':
		$companyNational = "ENGLISH";
		break;

	case 'vn':
		$companyNational = "VIETNAM";
		break;

	default:
		$companyNational = "OTHER";
		break;
}

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../View/templates');
$twig = new \Twig\Environment($loader);

$template = $twig->load('admin-seo.html');

echo $template->render([
	'title' => 'FACT-LINK SEO MANAGEMENT', 
	'companyId' => $companyId, 
	'companyName' => $companyName, 
	'companyNational' => $companyNational, 
	'companyPackage' => $companyPackage, 
	'companyAddress' => $companyAddress, 
	'companyEmail' => $companyEmail,
	'metaDescEn' => $metaDescEn, 
	'metaDescJp' => $metaDescJp, 
	'metaDescVn' => $metaDescVn, 
	'handler' => 'AdminAddSeoAction.php', 
]);

?>
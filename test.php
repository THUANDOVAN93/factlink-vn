<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("include/global_config.php");
	
mysql_query("use $db_name;");

$sqlGetPageEn = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'prf' AND pag_show_en = 't' AND pag_status != 'd';";
$sqlGetPageJp = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'prf' AND pag_show_jp = 't' AND pag_status != 'd';";
$sqlGetPageVn = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'prf' AND pag_show_vn = 't' AND pag_status != 'd';";

$sqlGetHomePageEn = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'hom' AND pag_show_en = 't' AND pag_status != 'd';";
$sqlGetHomePageJp = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'hom' AND pag_show_jp = 't' AND pag_status != 'd';";
$sqlGetHomePageVn = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'hom' AND pag_show_vn = 't' AND pag_status != 'd';";

$sqlGetContentPageEn = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'con' AND pag_show_en = 't' AND pag_status != 'd';";
$sqlGetContentPageJp = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'con' AND pag_show_jp = 't' AND pag_status != 'd';";
$sqlGetContentPageVn = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'con' AND pag_show_vn = 't' AND pag_status != 'd';";

$sqlGetPresentPageEn = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'pst' AND pag_show_en = 't' AND pag_status != 'd';";
$sqlGetPresentPageJp = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'pst' AND pag_show_jp = 't' AND pag_status != 'd';";
$sqlGetPresentPageVn = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'pst' AND pag_show_vn = 't' AND pag_status != 'd';";

$sqlGetProductPageEn = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'pro' AND pag_show_en = 't' AND pag_status != 'd';";
$sqlGetProductPageJp = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'pro' AND pag_show_jp = 't' AND pag_status != 'd';";
$sqlGetProductPageVn = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'pro' AND pag_show_vn = 't' AND pag_status != 'd';";

$sqlGetInquiryPageEn = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'inq' AND pag_show_en = 't' AND pag_status != 'd';";
$sqlGetInquiryPageJp = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'inq' AND pag_show_jp = 't' AND pag_status != 'd';";
$sqlGetInquiryPageVn = "SELECT mem_id, pag_id FROM flc_page WHERE pag_type = 'inq' AND pag_show_vn = 't' AND pag_status != 'd';";

$sqlGetNewsPage = "SELECT nws_id FROM flc_news WHERE nws_show = 't' AND nws_status != 'd';";

$sqlGetProductPerCatPage = "SELECT CategoryID FROM flc_product_category WHERE Active = 1;";

$sqlGetProducts = "SELECT ProductID FROM flc_products WHERE 1;";

$sqlGetFolder = "SELECT mem_folder FROM flc_member WHERE mem_status != 'd';";

$rsPageEn = mysql_query($sqlGetPageEn);
$rsPageJp = mysql_query($sqlGetPageJp);
$rsPageVn = mysql_query($sqlGetPageVn);

$rsPageFolder = mysql_query($sqlGetFolder);

$rsPageHomeEn = mysql_query($sqlGetHomePageEn);
$rsPageHomeJp = mysql_query($sqlGetHomePageJp);
$rsPageHomeVn = mysql_query($sqlGetHomePageVn);

$rsPageContentEn = mysql_query($sqlGetContentPageEn);
$rsPageContentJp = mysql_query($sqlGetContentPageJp);
$rsPageContentVn = mysql_query($sqlGetContentPageVn);

$rsPagePresentEn = mysql_query($sqlGetPresentPageEn);
$rsPagePresentJp = mysql_query($sqlGetPresentPageJp);
$rsPagePresentVn = mysql_query($sqlGetPresentPageVn);

$rsPageInquiryEn = mysql_query($sqlGetInquiryPageEn);
$rsPageInquiryJp = mysql_query($sqlGetInquiryPageJp);
$rsPageInquiryVn = mysql_query($sqlGetInquiryPageVn);

$rsPageProductEn = mysql_query($sqlGetProductPageEn);
$rsPageProductJp = mysql_query($sqlGetProductPageEn);
$rsPageProductVn = mysql_query($sqlGetProductPageEn);

$rsPageNews = mysql_query($sqlGetNewsPage);
$rsPageProductPerCat = mysql_query($sqlGetProductPerCatPage);

$rsPageProducts = mysql_query($sqlGetProducts);

$sitemapCustomPath = "assets/sitemapCustom.xml";
$sitemapToolPath = "assets/sitemap.xml";

if (!$handle = fopen($sitemapCustomPath, "a")) {
	echo "Can not open file !";
	exit;
}

$count = 0;
$editTime = date('c',time());
$priority_1 = "1.0000";
$priority_9 = "0.9000";
$priority_8 = "0.8000";
$priority_7 = "0.7000";
$frequencyDaily = "daily";
$webBase = "https://www.fact-link.com.vn";

$ctArray = array();

$ctArray[] = "<url>"."\n"."<loc>".$webBase."</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_1."</priority>"."\n"."</url>"."\n";
$ctArray[] = "<url>"."\n"."<loc>".$webBase."/news_list.php</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_9."</priority>"."\n"."</url>"."\n";
$ctArray[] = "<url>"."\n"."<loc>".$webBase."/search_category.php</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
$ctArray[] = "<url>"."\n"."<loc>".$webBase."/feature.php?start=0</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
$ctArray[] = "<url>"."\n"."<loc>".$webBase."//manual?page=primary</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
$ctArray[] = "<url>"."\n"."<loc>".$webBase."/manual?page=profile</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
$ctArray[] = "<url>"."\n"."<loc>".$webBase."/manual?page=home</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
$ctArray[] = "<url>"."\n"."<loc>".$webBase."/manual?page=content</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
$ctArray[] = "<url>"."\n"."<loc>".$webBase."/manual?page=inquiry</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
$ctArray[] = "<url>"."\n"."<loc>".$webBase."/touroku.php</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
$ctArray[] = "<url>"."\n"."<loc>".$webBase."/contact</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
$ctArray[] = "<url>"."\n"."<loc>".$webBase."/intro</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";

foreach ($ctArray as $ct) {
	fwrite($handle, $ct);
	$count++;
}

while ($pageProductsPage = mysql_fetch_assoc($rsPageProducts)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/product_detail.php?proid=".$pageProductsPage['ProductID']."</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_7."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}

while ($pageProductPerCat = mysql_fetch_assoc($rsPageProductPerCat)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/products_list.php?id=".$pageProductPerCat['CategoryID']."</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_7."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}


while ($pageNews = mysql_fetch_assoc($rsPageNews)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/news_view.php?id=00000782".$pageNews['nws_id']."</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_9."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}

while ($pageHomeEn = mysql_fetch_assoc($rsPageHomeEn)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_home.php?id=".$pageHomeEn['mem_id']."&amp;page=".$pageHomeEn['pag_id']."&amp;lang=en</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}
while ($pageHomeJp = mysql_fetch_assoc($rsPageHomeJp)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_home.php?id=".$pageHomeJp['mem_id']."&amp;page=".$pageHomeJp['pag_id']."&amp;lang=jp</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}
while ($pageHomeVn = mysql_fetch_assoc($rsPageHomeVn)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_home.php?id=".$pageHomeVn['mem_id']."&amp;page=".$pageHomeVn['pag_id']."&amp;lang=vn</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}

while ($pageContentEn = mysql_fetch_assoc($rsPageContentEn)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_content.php?id=".$pageContentEn['mem_id']."&amp;page=".$pageContentEn['pag_id']."&amp;lang=en</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}
while ($pageContentJp = mysql_fetch_assoc($rsPageContentJp)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_content.php?id=".$pageContentJp['mem_id']."&amp;page=".$pageContentJp['pag_id']."&amp;lang=jp</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}
while ($pageContentVn = mysql_fetch_assoc($rsPageContentVn)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_content.php?id=".$pageContentVn['mem_id']."&amp;page=".$pageContentVn['pag_id']."&amp;lang=vn</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}

while ($pagePresentEn = mysql_fetch_assoc($rsPagePresentEn)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_present.php?id=".$pagePresentEn['mem_id']."&amp;page=".$pagePresentEn['pag_id']."&amp;lang=en</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}
while ($pagePresentJp = mysql_fetch_assoc($rsPagePresentJp)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_present.php?id=".$pagePresentJp['mem_id']."&amp;page=".$pagePresentJp['pag_id']."&amp;lang=jp</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}
while ($pagePresentVn = mysql_fetch_assoc($rsPagePresentVn)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_present.php?id=".$pagePresentVn['mem_id']."&amp;page=".$pagePresentVn['pag_id']."&amp;lang=vn</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}

while ($pageInquiryEn = mysql_fetch_assoc($rsPageInquiryEn)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_inquiry.php?id=".$pageInquiryEn['mem_id']."&amp;page=".$pageInquiryEn['pag_id']."&amp;lang=en</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}
while ($pageInquiryJp = mysql_fetch_assoc($rsPageInquiryJp)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_inquiry.php?id=".$pageInquiryJp['mem_id']."&amp;page=".$pageInquiryJp['pag_id']."&amp;lang=jp</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}
while ($pageInquiryVn = mysql_fetch_assoc($rsPageInquiryVn)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_inquiry.php?id=".$pageInquiryVn['mem_id']."&amp;page=".$pageInquiryVn['pag_id']."&amp;lang=vn</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}

while ($pageProductEn = mysql_fetch_assoc($rsPageProductEn)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_products.php?id=".$pageProductEn['mem_id']."&amp;page=".$pageProductEn['pag_id']."&amp;lang=en</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}
while ($pageProductJp = mysql_fetch_assoc($rsPageProductJp)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_products.php?id=".$pageProductJp['mem_id']."&amp;page=".$pageProductJp['pag_id']."&amp;lang=jp</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}
while ($pageProductVn = mysql_fetch_assoc($rsPageProductVn)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_products.php?id=".$pageProductVn['mem_id']."&amp;page=".$pageProductVn['pag_id']."&amp;lang=vn</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}

while ($pageNews = mysql_fetch_assoc($rsPageNews)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/news_view.php?id=".$pageNews['nws_id']."</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}

while ($pageFolder = mysql_fetch_assoc($rsPageFolder)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/home/".$pageFolder['mem_folder']."</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_9."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}

while ($pageEn = mysql_fetch_assoc($rsPageEn)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_profile.php?id=".$pageEn['mem_id']."&amp;page=".$pageEn['pag_id']."&amp;lang=en"."</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}

while ($pageJp = mysql_fetch_assoc($rsPageJp)) {
	$ct = "<url>"."\n"."<loc>".$webBase."mem_profile.php?id=".$pageJp['mem_id']."&amp;page=".$pageJp['pag_id']."&amp;lang=jp"."</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}

while ($pageVn = mysql_fetch_assoc($rsPageVn)) {
	$ct = "<url>"."\n"."<loc>".$webBase."/mem_profile.php?id=".$pageVn['mem_id']."&amp;page=".$pageVn['pag_id']."&amp;lang=vn"."</loc>"."\n"."<lastmod>".$editTime."</lastmod>"."\n"."<changefreq>".$frequencyDaily."</changefreq>"."\n"."<priority>".$priority_8."</priority>"."\n"."</url>"."\n";
	fwrite($handle, $ct);
	$count++;
}

echo $count;

fclose($handle);

?>
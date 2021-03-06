<?php

	/* Enable or Disable PHP error messages */
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);
	
	/*  */
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	
	/* Session setting */
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	
	/* Config for template */
	$url1 = "structure-new.html"; 
	$url2 = "default.html";
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	
	$url7 = "InfoTop.html";
	$url8 = "Link_Footer.html";
	$url9 = "Link_Footer2.html";
	$url10 = "Link_Footer3.html";
	$url11 = "SearchMenubar1.html";	
	$url12 = "SearchMenubar2.html";
	$url13 = "SearchMenubar3.html";
	$url14 = "SearchMenubar4.html";
	$url15 = "heading_index.html";
	$url16 = "heading_index2.html";
	$url17 = "heading_index3.html";
	$url18 = "Logo.html";
	$url19 = "HeadBeforeLogo.html";
	$pagecode = "idx";
	
	/* Set default language cookie */
	if(empty($_COOKIE['vlang'])) {
		$_COOKIE['vlang'] = 'en';
	}
	
	/* Prevent unknown cookie language value */
	if(!in_array($_COOKIE['vlang'],['en','jp','vn'])) {
		$_COOKIE['vlang'] = 'en';
	}
	
	/* Navigation menu for template (HTML Fragments) */
	if ($_COOKIE['vlang'] == 'en') {
		$url6 = "menu-html_en.html";
	} else if ($_COOKIE['vlang'] == 'vn') {
		$url6 = "menu-html_vn.html";
	} else {
		$url6 = "menu-html_jp.html";
	}
	
	/* Define fragments for template */
	$tpl = new rFastTemplate("template");
	$tpl->define(array(
		"main_tpl"		=> $url1,
		"detail_tpl"	=> $url2,
		"right_tpl"		=> $url3,
		"left_tpl"		=> $url4,
		"top_tpl"		=> $url5,
		"menu_tpl"		=> $url6,
		"Info_tpl"      => $url7,
		"linkFooter_tpl" => $url8,
		"linkFooter_tpl2" => $url9,
		"linkFooter_tpl3" => $url10,
		"SearchMenubar_tpl1" => $url11,
		"SearchMenubar_tpl2" => $url12,
		"SearchMenubar_tpl3" => $url13,
		"SearchMenubar_tpl4" => $url14,
		"heading_tpl" => $url15,
		"heading_tpl2" => $url16,
		"heading_tpl3" => $url17,
		"logo_tpl" => $url18,
		"HeadBeforeLogo_tpl" => $url19
	));

	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	include_once("./include/global_expire.php");
	
	// --- Feature Article
	
	$sql1 = "select * from flc_feature where fea_show = 't' order by fea_id desc;";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		$feaid = $dbarr1['fea_id']; 
		$featitleen = $dbarr1['fea_title_en']; 
		$featitlevn = $dbarr1['fea_title_vn']; 
		$featitlejp = $dbarr1['fea_title_jp']; 
		$feadetailen = $dbarr1['fea_detail_en']; 
		$feadetailvn = $dbarr1['fea_detail_vn']; 
		$feadetailjp = $dbarr1['fea_detail_jp'];
		$feaimage = $dbarr1['fea_image']; 
		$feaimagewidth = $dbarr1['fea_image_width']; 
		$feaimagelink = $dbarr1['fea_image_link'];
		$feavideolink = $dbarr1['fea_video_link'];
		$feamedia_option = $dbarr1['fea_media_option'];

		$feadetailen1 = $dbarr1['fea_detail1_en']; 
		$feadetailvn1 = $dbarr1['fea_detail1_vn']; 
		$feadetailjp1 = $dbarr1['fea_detail1_jp'];
		$feaimage1 = $dbarr1['fea_image1']; 
		$feaimagewidth1 = $dbarr1['fea_image1_width']; 
		$feaimagelink1 = $dbarr1['fea_image1_link'];
		$feaimageside1 = $dbarr1['fea_image1_side'];
		$feavideolink1 = $dbarr1['fea_video1_link'];
		$feamedia_option1 = $dbarr1['fea_media1_option'];

		$feadetailen2 = $dbarr1['fea_detail2_en']; 
		$feadetailvn2 = $dbarr1['fea_detail2_vn']; 
		$feadetailjp2 = $dbarr1['fea_detail2_jp'];
		$feaimage2 = $dbarr1['fea_image2']; 
		$feaimagewidth2 = $dbarr1['fea_image2_width']; 
		$feaimagelink2 = $dbarr1['fea_image2_link'];
		$feaimageside2 = $dbarr1['fea_image2_side'];
		$feavideolink2 = $dbarr1['fea_video2_link'];
		$feamedia_option2 = $dbarr1['fea_media2_option'];
		$fealink = $dbarr1['fea_link'];
		
	}
	
	if ($_COOKIE['vlang'] == 'en') {
		$featitle = $featitleen;
		$feadetail = $feadetailen;
		$feadetail1 = $feadetailen1;
		$feadetail2 = $feadetailen2;
	} else if ($_COOKIE['vlang'] == 'vn') {
		$featitle = $featitlevn;
		$feadetail = $feadetailvn;
		$feadetail1 = $feadetailvn1;
		$feadetail2 = $feadetailvn2;
	} else {
		$featitle = $featitlejp;
		$feadetail = $feadetailjp;
		$feadetail1 = $feadetailjp1;
		$feadetail2 = $feadetailjp2;
	}
	
	
	/* Dirty fix backslashes on display */
	if(true) {
		$featitle = stripcslashes(stripcslashes($featitle));
		$feadetail = stripcslashes(stripcslashes($feadetail));
		$feadetail1 = stripcslashes(stripcslashes($feadetail1));
		$feadetail2 = stripcslashes(stripcslashes($feadetail2));
	}
	
	
	/*  */
	if ($feaimage == 't' && $feamedia_option == 'image') {
		$imgpath = "images/feature/".$feaid."-F.jpg";
		if ($feaimagewidth == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $feaimagewidth; }
		if ($imgwidth > 560) { $imgwidth = 560; }
		if ($imgwidth >= 555) { $imgclass = "topimgfull"; } else { $imgclass = "topimg"; }
		$feaimage = "<img src=\"".$imgpath."\" width=\"100%\" border=\"0\" class=\"".$imgclass."\" alt=\"".$featitle."\"/>";
		if ($feaimagelink != '') { $feaimage = "<a href=\"".$feaimagelink."\" target=\"_blank\">".$feaimage."</a>"; }
	} 

	$pagvideo_html = "";
	if ($feaimage == 't' && $feamedia_option == 'video') {
		$feaimage = '';
		$feavideo_html = "<div class=\"fea-video fea-video-top\">".$feavideolink."</div>";
	}

	// position video 1
	if ($feaimageside1 == 'l') { 
		$imgclass = "colimg-defleft";
		$video_position_class = "video-left";
	} else { 
		$imgclass = "colimg-defright";
	}

	if ($feaimageside1 == 'r') {
		$video_position_class = "video-right";
	}
	
	/*  */
	if ($feaimage1 == 't' && $feamedia_option1 == 'image') { 
		$imgpath = "images/feature/".$feaid."-F1.jpg";
		if ($feaimagewidth1 == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $feaimagewidth1; }
		if ($imgwidth > 400) { $imgwidth = 400; }
		if ($feaimageside1 == 'l') { $imgclass = "colimg-defleft"; } else { $imgclass = "colimg-defright"; }
		$feaimage1 = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" alt=\"".$featitle."\"/>";
		if ($feaimagelink1 != '') { $feaimage1 = "<a href=\"".$feaimagelink1."\" target=\"_blank\">".$feaimage1."</a>"; }
	} 
	$feavideo1_html = "";
	if ($feaimage1 == 't' && $feamedia_option1 == 'video') {
		$feaimage1 = '';
		$feavideo1_html = "<div class=\"fea-video ".$video_position_class."\">".$feavideolink1."</div>";
	}

	// position video 2
	if ($feaimageside2 == 'l') { 
		$imgclass = "colimg-defleft";
		$video_position_class = "video-left";
	} else { 
		$imgclass = "colimg-defright";
	}

	if ($feaimageside2 == 'r') {
		$video_position_class = 'video-right';
	}
	/*  */
	if ($feaimage2 == 't' && $feamedia_option2 == 'image') { 
		$imgpath = "images/feature/".$feaid."-F2.jpg";
		if ($feaimagewidth2 == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $feaimagewidth2; }
		if ($imgwidth > 400) { $imgwidth = 400; }
		if ($feaimageside2 == 'l') { $imgclass = "colimg-defleft"; } else { $imgclass = "colimg-defright"; }
		$feaimage2 = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" alt=\"".$featitle."\"/>";
		if ($feaimagelink2 != '') { $feaimage2 = "<a href=\"".$feaimagelink2."\" target=\"_blank\">".$feaimage2."</a>"; }
	} 
	$feavideo2_html = "";
	if ($feaimage2 == 't' && $feamedia_option2 == 'video') {
		$feaimage2 = '';
		$feavideo2_html = "<div class=\"fea-video ".$video_position_class."\">".$feavideolink2."</div>";
	}
	
	/*  */
	/* Create HTML for FeatureDetail (1st) */
	$feadetail = "
		<div>".
			$feaimage.$feavideo_html.html($feadetail).
			"<hr style=\"border-style: dashed; clear:both;\"/>
		</div>";
	
	/* Create HTML for FeatureBox 1 (2nd) */
	if ($feaimage1 != '' || $feadetail1 != '') { 	
		$feadetail = $feadetail."
			<div>"
				.$feaimage1.$feavideo1_html.html($feadetail1).
				"<hr style=\"border-style: dashed; clear:both;\"/>
			</div>";
	}
	
	/* Create HTML for FeatureBox 2 (3nd) */
	if ($feaimage2 != '' || $feadetail2 != '') {
		$feadetail = $feadetail."
			<div>"
				.$feaimage2.$feavideo2_html.html($feadetail2).
			"</div>";
	}
	
	if ($fealink != '') {
		$fealinktext = "<a href=\"".$fealink."\" target=\"_blank\"><strong>".$lb_fea_comlink."</strong></a> ||";
	} else {
		$fealinktext = "";
	}
	
	$tpl->assign("##featitle##", $featitle);
	$tpl->assign("##feadetail##", $feadetail);
	$tpl->assign("##fealinktext##", $fealinktext);
	
	// --- Featured Products
	$sqlGetFeaCatProId = "select CategoryID from flc_product_category where CatFeatured = 1";
	$rsFeaCatProId = mysql_query($sqlGetFeaCatProId);
	$getFeaCatProId = mysql_fetch_array($rsFeaCatProId);
	$feaCatProId = $getFeaCatProId['CategoryID'];

	$sqlFeaturedProduct = "select p.*, m.mem_folder from flc_products p, flc_member m where CategoryID = '$feaCatProId' and p.SupplierID = m.mem_id limit $qtyFeaProduct;";	
	$rsFeaturedproduct = mysql_query($sqlFeaturedProduct);
	while ($feaProductItem = mysql_fetch_array($rsFeaturedproduct)) {
		if ($_COOKIE['vlang'] == 'en') {
			$feaProductName = $feaProductItem['ProductNameEN'];
		} elseif ($_COOKIE['vlang'] == 'vn') {
			$feaProductName = $feaProductItem['ProductNameVN'];
		} else {
			$feaProductName = $feaProductItem['ProductNameJP'];
		}

		// BUILD IMAGE LINK
		$sourceImage = 'home/'.$feaProductItem['mem_folder'].'/products/';
		$imgLink = $sourceImage.$feaProductItem['ProductID'].'-L.jpg';

		$tpl->assign("##feaproductimagelink##", $imgLink);
		$tpl->assign("##feaproductname##", $feaProductName);
		$tpl->assign("##feaproductid##", $feaProductItem['ProductID']);
		$tpl->parse("#####ROW#####", '.rows_featured_products');
	}
	
	// --- Introduce Company
	
	$sql2 = "select * from flc_introduce_set where ins_1 != '' and ins_2 != '' and ins_3 != '' order by ins_id asc;";
	$result2 = mysql_query($sql2);
	$cntins = mysql_num_rows($result2); 
	while ($dbarr2 = mysql_fetch_array($result2)) {
		
		$insid = $dbarr2['ins_id'];
		$ins1 = $dbarr2['ins_1'];
		$ins2 = $dbarr2['ins_2'];
		$ins3 = $dbarr2['ins_3'];
		
		$sqlint1 = "select * from flc_introduce where int_id = '$ins1';";
		$resultint1 = mysql_query($sqlint1);
		while ($dbarrint1 = mysql_fetch_array($resultint1)) {
		
			if ($_COOKIE['vlang'] == 'en') {
				$intname1 = $dbarrint1['int_name_en'];
				$inttitle1 = $dbarrint1['int_title_en'];
				$intdetail1 = html($dbarrint1['int_detail_en']);
			} else if ($_COOKIE['vlang'] == 'vn') {
				$intname1 = $dbarrint1['int_name_vn'];
				$inttitle1 = $dbarrint1['int_title_vn'];
				$intdetail1 = html($dbarrint1['int_detail_vn']);
			} else {
				$intname1 = $dbarrint1['int_name_jp'];
				$inttitle1 = $dbarrint1['int_title_jp'];
				$intdetail1 = html($dbarrint1['int_detail_jp']);
			}
			
			$intlink1 = $dbarrint1['int_link'];
			$intimage1 = $dbarrint1['int_image'];
			
			if ($intimage1 == 't') {
				$imgpath = "images/introduce/".$ins1."-T.jpg";
				$imgwidth = 160; 
				$intimage1 = "<img src=\"".$imgpath."\" width=\"100%\" border=\"0\" alt=\"".$intname1."\"/>"; 
			}
			
		}
		
		$sqlint2 = "select * from flc_introduce where int_id = '$ins2';";
		$resultint2 = mysql_query($sqlint2);
		while ($dbarrint2 = mysql_fetch_array($resultint2)) {
		
			if ($_COOKIE['vlang'] == 'en') { $intname2 = $dbarrint2['int_name_en']; $inttitle2 = $dbarrint2['int_title_en']; $intdetail2 = html($dbarrint2['int_detail_en']); }
			else if ($_COOKIE['vlang'] == 'vn') { $intname2 = $dbarrint2['int_name_vn']; $inttitle2 = $dbarrint2['int_title_vn']; $intdetail2 = html($dbarrint2['int_detail_vn']); }
			else { $intname2 = $dbarrint2['int_name_jp']; $inttitle2 = $dbarrint2['int_title_jp']; $intdetail2 = html($dbarrint2['int_detail_jp']); }
			$intlink2 = $dbarrint2['int_link'];
			$intimage2 = $dbarrint2['int_image'];
			
			if ($intimage2 == 't') {
				$imgpath = "images/introduce/".$ins2."-T.jpg";
				$imgwidth = 160; 
				$intimage2 = "<img src=\"".$imgpath."\" width=\"100%\" border=\"0\" alt=\"".$intname2."\"/>"; 
			}
			
		}
		
		$sqlint3 = "select * from flc_introduce where int_id = '$ins3';";
		$resultint3 = mysql_query($sqlint3);
		while ($dbarrint3 = mysql_fetch_array($resultint3)) {
		
			if ($_COOKIE['vlang'] == 'en') { $intname3 = $dbarrint3['int_name_en']; $inttitle3 = $dbarrint3['int_title_en']; $intdetail3 = html($dbarrint3['int_detail_en']); }
			else if ($_COOKIE['vlang'] == 'vn') { $intname3 = $dbarrint3['int_name_vn']; $inttitle3 = $dbarrint3['int_title_vn']; $intdetail3 = html($dbarrint3['int_detail_vn']); }
			else { $intname3 = $dbarrint3['int_name_jp']; $inttitle3 = $dbarrint3['int_title_jp']; $intdetail3 = html($dbarrint3['int_detail_jp']); }
			$intlink3 = $dbarrint3['int_link'];
			$intimage3 = $dbarrint3['int_image'];
			
			if ($intimage3 == 't') {
				$imgpath = "images/introduce/".$ins3."-T.jpg";
				$imgwidth = 160; 
				$intimage3 = "<img src=\"".$imgpath."\" width=\"100%\" border=\"0\" alt=\"".$intname3."\"/>"; 
			}
			
		}
		
		$cntline = 0;
		$cntline = $cntline + 1;
		
		if ($cntins == $cntline) {
			$insline = "<img src=\"images/line_body_02.png\" width=\"560\" height=\"20\" />";
		} else {
			$insline = "<img src=\"images/line_body_01.png\" width=\"560\" height=\"20\" />";
		}
		
		$tpl->assign("##intname1##", $intname1);
		$tpl->assign("##inttitle1##", $inttitle1);
		$tpl->assign("##intdetail1##", $intdetail1);
		$tpl->assign("##intimage1##", $intimage1);
		$tpl->assign("##intlink1##", $intlink1);
		$tpl->assign("##intname2##", $intname2);
		$tpl->assign("##inttitle2##", $inttitle2);
		$tpl->assign("##intdetail2##", $intdetail2);
		$tpl->assign("##intimage2##", $intimage2);
		$tpl->assign("##intlink2##", $intlink2);
		$tpl->assign("##intname3##", $intname3);
		$tpl->assign("##inttitle3##", $inttitle3);
		$tpl->assign("##intdetail3##", $intdetail3);
		$tpl->assign("##intimage3##", $intimage3);
		$tpl->assign("##intlink3##", $intlink3);
		$tpl->assign("##insline##", $insline);
		$tpl->parse ("#####ROW#####", '.rows_introduce');
		
	}
	
	// --- Updated Info
		
	$sqluif = "select * from flc_upinfo where uif_show = 't';";
	$resultuif = mysql_query($sqluif);
	while ($dbarruif = mysql_fetch_array($resultuif)) { 
	
		if ($_COOKIE['vlang'] == 'en') {
			$uifdetail = $dbarruif['uif_detail_en'];
		} else if ($_COOKIE['vlang'] == 'vn') {
			$uifdetail = $dbarruif['uif_detail_vn'];
		} else {
			$uifdetail = $dbarruif['uif_detail_jp'];
		}
		
	}
		
	if ($uifdetail != '') {
		
		$uifdetail = "<div style=\"border:1px solid #0ff;\">".html($uifdetail)."</div>";

	} 

	$tpl->assign("##uifdetail##", $uifdetail);

	// --- Page Update
	
	$updidx = 0;
	$updarr = array();
	$updarr[0] = "";
	
	$sqlupd1 = "select * from flc_page left join flc_member on flc_page.mem_id = flc_member.mem_id where flc_page.pag_update != '0000-00-00 00:00:00' and flc_member.mem_package != '' and flc_page.pag_status != 'd' order by flc_page.pag_update desc;";
	$resultupd1 = mysql_query($sqlupd1);
	while ($dbarrupd1 = mysql_fetch_array($resultupd1)) { 
		
		$updsameid = "";
		
		$updarrcnt = count($updarr);
		for($upd=0;$upd<$updarrcnt;$upd++) {
			if($dbarrupd1['mem_id'] == $updarr[$upd]) {
				$updsameid = "t";
				break;
			}
		}
		
		if($updsameid != 't') {
			$updarr[$updidx] = $dbarrupd1['mem_id'];
			$updidx = $updidx + 1;
		} else {
			continue;
		}
		
		if ($updidx == 5) {
			break;
		}
		
	}
	
	for ($updlist=0;$updlist<=5;$updlist++) { 
		 
		if ($updarr[$updlist] == '') { break; } else { $updlistmemid = $updarr[$updlist]; }		
		$updpagshowen = ""; $updpagshowjp = ""; $updpagshowth = ""; $updlangset = "";
		
		$sqlupd11 = "select * from flc_page where mem_id = '$updlistmemid' and pag_status != 'd' order by pag_update desc limit 0,1;";
		$resultupd11 = mysql_query($sqlupd11);
		while ($dbarrupd11 = mysql_fetch_array($resultupd11)) {
			
			$updpagid = $dbarrupd11['pag_id'];
			$updpagshowen = $dbarrupd11['pag_show_en'];
			$updpagshowjp = $dbarrupd11['pag_show_jp'];
			$updpagshowvn = $dbarrupd11['pag_show_vn'];
			$updpagtype = $dbarrupd11['pag_type']; 
			$updpagupdate = $dbarrupd11['pag_update'];
		
		}
		
		$updpagupdate = explode(" ",$updpagupdate);
		$upd1 = explode("-",$updpagupdate[0]);
			
		if ($_COOKIE['vlang'] == 'en') {
			$updupdate = $upd1[2]." ".mcvzerotosub($upd1[1])." ".$upd1[0];
		} else if ($_COOKIE['vlang'] == 'vn') {
			$updupdate = $upd1[2]." ".mcvzerotosub($upd1[1])." ".$upd1[0];
		} else {
			$updupdate = $upd1[0]."年".$upd1[1]."月".$upd1[2]."日";
		}
		
		if ($updpagtype == 'prf') { $updpagtype = "profile"; }
		else if ($updpagtype == 'hom') { $updpagtype = "home"; }
		else if ($updpagtype == 'inq') { $updpagtype = "inquiry"; }
		else if ($updpagtype == 'pst') { $updpagtype = "present"; }
		else if ($updpagtype == 'con') { $updpagtype = "content"; }
		
		$updlangarr = array();
		if ($updpagshowjp == 't') { $updlangarr[0] = "jp"; } else { $updlangarr[0] = ""; }
		if ($updpagshowvn == 't') { $updlangarr[1] = "vn"; } else { $updlangarr[1] = ""; }
		if ($updpagshowen == 't') { $updlangarr[2] = "en"; } else { $updlangarr[2] = ""; }
			
		for ($i=0;$i<=2;$i++) { 
			if ($updlangarr[$i] != '') { $updlangset = $updlangarr[$i]; }
			if ($updlangset == $_COOKIE['vlang']) { $i = $i + 3; } 
		}
		
		$sqlupd2 = "select * from flc_member where mem_id = '$updlistmemid';";
		$resultupd2 = mysql_query($sqlupd2);
		while ($dbarrupd2 = mysql_fetch_array($resultupd2)) { 
			
			if ($_COOKIE['vlang'] == 'en') { $updmemname = $dbarrupd2['mem_comname_en']; }
			else if ($_COOKIE['vlang'] == 'vn') { $updmemname = $dbarrupd2['mem_comname_vn']; }
			else { $updmemname = $dbarrupd2['mem_comname_jp']; }
			
		}
			
		$updlink = "mem_".$updpagtype.".php?id=".$updlistmemid."&page=".$updpagid."&lang=".$updlangset;		
		
		$tpl->assign("##updmemname##", $updmemname);
		$tpl->assign("##updlink##", $updlink);
		$tpl->assign("##updupdate##", $updupdate);
		$tpl->parse ("#####ROW#####", '.rows_pageupdate');
		
	}

	// --- News (JP Only)

	$newstable = "
		<tr data-note=\"JP-ONLY\">
			<td>
				<img src=\"images/blank.png\" width=\"560\" height=\"10\" />
			</td>
		</tr>
		<tr>
			<td>
				<h2 class=\"header\">INFORMATION / EVENTS</h2>
			</td>
		</tr>
		<tr>
			<td valign=\"top\">
				<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
	";
	$sql3 = "select * from flc_news where nws_show = 't' and nws_status != 'd' order by nws_year desc, nws_month desc, nws_day desc, nws_id desc limit 0,4;";
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) {
		
		$nwsid = $dbarr3['nws_id'];
		$nwsday = $dbarr3['nws_day'];
		$nwsmonth = $dbarr3['nws_month'];
		$nwsyear = $dbarr3['nws_year'];
		
		if ( $_COOKIE['vlang'] == 'en') {
			$nwstitle = stripslashes($dbarr3['nws_title_en']);
			$monthName = mcvnumtosub($nwsmonth);
			$nwsnewsdate = $nwsday." ".$monthName." ".$nwsyear;
		} elseif ( $_COOKIE['vlang'] == 'vn' ) {
			$nwstitle = stripslashes($dbarr3['nws_title_vn']); 
			$nwsnewsdate = $nwsday." - ".$nwsmonth." - ".$nwsyear;
		} else {
			$nwstitle = stripslashes($dbarr3['nws_title_jp']); 
			$nwsnewsdate = $nwsyear."年".$nwsmonth."月".$nwsday."日";
		}
		
		$newstable = $newstable."
		<tr>
			<td width=\"5\" valign=\"top\" bgcolor=\"#999999\">&nbsp;</td>
			<td width=\"5\" valign=\"top\">&nbsp;</td>
			<td width=\"450\" valign=\"top\">
				<a href=\"news_view.php?id=".$nwsid."\">".$nwstitle."</a>
			</td>
			<td width=\"100\" align=\"right\" valign=\"top\">".$nwsnewsdate."</td>
		</tr>
		<tr>
			<td colspan=\"4\">
				<hr style=\"border-style: dashed;\">
			</td>
		</tr>
		";
	}
		
	$newstable = $newstable."
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<p style=\"text-align: right;\">
					<a href=\"news_list.php?start=0\">SHOW MORE</a>
				</p>
			</td>
		</tr>";	
	$tpl->assign("##newstable##", $newstable);

	// Temp announcement
	
	if ($_COOKIE['vlang'] == 'en') {
		$announcetext = "<strong>What is Fact-Link ?</strong><br />FactLink Vietnam is a company introduction site for manufacturing companies based in Vietnam. We will introduce the information of the registered company. The information posted includes business domain, products, location, industrial park, and contact information. We also provide services to support the manufacturing industry in Vietnam, such as factory searching support. Please contact us via phone ((+84)888767138) or Email (info@fact-link.com.vn)";
	} else if ($_COOKIE['vlang'] == 'vn') {
		$announcetext = "<strong>Fact-link là gì ?</strong><br />FactLink Vietnam là trang web chuyên giới thiệu  các công ty trong ngành công nghiệp sản xuất có trụ sở tại Việt Nam. Chúng tôi sẽ giới thiệu thông tin của các công ty thành viên bao gồm lĩnh vực kinh doanh, mô tả sản phẩm, địa chỉ, thông tin liên hệ.... Chúng tôi cũng cung cấp các dịch vụ để hỗ trợ ngành sản xuất tại Việt Nam, như hỗ trợ tìm kiếm nhà máy, nhà kho. Vui lòng liên hệ với chúng tôi qua điện thoại ((+84) 888 767 138) hoặc Email (info@fact-link.com.vn)";
	} else { $announcetext = "<h1 style=\"margin:0; padding:0; color: #000000; font-size:13px; font-weight:normal;\">ファクトリンクベトナムは、ベトナムに拠点を置く「製造関連企業」の、会社紹介サイトです。ご登録いただいた企業様の情報をご紹介致します。掲載情報は、事業内容、取扱品目、住所、工業団地、連絡先など製造業に特化した項目を設けております。また工場進出サポートなど在ベトナムの製造業を支援するサービスを提供しております。お電話((+84)888767138)またはメール(info@fact-link.com.vn)にてお気軽にお問い合わせください。</h1>"; }
	
	if ($announcetext != '') {
		$announce = "<tr>
		<td valign=\"top\" class=\"grey_s\">".$announcetext."</td>
	  </tr>";
	} else { $announce = ""; }
	
	/*if ($announcetext != '') {
		$announce = "<tr>
		<td valign=\"top\"><table width=\"560\" border=\"2\" cellpadding=\"5\" cellspacing=\"0\" bordercolor=\"#990000\">
		  <tr>
			<td bgcolor=\"#FFCCCC\">".$announcetext."</td>
		  </tr>
		</table></td>
	  </tr>";
	} else { $announce = ""; }*/
	
	$tpl->assign("##announce##", $announce);
	
	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("##INFOTOP_AREA##", "Info_tpl");
	$tpl->parse ("##LinkFooter_AREA##", "linkFooter_tpl");
	$tpl->parse ("##LinkFooter_AREA2##", "linkFooter_tpl2");
	$tpl->parse ("##LinkFooter_AREA3##", "linkFooter_tpl3");
	$tpl->parse ("##SearchMenubar_AREA1##", "SearchMenubar_tpl1");
	$tpl->parse ("##SearchMenubar_AREA2##", "SearchMenubar_tpl2");
	$tpl->parse ("##SearchMenubar_AREA3##", "SearchMenubar_tpl3");
	$tpl->parse ("##SearchMenubar_AREA4##", "SearchMenubar_tpl4");
	$tpl->parse ("##heading_AREA##", "heading_tpl");
	$tpl->parse ("##heading_AREA2##", "heading_tpl2");
	$tpl->parse ("##heading_AREA3##", "heading_tpl3");
	$tpl->parse ("##logo_AREA##", "logo_tpl");
	$tpl->parse ("##HeadBeforeLogo_AREA##", "HeadBeforeLogo_tpl");
	
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
	
?>
<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure.html"; 
	$url2 = "feature_view.html";
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	$pagecode = "fea";
	if ($_COOKIE['vlang'] == 'en') { $url6 = "menu_en.html"; } else if ($_COOKIE['vlang'] == 'vn') { $url6 = "menu_vn.html"; } else { $url6 = "menu_jp.html"; }
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "right_tpl" => $url3, "left_tpl" => $url4, "top_tpl" => $url5, "menu_tpl" => $url6));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	$feaid = $_GET['id'];
	
	$sql1 = "select * from flc_feature where fea_id = '$feaid';";
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
		$feadetailen1 = $dbarr1['fea_detail1_en']; 
		$feadetailvn1 = $dbarr1['fea_detail1_vn']; 
		$feadetailjp1 = $dbarr1['fea_detail1_jp'];
		$feaimage1 = $dbarr1['fea_image1']; 
		$feaimagewidth1 = $dbarr1['fea_image1_width']; 
		$feaimagelink1 = $dbarr1['fea_image1_link'];
		$feaimageside1 = $dbarr1['fea_image1_side'];
		$feadetailen2 = $dbarr1['fea_detail2_en']; 
		$feadetailvn2 = $dbarr1['fea_detail2_vn']; 
		$feadetailjp2 = $dbarr1['fea_detail2_jp'];
		$feaimage2 = $dbarr1['fea_image2']; 
		$feaimagewidth2 = $dbarr1['fea_image2_width']; 
		$feaimagelink2 = $dbarr1['fea_image2_link'];
		$feaimageside2 = $dbarr1['fea_image2_side'];
		$fealink = $dbarr1['fea_link'];
		
	}
	
	if ($_COOKIE['vlang'] == 'en') { $featitle = $featitleen; $feadetail = $feadetailen; $feadetail1 = $feadetailen1; $feadetail2 = $feadetailen2; }
	else if ($_COOKIE['vlang'] == 'vn') { $featitle = $featitlevn; $feadetail = $feadetailvn; $feadetail1 = $feadetailvn1; $feadetail2 = $feadetailvn2; }
	else { $featitle = $featitlejp; $feadetail = $feadetailjp; $feadetail1 = $feadetailjp1; $feadetail2 = $feadetailjp2; }
	
	if ($feaimage == 't') { 
		$imgpath = "images/feature/".$feaid."-F.jpg";
		if ($feaimagewidth == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $feaimagewidth; }
		if ($imgwidth > 560) { $imgwidth = 560; }
		if ($imgwidth >= 555) { $imgclass = "topimgfull"; } else { $imgclass = "topimg"; }
		$feaimage = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" alt=\"".$featitle."\"/>";
		if ($feaimagelink != '') { $feaimage = "<a href=\"".$feaimagelink."\" target=\"_blank\">".$feaimage."</a>"; }
	} 
	
	if ($feaimage1 == 't') { 
		$imgpath = "images/feature/".$feaid."-F1.jpg";
		if ($feaimagewidth1 == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $feaimagewidth1; }
		if ($imgwidth > 300) { $imgwidth = 300; }
		if ($feaimageside1 == 'l') { $imgclass = "colimg-defleft"; } else { $imgclass = "colimg-defright"; }
		$feaimage1 = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" alt=\"".$featitle."\"/>";
		if ($feaimagelink1 != '') { $feaimage1 = "<a href=\"".$feaimagelink1."\" target=\"_blank\">".$feaimage1."</a>"; }
	} 
	
	if ($feaimage2 == 't') { 
		$imgpath = "images/feature/".$feaid."-F2.jpg";
		if ($feaimagewidth2 == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $feaimagewidth2; }
		if ($imgwidth > 300) { $imgwidth = 300; }
		if ($feaimageside2 == 'l') { $imgclass = "colimg-defleft"; } else { $imgclass = "colimg-defright"; }
		$feaimage2 = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" alt=\"".$featitle."\"/>";
		if ($feaimagelink2 != '') { $feaimage2 = "<a href=\"".$feaimagelink2."\" target=\"_blank\">".$feaimage2."</a>"; }
	} 
	
	$feadetail = "<tr><td valign=\"top\">".$feaimage.html($feadetail)."</td></tr>";
	
	if ($feaimage1 != '' || $feadetail1 != '') { 
		
		$feadetail = $feadetail."<tr><td valign=\"top\"><img src=\"images/line_body_01.png\" width=\"560\" height=\"20\" /></td></tr>
		<tr><td valign=\"top\">".$feaimage1.html($feadetail1)."</td></tr>";
				 
	}
	
	if ($feaimage2 != '' || $feadetail2 != '') { 
		
		$feadetail = $feadetail."<tr><td valign=\"top\"><img src=\"images/line_body_01.png\" width=\"560\" height=\"20\" /></td></tr>
		<tr><td valign=\"top\">".$feaimage2.html($feadetail2)."</td></tr>";
		
	}
	
	if ($fealink != '') { $fealinktext = "<a href=\"".$fealink."\" target=\"_blank\"><strong>".$lb_fea_comlink." &gt;&gt;</strong></a>"; } else { $fealinktext = ""; }
	
	$tpl->assign("##featitle##", $featitle);
	$tpl->assign("##feadetail##", $feadetail);
	$tpl->assign("##fealinktext##", $fealinktext);
	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
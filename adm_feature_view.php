<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_feature_view.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$feaid = $_GET['id'];
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
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
		
	}
	
	if ($_COOKIE['vlang'] == 'en') { $featitle = $featitleen; $feadetail = $feadetailen; $feadetail1 = $feadetailen1; $feadetail2 = $feadetailen2; }
	else if ($_COOKIE['vlang'] == 'vn') { $featitle = $featitlevn; $feadetail = $feadetailvn; $feadetail1 = $feadetailvn1; $feadetail2 = $feadetailvn2; }
	else { $featitle = $featitlejp; $feadetail = $feadetailjp; $feadetail1 = $feadetailjp1; $feadetail2 = $feadetailjp2; }
	
	if ($feaimage == 't' && $feamedia_option == 'image') { 
		$imgpath = "images/feature/".$feaid."-F.jpg";
		if ($feaimagewidth == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $feaimagewidth; }
		if ($imgwidth > 560) { $imgwidth = 560; }
		if ($imgwidth >= 555) { $imgclass = "topimgfull"; } else { $imgclass = "topimg"; }
		$feaimage = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" alt=\"".$featitle."\"/>";
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

	
	if ($feaimage1 == 't' && $feamedia_option1 == 'image') { 
		$imgpath = "images/feature/".$feaid."-F1.jpg";
		if ($feaimagewidth1 == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $feaimagewidth1; }
		if ($imgwidth > 300) { $imgwidth = 300; }
		// if ($feaimageside1 == 'l') { $imgclass = "colimg-defleft"; } else { $imgclass = "colimg-defright"; }
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

	
	
	if ($feaimage2 == 't' && $feamedia_option2 == 'image') { 
		$imgpath = "images/feature/".$feaid."-F2.jpg";
		if ($feaimagewidth2 == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $feaimagewidth2; }
		if ($imgwidth > 300) { $imgwidth = 300; }
		// if ($feaimageside2 == 'l') { $imgclass = "colimg-defleft"; } else { $imgclass = "colimg-defright"; }
		$feaimage2 = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" alt=\"".$featitle."\"/>";
		if ($feaimagelink2 != '') { $feaimage2 = "<a href=\"".$feaimagelink2."\" target=\"_blank\">".$feaimage2."</a>"; }
	} 

	$feavideo2_html = "";
	if ($feaimage2 == 't' && $feamedia_option2 == 'video') {
		$feaimage2 = '';
		$feavideo2_html = "<div class=\"fea-video ".$video_position_class."\">".$feavideolink2."</div>";
	}
	
	$feadetail = "<tr><td valign=\"top\">".$feaimage.$feavideo_html.html($feadetail)."</td></tr>";
	
	if ($feaimage1 != '' || $feadetail1 != '') { 
		
		$feadetail = $feadetail."<tr><td valign=\"top\"><img src=\"images/line_body_01.png\" width=\"560\" height=\"20\" /></td></tr>
		<tr><td valign=\"top\">".$feaimage1.$feavideo1_html.html($feadetail1)."</td></tr>";
				 
	}
	
	if ($feaimage2 != '' || $feadetail2 != '') { 
		
		$feadetail = $feadetail."<tr><td valign=\"top\"><img src=\"images/line_body_01.png\" width=\"560\" height=\"20\" /></td></tr>
		<tr><td valign=\"top\">".$feaimage2.$feavideo2_html.html($feadetail2)."</td></tr>";
		
	}
	
	
	
	if ($_COOKIE['vlang'] == 'en') { $titlefeature = "title_feature_en.png"; }
	else if ($_COOKIE['vlang'] == 'vn') { $titlefeature = "title_feature_vn.png"; }
	else { $titlefeature = "title_feature_jp.png"; }
	
	$tpl->assign("##featitle##", $featitle);
	$tpl->assign("##feadetail##", $feadetail);
	$tpl->assign("##titlefeature##", $titlefeature);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
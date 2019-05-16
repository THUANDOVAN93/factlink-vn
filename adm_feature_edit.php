<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_feature_edit.html";
	$media_option_origin = array(
		'image' => 'image',
		'video' => 'video'
	);
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$feaid = $_GET['id'];
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "feature_edit";
	$currentrec = $feaid;
	$currentuserid = $_SESSION['vd']; 
	$currentuserper = "adm";
	
	$sqlusl0 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl0 = mysql_query($sqlusl0);
	
	$sqlusl1 = "select * from flc_uselog where usl_filepage = '$currentpage' and usl_filerec = '$currentrec';"; 
	$resultusl1 = mysql_query($sqlusl1);
	while ($dbarrusl1 = mysql_fetch_array($resultusl1)) { 
	
		$usltimestamp = $dbarrusl1['usl_timestamp'];
		
		if ($usltimestamp > $limittimestamp) { 
			
			$_SESSION['vlock_userid'] = $dbarrusl1['usl_userid'];
			$_SESSION['vlock_userper'] = $dbarrusl1['usl_userper'];
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_lock.php\">"; exit(); 
			
		} else { $usldel = "t"; }
		
	}
	
	if ($usldel == 't') { 
	
		$sqlusl2 = "delete from flc_uselog where usl_timestamp = '$usltimestamp';"; 
		$resultusl2 = mysql_query($sqlusl2);
		
	}
	
	$sqlusl3 = "insert into flc_uselog (usl_filepage, usl_filerec, usl_userid, usl_userper) values ('$currentpage', '$currentrec', '$currentuserid', '$currentuserper');"; 
	$resultusl3 = mysql_query($sqlusl3);
	
	// --------------------
	
	$sql1 = "select * from flc_feature where fea_id = '$feaid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) { 
		$featitleen = $dbarr1['fea_title_en']; 
		$featitlevn = $dbarr1['fea_title_vn']; 
		$featitlejp = $dbarr1['fea_title_jp']; 
		$feadetailen = $dbarr1['fea_detail_en']; 
		$feadetailvn = $dbarr1['fea_detail_vn']; 
		$feadetailjp = $dbarr1['fea_detail_jp'];
		$feaimage = $dbarr1['fea_image']; 
		$feaimagewidth = $dbarr1['fea_image_width']; 
		$feaimagelink = $dbarr1['fea_image_link'];
		$feavideolink_cr = $dbarr1['fea_video_link'];
		$feamedia_option = $dbarr1['fea_media_option'];


		$feadetailen1 = $dbarr1['fea_detail1_en']; 
		$feadetailvn1 = $dbarr1['fea_detail1_vn']; 
		$feadetailjp1 = $dbarr1['fea_detail1_jp'];
		$feaimage1 = $dbarr1['fea_image1']; 
		$feaimagewidth1 = $dbarr1['fea_image1_width']; 
		$feaimagelink1 = $dbarr1['fea_image1_link'];
		$feaimageside1 = $dbarr1['fea_image1_side'];
		$feavideolink1_cr = $dbarr1['fea_video1_link'];
		$feamedia1_option = $dbarr1['fea_media1_option'];


		$feadetailen2 = $dbarr1['fea_detail2_en']; 
		$feadetailvn2 = $dbarr1['fea_detail2_vn']; 
		$feadetailjp2 = $dbarr1['fea_detail2_jp'];
		$feaimage2 = $dbarr1['fea_image2']; 
		$feaimagewidth2 = $dbarr1['fea_image2_width']; 
		$feaimagelink2 = $dbarr1['fea_image2_link'];
		$feaimageside2 = $dbarr1['fea_image2_side'];
		$feavideolink2_cr = $dbarr1['fea_video2_link'];
		$feamedia2_option = $dbarr1['fea_media2_option'];

		$fealink = $dbarr1['fea_link'];
	}

	// edit by thuando


	$meoselected_top = '';
	$meoselected_1 = '';
	$meoselected_2 = '';

	foreach ($media_option_origin as $key => $option) {
		
		$tpl->assign("##meoname##", $option);
		$tpl->assign("##meovalue##", $option);
		if ( $feamedia_option == $option ) {
			$meoselected_top = 'selected';
		} else {
			$meoselected_top = '';
		}
		
		if ( $feamedia1_option == $option ) {
			$meoselected_1 = 'selected';
		} else {
			$meoselected_1 = '';
		}
		
		if ( $feamedia2_option == $option ) {
			$meoselected_2 = 'selected';
		} else {
			$meoselected_2 = '';
		}
		
		$tpl->assign("##meoselected##", $meoselected_top);
		$tpl->assign("##meoselected1##", $meoselected_1);
		$tpl->assign("##meoselected2##", $meoselected_2);
		$tpl->parse ("#####ROW#####", '.rows_meo');
		$tpl->parse ("#####ROW#####", '.rows_meo1');
		$tpl->parse ("#####ROW#####", '.rows_meo2');
	}


	$tpl->assign("##pagvideolink##", htmlentities($feavideolink_cr));
	$tpl->assign("##pagvideolink1##", htmlentities($feavideolink1_cr));
	$tpl->assign("##pagvideolink2##", htmlentities($feavideolink2_cr));
	// end by thuando
	

	/* Convert [br] to actual [LineBreak] for <textarea> */
	$featitleen = str_replace('[br]',PHP_EOL,$featitleen);
	$featitlevn = str_replace('[br]',PHP_EOL,$featitlevn);
	$featitlejp = str_replace('[br]',PHP_EOL,$featitlejp);
	$feadetailen = str_replace('[br]',PHP_EOL,$feadetailen);
	$feadetailvn = str_replace('[br]',PHP_EOL,$feadetailvn);
	$feadetailjp = str_replace('[br]',PHP_EOL,$feadetailjp);
	$feadetailen1 = str_replace('[br]',PHP_EOL,$feadetailen1);
	$feadetailvn1 = str_replace('[br]',PHP_EOL,$feadetailvn1);
	$feadetailjp1 = str_replace('[br]',PHP_EOL,$feadetailjp1);
	$feadetailen2 = str_replace('[br]',PHP_EOL,$feadetailen2);
	$feadetailvn2 = str_replace('[br]',PHP_EOL,$feadetailvn2);
	$feadetailjp2 = str_replace('[br]',PHP_EOL,$feadetailjp2);
	$fealink = str_replace('[br]',PHP_EOL,$fealink);


	
	if ($feaimage == 't') { 
		
		$imgpath = "images/feature/".$feaid."-F.jpg";
		if ($feaimagewidth == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $feaimagewidth; }
		if ($imgwidth > 540) { $imgwidth = 540; }
		$feaimagepreview = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\"/>"; 
		
		if ($feaimagelink != '') { $feaimagepreview = "<a href=\"".$feaimagelink."\" target=\"_blank\">".$feaimagepreview."</a>"; }
	
	} else { $feaimagedisable = "checked"; }
	
	if ($feaimage1 == 't') { 
		
		$imgpath1 = "images/feature/".$feaid."-F1.jpg";
		if ($feaimagewidth1 == 0) { $imgdms1 = getimagesize($imgpath1); $imgwidth1 = $imgdms1[0]; } else { $imgwidth1 = $feaimagewidth1; }
		if ($imgwidth1 > 540) { $imgwidth1 = 540; }
		$feaimagepreview1 = "<img src=\"".$imgpath1."\" width=\"".$imgwidth1."\" border=\"0\"/>"; 
		
		if ($feaimagelink1 != '') { $feaimagepreview1 = "<a href=\"".$feaimagelink1."\" target=\"_blank\">".$feaimagepreview1."</a>"; }
	
	} else { $feaimagedisable1 = "checked"; }
	
	if ($feaimage2 == 't') { 
		
		$imgpath2 = "images/feature/".$feaid."-F2.jpg";
		if ($feaimagewidth2 == 0) { $imgdms2 = getimagesize($imgpath2); $imgwidth2 = $imgdms2[0]; } else { $imgwidth2 = $feaimagewidth2; }
		if ($imgwidth2 > 540) { $imgwidth2 = 540; }
		$feaimagepreview2 = "<img src=\"".$imgpath2."\" width=\"".$imgwidth2."\" border=\"0\"/>"; 
		
		if ($feaimagelink2 != '') { $feaimagepreview2 = "<a href=\"".$feaimagelink2."\" target=\"_blank\">".$feaimagepreview2."</a>"; }
	
	} else { $feaimagedisable2 = "checked"; }
	
	if ($feaimageside1 == 'l') { $feaimageside1_l = "checked"; $feaimageside1_r = ""; } else { $feaimageside1_l = ""; $feaimageside1_r = "checked"; }
	if ($feaimageside2 == 'l') { $feaimageside2_l = "checked"; $feaimageside2_r = ""; } else { $feaimageside2_l = ""; $feaimageside2_r = "checked"; }
	
	$tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->assign("##feaid##", $feaid);
	$tpl->assign("##featitleen##", $featitleen);
	$tpl->assign("##featitlejp##", $featitlejp);
	$tpl->assign("##featitlevn##", $featitlevn);
	$tpl->assign("##feadetailen##", $feadetailen);
	$tpl->assign("##feadetailjp##", $feadetailjp);
	$tpl->assign("##feadetailvn##", $feadetailvn);
	$tpl->assign("##feaimagepreview##", $feaimagepreview);
	$tpl->assign("##feaimagewidth##", $feaimagewidth);
	$tpl->assign("##feaimagedisable##", $feaimagedisable);
	$tpl->assign("##feaimagelink##", $feaimagelink);
	$tpl->assign("##feadetailen1##", $feadetailen1);
	$tpl->assign("##feadetailjp1##", $feadetailjp1);
	$tpl->assign("##feadetailvn1##", $feadetailvn1);
	$tpl->assign("##feaimagepreview1##", $feaimagepreview1);
	$tpl->assign("##feaimagewidth1##", $feaimagewidth1);
	$tpl->assign("##feaimagedisable1##", $feaimagedisable1);
	$tpl->assign("##feaimagelink1##", $feaimagelink1);
	$tpl->assign("##feaimageside1_l##", $feaimageside1_l);
	$tpl->assign("##feaimageside1_r##", $feaimageside1_r);
	$tpl->assign("##feadetailen2##", $feadetailen2);
	$tpl->assign("##feadetailjp2##", $feadetailjp2);
	$tpl->assign("##feadetailvn2##", $feadetailvn2);
	$tpl->assign("##feaimagepreview2##", $feaimagepreview2);
	$tpl->assign("##feaimagewidth2##", $feaimagewidth2);
	$tpl->assign("##feaimagedisable2##", $feaimagedisable2);
	$tpl->assign("##feaimagelink2##", $feaimagelink2);
	$tpl->assign("##feaimageside2_l##", $feaimageside2_l);
	$tpl->assign("##feaimageside2_r##", $feaimageside2_r);
	$tpl->assign("##fealink##", $fealink);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
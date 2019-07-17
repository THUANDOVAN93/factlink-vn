<?php
	ini_set("session.gc_maxlifetime", "18000");
	session_start();

	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	$memid = $_GET['id'];
	$pagid = $_GET['page'];
	$langcode = $_GET['lang'];

	$url1 = "mem_structure.html";
	$url2 = "mem_profile.html";
	$url3 = "footer.html";
	/* Navigation menu for template (HTML Fragments) */
	if ($langcode == 'en') {
		$url6 = "menu-html_en.html";
	} elseif ($langcode == 'vn') {
		$url6 = "menu-html_vn.html";
	} else {
		$url6 = "menu-html_jp.html";
	}

	$tpl = new rFastTemplate("template");
	$tpl->define (array(
		"main_tpl" => $url1,
		"detail_tpl" => $url2,
		"menu_tpl" => $url6,
		"footer" => $url3
	));

	mysql_query("use $db_name;");
	
	if ($_SESSION['repage']!=date("m")) {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_profile.php?id=".$_GET['id']."&page=".$_GET['page']."&lang=".$_GET['lang']."\">";
		$_SESSION['repage']=date("m");
		exit();
	}
	
	// --- Global Template Section
	include_once("./include/global_memvalue.php");

	$sql1 = "select * from flc_member where mem_id = '$memid';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		$dbarr1 = array_map('nl2br',$dbarr1);

		if ($dbarr1['mem_status'] == 'd') {
			
			if ($_SESSION['vp'] != 'exe' && $_SESSION['vp'] != 'adm') {
				echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">";
				exit();
			}
		
		}

		$memcomnameen = $dbarr1['mem_comname_en'];
		$memcomnamejp = $dbarr1['mem_comname_jp'];
		$memcomnamevn = $dbarr1['mem_comname_vn'];
		$memsubdescen = $dbarr1['mem_subdesc_en'];
		$memsubdescjp = $dbarr1['mem_subdesc_jp'];
		$memsubdescvn = $dbarr1['mem_subdesc_vn'];
		$memfooteren = $dbarr1['mem_footer_en'];
		$memfooterjp = $dbarr1['mem_footer_jp'];
		$memfootervn = $dbarr1['mem_footer_vn'];
		$memtemplate = $dbarr1['mem_template'];
		$memfolder = $dbarr1['mem_folder'];
		$memseocom = $dbarr1['mem_seocomdesc'];
		$memseokey = $dbarr1['mem_seokeyword'];
		$memCatId = $dbarr1['mem_category'];

		if ($dbarr1['mem_package'] === '') {
			$tpl->assign("##footerVisible##", "block");
			$tpl->assign("##footerVisibleNoneFree##", "none");
			// add inquiry form here for free member

		} else {
			$tpl->assign("##footerVisible##", "none");
			$tpl->assign("##footerVisibleNoneFree##", "");
		}

	}
	
	$sql2 = "select * from flc_template_main where tpm_id = '$memtemplate';";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
		$tpmcode = $dbarr2['tpm_name_file'];
	}
	if ($tpmcode == '') {
		$tpmcode = "red";
	}

	if ($langcode != 'en' && $langcode != 'jp' && $langcode != 'vn') {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">";
		 exit();
	}
	
	$sql4 = "select * from flc_page where mem_id = '$memid' and pag_id = '$pagid';";
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) {

		$pagcheck = "t";
		$dbarr4 = array_map('stripslashes',$dbarr4);
		if ($dbarr4['pag_status'] == 'd') {
			if ($_SESSION['vp'] != 'exe' && $_SESSION['vp'] != 'adm') {
				echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">";
				exit();
			}
		}

		if ($dbarr4['pag_type'] != 'prf') {
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">";
			exit();
		}

		if ($langcode == 'en' && $dbarr4['pag_show_en'] != 't') {
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">";
			exit();
		}
		if ($langcode == 'jp' && $dbarr4['pag_show_jp'] != 't') {
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">";
			exit();
		}
		if ($langcode == 'vn' && $dbarr4['pag_show_vn'] != 't') {
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">";
			exit();
		}

		if ($dbarr4['pag_show_en'] == 't' || $prfshowen == 't') {
			$langen = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/tpl_".$memlangpicen."\" title=\"English\" width=\"24\" height=\"24\" border=\"0\" /></a>";
		} else {
			$langen = "<img src=\"images/tpl_en_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
		}

		if ($dbarr4['pag_show_jp'] == 't' || $prfshowjp == 't') {
			$langjp = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/tpl_".$memlangpicjp."\" title=\"日本語\" width=\"24\" height=\"24\" border=\"0\" /></a>";
		} else {
			$langjp = "<img src=\"images/tpl_jp_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
		}

		if ($dbarr4['pag_show_vn'] == 't' || $prfshowvn == 't') {
			$langvn = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/tpl_".$memlangpicvn."\" title=\"Việt Nam\" width=\"24\" height=\"24\" border=\"0\" /></a>";
		} else {
			$langvn = "<img src=\"images/tpl_vn_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
		}
		
		$pagpagetitleen = $dbarr4['pag_pagetitle_en'];
		$pagpagetitlejp = $dbarr4['pag_pagetitle_jp'];
		$pagpagetitlevn = $dbarr4['pag_pagetitle_vn'];
		$pagtitleen = $dbarr4['pag_title_en'];
		$pagtitlejp = $dbarr4['pag_title_jp'];
		$pagtitlevn = $dbarr4['pag_title_vn'];
		$pagtitlecolor = "#".$dbarr4['pag_title_color'];
		if ($pagtitlecolor == '#') {
			$pagtitlecolor = "#CC0000";
		}
		$pagprfcolor = "#".$dbarr4['pag_profile_color'];
		if ($pagprfcolor == '#') {
			$pagprfcolor = "#CC0000";
		}
		$pagdetailen = $dbarr4['pag_detail_en'];
		$pagdetailjp = $dbarr4['pag_detail_jp'];
		$pagdetailvn = $dbarr4['pag_detail_vn'];
		$pagimage = $dbarr4['pag_image'];
		$pagimagewidth = $dbarr4['pag_image_width'];
		$pagimagelink = $dbarr4['pag_image_link'];
		$pagimageside = $dbarr4['pag_image_side'];
		$pagvideo_html = '';
		$pagemedia_option = $dbarr4['pag_media_option'];
		if ($pagimageside == 'r') { 
			$imgside = "colimg-defright";
			$imgsidefull = "colimg-defright-full";
			$video_position_class = "video-right";
		} else { 
			$imgside = "colimg-defleft";
			$imgsidefull = "colimg-defleft-full"; 
		}

		if ($pagimageside == 'l') {
			$video_position_class = 'video-left';
		}

		if ($pagimage == 't' && $pagemedia_option == 'image') {

			$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-P.jpg";
			if ($pagimagewidth == 0) {
				$imgdms = getimagesize($imgpath);
				$imgwidth = $imgdms[0];
			} else {
				$imgwidth = $pagimagewidth;
			}

			if ($imgwidth > 760) {
				$imgwidth = 760;
			}

			if ($imgwidth >= 755) {
				$imgclass = $imgsidefull;
			} else {
				$imgclass = $imgside;
			}
			$pagimage = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" />";
			if ($pagimagelink == 't') {
				$pagimage = "<a href=\"".$imgpath."\" target=\"_blank\">".$pagimage."</a>";
			}
		}

		if ($pagimage == 't' && $pagemedia_option == 'video') {
			if ($pagimagelink == 't') {
				$video_position_class = "video-origin";
			}
			$pagimage = '';
			$pagvideo_html = "<div class=\"home-video-top ".$video_position_class."\">".$dbarr4['pag_video_link']."</div>";
		}
	}

	if ($pagcheck != 't') {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">";
		exit();
	}

	
	
	$sql5 = "select * from flc_member where mem_id = '$memid';";
	$result5 = mysql_query($sql5);
	while ($dbarr5 = mysql_fetch_array($result5)) {
		
		$dbarr5 = array_map('stripslashes',$dbarr5);
		$dbarr5 = array_map('html',$dbarr5);

		$memposnameen = $dbarr5['mem_posname_en'];
		if ($memposnameen != '') {
			$memposnameen = $memposnameen." : ";
		}
		$memposnamejp = $dbarr5['mem_posname_jp'];
		if ($memposnamejp != '') {
			$memposnamejp = $memposnamejp." : ";
		}
		$memposnamevn = $dbarr5['mem_posname_vn'];
		if ($memposnamevn != '') {
			$memposnamevn = $memposnamevn." : ";
		}
		$mempernameen = $dbarr5['mem_pername_en'];
		$mempernamejp = $dbarr5['mem_pername_jp'];
		$mempernamevn = $dbarr5['mem_pername_vn'];
		$memaddlab1en = $dbarr5['mem_addresslabel1_en'];
		$memaddlab1jp = $dbarr5['mem_addresslabel1_jp'];
		$memaddlab1vn = $dbarr5['mem_addresslabel1_vn'];
		$memadd1en = $dbarr5['mem_address1_en'];
		$memadd1jp = $dbarr5['mem_address1_jp'];
		$memadd1vn = $dbarr5['mem_address1_vn'];
		$memine1 = $dbarr5['mem_addressine1'];
		$memprv1 = $dbarr5['mem_addressprv1'];
		$memcty1 = $dbarr5['mem_addresscty1'];
		$memzip1 = $dbarr5['mem_addresszip1'];
		$memaddlab2en = $dbarr5['mem_addresslabel2_en'];
		$memaddlab2jp = $dbarr5['mem_addresslabel2_jp'];
		$memaddlab2vn = $dbarr5['mem_addresslabel2_vn'];
		$memadd2en = $dbarr5['mem_address2_en'];
		$memadd2jp = $dbarr5['mem_address2_jp'];
		$memadd2vn = $dbarr5['mem_address2_vn'];
		$memine2 = $dbarr5['mem_addressine2'];
		$memprv2 = $dbarr5['mem_addressprv2'];
		$memcty2 = $dbarr5['mem_addresscty2'];
		$memzip2 = $dbarr5['mem_addresszip2'];
		$memaddlab3en = $dbarr5['mem_addresslabel3_en'];
		$memaddlab3jp = $dbarr5['mem_addresslabel3_jp'];
		$memaddlab3vn = $dbarr5['mem_addresslabel3_vn'];
		$memadd3en = $dbarr5['mem_address3_en'];
		$memadd3jp = $dbarr5['mem_address3_jp'];
		$memadd3vn = $dbarr5['mem_address3_vn'];
		$memine3 = $dbarr5['mem_addressine3'];
		$memprv3 = $dbarr5['mem_addressprv3'];
		$memcty3 = $dbarr5['mem_addresscty3'];
		$memzip3 = $dbarr5['mem_addresszip3'];
		$memaddlab4en = $dbarr5['mem_addresslabel4_en'];
		$memaddlab4jp = $dbarr5['mem_addresslabel4_jp'];
		$memaddlab4vn = $dbarr5['mem_addresslabel4_vn'];
		$memadd4en = $dbarr5['mem_address4_en'];
		$memadd4jp = $dbarr5['mem_address4_jp'];
		$memadd4vn = $dbarr5['mem_address4_vn'];
		$memine4 = $dbarr5['mem_addressine4'];
		$memprv4 = $dbarr5['mem_addressprv4'];
		$memcty4 = $dbarr5['mem_addresscty4'];
		$memzip4 = $dbarr5['mem_addresszip4'];
		$memaddlab5en = $dbarr5['mem_addresslabel5_en'];
		$memaddlab5jp = $dbarr5['mem_addresslabel5_jp'];
		$memaddlab5vn = $dbarr5['mem_addresslabel5_vn'];
		$memadd5en = $dbarr5['mem_address5_en'];
		$memadd5jp = $dbarr5['mem_address5_jp'];
		$memadd5vn = $dbarr5['mem_address5_vn'];
		$memine5 = $dbarr5['mem_addressine5'];
		$memprv5 = $dbarr5['mem_addressprv5'];
		$memcty5 = $dbarr5['mem_addresscty5'];
		$memzip5 = $dbarr5['mem_addresszip5'];
		$memtellab1en = $dbarr5['mem_tellabel1_en'];
		$memtellab1jp = $dbarr5['mem_tellabel1_jp'];
		$memtellab1vn = $dbarr5['mem_tellabel1_vn'];
		$memtel1 = $dbarr5['mem_telnum1'];
		$memtellab2en = $dbarr5['mem_tellabel2_en'];
		$memtellab2jp = $dbarr5['mem_tellabel2_jp'];
		$memtellab2vn = $dbarr5['mem_tellabel2_vn'];
		$memtel2 = $dbarr5['mem_telnum2'];
		$memtellab3en = $dbarr5['mem_tellabel3_en'];
		$memtellab3jp = $dbarr5['mem_tellabel3_jp'];
		$memtellab3vn = $dbarr5['mem_tellabel3_vn'];
		$memtel3 = $dbarr5['mem_telnum3'];
		$memtellab4en = $dbarr5['mem_tellabel4_en'];
		$memtellab4jp = $dbarr5['mem_tellabel4_jp'];
		$memtellab4vn = $dbarr5['mem_tellabel4_vn'];
		$memtel4 = $dbarr5['mem_telnum4'];
		$memtellab5en = $dbarr5['mem_tellabel5_en'];
		$memtellab5jp = $dbarr5['mem_tellabel5_jp'];
		$memtellab5vn = $dbarr5['mem_tellabel5_vn'];
		$memtel5 = $dbarr5['mem_telnum5'];
		$memmaillab1en = $dbarr5['mem_maillabel1_en'];
		$memmaillab1jp = $dbarr5['mem_maillabel1_jp'];
		$memmaillab1vn = $dbarr5['mem_maillabel1_vn'];
		$memmail1 = $dbarr5['mem_mail1'];
		$memmaillab2en = $dbarr5['mem_maillabel2_en'];
		$memmaillab2jp = $dbarr5['mem_maillabel2_jp'];
		$memmaillab2vn = $dbarr5['mem_maillabel2_vn'];
		$memmail2 = $dbarr5['mem_mail2'];
		$memmaillab3en = $dbarr5['mem_maillabel3_en'];
		$memmaillab3jp = $dbarr5['mem_maillabel3_jp'];
		$memmaillab3vn = $dbarr5['mem_maillabel3_vn'];
		$memmail3 = $dbarr5['mem_mail3'];
		$memmaillab4en = $dbarr5['mem_maillabel4_en'];
		$memmaillab4jp = $dbarr5['mem_maillabel4_jp'];
		$memmaillab4vn = $dbarr5['mem_maillabel4_vn'];
		$memmail4 = $dbarr5['mem_mail4'];
		$memmaillab5en = $dbarr5['mem_maillabel5_en'];
		$memmaillab5jp = $dbarr5['mem_maillabel5_jp'];
		$memmaillab5vn = $dbarr5['mem_maillabel5_vn'];
		$memmail5 = $dbarr5['mem_mail5'];
		$memurl = $dbarr5['mem_url'];
		$memparenten = $dbarr5['mem_comparent_en'];
		$memparentjp = $dbarr5['mem_comparent_jp'];
		$memparentvn = $dbarr5['mem_comparent_vn'];
		$memestdateen = $dbarr5['mem_establishdate_en'];
		$memestdatejp = $dbarr5['mem_establishdate_jp'];
		$memestdatevn = $dbarr5['mem_establishdate_vn'];
		$memcapitalen = $dbarr5['mem_capital_en'];
		$memcapitaljp = $dbarr5['mem_capital_jp'];
		$memcapitalvn = $dbarr5['mem_capital_vn'];
		$memshareen = $dbarr5['mem_shareholder_en'];
		$memsharejp = $dbarr5['mem_shareholder_jp'];
		$memsharevn = $dbarr5['mem_shareholder_vn'];
		$membanken = $dbarr5['mem_bank_en'];
		$membankjp = $dbarr5['mem_bank_jp'];
		$membankvn = $dbarr5['mem_bank_vn'];
		$memaccdateen = $dbarr5['mem_accountdate_en'];
		$memaccdatejp = $dbarr5['mem_accountdate_jp'];
		$memaccdatevn = $dbarr5['mem_accountdate_vn'];
		$mememployeeen = $dbarr5['mem_employee_en'];
		$mememployeejp = $dbarr5['mem_employee_jp'];
		$mememployeevn = $dbarr5['mem_employee_vn'];
		$memboien = $dbarr5['mem_boi_en'];
		$memboijp = $dbarr5['mem_boi_jp'];
		$memboivn = $dbarr5['mem_boi_vn'];
		$memisoen = $dbarr5['mem_iso_en'];
		$memisojp = $dbarr5['mem_iso_jp'];
		$memisovn = $dbarr5['mem_iso_vn'];
		$memvalcusen = $dbarr5['mem_valuecustomer_en'];
		$memvalcusjp = $dbarr5['mem_valuecustomer_jp'];
		$memvalcusvn = $dbarr5['mem_valuecustomer_vn'];
		$membusinessen = $dbarr5['mem_business_en'];
		$membusinessjp = $dbarr5['mem_business_jp'];
		$membusinessvn = $dbarr5['mem_business_vn'];
		$memproducten = $dbarr5['mem_product_en'];
		$memproductjp = $dbarr5['mem_product_jp'];
		$memproductvn = $dbarr5['mem_product_vn'];
		$memconlab1en = $dbarr5['mem_contentlabel1_en'];
		$memconlab1jp = $dbarr5['mem_contentlabel1_jp'];
		$memconlab1vn = $dbarr5['mem_contentlabel1_vn'];
		$memcon1en = $dbarr5['mem_content1_en'];
		$memcon1jp = $dbarr5['mem_content1_jp'];
		$memcon1vn = $dbarr5['mem_content1_vn'];
		$memconlab2en = $dbarr5['mem_contentlabel2_en'];
		$memconlab2jp = $dbarr5['mem_contentlabel2_jp'];
		$memconlab2vn = $dbarr5['mem_contentlabel2_vn'];
		$memcon2en = $dbarr5['mem_content2_en'];
		$memcon2jp = $dbarr5['mem_content2_jp'];
		$memcon2vn = $dbarr5['mem_content2_vn'];
		$memconlab3en = $dbarr5['mem_contentlabel3_en'];
		$memconlab3jp = $dbarr5['mem_contentlabel3_jp'];
		$memconlab3vn = $dbarr5['mem_contentlabel3_vn'];
		$memcon3en = $dbarr5['mem_content3_en'];
		$memcon3jp = $dbarr5['mem_content3_jp'];
		$memcon3vn = $dbarr5['mem_content3_vn'];
		$memconlab4en = $dbarr5['mem_contentlabel4_en'];
		$memconlab4jp = $dbarr5['mem_contentlabel4_jp'];
		$memconlab4vn = $dbarr5['mem_contentlabel4_vn'];
		$memcon4en = $dbarr5['mem_content4_en'];
		$memcon4jp = $dbarr5['mem_content4_jp'];
		$memcon4vn = $dbarr5['mem_content4_vn'];
		$memconlab5en = $dbarr5['mem_contentlabel5_en'];
		$memconlab5jp = $dbarr5['mem_contentlabel5_jp'];
		$memconlab5vn = $dbarr5['mem_contentlabel5_vn'];
		$memcon5en = $dbarr5['mem_content5_en'];
		$memcon5jp = $dbarr5['mem_content5_jp'];
		$memcon5vn = $dbarr5['mem_content5_vn'];

	}
	// language
	if ($langcode == 'en') {
		$memsubdesc = $memsubdescen;
		$memfooter = $memfooteren;
		$memcomname = $memcomnameen;
		$pagpagetitle = $pagpagetitleen;
		$pagtitle = $pagtitleen;
		$pagdetail = $pagdetailen;

		$memcomnamefull = subhtml($memcomnameen);
		$memrepname = subhtml($memposnameen.$mempernameen);
		$memaddlab1 = $memaddlab1en;
		$memadd1 = $memadd1en;
		$memaddlab2 = $memaddlab2en;
		$memadd2 = $memadd2en;
		$memaddlab3 = $memaddlab3en;
		$memadd3 = $memadd3en;
		$memaddlab4 = $memaddlab4en;
		$memadd4 = $memadd4en;
		$memaddlab5 = $memaddlab5en;
		$memadd5 = $memadd5en;

		$memtellab1 = $memtellab1en;
		$memtellab2 = $memtellab2en;
		$memtellab3 = $memtellab3en;
		$memtellab4 = $memtellab4en;
		$memtellab5 = $memtellab5en;

		$memmaillab1 = $memmaillab1en;
		$memmaillab2 = $memmaillab2en;
		$memmaillab3 = $memmaillab3en;
		$memmaillab4 = $memmaillab4en;
		$memmaillab5 = $memmaillab5en;

		$memconlab1 = $memconlab1en;
		$memcon1 = $memcon1en;
		$memconlab2 = $memconlab2en;
		$memcon2 = $memcon2en;
		$memconlab3 = $memconlab3en;
		$memcon3 = $memcon3en;
		$memconlab4 = $memconlab4en;
		$memcon4 = $memcon4en;
		$memconlab5 = $memconlab5en;
		$memcon5 = $memcon5en;

		$memcapital = $memcapitalen;
		$memestdate = $memestdateen;
		$memaccdate = $memaccdateen;
		$mememployee = $mememployeeen;
		$memboi = $memboien;
		$memiso = $memisoen;
		$memparent = $memparenten;
		$memshare = $memshareen;
		$membank = $membanken;
		$memvalcus = $memvalcusen;
		$membusiness = $membusinessen;
		$memproduct = $memproducten;

	} elseif ($langcode == 'vn') {
		$memsubdesc = $memsubdescvn;
		$memfooter = $memfootervn;
		$memcomname = $memcomnamevn;
		$pagpagetitle = $pagpagetitlevn;
		$pagtitle = $pagtitlevn;
		$pagdetail = $pagdetailvn;

		$memcomnamefull = subhtml($memcomnamevn)."<br />".subhtml($memcomnameen);
		$memrepname = subhtml($memposnamevn.$mempernamevn);
		if ($memposnameen != '' || $mempernameen != '') {
			$memrepname = $memrepname."<br />".subhtml($memposnameen.$mempernameen);
		}
		$memaddlab1 = $memaddlab1vn;
		$memadd1 = $memadd1vn;
		$memaddlab2 = $memaddlab2vn;
		$memadd2 = $memadd2vn;
		$memaddlab3 = $memaddlab3vn;
		$memadd3 = $memadd3vn;
		$memaddlab4 = $memaddlab4vn;
		$memadd4 = $memadd4vn;
		$memaddlab5 = $memaddlab5vn;
		$memadd5 = $memadd5vn;

		$memtellab1 = $memtellab1vn;
		$memtellab2 = $memtellab2vn;
		$memtellab3 = $memtellab3vn;
		$memtellab4 = $memtellab4vn;
		$memtellab5 = $memtellab5vn;

		$memmaillab1 = $memmaillab1vn;
		$memmaillab2 = $memmaillab2vn;
		$memmaillab3 = $memmaillab3vn;
		$memmaillab4 = $memmaillab4vn;
		$memmaillab5 = $memmaillab5vn;

		$memconlab1 = $memconlab1vn;
		$memcon1 = $memcon1vn;
		$memconlab2 = $memconlab2vn;
		$memcon2 = $memcon2vn;
		$memconlab3 = $memconlab3vn;
		$memcon3 = $memcon3vn;
		$memconlab4 = $memconlab4vn;
		$memcon4 = $memcon4vn;
		$memconlab5 = $memconlab5vn;
		$memcon5 = $memcon5vn;

		$memcapital = $memcapitalvn;
		$memestdate = $memestdatevn;
		$memaccdate = $memaccdatevn;
		$mememployee = $mememployeevn;
		$memboi = $memboivn;
		$memiso = $memisovn;
		$memparent = $memparentvn;
		$memshare = $memsharevn;
		$membank = $membankvn;
		$memvalcus = $memvalcusvn;
		$membusiness = $membusinessvn;
		$memproduct = $memproductvn;

	} else {
		$memsubdesc = $memsubdescjp;
		$memfooter = $memfooterjp;
		$memcomname = $memcomnamejp;
		$pagpagetitle = $pagpagetitlejp;
		$pagtitle = $pagtitlejp;
		$pagdetail = $pagdetailjp;

		$memcomnamefull = subhtml($memcomnamejp)."<br />".subhtml($memcomnameen);
		$memrepname = subhtml($memposnamejp.$mempernamejp);
		if ($memposnameen != '' || $mempernameen != '') {
			$memrepname = $memrepname."<br />".subhtml($memposnameen.$mempernameen);
		}
		$memaddlab1 = $memaddlab1jp;
		$memadd1 = $memadd1jp;
		$memaddlab2 = $memaddlab2jp;
		$memadd2 = $memadd2jp;
		$memaddlab3 = $memaddlab3jp;
		$memadd3 = $memadd3jp;
		$memaddlab4 = $memaddlab4jp;
		$memadd4 = $memadd4jp;
		$memaddlab5 = $memaddlab5jp;
		$memadd5 = $memadd5jp;

		$memtellab1 = $memtellab1jp;
		$memtellab2 = $memtellab2jp;
		$memtellab3 = $memtellab3jp;
		$memtellab4 = $memtellab4jp;
		$memtellab5 = $memtellab5jp;

		$memmaillab1 = $memmaillab1jp;
		$memmaillab2 = $memmaillab2jp;
		$memmaillab3 = $memmaillab3jp;
		$memmaillab4 = $memmaillab4jp;
		$memmaillab5 = $memmaillab5jp;

		$memconlab1 = $memconlab1jp;
		$memcon1 = $memcon1jp;
		$memconlab2 = $memconlab2jp;
		$memcon2 = $memcon2jp;
		$memconlab3 = $memconlab3jp;
		$memcon3 = $memcon3jp;
		$memconlab4 = $memconlab4jp;
		$memcon4 = $memcon4jp;
		$memconlab5 = $memconlab5jp;
		$memcon5 = $memcon5jp;

		$memcapital = $memcapitaljp;
		$memestdate = $memestdatejp;
		$memaccdate = $memaccdatejp;
		$mememployee = $mememployeejp;
		$memboi = $memboijp;
		$memiso = $memisojp;
		$memparent = $memparentjp;
		$memshare = $memsharejp;
		$membank = $membankjp;
		$memvalcus = $memvalcusjp;
		$membusiness = $membusinessjp;
		$memproduct = $memproductjp;

	}
		
	$pagtitle = "<font color=\"".$pagtitlecolor."\"><h2 class=\"h2_title\">".subhtml($pagtitle)."</h2></font>";
	$pagdetail = $pagimage.$pagvideo_html.$pagtitle.html($pagdetail);
	
	function call_ine($memineid, $langcode) {

		if ($memineid != '1' && $memineid != '2' && $memineid != '') {

			$sql6 = "select * from flc_ie where ine_id = '$memineid';";
			$result6 = mysql_query($sql6);
			while ($dbarr6 = mysql_fetch_array($result6)) {

				if ($langcode == 'en') {
					$inename = $dbarr6['ine_name_en'];
				} elseif ($langcode == 'vn') {
					$inename = $dbarr6['ine_name_vn'];
				} else {
					$inename = $dbarr6['ine_name_en'];
				}
			}
		} else {
			$inename = "";
		}

		return $inename;
	}

	function call_prv($memprvid, $langcode) {

		if ($memprvid != '1' && $memprvid != '') {

			$sql6 = "select * from flc_province where prv_id = '$memprvid';";
			$result6 = mysql_query($sql6);
			while ($dbarr6 = mysql_fetch_array($result6)) {

				if ($langcode == 'en') {
					$prvname = $dbarr6['prv_name_en'];
				} elseif ($langcode == 'vn') {
					$prvname = $dbarr6['prv_name_vn'];
				} else {
					$prvname = $dbarr6['prv_name_en'];
				}
			}

			$prvname = "<br/>".$prvname;
		} else {
			$prvname = "";
		}

		return $prvname;
	}

	function call_cty($memctyid, $langcode) {

		if ($memctyid != '1' && $memctyid != '') {

			$sql6 = "select * from flc_country where cty_id = '$memctyid';";
			$result6 = mysql_query($sql6);
			while ($dbarr6 = mysql_fetch_array($result6)) {

				if ($langcode == 'en') {
					$ctyname = $dbarr6['cty_name_en'];
				} elseif ($langcode == 'vn') {
					$ctyname = $dbarr6['cty_name_vn'];
				} else {
					$ctyname = $dbarr6['cty_name_en'];
				}
			}
		} else {
			$ctyname = "";
		}

		return $ctyname;
	}

	if (trim($memadd1) != '') {
		$memaddress = $memaddress."
		<!-- memadd1 -->
		<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memaddlab1)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".call_ine($memine1, $langcode).subhtml($memadd1).call_prv($memprv1, $langcode)." ".$memzip1." ".call_cty($memcty1, $langcode)."</td>
		  </tr>
		<!-- /memadd1 -->
		".$prfline;
	}
	if (trim($memadd2) != '') {
		$memaddress = $memaddress."
		<!-- memadd2 -->
		<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memaddlab2)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".call_ine($memine2, $langcode).subhtml($memadd2).call_prv($memprv2, $langcode)." ".$memzip2." ".call_cty($memcty2, $langcode)."</td>
		  </tr>
		<!-- /memadd2 -->
		 ".$prfline;
	}	
	if (trim($memadd3) != '') {
		$memaddress = $memaddress."
		<!-- memadd3 -->
		<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memaddlab3)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".call_ine($memine3, $langcode).subhtml($memadd3).call_prv($memprv3, $langcode)." ".$memzip3." ".call_cty($memcty3, $langcode)."</td>
		  </tr>
		<!-- memadd3 -->
		".$prfline;
	}
	if (trim($memadd4) != '') {
		$memaddress = $memaddress."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memaddlab4)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".call_ine($memine4, $langcode).subhtml($memadd4).call_prv($memprv4, $langcode)." ".$memzip4." ".call_cty($memcty4, $langcode)."</td>
		  </tr>".$prfline;
	}
	if (trim($memadd5) != '') {
		$memaddress = $memaddress."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memaddlab5)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".call_ine($memine5, $langcode).subhtml($memadd5).call_prv($memprv5, $langcode)." ".$memzip5." ".call_cty($memcty5, $langcode)."</td>
		  </tr>".$prfline;
	}

	
	if (trim($memtel1) != '') {
		$memtel = $memtel."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memtellab1)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".subhtml($memtel1)."</td>
		  </tr>".$prfline;
	}
	if (trim($memtel2) != '') {
		$memtel = $memtel."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memtellab2)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".subhtml($memtel2)."</td>
		  </tr>".$prfline;
	}
	if (trim($memtel3) != '') {
		$memtel = $memtel."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memtellab3)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".subhtml($memtel3)."</td>
		  </tr>".$prfline;
	}
	if (trim($memtel4) != '') {
		$memtel = $memtel."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memtellab4)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".subhtml($memtel4)."</td>
		  </tr>".$prfline;
	}
	if (trim($memtel5) != '') {
		$memtel = $memtel."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memtellab5)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".subhtml($memtel5)."</td>
		  </tr>".$prfline;
	}


	if (trim($memmail1) != '') {
		$memmail = $memmail."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memmaillab1)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".subhtml($memmail1)."</td>
		  </tr>".$prfline;
	}
	if (trim($memmail2) != '') {
		$memmail = $memmail."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memmaillab2)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".subhtml($memmail2)."</td>
		  </tr>".$prfline;
	}
	if (trim($memmail3) != '') {
		$memmail = $memmail."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memmaillab3)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".subhtml($memmail3)."</td>
		  </tr>".$prfline;
	}
	if (trim($memmail4) != '') {
		$memmail = $memmail."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memmaillab4)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".subhtml($memmail4)."</td>
		  </tr>".$prfline;
	}
	if (trim($memmail5) != '') {
		$memmail = $memmail."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memmaillab5)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".subhtml($memmail5)."</td>
		  </tr>".$prfline;
	}
	if (trim($memcon1) != '') {
		$memcontent = $memcontent."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memconlab1)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".convertURL2HTML($memcon1)."</td>
		  </tr>".$prfline;
	}
	if (trim($memcon2) != '') {
		$memcontent = $memcontent."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memconlab2)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".convertURL2HTML($memcon2)."</td>
		  </tr>".$prfline;
	}
	if (trim($memcon3) != '') {
		$memcontent = $memcontent."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memconlab3)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".convertURL2HTML($memcon3)."</td>
		  </tr>".$prfline;
	}
	if (trim($memcon4) != '') {
		$memcontent = $memcontent."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memconlab4)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".convertURL2HTML($memcon4)."</td>
		  </tr>".$prfline;
	}
	if (trim($memcon5) != '') {
		$memcontent = $memcontent."<tr>
			<td valign=\"top\"><font color=\"".$pagprfcolor."\"><strong>".subhtml($memconlab5)."</strong></font></td>
			<td valign=\"top\">&nbsp;</td>
			<td valign=\"top\">".convertURL2HTML($memcon5)."</td>
		  </tr>".$prfline;
	}
	// Customize CSS For Special Company
	if ($memid == "00001109") {
		$memsubdesc = "<p style=\"margin: 0;padding-left: 25px;line-height: 18px;\">".$memsubdesc."</p>";
		$memcomname = "<span style=\"display: inline-block;width: 25px;\"></span>".$memcomname;
	}
	
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##memcomname##", subhtml($memcomname));
	$tpl->assign("##memcomnamefull##", $memcomnamefull);
	$tpl->assign("##memrepname##", $memrepname);
	$tpl->assign("##memaddress##", $memaddress);
	$tpl->assign("##memtel##", $memtel);
	$tpl->assign("##memmail##", $memmail);
	$tpl->assign("##memcontent##", $memcontent);
	$tpl->assign("##memurl##", subhtml($memurl)); //
	$tpl->assign("##membusiness##", subhtml($membusiness));
	$tpl->assign("##memproduct##", subhtml($memproduct));
	$tpl->assign("##memestdate##", subhtml($memestdate));
	$tpl->assign("##memcapital##", subhtml($memcapital));
	$tpl->assign("##memparent##", subhtml($memparent)); //
	$tpl->assign("##memshare##", subhtml($memshare));
	$tpl->assign("##mememployee##", subhtml($mememployee));
	$tpl->assign("##memaccdate##", subhtml($memaccdate));
	$tpl->assign("##membank##", subhtml($membank));
	$tpl->assign("##memvalcus##", subhtml($memvalcus));
	$tpl->assign("##memboi##", subhtml($memboi));
	$tpl->assign("##memiso##", subhtml($memiso));
	$tpl->assign("##memseocom##", $memseocom);
	$tpl->assign("##memseokey##", $memseokey);
	$tpl->assign("##pagdetail##", $pagdetail);
	$tpl->assign("##pagpagetitle##", $pagpagetitle);
	$tpl->assign("##pagtitlecolor##", $pagtitlecolor);
	$tpl->assign("##pagprfcolor##", $pagprfcolor);
	$tpl->assign("##memsubdesc##", $memsubdesc);
	$tpl->assign("##memfooter##", $memfooter);
	$tpl->assign("##tpmcode##", $tpmcode);
	$tpl->assign("##langen##", $langen);
	$tpl->assign("##langjp##", $langjp);
	$tpl->assign("##langvn##", $langvn);

	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("##FOOTER##", "footer");
	$tpl->parse ("MAIN", "main_tpl");

	$tpl->FastPrint ();
	exit();
	
?>

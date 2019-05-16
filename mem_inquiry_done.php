<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "mem_structure.html"; 
	$url2 = "mem_inquiry_done.html"; 
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_GET['id'];
	$pagid = $_GET['page'];
	$langcode = $_GET['lang'];
	$code = $_GET['code'];
	
	// --- Global Template Section	
	include_once("./include/global_memvalue.php");
	
	$sql1 = "select * from flc_member where mem_id = '$memid';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($dbarr1['mem_status'] == 'd') { if ($_SESSION['vp'] != 'exe' && $_SESSION['vp'] != 'adm') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); }  }
		
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
		$memstatus = $dbarr1['mem_status'];
	
	}
	
	
	$sql2 = "select * from flc_template_main where tpm_id = '$memtemplate';";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) { $tpmcode = $dbarr2['tpm_name_file']; } if ($tpmcode == '') { $tpmcode = "red"; }
	
	
	$sql3 = "select * from flc_page where mem_id = '$memid' and pag_type = 'prf';";
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) {
		 $prfshowid = $dbarr3['pag_id']; $prfshowen = $dbarr3['pag_show_en']; $prfshowjp = $dbarr3['pag_show_jp']; $prfshowvn = $dbarr3['pag_show_vn']; 
		 
		 }
	
	if ($langcode == 'en') { if ($prfshowen != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } }
	else if ($langcode == 'jp') { if ($prfshowjp != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } }
	else if ($langcode == 'vn') { if ($prfshowvn != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } }
	else { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); }
	
	
	$sql4 = "select * from flc_page where mem_id = '$memid' and pag_id = '$pagid';";
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) {
		
		$pagcheck = "t";
		
		if ($dbarr4['pag_status'] == 'd') { if ($_SESSION['vp'] != 'exe' && $_SESSION['vp'] != 'adm') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } }
		
		if ($dbarr4['pag_type'] != 'inq') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); }
		
		if ($langcode == 'en' && $dbarr4['pag_show_en'] != 't') { 
			if ($prfshowen == 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_profile.php?id=".$memid."&page=".$prfshowid."&lang=en\">"; exit(); }
			else { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } 
		}
		
		if ($langcode == 'jp' && $dbarr4['pag_show_jp'] != 't') { 
			if ($prfshowjp == 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_profile.php?id=".$memid."&page=".$prfshowid."&lang=jp\">"; exit(); }
			else { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } 
		}
		
		if ($langcode == 'vn' && $dbarr4['pag_show_vn'] != 't') { 
			if ($prfshowvn == 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_profile.php?id=".$memid."&page=".$prfshowid."&lang=vn\">"; exit(); }
			else { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php?id\">"; exit(); } 
		}
		
		if ($dbarr4['pag_show_en'] == 't' || $prfshowen == 't') { $langen = "<a href=\"mem_inquiry_done.php?id=".$memid."&page=".$pagid."&lang=en&code=".$code."\"><img src=\"images/tpl_".$memlangpicen."\" title=\"English\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
		else { $langen = "<img src=\"images/tpl_en_00.png\" width=\"24\" height=\"24\" border=\"0\" />"; }
		
		if ($dbarr4['pag_show_jp'] == 't' || $prfshowjp == 't') { $langjp = "<a href=\"mem_inquiry_done.php?id=".$memid."&page=".$pagid."&lang=jp&code=".$code."\"><img src=\"images/tpl_".$memlangpicjp."\" title=\"日本語\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
		else { $langjp = "<img src=\"images/tpl_jp_00.png\" width=\"24\" height=\"24\" border=\"0\" />"; }
		
		if ($dbarr4['pag_show_vn'] == 't' || $prfshowvn == 't') { $langvn = "<a href=\"mem_inquiry_done.php?id=".$memid."&page=".$pagid."&lang=vn&code=".$code."\"><img src=\"images/tpl_".$memlangpicvn."\" title=\"Việt Nam\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
		else { $langvn = "<img src=\"images/tpl_vn_00.png\" width=\"24\" height=\"24\" border=\"0\" />"; }
		
		$pagpagetitleen = $dbarr4['pag_pagetitle_en'];
		$pagpagetitlejp = $dbarr4['pag_pagetitle_jp'];
		$pagpagetitlevn = $dbarr4['pag_pagetitle_vn'];
		$pagtitleen = $dbarr4['pag_title_en'];
		$pagtitlejp = $dbarr4['pag_title_jp'];
		$pagtitlevn = $dbarr4['pag_title_vn'];
		$pagtitlecolor = "#".$dbarr4['pag_title_color'];
		$pagdetailen = $dbarr4['pag_detail_en'];
		$pagdetailjp = $dbarr4['pag_detail_jp'];
		$pagdetailvn = $dbarr4['pag_detail_vn'];
		$pagimage = $dbarr4['pag_image'];
		$pagimagewidth = $dbarr4['pag_image_width'];
		$pagimagelink = $dbarr4['pag_image_link'];
		
		if ($pagimage == 't') { 
			
			$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-P.jpg";
			if ($pagimagewidth == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $pagimagewidth; }
			if ($imgwidth > 760) { $imgwidth = 760; }
			if ($imgwidth >= 755) { $imgclass = "topimgfull"; } else { $imgclass = "topimg"; }
			$pagimage = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" />"; 
			if ($pagimagelink == 't') { $pagimage = "<a href=\"".$imgpath."\" target=\"_blank\">".$pagimage."</a>"; }
		}
		
	}
	
	if ($pagcheck != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); }
	
	// language
	if ($langcode == 'en') { 
		$memsubdesc = $memsubdescen; 
		$memfooter = $memfooteren;
		$memcomname = $memcomnameen;
		$pagpagetitle = $pagpagetitleen;
		$pagtitle = $pagtitleen;
		$pagdetail = $pagdetailen;
		
		$tx_inqalert_1_1 = "Your inquiry has been sent.";
		$tx_inqalert_1_2 = "Please wait for the reply. If you haven't receive any reply in several days, <br />please contact Fact-Link to find out the reason. <a href=\"contact.php\" target=\"_blank\">Go to contact form, click here.</a>";
		$tx_inqalert_2_1 = "Fail to send your inquiry. Please try again.";
		$tx_inqalert_2_2 = "Cannot send your inquiry because of some network problem. Please check your internet connection. <br />If it's still failed after trying multiple times, please contact Fact-Link. <a href=\"contact.php\" target=\"_blank\">Go to contact form, click here.</a>";
		
	} 
	
	else if ($langcode == 'vn') { 
		$memsubdesc = $memsubdescvn; 
		$memfooter = $memfootervn;
		$memcomname = $memcomnamevn;
		$pagpagetitle = $pagpagetitlevn;
		$pagtitle = $pagtitlevn;
		$pagdetail = $pagdetailvn;
		
		$tx_inqalert_1_1 = "Your inquiry has been sent.";
		$tx_inqalert_1_2 = "Please wait for the reply. If you haven't receive any reply in several days, <br />please contact Fact-Link to find out the reason. <a href=\"contact.php\" target=\"_blank\">Go to contact form, click here.</a>";
		$tx_inqalert_2_1 = "Fail to send your inquiry. Please try again.";
		$tx_inqalert_2_2 = "Cannot send your inquiry because of some network problem. Please check your internet connection. <br />If it's still failed after trying multiple times, please contact Fact-Link. <a href=\"contact.php\" target=\"_blank\">Go to contact form, click here.</a>";
		
	} 
	
	else { 
		$memsubdesc = $memsubdescjp; 
		$memfooter = $memfooterjp;
		$memcomname = $memcomnamejp;
		$pagpagetitle = $pagpagetitlejp;
		$pagtitle = $pagtitlejp;
		$pagdetail = $pagdetailjp;
		
		$tx_inqalert_1_1 = "お問い合わせ送信完了しました。";
		$tx_inqalert_1_2 = "お問い合わせ企業からの回答をお待ちください。数日経っても何の返事もない場合は、<br />ファクトリンク事務局から確認可能ですので、その際は、お手数ですがご連絡ください。<a href=\"contact.php\" target=\"_blank\">こちらをクリック。</a>";
		$tx_inqalert_2_1 = "問題が生じた為、お問い合わせは送信できません　再度お試しください。";
		$tx_inqalert_2_2 = "回線状況が混み合っているなどの為、お問い合わせメールの送信に失敗しました。<br />インターネットの接続状況などをご確認ください。何度お試しになっても送信が出来ない場合は、<br />お手数ですがファクトリンク事務局にご連絡ください。<a href=\"contact.php\" target=\"_blank\">こちらをクリック。</a>";
		
	} 
	
	$pagtitle = "<font color=\"".$pagtitlecolor."\"><h2 class=\"h2_title\">".subhtml($pagtitle)."</h2></font>";
	$pagdetail = $pagimage.$pagtitle.html($pagdetail);
	
	//-----
	
	if ($code == '1') { 
		$inqalert = "<h2 class=\"h2_title\"><img src=\"images/icon_done_01.png\" width=\"20\" height=\"20\" align=\"absmiddle\" /> <span class=\"green_n\">".$tx_inqalert_1_1."</span></h2><br />".$tx_inqalert_1_2;
	} else if ($code == '2') {
		$inqalert = "<h2 class=\"h2_title\"><img src=\"images/icon_delete_01.png\" width=\"20\" height=\"20\" align=\"absmiddle\" /> <span class=\"red_n\">".$tx_inqalert_2_1."</span></h2><br />".$tx_inqalert_2_2;
	}
	
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##pagid##", $pagid);
	$tpl->assign("##prfshowid##", $prfshowid);
	$tpl->assign("##pagdetail##", $pagdetail);
	$tpl->assign("##pagpagetitle##", $pagpagetitle);
	$tpl->assign("##pagtitlecolor##", $pagtitlecolor);
	$tpl->assign("##memcomname##", $memcomname);
	$tpl->assign("##memsubdesc##", $memsubdesc);
	$tpl->assign("##memfooter##", $memfooter);
	$tpl->assign("##memseocom##", $memseocom);
	$tpl->assign("##memseokey##", $memseokey);
	$tpl->assign("##tpmcode##", $tpmcode);
	$tpl->assign("##inqalert##", $inqalert);
	$tpl->assign("##langcode##", $langcode);
	$tpl->assign("##langen##", $langen);
	$tpl->assign("##langjp##", $langjp);
	$tpl->assign("##langvn##", $langvn);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
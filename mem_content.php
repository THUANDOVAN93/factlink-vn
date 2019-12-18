<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "mem_structure.html"; 
	$url2 = "mem_content.html"; 
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_GET['id'];
	$pagid = $_GET['page'];
	$langcode = $_GET['lang'];
	
	// --- Global Template Section	
	include_once("./include/global_memvalue.php");
	
	$sql1 = "select * from flc_member where mem_id = '$memid';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($dbarr1['mem_status'] == 'd') { if ($_SESSION['vp'] != 'exe' && $_SESSION['vp'] != 'adm') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } }
		
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
	while ($dbarr3 = mysql_fetch_array($result3)) { $prfshowid = $dbarr3['pag_id']; $prfshowen = $dbarr3['pag_show_en']; $prfshowjp = $dbarr3['pag_show_jp']; $prfshowvn = $dbarr3['pag_show_vn']; }
	
	if ($langcode == 'en') { if ($prfshowen != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } }
	else if ($langcode == 'jp') { if ($prfshowjp != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } }
	else if ($langcode == 'vn') { if ($prfshowvn != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } }
	else { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); }
	
	
	$sql4 = "select * from flc_page where mem_id = '$memid' and pag_id = '$pagid';";
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) {
		
		$pagcheck = "t";
		
		if ($dbarr4['pag_status'] == 'd') { if ($_SESSION['vp'] != 'exe' && $_SESSION['vp'] != 'adm') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); } }
		
		if ($dbarr4['pag_type'] != 'con') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); }
		
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
		
		if ($dbarr4['pag_show_en'] == 't' || $prfshowen == 't') { $langen = "<a href=\"mem_content.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/tpl_".$memlangpicen."\" title=\"English\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
		else { $langen = "<img src=\"images/tpl_en_00.png\" width=\"24\" height=\"24\" border=\"0\" />"; }
		
		if ($dbarr4['pag_show_jp'] == 't' || $prfshowjp == 't') { $langjp = "<a href=\"mem_content.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/tpl_".$memlangpicjp."\" title=\"日本語\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
		else { $langjp = "<img src=\"images/tpl_jp_00.png\" width=\"24\" height=\"24\" border=\"0\" />"; }
		
		if ($dbarr4['pag_show_vn'] == 't' || $prfshowvn == 't') { $langvn = "<a href=\"mem_content.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/tpl_".$memlangpicvn."\" title=\"Việt Nam\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
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
			if ($pagimagewidth == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $pagimagewidth; }
			if ($imgwidth > 760) { $imgwidth = 760; }
			if ($imgwidth >= 755) { $imgclass = $imgsidefull; } else { $imgclass = $imgside; } 
			$pagimage = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" />"; 
			if ($pagimagelink == 't') { $pagimage = "<a href=\"".$imgpath."\" target=\"_blank\">".$pagimage."</a>"; }
		}

		if ($pagimage == 't' && $pagemedia_option == 'video') {
			if ($pagimagelink == 't') {
				$video_position_class = "video-origin";
			}
			$pagimage = '';
			$pagvideo_html = "<div class=\"home-video-top ".$video_position_class."\">".$dbarr4['pag_video_link']."</div>";
		}

		// EDIT BY THUANDO
		
		
		// if ($pagimageside == 'r') { 
		// 	$imgside = "colimg-defright";
		// 	$imgsidefull = "colimg-defright-full";
		// } else {
		// 	$imgside = "colimg-defleft";
		// 	$imgsidefull = "colimg-defleft-full";
		// }

		// if ($pagimage == 't') { 
			
		// 	$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-P.jpg";
		// 	if ($pagimagewidth == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $pagimagewidth; }
		// 	if ($imgwidth > 760) { $imgwidth = 760; }
		// 	if ($imgwidth >= 755) { $imgclass = $imgsidefull; } else { $imgclass = $imgside; } 
		// 	$pagimage = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" />"; 
		// 	if ($pagimagelink == 't') { $pagimage = "<a href=\"".$imgpath."\" target=\"_blank\">".$pagimage."</a>"; }
		// }

		// END BY THUANDO
		
	}
	
	if ($pagcheck != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); }
	
	// Image Class ----------
	
	function colimgclass($pattern, $width) {
		
		/*if ($pattern == '001' || $pattern == '003') { if ($width >= 755) { $class = "colimg-defleft-full"; } else { $class = "colimg-defleft"; } }
		else if ($pattern == '002' || $pattern == '005') { if ($width >= 755) { $class = "colimg-defright-full"; } else { $class = "colimg-defright"; } }
		else if ($pattern == '004') { $class = "colimg-top"; }
		else if ($pattern == '006' || $pattern == '007' || $pattern == '008') { $class = "colimg-bottom"; }*/
		
		if ($pattern == '001' || $pattern == '003' || $pattern == '005') { if ($width >= 755) { $class = "colimg-defleft-full"; } else { $class = "colimg-defleft"; } }
		else if ($pattern == '002' || $pattern == '004' || $pattern == '006') { if ($width >= 755) { $class = "colimg-defright-full"; } else { $class = "colimg-defright"; } }
			
		return $class;
		
	}
	
	// Pattern Column ----------
	
	$sql5 = "select * from flc_content where pag_id = '$pagid' and con_status != 'd' order by con_sort asc;";
	$result5 = mysql_query($sql5);
	while ($dbarr5 = mysql_fetch_array($result5)) {
	
		if ($langcode == 'en') {
			$contitle = subhtml($dbarr5['con_title_en']);
			$consubtitle = $dbarr5['con_subtitle_en'];
			$condetail = $dbarr5['con_detail_en'];
		} else if ($langcode == 'vn') {
			$contitle = subhtml($dbarr5['con_title_vn']);
			$consubtitle = $dbarr5['con_subtitle_vn'];
			$condetail = $dbarr5['con_detail_vn'];
		} else {
			$contitle = subhtml($dbarr5['con_title_jp']);
			$consubtitle = $dbarr5['con_subtitle_jp'];
			$condetail = $dbarr5['con_detail_jp'];
		}
		
		$contitlecolor = "#".$dbarr5['con_title_color'];
		$consubtitlecolor = "#666666";		
		$conpattern = $dbarr5['con_pattern']; if ($conpattern == '') { $conpattern = "001"; }
		$conimage = $dbarr5['con_image'];
		$conimagewidth = $dbarr5['con_image_width'];
		$conimagelink = $dbarr5['con_image_link'];

		$convideolink = $dbarr5['con_video_link'];
		$conmedia_option = $dbarr5['con_media_option'];

		$conid = $dbarr5['con_id'];
		$convideo_html = '';


		
		// EDIT BY THUANDO


		
		if ($conimage == 't' && $conmedia_option == 'image') { 
			$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-".$conid."-C.jpg";
			if ($conimagewidth == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $conimagewidth; }
			if ($imgwidth > 760) { $imgwidth = 760; }
			$imgclass = colimgclass($conpattern, $imgwidth);
			$conimage = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" />"; 
			if ($conimagelink == 't') { $conimage = "<a href=\"".$imgpath."\" target=\"_blank\">".$conimage."</a>"; }
		}

		$con_video_position_class = 'video-left';
		if ($conpattern == '001' || $conpattern == '003') {
			$con_video_position_class = 'video-left';
		} else {
			$con_video_position_class = 'video-right';
		}

		if ($conimage == 't' && $conmedia_option == 'video') { 
			if ($conimagelink == 't') {
				$con_video_position_class = "video-origin";
			}
			$conimage = '';
			$convideo_html = "<div class=\"".$con_video_position_class."\">".$convideolink."</div>";
		}
			
		$contitle = "<font color=\"".$contitlecolor."\"><h3 class=\"h3_title\">".$contitle."</h3></font>";
		if ($consubtitle != '') { $consubtitle = "<font color=\"".$consubtitlecolor."\">".$consubtitle."</font><br />"; }
		
		$contable = "<tr><td><table width=\"760\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
		
		if ($conpattern == '001' || $conpattern == '002') { $contable = $contable."<tr><td>".$conimage.$convideo_html.$contitle.$consubtitle."<br />".html($condetail)."</td></tr><tr><td><img src=\"images/line_h_01.png\" width=\"760\" height=\"20\" /></td></tr>"; }
		else if ($conpattern == '003' || $conpattern == '004') { $contable = $contable."<tr>
        <td width=\"10\" bgcolor=\"".$contitlecolor."\"><img src=\"images/blank.png\" width=\"10\" height=\"5\" /></td>
        <td width=\"750\" background=\"images/bg_03.png\"><table width=\"750\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
          <tr><td colspan=\"2\" bgcolor=\"".$contitlecolor."\"><img src=\"images/blank.png\" width=\"750\" height=\"1\" /></td></tr>
		  <tr><td colspan=\"2\"><img src=\"images/blank.png\" width=\"750\" height=\"5\" /></td></tr>
          <tr>
            <td width=\"5\"><img src=\"images/blank.png\" width=\"5\" height=\"5\" /></td>
            <td width=\"745\">".$contitle.$consubtitle."</td>
          </tr>
          <tr><td colspan=\"2\"><img src=\"images/blank.png\" width=\"750\" height=\"5\" /></td></tr>
        </table></td>
        </tr>
      <tr><td colspan=\"2\"><img src=\"images/blank.png\" width=\"760\" height=\"10\" /></td></tr>
	  <tr><td colspan=\"2\">".$conimage.$convideo_html.html($condetail)."</td></tr>
		<tr><td colspan=\"2\"><img src=\"images/blank.png\" width=\"760\" height=\"10\" /></td></tr>"; }
		else if ($conpattern == '005' || $conpattern == '006') { $contable = $contable."<tr><td>".$conimage.$convideo_html.$contitle.$consubtitle."<br />".html($condetail)."</td></tr><tr><td><img src=\"images/blank.png\" width=\"760\" height=\"10\" /></td></tr>"; }
				
		$contable = $contable."</table></td></tr>";
		
		$tpl->assign("##contable##", $contable);
		$tpl->parse ("#####ROW#####", '.rows_con');
		
	}
	
	// language
	if ($langcode == 'en') { 
		$memsubdesc = $memsubdescen; 
		$memfooter = $memfooteren;
		$memcomname = $memcomnameen;
		$pagpagetitle = $pagpagetitleen;
		$pagtitle = $pagtitleen;
		$pagdetail = $pagdetailen;
		
	} 
	
	else if ($langcode == 'vn') { 
		$memsubdesc = $memsubdescvn; 
		$memfooter = $memfootervn;
		$memcomname = $memcomnamevn;
		$pagpagetitle = $pagpagetitlevn;
		$pagtitle = $pagtitlevn;
		$pagdetail = $pagdetailvn;
		
	} 
	
	else { 
		$memsubdesc = $memsubdescjp; 
		$memfooter = $memfooterjp;
		$memcomname = $memcomnamejp;
		$pagpagetitle = $pagpagetitlejp;
		$pagtitle = $pagtitlejp;
		$pagdetail = $pagdetailjp;
		
	} 
	
	$pagtitle = "<font color=\"".$pagtitlecolor."\"><h2 class=\"h2_title\">".subhtml($pagtitle)."</h2></font>";
	$pagdetail = $pagimage.$pagvideo_html.$pagtitle.html($pagdetail);

	// Customize CSS For Special Company
	if ($memid == "00001109") {
		$memsubdesc = "<p style=\"margin: 0;padding-left: 25px;line-height: 18px;\">".$memsubdesc."</p>";
		$memcomname = "<span style=\"display: inline-block;width: 25px;\"></span>".$memcomname;
	}
	if (!empty($memPackage) && !empty($pagpagetitle)) {
		$metaTitle = $pagpagetitle;
	}
	
	$tpl->assign("##metaTitle##", $metaTitle);
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##pagdetail##", $pagdetail);
	$tpl->assign("##pagpagetitle##", $pagpagetitle);
	$tpl->assign("##pagtitlecolor##", $pagtitlecolor);
	$tpl->assign("##memcomname##", $memcomname);
	$tpl->assign("##memsubdesc##", $memsubdesc);
	$tpl->assign("##memfooter##", $memfooter);
	$tpl->assign("##memseocom##", $memseocom);
	$tpl->assign("##memseokey##", $memseokey);
	$tpl->assign("##tpmcode##", $tpmcode);
	$tpl->assign("##langen##", $langen);
	$tpl->assign("##langjp##", $langjp);
	$tpl->assign("##langvn##", $langvn);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
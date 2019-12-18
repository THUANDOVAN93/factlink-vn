<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "mem_structure.html"; 
	$url2 = "mem_home.html"; 
	
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
		
		if ($dbarr4['pag_type'] != 'hom') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); }
		
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
		
		if ($dbarr4['pag_show_en'] == 't' || $prfshowen == 't') { $langen = "<a href=\"mem_home.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/tpl_".$memlangpicen."\" title=\"English\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
		else { $langen = "<img src=\"images/tpl_en_00.png\" width=\"24\" height=\"24\" border=\"0\" />"; }
		
		if ($dbarr4['pag_show_jp'] == 't' || $prfshowjp == 't') { $langjp = "<a href=\"mem_home.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/tpl_".$memlangpicjp."\" title=\"日本語\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
		else { $langjp = "<img src=\"images/tpl_jp_00.png\" width=\"24\" height=\"24\" border=\"0\" />"; }
		
		if ($dbarr4['pag_show_vn'] == 't' || $prfshowvn == 't') { $langvn = "<a href=\"mem_home.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/tpl_".$memlangpicvn."\" title=\"Việt Nam\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
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
			$video_position = "right";
		} else { 
			$imgside = "colimg-defleft";
			$imgsidefull = "colimg-defleft-full";
		}

		if ($pagimageside == 'l') {
			$video_margin = "10px";
			$video_position = 'left';
		} else {
			$video_margin = "0";
		}

		if ( $pagimage == 't' && $pagemedia_option == 'image' ) { 
			
			$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-P.jpg";
			if ($pagimagewidth == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $pagimagewidth; }
			if ($imgwidth > 760) { $imgwidth = 760; }
			if ($imgwidth >= 755) { $imgclass = $imgsidefull; } else { $imgclass = $imgside; } 
			$pagimage = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" />"; 
			if ($pagimagelink == 't') { $pagimage = "<a href=\"".$imgpath."\" target=\"_blank\">".$pagimage."</a>"; }
		}		
		if ( $pagimage == 't' && $pagemedia_option == 'video' ) {
			if ($pagimagelink == 't') {
				$video_position = "none";
				$video_margin = "0";
			}
			$pagimage = '';
			$pagvideo_html = "<div class=\"home-video-top\" style=\"float:".$video_position." ; margin-right:".$video_margin."\">".$dbarr4['pag_video_link']."</div>";
		}
	}
	
	if ($pagcheck != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); }
	
	
	$sql5 = "select * from flc_home where mem_id = '$memid';";
	$result5 = mysql_query($sql5);
	while ($dbarr5 = mysql_fetch_array($result5)) {
	
		$homtemplate = $dbarr5['hom_template'];
		$homkeytitleen = $dbarr5['hom_keytitle_en'];
		$homkeytitlejp = $dbarr5['hom_keytitle_jp'];
		$homkeytitlevn = $dbarr5['hom_keytitle_vn'];
		$homkeytitlecolor = "#".$dbarr5['hom_keytitle_color'];
		$homkeydetailen = $dbarr5['hom_keydetail_en'];
		$homkeydetailjp = $dbarr5['hom_keydetail_jp'];
		$homkeydetailvn = $dbarr5['hom_keydetail_vn'];
		$homkeytitle1en = $dbarr5['hom_keytitle1_en'];
		$homkeytitle1jp = $dbarr5['hom_keytitle1_jp'];
		$homkeytitle1vn = $dbarr5['hom_keytitle1_vn'];
		$homkeydetail1en = $dbarr5['hom_keydetail1_en'];
		$homkeydetail1jp = $dbarr5['hom_keydetail1_jp'];
		$homkeydetail1vn = $dbarr5['hom_keydetail1_vn'];
		$homkeytitle2en = $dbarr5['hom_keytitle2_en'];
		$homkeytitle2jp = $dbarr5['hom_keytitle2_jp'];
		$homkeytitle2vn = $dbarr5['hom_keytitle2_vn'];
		$homkeydetail2en = $dbarr5['hom_keydetail2_en'];
		$homkeydetail2jp = $dbarr5['hom_keydetail2_jp'];
		$homkeydetail2vn = $dbarr5['hom_keydetail2_vn'];
		$homkeytitle3en = $dbarr5['hom_keytitle3_en'];
		$homkeytitle3jp = $dbarr5['hom_keytitle3_jp'];
		$homkeytitle3vn = $dbarr5['hom_keytitle3_vn'];
		$homkeydetail3en = $dbarr5['hom_keydetail3_en'];
		$homkeydetail3jp = $dbarr5['hom_keydetail3_jp'];
		$homkeydetail3vn = $dbarr5['hom_keydetail3_vn'];
		$homlinetitleen = $dbarr5['hom_linetitle_en'];
		$homlinetitlejp = $dbarr5['hom_linetitle_jp'];
		$homlinetitlevn= $dbarr5['hom_linetitle_vn'];
		$homlinetitlecolor = "#".$dbarr5['hom_linetitle_color'];
		$homlinedetailen = $dbarr5['hom_linedetail_en'];
		$homlinedetailjp = $dbarr5['hom_linedetail_jp'];
		$homlinedetailvn = $dbarr5['hom_linedetail_vn'];
		$homlinetitle1en = $dbarr5['hom_linetitle1_en'];
		$homlinetitle1jp = $dbarr5['hom_linetitle1_jp'];
		$homlinetitle1vn = $dbarr5['hom_linetitle1_vn'];
		$homlinedetail1en = $dbarr5['hom_linedetail1_en'];
		$homlinedetail1jp = $dbarr5['hom_linedetail1_jp'];
		$homlinedetail1vn = $dbarr5['hom_linedetail1_vn'];
		$homlineimage1 = $dbarr5['hom_lineimage1'];
		$homlineimage1width = $dbarr5['hom_lineimage1_width'];
		$homlineimage1link = $dbarr5['hom_lineimage1_link'];

		$hom_linevideo1_link = $dbarr5['hom_linevideo1_link'];
		$hom_media_option1 = $dbarr5['hom_media_option1'];

		$homlinetitle2en = $dbarr5['hom_linetitle2_en'];
		$homlinetitle2jp = $dbarr5['hom_linetitle2_jp'];
		$homlinetitle2vn = $dbarr5['hom_linetitle2_vn'];
		$homlinedetail2en = $dbarr5['hom_linedetail2_en'];
		$homlinedetail2jp = $dbarr5['hom_linedetail2_jp'];
		$homlinedetail2vn = $dbarr5['hom_linedetail2_vn'];
		$homlineimage2 = $dbarr5['hom_lineimage2'];
		$homlineimage2width = $dbarr5['hom_lineimage2_width'];
		$homlineimage2link = $dbarr5['hom_lineimage2_link'];


		$hom_linevideo2_link = $dbarr5['hom_linevideo2_link'];
		$hom_media_option2 = $dbarr5['hom_media_option2'];

		$homlinetitle3en = $dbarr5['hom_linetitle3_en'];
		$homlinetitle3jp = $dbarr5['hom_linetitle3_jp'];
		$homlinetitle3vn= $dbarr5['hom_linetitle3_vn'];
		$homlinedetail3en = $dbarr5['hom_linedetail3_en'];
		$homlinedetail3jp = $dbarr5['hom_linedetail3_jp'];
		$homlinedetail3vn = $dbarr5['hom_linedetail3_vn'];
		$homlineimage3 = $dbarr5['hom_lineimage3'];
		$homlineimage3width = $dbarr5['hom_lineimage3_width'];
		$homlineimage3link = $dbarr5['hom_lineimage3_link'];

		$hom_linevideo3_link = $dbarr5['hom_linevideo3_link'];
		$hom_media_option3 = $dbarr5['hom_media_option3'];

		$homdescen = $dbarr5['hom_description_en'];
		$homdescjp = $dbarr5['hom_description_jp'];
		$homdescvn = $dbarr5['hom_description_vn'];
	
	}
	
	$sql6 = "select * from flc_template_key where tpk_id = '$homtemplate';";
	$result6 = mysql_query($sql6);
	while ($dbarr6 = mysql_fetch_array($result6)) { $tpkcode = $dbarr6['tpk_name_file']; $tpktitlecolor = "#".$dbarr6['tpk_title_color']; } 
	
	// language
	if ($langcode == 'en') { 
		$memsubdesc = $memsubdescen; 
		$memfooter = $memfooteren;
		$memcomname = $memcomnameen;
		$pagpagetitle = $pagpagetitleen;
		$pagtitle = $pagtitleen;
		$pagdetail = $pagdetailen;
		
		$homkeytitle = $homkeytitleen;
		$homkeydetail = $homkeydetailen;
		$homkeytitle1 = $homkeytitle1en;
		$homkeydetail1 = $homkeydetail1en;
		$homkeytitle2 = $homkeytitle2en;
		$homkeydetail2 = $homkeydetail2en;
		$homkeytitle3 = $homkeytitle3en;
		$homkeydetail3 = $homkeydetail3en;
		$homlinetitle = $homlinetitleen;
		$homlinedetail = $homlinedetailen;
		$homlinetitle1 = $homlinetitle1en;
		$homlinedetail1 = $homlinedetail1en;
		$homlinetitle2 = $homlinetitle2en;
		$homlinedetail2 = $homlinedetail2en;
		$homlinetitle3 = $homlinetitle3en;
		$homlinedetail3 = $homlinedetail3en;
		$homdesc = $homdescen;
		
	} 
	
	else if ($langcode == 'vn') { 
		$memsubdesc = $memsubdescvn; 
		$memfooter = $memfootervn;
		$memcomname = $memcomnamevn;
		$pagpagetitle = $pagpagetitlevn;
		$pagtitle = $pagtitlevn;
		$pagdetail = $pagdetailvn;
		
		$homkeytitle = $homkeytitlevn;
		$homkeydetail = $homkeydetailvn;
		$homkeytitle1 = $homkeytitle1vn;
		$homkeydetail1 = $homkeydetail1vn;
		$homkeytitle2 = $homkeytitle2vn;
		$homkeydetail2 = $homkeydetail2vn;
		$homkeytitle3 = $homkeytitle3vn;
		$homkeydetail3 = $homkeydetail3vn;
		$homlinetitle = $homlinetitlevn;
		$homlinedetail = $homlinedetailvn;
		$homlinetitle1 = $homlinetitle1vn;
		$homlinedetail1 = $homlinedetail1vn;
		$homlinetitle2 = $homlinetitle2vn;
		$homlinedetail2 = $homlinedetail2vn;
		$homlinetitle3 = $homlinetitle3vn;
		$homlinedetail3 = $homlinedetail3vn;
		$homdesc = $homdescvn;
		
	} 
	
	else { 
		$memsubdesc = $memsubdescjp; 
		$memfooter = $memfooterjp;
		$memcomname = $memcomnamejp;
		$pagpagetitle = $pagpagetitlejp;
		$pagtitle = $pagtitlejp;
		$pagdetail = $pagdetailjp;
		
		$homkeytitle = $homkeytitlejp;
		$homkeydetail = $homkeydetailjp;
		$homkeytitle1 = $homkeytitle1jp;
		$homkeydetail1 = $homkeydetail1jp;
		$homkeytitle2 = $homkeytitle2jp;
		$homkeydetail2 = $homkeydetail2jp;
		$homkeytitle3 = $homkeytitle3jp;
		$homkeydetail3 = $homkeydetail3jp;
		$homlinetitle = $homlinetitlejp;
		$homlinedetail = $homlinedetailjp;
		$homlinetitle1 = $homlinetitle1jp;
		$homlinedetail1 = $homlinedetail1jp;
		$homlinetitle2 = $homlinetitle2jp;
		$homlinedetail2 = $homlinedetail2jp;
		$homlinetitle3 = $homlinetitle3jp;
		$homlinedetail3 = $homlinedetail3jp;
		$homdesc = $homdescjp;
	} 
	
	$pagtitle = "<font color=\"".$pagtitlecolor."\"><h2 class=\"h2_title\">".subhtml($pagtitle)."</h2></font>";
	$pagdetail = $pagimage.$pagvideo_html.$pagtitle.html($pagdetail);
	
	if ($homkeytitle != '') {
		
		$homkeycheck = "t";
		$homkey = "<tr><td valign=\"top\"><font color=\"".$homkeytitlecolor."\"><h3 class=\"h3_title\">".subhtml($homkeytitle)."</h3></font>";
		if ($homkeydetail != '') { $homkey = $homkey.html($homkeydetail); }
		$homkey = $homkey."</td></tr>";
		
	}
	
	if ($homkeytitle1 != '' || $homkeytitle2 != '' || $homkeytitle3 != '') {
		
		$homkeycheck = "t";
		if ($homkeytitle != '') { $homkey = $homkey."<tr><td valign=\"top\"><img src=\"images/blank.png\" width=\"760\" height=\"10\" /></td></tr>"; }
		$homkeytitle1 = "<font color=\"".$tpktitlecolor."\"><h3 class=\"h3_title\">".subhtml($homkeytitle1)."</h3></font>";
		$homkeytitle2 = "<font color=\"".$tpktitlecolor."\"><h3 class=\"h3_title\">".subhtml($homkeytitle2)."</h3></font>";
		$homkeytitle3 = "<font color=\"".$tpktitlecolor."\"><h3 class=\"h3_title\">".subhtml($homkeytitle3)."</h3></font>";
		
		$homkey = $homkey."<tr>
        <td valign=\"top\"><table width=\"760\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
          <tr>
            <td colspan=\"5\" valign=\"top\"><img src=\"images/tplkey_".$tpkcode."_01.png\" width=\"760\" height=\"10\" /></td>
            </tr>
          <tr>
            <td width=\"240\" valign=\"top\" background=\"images/tplkey_".$tpkcode."_02.png\"><table width=\"240\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
                <td width=\"220\" valign=\"top\">".$homkeytitle1."</td>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
              </tr>
			  <tr>
                <td colspan=\"3\"><img src=\"images/blank.png\" width=\"240\" height=\"5\" /></td>
              </tr>
			  <tr>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
                <td width=\"220\" valign=\"top\">".html($homkeydetail1)."</td>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
              </tr>
            </table></td>
            <td width=\"20\" valign=\"top\"><img src=\"images/blank.png\" width=\"20\" height=\"5\" /></td>
            <td width=\"240\" valign=\"top\" background=\"images/tplkey_".$tpkcode."_02.png\"><table width=\"240\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
                <td width=\"220\" valign=\"top\">".$homkeytitle2."</td>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
              </tr>
			  <tr>
                <td colspan=\"3\"><img src=\"images/blank.png\" width=\"240\" height=\"5\" /></td>
              </tr>
			  <tr>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
                <td width=\"220\" valign=\"top\">".html($homkeydetail2)."</td>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
              </tr>
            </table></td>
            <td width=\"20\" valign=\"top\"><img src=\"images/blank.png\" width=\"20\" height=\"5\" /></td>
            <td width=\"240\" valign=\"top\" background=\"images/tplkey_".$tpkcode."_02.png\"><table width=\"240\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
                <td width=\"220\" valign=\"top\">".$homkeytitle3."</td>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
              </tr>
			  <tr>
                <td colspan=\"3\"><img src=\"images/blank.png\" width=\"240\" height=\"5\" /></td>
              </tr>
			  <tr>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
                <td width=\"220\" valign=\"top\">".html($homkeydetail3)."</td>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan=\"5\" valign=\"top\"><img src=\"images/tplkey_".$tpkcode."_03.png\" width=\"760\" height=\"10\" /></td>
            </tr>
        </table></td>
      </tr>";
	
	}
	
	if ($homkeycheck == 't') { $homkey = $homkey."<tr><td valign=\"top\"><img src=\"images/blank.png\" width=\"760\" height=\"10\" /></td></tr>"; }
	else { $homkey = ""; }
	
	if ($homlinetitle != '') {
	
		$homlinecheck = "t";
		$homline = "<tr><td bgcolor=\"".$homlinetitlecolor."\"><img src=\"images/blank.png\" width=\"760\" height=\"2\" /></td></tr><tr><td><img src=\"images/blank.png\" width=\"760\" height=\"10\" /></td></tr>";
		$homline = $homline."<tr><td valign=\"top\"><font color=\"".$homlinetitlecolor."\"><h3 class=\"h3_title\">".subhtml($homlinetitle)."</h3></font>";
		if ($homlinedetail != '') { $homline = $homline.html($homlinedetail); }
		$homline = $homline."</td></tr><tr><td valign=\"top\"><img src=\"images/line_h_03.png\" width=\"760\" height=\"20\" /></td></tr>";
	
	}
	
	if ($homlinetitle1 != '' || $homlinetitle2 != '' || $homlinetitle3 != '') {
		
		$homlinecheck = "t";
		
		if ($homlinetitle1 != '' || $homlinedetail1 != '' || $homlineimage1 != '') {
			
			if ($homlineimage1 == 't' && $hom_media_option1 == 'image') { 
				$hom_linevideo1_html = "";
				$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-H-1.jpg";
				if ($homlineimage1width == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $homlineimage1width; }
				if ($imgwidth > 760) { $imgwidth = 760; }
				if ($imgwidth >= 755) { $imgclass = "topimgfull"; } else { $imgclass = "topimg"; }
				$homlineimage1 = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" />"; 
				if ($homlineimage1link == 't') { $homlineimage1 = "<a href=\"".$imgpath."\" target=\"_blank\">".$homlineimage1."</a>"; }
			}

			if ($homlineimage1 == 't' && $hom_media_option1 == 'video') {
				$homlineimage1 = '';
				$hom_linevideo1_html = "<div class=\"home-video\">".$hom_linevideo1_link."</div>";
			}

			
			$homlinetitle1 = "<font color=\"".$homlinetitlecolor."\"><h3 class=\"h3_title\">".subhtml($homlinetitle1)."</h3></font>";
			$homdetail1 = $homlineimage1.$hom_linevideo1_html.$homlinetitle1.html($homlinedetail1);
			$homline = $homline."<tr><td valign=\"top\">".$homdetail1."</td></tr><tr><td valign=\"top\"><img src=\"images/line_h_03.png\" width=\"760\" height=\"20\" /></td></tr>";
		
		}
	
		if ($homlinetitle2 != '' || $homlinedetail2 != '' || $homlineimage2 != '') {
			
			if ($homlineimage2 == 't' && $hom_media_option2 == 'image') { 
				$hom_linevideo2_html = "";
				$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-H-2.jpg";
				if ($homlineimage2width == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $homlineimage2width; }
				if ($imgwidth > 760) { $imgwidth = 760; }
				if ($imgwidth >= 755) { $imgclass = "topimgfull"; } else { $imgclass = "topimg"; }
				$homlineimage2 = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" />"; 
				if ($homlineimage2link == 't') { $homlineimage2 = "<a href=\"".$imgpath."\" target=\"_blank\">".$homlineimage2."</a>"; }
			}
			if ($homlineimage2 == 't' && $hom_media_option2 == 'video') {
				$homlineimage2 = '';
				$hom_linevideo2_html = "<div class=\"home-video\">".$hom_linevideo2_link."</div>";
			}
			
			$homlinetitle2 = "<font color=\"".$homlinetitlecolor."\"><h3 class=\"h3_title\">".subhtml($homlinetitle2)."</h3></font>";
			$homdetail2 = $homlineimage2.$hom_linevideo2_html.$homlinetitle2.html($homlinedetail2);
			$homline = $homline."<tr><td valign=\"top\">".$homdetail2."</td></tr><tr><td valign=\"top\"><img src=\"images/line_h_03.png\" width=\"760\" height=\"20\" /></td></tr>";
		
		}
	
		if ($homlinetitle3 != '' || $homlinedetail3 != '' || $homlineimage3 != '') {
			
			if ($homlineimage3 == 't' && $hom_media_option3 == 'image') { 
				$hom_linevideo3_html = "";
				$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-H-3.jpg";
				if ($homlineimage3width == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $homlineimage3width; }
				if ($imgwidth > 760) { $imgwidth = 760; }
				if ($imgwidth >= 755) { $imgclass = "topimgfull"; } else { $imgclass = "topimg"; }
				$homlineimage3 = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" />"; 
				if ($homlineimage3link == 't') { $homlineimage3 = "<a href=\"".$imgpath."\" target=\"_blank\">".$homlineimage3."</a>"; }
			}

			if ($homlineimage3 == 't' && $hom_media_option3 == 'video') {
				$homlineimage3 = '';
				$hom_linevideo3_html = "<div class=\"home-video\">".$hom_linevideo3_link."</div>";
			}
			
			$homlinetitle3 = "<font color=\"".$homlinetitlecolor."\"><h3 class=\"h3_title\">".subhtml($homlinetitle3)."</h3></font>";
			$homdetail3 = $homlineimage3.$hom_linevideo3_html.$homlinetitle3.html($homlinedetail3);
			$homline = $homline."<tr><td valign=\"top\">".$homdetail3."</td></tr><tr><td valign=\"top\"><img src=\"images/line_h_03.png\" width=\"760\" height=\"20\" /></td></tr>";
		
		}
		
	}
	
	if ($homlinecheck == '') { $homline = ""; }
	
	if ($homdesc != '') { $homdesc = "<tr><td valign=\"top\">".html($homdesc)."</td></tr>"; } 

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
	$tpl->assign("##homkey##", $homkey);
	$tpl->assign("##homline##", $homline);
	$tpl->assign("##homdesc##", $homdesc);
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
<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "mem_structure.html"; 
	$url2 = "mem_present.html"; 
	
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
		
		if ($dbarr4['pag_type'] != 'pst') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); }
		
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
		
		if ($dbarr4['pag_show_en'] == 't' || $prfshowen == 't') { $langen = "<a href=\"mem_present.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/tpl_".$memlangpicen."\" title=\"English\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
		else { $langen = "<img src=\"images/tpl_en_00.png\" width=\"24\" height=\"24\" border=\"0\" />"; }
		
		if ($dbarr4['pag_show_jp'] == 't' || $prfshowjp == 't') { $langjp = "<a href=\"mem_present.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/tpl_".$memlangpicjp."\" title=\"日本語\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
		else { $langjp = "<img src=\"images/tpl_jp_00.png\" width=\"24\" height=\"24\" border=\"0\" />"; }
		
		if ($dbarr4['pag_show_vn'] == 't' || $prfshowvn == 't') { $langvn = "<a href=\"mem_present.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/tpl_".$memlangpicvn."\" title=\"Việt Nam\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
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
		if ($pagimageside == 'r') { $imgside = "colimg-defright"; $imgsidefull = "colimg-defright-full"; } else { $imgside = "colimg-defleft"; $imgsidefull = "colimg-defleft-full"; }
		
		if ($pagimage == 't') { 
			
			$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-P.jpg";
			if ($pagimagewidth == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $pagimagewidth; }
			if ($imgwidth > 760) { $imgwidth = 760; }
			if ($imgwidth >= 755) { $imgclass = $imgsidefull; } else { $imgclass = $imgside; } 
			$pagimage = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" />"; 
			if ($pagimagelink == 't') { $pagimage = "<a href=\"".$imgpath."\" target=\"_blank\">".$pagimage."</a>"; }
		}
		
	}
	
	if ($pagcheck != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); }
	
	$sql7 = "select * from flc_present where pag_id = '$pagid';";
	$result7 = mysql_query($sql7);
	while ($dbarr7 = mysql_fetch_array($result7)) { $psttemplate = $dbarr7['pst_template']; }
	
	$sql6 = "select * from flc_template_key where tpk_id = '$psttemplate';";
	$result6 = mysql_query($sql6);
	while ($dbarr6 = mysql_fetch_array($result6)) { $pstcode = $dbarr6['tpk_name_file']; } 
	
	$sql5 = "select * from flc_present_box where pag_id = '$pagid' and box_status != 'd' order by box_sort asc;";
	$result5 = mysql_query($sql5);
	while ($dbarr5 = mysql_fetch_array($result5)) {
	
		$boxid = $dbarr5['box_id'];
		$boxtype1 = $dbarr5['box_type1'];
		$boxtitle1en = $dbarr5['box_title1_en'];
		$boxtitle1jp = $dbarr5['box_title1_jp'];
		$boxtitle1vn = $dbarr5['box_title1_vn'];
		$boxtitle1color = "#".$dbarr5['box_title1_color'];
		$boxdetail1en = $dbarr5['box_detail1_en'];
		$boxdetail1jp = $dbarr5['box_detail1_jp'];
		$boxdetail1vn = $dbarr5['box_detail1_vn'];
		$boximage1 = $dbarr5['box_image1'];
		$boximage1width = $dbarr5['box_image1_width'];
		$boximage1link = $dbarr5['box_image1_link'];
		$boxtype2 = $dbarr5['box_type2'];
		$boxtitle2en = $dbarr5['box_title2_en'];
		$boxtitle2jp = $dbarr5['box_title2_jp'];
		$boxtitle2vn = $dbarr5['box_title2_vn'];
		$boxtitle2color = "#".$dbarr5['box_title2_color'];
		$boxdetail2en = $dbarr5['box_detail2_en'];
		$boxdetail2jp = $dbarr5['box_detail2_jp'];
		$boxdetail2vn = $dbarr5['box_detail2_vn'];
		$boximage2 = $dbarr5['box_image2'];
		$boximage2width = $dbarr5['box_image2_width'];
		$boximage2link = $dbarr5['box_image2_link'];
		$boxtype3 = $dbarr5['box_type3'];
		$boxtitle3en = $dbarr5['box_title3_en'];
		$boxtitle3jp = $dbarr5['box_title3_jp'];
		$boxtitle3vn = $dbarr5['box_title3_vn'];
		$boxtitle3color = "#".$dbarr5['box_title3_color'];
		$boxdetail3en = $dbarr5['box_detail3_en'];
		$boxdetail3jp = $dbarr5['box_detail3_jp'];
		$boxdetail3vn = $dbarr5['box_detail3_vn'];
		$boximage3 = $dbarr5['box_image3'];
		$boximage3width = $dbarr5['box_image3_width'];
		$boximage3link = $dbarr5['box_image3_link'];
	
		if ($boxtype1 == 'image' && $boximage1 == 't') { 
			$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-".$boxid."-B1.jpg";
			if ($boximage1width == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $boximage1width; }
			if ($imgwidth > 220) { $imgwidth = 220; }
			$boximage1 = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" />"; 
			if ($boximage1link == 't') { $boximage1 = "<a href=\"".$imgpath."\" target=\"_blank\">".$boximage1."</a>"; }
			$boximage1 = "<div align=\"center\">".$boximage1."</div>";
		} else { $boximgae1 == ""; }
		
		if ($boxtype2 == 'image' && $boximage2 == 't') { 
			$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-".$boxid."-B2.jpg";
			if ($boximage2width == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $boximage2width; }
			if ($imgwidth > 220) { $imgwidth = 220; }
			$boximage2 = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" />"; 
			if ($boximage2link == 't') { $boximage2 = "<a href=\"".$imgpath."\" target=\"_blank\">".$boximage2."</a>"; }
			$boximage2 = "<div align=\"center\">".$boximage2."</div>";
		} else { $boximgae2 == ""; }
		
		if ($boxtype3 == 'image' && $boximage3 == 't') { 
			$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-".$boxid."-B3.jpg";
			if ($boximage3width == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $boximage3width; }
			if ($imgwidth > 220) { $imgwidth = 220; }
			$boximage3 = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" />"; 
			if ($boximage3link == 't') { $boximage3 = "<a href=\"".$imgpath."\" target=\"_blank\">".$boximage3."</a>"; }
			$boximage3 = "<div align=\"center\">".$boximage3."</div>";
		} else { $boximgae3 == ""; }
		
		if ($langcode == 'en') { $boxtitle1 = $boxtitle1en; $boxdetail1 = $boxdetail1en; $boxtitle2 = $boxtitle2en; $boxdetail2 = $boxdetail2en; $boxtitle3 = $boxtitle3en; $boxdetail3 = $boxdetail3en; } 
		else if ($langcode == 'vn') { $boxtitle1 = $boxtitle1vn; $boxdetail1 = $boxdetail1vn; $boxtitle2 = $boxtitle2vn; $boxdetail2 = $boxdetail2vn; $boxtitle3 = $boxtitle3vn; $boxdetail3 = $boxdetail3vn; } 
		else { $boxtitle1 = $boxtitle1jp; $boxdetail1 = $boxdetail1jp; $boxtitle2 = $boxtitle2jp; $boxdetail2 = $boxdetail2jp; $boxtitle3 = $boxtitle3jp; $boxdetail3 = $boxdetail3jp; } 
		
		$box1 = ""; $box2 = ""; $box3 = "";
		
		if ($boxtype1 == 'text') { $box1 = "<font color=\"".$boxtitle1color."\"><h3 class=\"h3_title\">".$boxtitle1."</h3></font>".html($boxdetail1); }
		else if ($boxtype1 == 'image') { $box1 = $boximage1; }
		
		if ($boxtype2 == 'text') { $box2 = "<font color=\"".$boxtitle2color."\"><h3 class=\"h3_title\">".$boxtitle2."</h3></font>".html($boxdetail2); }
		else if ($boxtype2 == 'image') { $box2 = $boximage2; }
		
		if ($boxtype3 == 'text') { $box3 = "<font color=\"".$boxtitle3color."\"><h3 class=\"h3_title\">".$boxtitle3."</h3></font>".html($boxdetail3); }
		else if ($boxtype3 == 'image') { $box3 = $boximage3; }
				
		$boxdetail = "<tr>
        <td valign=\"top\"><table width=\"760\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
          <tr>
            <td colspan=\"5\" valign=\"top\"><img src=\"images/tplkey_".$pstcode."_01.png\" width=\"760\" height=\"10\" /></td>
            </tr>
          <tr>
            <td width=\"240\" valign=\"top\" background=\"images/tplkey_".$pstcode."_02.png\"><table width=\"240\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
                <td width=\"220\" valign=\"top\">".$box1."</td>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
              </tr>
            </table></td>
            <td width=\"20\" valign=\"top\"><img src=\"images/blank.png\" width=\"20\" height=\"5\" /></td>
            <td width=\"240\" valign=\"top\" background=\"images/tplkey_".$pstcode."_02.png\"><table width=\"240\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
                <td width=\"220\" valign=\"top\">".$box2."</td>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
              </tr>
            </table></td>
            <td width=\"20\" valign=\"top\"><img src=\"images/blank.png\" width=\"20\" height=\"5\" /></td>
            <td width=\"240\" valign=\"top\" background=\"images/tplkey_".$pstcode."_02.png\"><table width=\"240\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
              <tr>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
                <td width=\"220\" valign=\"top\">".$box3."</td>
                <td width=\"10\" valign=\"top\">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan=\"5\" valign=\"top\"><img src=\"images/tplkey_".$pstcode."_03.png\" width=\"760\" height=\"10\" /></td>
            </tr>
        </table></td>
      </tr>";
		
		$tpl->assign("##boxdetail##", $boxdetail);
		$tpl->parse ("#####ROW#####", '.rows_box');
		
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
	$pagdetail = $pagimage.$pagtitle.html($pagdetail);
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
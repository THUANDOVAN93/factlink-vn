<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_page_profile_add.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_GET['id'];
	$langcode = $_GET['lang'];
	
	if ($langcode != 'en' && $langcode != 'jp' && $langcode != 'vn') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=4\">"; exit(); }
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "page_profile_add";
	$currentrec = $memid;
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
	
	$sql0 = "select * from flc_member where mem_id = '$memid';"; 
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { 
		
		if ($_COOKIE['vlang'] == 'en') { $memcomname = $dbarr0['mem_comname_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $memcomname = $dbarr0['mem_comname_vn']; }
		else { $memcomname = $dbarr0['mem_comname_jp']; } 
		
	}
	
	$sql4 = "select * from flc_page where mem_id = '$memid' and pag_type = 'prf';"; 
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) { $pagid = $dbarr4['pag_id']; }
	
	if ($pagid != '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_page_profile_edit.php?id=$memid&page=$pagid&lang=$langcode\">"; exit(); }
	
	$sql1 = "select * from flc_member where mem_id = '$memid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($dbarr1['mem_user'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_view.php?id=$memid\">"; exit(); }
		if ($dbarr1['mem_folder'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_view.php?id=$memid\">"; exit(); }
		
		$memcomnameen = $dbarr1['mem_comname_en'];
		$memcomnamejp = $dbarr1['mem_comname_jp'];
		$memcomnamevn = $dbarr1['mem_comname_vn'];
		$memaddress1en = $dbarr1['mem_address1_en'];
		$memaddress1jp = $dbarr1['mem_address1_jp'];
		$memaddress1vn = $dbarr1['mem_address1_vn'];
		$memaddressine1 = $dbarr1['mem_addressine1'];
		$memaddressprv1 = $dbarr1['mem_addressprv1']; 
		$memaddresscty1 = $dbarr1['mem_addresscty1']; 
		$memaddresszip1 = $dbarr1['mem_addresszip1'];
		$memcomtel = $dbarr1['mem_comtel'];
		$memconnameen = $dbarr1['mem_contactname_en'];
		$memconnamejp = $dbarr1['mem_contactname_jp'];
		$memconnamevn = $dbarr1['mem_contactname_vn'];
		$memconposen = $dbarr1['mem_contactposition_en'];
		$memconposjp = $dbarr1['mem_contactposition_jp'];
		$memconposvn = $dbarr1['mem_contactposition_vn'];
		
		if ($memprv1 == '001') { $ctydisable1 = ""; } else { $ctydisable1 = "disabled"; }
		$ctydisable2 = "disabled";
		$ctydisable3 = "disabled";
		$ctydisable4 = "disabled";
		$ctydisable5 = "disabled";
		
	}
	
	if ($langcode == 'en') { $sql1 = "select * from flc_ie order by ine_name_en asc;"; }
	else if ($langcode == 'vn') { $sql1 = "select * from flc_ie order by ine_name_vn asc;"; }
	else { $sql1 = "select * from flc_ie order by ine_name_jp asc;"; }
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($langcode == 'en') { $inename = $dbarr1['ine_name_en']; }
		else if ($langcode == 'vn') { $inename = $dbarr1['ine_name_vn']; }
		else { $inename = $dbarr1['ine_name_jp']; }
		$ineid = $dbarr1['ine_id'];
		
		if ($ineid == $memaddressine1) { $ineselected1 = "selected"; $inedefault1 = ""; } else { $ineselected1 = ""; $inedefault1 = "selected"; }
		
		$tpl->assign("##ineid1##", $ineid);
		$tpl->assign("##inename1##", $inename);
		$tpl->assign("##ineselected1##", $ineselected1);
		$tpl->parse ("#####ROW#####", '.rows_ine1');
		
		$tpl->assign("##ineid2##", $ineid);
		$tpl->assign("##inename2##", $inename);
		$tpl->parse ("#####ROW#####", '.rows_ine2');
		
		$tpl->assign("##ineid3##", $ineid);
		$tpl->assign("##inename3##", $inename);
		$tpl->parse ("#####ROW#####", '.rows_ine3');
		
		$tpl->assign("##ineid4##", $ineid);
		$tpl->assign("##inename4##", $inename);
		$tpl->parse ("#####ROW#####", '.rows_ine4');
		
		$tpl->assign("##ineid5##", $ineid);
		$tpl->assign("##inename5##", $inename);
		$tpl->parse ("#####ROW#####", '.rows_ine5');
		
	}
	
	if ($langcode == 'en') { $sql2 = "select * from flc_province order by prv_name_en asc;"; }
	else if ($langcode == 'vn') { $sql2 = "select * from flc_province order by prv_name_vn asc;"; }
	else { $sql2 = "select * from flc_province order by prv_name_jp asc;"; }
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
		
		if ($langcode == 'en') { $prvname = $dbarr2['prv_name_en']; }
		else if ($langcode == 'vn') { $prvname = $dbarr2['prv_name_vn']; }
		else { $prvname = $dbarr2['prv_name_jp']; }
		$prvid = $dbarr2['prv_id'];
		
		if ($prvid == $memaddressprv1) { $prvselected1 = "selected"; $prvdefault1 = ""; } else { $prvselected1 = ""; $prvdefault1 = "selected"; }
		
		$tpl->assign("##prvid1##", $prvid);
		$tpl->assign("##prvname1##", $prvname);
		$tpl->assign("##prvselected1##", $prvselected1);
		$tpl->parse ("#####ROW#####", '.rows_prv1');
		
		$tpl->assign("##prvid2##", $prvid);
		$tpl->assign("##prvname2##", $prvname);
		$tpl->parse ("#####ROW#####", '.rows_prv2');
		
		$tpl->assign("##prvid3##", $prvid);
		$tpl->assign("##prvname3##", $prvname);
		$tpl->parse ("#####ROW#####", '.rows_prv3');
		
		$tpl->assign("##prvid4##", $prvid);
		$tpl->assign("##prvname4##", $prvname);
		$tpl->parse ("#####ROW#####", '.rows_prv4');
		
		$tpl->assign("##prvid5##", $prvid);
		$tpl->assign("##prvname5##", $prvname);
		$tpl->parse ("#####ROW#####", '.rows_prv5');
		
	}
	
	$sql3 = "select * from flc_country where cty_id != '1' order by cty_order asc;"; 
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) {
		
		if ($langcode == 'en') { $ctyname = $dbarr3['cty_name_en']; }
		else if ($langcode == 'vn') { $ctyname = $dbarr3['cty_name_vn']; }
		else { $ctyname = $dbarr3['cty_name_jp']; }
		$ctyid = $dbarr3['cty_id'];
		
		if ($ctyid == $memaddresscty1) { $ctyselected1 = "selected"; $ctydefault1 = ""; } else { $ctyselected1 = ""; $ctydefault1 = "selected"; }
		$ctydefault2 = "selected";
		$ctydefault3 = "selected";
		$ctydefault4 = "selected";
		$ctydefault5 = "selected";
		
		$tpl->assign("##ctyid1##", $ctyid);
		$tpl->assign("##ctyname1##", $ctyname);
		$tpl->assign("##ctyselected1##", $ctyselected1);
		$tpl->parse ("#####ROW#####", '.rows_cty1');
		
		$tpl->assign("##ctyid2##", $ctyid);
		$tpl->assign("##ctyname2##", $ctyname);
		$tpl->parse ("#####ROW#####", '.rows_cty2');
		
		$tpl->assign("##ctyid3##", $ctyid);
		$tpl->assign("##ctyname3##", $ctyname);
		$tpl->parse ("#####ROW#####", '.rows_cty3');
		
		$tpl->assign("##ctyid4##", $ctyid);
		$tpl->assign("##ctyname4##", $ctyname);
		$tpl->parse ("#####ROW#####", '.rows_cty4');
		
		$tpl->assign("##ctyid5##", $ctyid);
		$tpl->assign("##ctyname5##", $ctyname);
		$tpl->parse ("#####ROW#####", '.rows_cty5');
		
	}
	
	$sql4_1 = "select * from flc_country where cty_id = '1';";
	$result4_1 = mysql_query($sql4_1);
	while ($dbarr4_1 = mysql_fetch_array($result4_1)) { 
		if ($langcode == 'en') { $ctyname_1 = $dbarr4_1['cty_name_en']; $ctynamedefault = "Vietnam"; } 
		else if ($langcode == 'vn') { $ctyname_1 = $dbarr4_1['cty_name_vn']; $ctynamedefault = "Việt Nam"; }
		else { $ctyname_1 = $dbarr4_1['cty_name_jp']; $ctynamedefault = "ベトナム"; }
	}
	
	if ($memaddresscty1 == '1') { $ctyselected1_1 = "selected"; $ctydefault1 = ""; } else { $ctyselected1_1 = ""; $ctydefault1 = "selected"; }
	
	/*$sqlcat = "select * from flc_category where cat_pos != 'm' order by cat_order asc;"; 
	$resultcat = mysql_query($sqlcat);
	while ($dbarrcat = mysql_fetch_array($resultcat)) {
	
		$catid = $dbarrcat['cat_id'];
		$catpos = $dbarrcat['cat_pos'];
		$catunder = $dbarrcat['cat_under'];
		
		if ($_COOKIE['vlang'] == 'en') { $catname = $dbarrcat['cat_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $catname = $dbarrcat['cat_name_vn']; }
		else { $catname = $dbarrcat['cat_name_jp']; }
		
		if ($catpos == 's') { 
		
			$sqlcatunder = "select * from flc_category where cat_id = '$catunder';"; 
			$resultcatunder = mysql_query($sqlcatunder);
			while ($dbarrcatunder = mysql_fetch_array($resultcatunder)) { 
				if ($_COOKIE['vlang'] == 'en') { $catundername = $dbarrcatunder['cat_name_en']; }
				else if ($_COOKIE['vlang'] == 'vn') { $catundername = $dbarrcatunder['cat_name_vn']; }
				else { $catundername = $dbarrcatunder['cat_name_jp']; }
			}
			
			$catname = $catundername."　・ ".$catname; 
			
		}
		
		$tpl->assign("##catid##", $catid);
		$tpl->assign("##catname##", $catname);
		$tpl->parse ("#####ROW#####", '.rows_cat');
		
	}*/
	
	$sqlclf = "select * from flc_color_font order by clf_name_en asc;"; 
	$resultclf = mysql_query($sqlclf);
	while ($dbarrclf = mysql_fetch_array($resultclf)) {
	
		$clfid = $dbarrclf['clf_id'];
		$clfname = $dbarrclf['clf_name_en']; 
		$clfcode = $dbarrclf['clf_code']; 
		if ($clfid == $defaultclfid) { $clfselected = "selected"; } else { $clfselected = ""; }
		
		$tpl->assign("##clfid##", $clfid);
		$tpl->assign("##clfname##", $clfname);
		$tpl->assign("##clfcode##", $clfcode);
		$tpl->assign("##clfselected##", $clfselected);
		$tpl->parse ("#####ROW#####", '.rows_clf');
		
		$tpl->assign("##clfdetailid##", $clfid);
		$tpl->assign("##clfdetailname##", $clfname);
		$tpl->assign("##clfdetailcode##", $clfcode);
		$tpl->assign("##clfdetailselected##", $clfselected);
		$tpl->parse ("#####ROW#####", '.rows_clfdetail');
		
	}
	
	$comname_jpk = "";
	
	if ($langcode == 'en') { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "English Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Anh"; } else { $langcodefull = "英語のページ"; }
		$val_comname = $memcomnameen;
		$val_comaddress = $memaddress1en;
		$val_conname = $memconnameen;
		$val_conpos = $memconposen;
		$val_pagname = "Company Profile";
		$val_addresslabel = "Address";
		$val_tellabel = "TEL";
		$val_langlocal = $lb_en;
		
		$box_conname_en = "";
		$box_conpos_en = "";
	
	} else if ($langcode == 'vn') { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Vietnamese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Việt"; } else { $langcodefull = "ベトナム語のページ"; }
		$val_comname = $memcomnamevn;
		$val_comaddress = $memaddress1vn;
		$val_conname = $memconnamevn;
		$val_conname_en = $memconnamevn;
		$val_conpos = $memconposvn;
		$val_conpos_en = $memconposen;
		$val_pagname = "Hồ sơ công ty";
		$val_addresslabel = "Địa chỉ";
		$val_tellabel = "Số điện thoại";
		$val_langlocal = $lb_vn;
		
		$box_conname_en = "<tr>
            <td colspan=\"3\"><img src=\"images/blank.png\" width=\"740\" height=\"10\" /></td>
          </tr>
          <tr bgcolor=\"#EEEEEE\">
            <td><div align=\"right\"><strong>".$lb_prf_pername." [".$lb_en."]</strong></div></td>
            <td>&nbsp;</td>
            <td><input name=\"t_pername_en\" type=\"text\" class=\"box_normal\" id=\"t_pername_en\" value=\"".$val_conname_en."\" maxlength=\"85\" /></td>
          </tr>";
		  
		  $box_conpos_en = "<tr>
            <td colspan=\"3\"><img src=\"images/blank.png\" width=\"740\" height=\"10\" /></td>
          </tr>
          <tr bgcolor=\"#EEEEEE\">
            <td><div align=\"right\"><strong>".$lb_prf_posname." [".$lb_en."]</strong></div></td>
            <td>&nbsp;</td>
            <td><input name=\"t_posname_en\" type=\"text\" class=\"box_normal\" id=\"t_posname_en\" value=\"".$val_conpos_en."\" maxlength=\"85\" /></td>
          </tr>";
		
	} else { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Japanese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Nhật"; } else { $langcodefull = "日本語のページ"; }
		$val_comname = $memcomnamejp;
		$val_comaddress = $memaddress1jp;
		$val_conname = $memconnamejp;
		$val_conname_en = $memconnameen;
		$val_conpos = $memconposjp;
		$val_conpos_en = $memconposen;
		$val_pagname = "会社概要";
		$val_addresslabel = "住所";
		$val_tellabel = "電話番号";
		$val_langlocal = $lb_jp;
		
		$box_conname_en = "<tr>
            <td colspan=\"3\"><img src=\"images/blank.png\" width=\"740\" height=\"10\" /></td>
          </tr>
          <tr bgcolor=\"#EEEEEE\">
            <td><div align=\"right\"><strong>".$lb_prf_pername." [".$lb_en."]</strong></div></td>
            <td>&nbsp;</td>
            <td><input name=\"t_pername_en\" type=\"text\" class=\"box_normal\" id=\"t_pername_en\" value=\"".$val_conname_en."\" maxlength=\"85\" /></td>
          </tr>";
		  
		  $box_conpos_en = "<tr>
            <td colspan=\"3\"><img src=\"images/blank.png\" width=\"740\" height=\"10\" /></td>
          </tr>
          <tr bgcolor=\"#EEEEEE\">
            <td><div align=\"right\"><strong>".$lb_prf_posname." [".$lb_en."]</strong></div></td>
            <td>&nbsp;</td>
            <td><input name=\"t_posname_en\" type=\"text\" class=\"box_normal\" id=\"t_posname_en\" value=\"".$val_conpos_en."\" maxlength=\"85\" /></td>
          </tr>";
		
		/*$comname_jpk = "<tr>
          <td valign=\"top\" bgcolor=\"#999999\" class=\"white_b\"><strong>".$lb_prf_comnamejpk."</strong></td>
          <td valign=\"top\" bgcolor=\"#FFFFFF\"><input name=\"t_comname_jpk\" type=\"text\" class=\"box_normal\" id=\"t_comname_jpk\" maxlength=\"85\" /></td>
        </tr>";*/
		
	}

	/* Convert [br] to actual [LineBreak] for <textarea> */
	$pagname = str_replace('[br]',PHP_EOL,$pagname);
	$pagtitle = str_replace('<br>',PHP_EOL,$pagtitle);
	$pagdetail = str_replace('[br]',PHP_EOL,$pagdetail);
	$membusiness = str_replace('[br]',PHP_EOL,$membusiness);
	$memproduct = str_replace('[br]',PHP_EOL,$memproduct);
	$memaddlab1 = str_replace('[br]',PHP_EOL,$memaddlab1);
	$memadd1 = str_replace('[br]',PHP_EOL,$memadd1);
	$memaddlab2 = str_replace('[br]',PHP_EOL,$memaddlab2);
	$memadd2 = str_replace('[br]',PHP_EOL,$memadd2);
	$memaddlab3 = str_replace('[br]',PHP_EOL,$memaddlab3);
	$memadd3 = str_replace('[br]',PHP_EOL,$memadd3);
	$memaddlab4 = str_replace('[br]',PHP_EOL,$memaddlab4);
	$memadd4 = str_replace('[br]',PHP_EOL,$memadd4);
	$memaddlab5 = str_replace('[br]',PHP_EOL,$memaddlab5);
	$memadd5 = str_replace('[br]',PHP_EOL,$memadd5);
	$memtellab1 = str_replace('[br]',PHP_EOL,$memtellab1);
	$memtellab2 = str_replace('[br]',PHP_EOL,$memtellab2);
	$memtellab3 = str_replace('[br]',PHP_EOL,$memtellab3);
	$memtellab4 = str_replace('[br]',PHP_EOL,$memtellab4);
	$memtellab5 = str_replace('[br]',PHP_EOL,$memtellab5);
	$memmaillab1 = str_replace('[br]',PHP_EOL,$memmaillab1);
	$memmaillab2 = str_replace('[br]',PHP_EOL,$memmaillab2);
	$memmaillab3 = str_replace('[br]',PHP_EOL,$memmaillab3);
	$memmaillab4 = str_replace('[br]',PHP_EOL,$memmaillab4);
	$memmaillab5 = str_replace('[br]',PHP_EOL,$memmaillab5);
	$memurl = str_replace('[br]',PHP_EOL,$memurl);
	$memcomparent = str_replace('[br]',PHP_EOL,$memcomparent);
	$memshareholder = str_replace('[br]',PHP_EOL,$memshareholder);
	$memvalcus = str_replace('[br]',PHP_EOL,$memvalcus);
	$memconlab1 = str_replace('[br]',PHP_EOL,$memconlab1);
	$memcon1 = str_replace('[br]',PHP_EOL,$memcon1);
	$memconlab2 = str_replace('[br]',PHP_EOL,$memconlab2);
	$memcon2 = str_replace('[br]',PHP_EOL,$memcon2);
	$memconlab3 = str_replace('[br]',PHP_EOL,$memconlab3);
	$memcon3 = str_replace('[br]',PHP_EOL,$memcon3);
	$memconlab4 = str_replace('[br]',PHP_EOL,$memconlab4);
	$memcon4 = str_replace('[br]',PHP_EOL,$memcon4);
	$memconlab5 = str_replace('[br]',PHP_EOL,$memconlab5);
	$memcon5 = str_replace('[br]',PHP_EOL,$memcon5);


	$tpl->assign("##memid##", $memid);
	$tpl->assign("##memcomname##", $memcomname);
	$tpl->assign("##langcode##", $langcode);
	$tpl->assign("##langcodefull##", $langcodefull);
	$tpl->assign("##val_comname##", $val_comname);
	$tpl->assign("##val_comaddress##", $val_comaddress);
	$tpl->assign("##val_comzip##", $memaddresszip1);
	$tpl->assign("##val_comtel##", $memcomtel);
	$tpl->assign("##val_conname##", $val_conname);
	$tpl->assign("##val_conpos##", $val_conpos);
	$tpl->assign("##box_conname_en##", $box_conname_en);
	$tpl->assign("##box_conpos_en##", $box_conpos_en);
	$tpl->assign("##val_langlocal##", $val_langlocal);
	$tpl->assign("##val_pagname##", $val_pagname);
	$tpl->assign("##val_addresslabel##", $val_addresslabel);
	$tpl->assign("##val_tellabel##", $val_tellabel);
	$tpl->assign("##inedefault1##", $inedefault1);
	$tpl->assign("##prvdefault1##", $prvdefault1);
	$tpl->assign("##ctyselected1_1##", $ctyselected1_1);
	$tpl->assign("##ctynamedefault##", $ctynamedefault);
	$tpl->assign("##ctyname_1##", $ctyname_1);
	$tpl->assign("##ctydefault1##", $ctydefault1);
	$tpl->assign("##ctydefault2##", $ctydefault2);
	$tpl->assign("##ctydefault3##", $ctydefault3);
	$tpl->assign("##ctydefault4##", $ctydefault4);
	$tpl->assign("##ctydefault5##", $ctydefault5);
	$tpl->assign("##ctydisable1##", $ctydisable1);
	$tpl->assign("##ctydisable2##", $ctydisable2);
	$tpl->assign("##ctydisable3##", $ctydisable3);
	$tpl->assign("##ctydisable4##", $ctydisable4);
	$tpl->assign("##ctydisable5##", $ctydisable5);
	//$tpl->assign("##comname_jpk##", $comname_jpk);	
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
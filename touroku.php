<?php 
   
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure-new.html";
	$url2 = "touroku.html";
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	$pagecode = "idx";
	
	/* Set default language cookie */
	if(empty($_COOKIE['vlang'])) {
		$_COOKIE['vlang'] = 'en';
	}
	
	/* Prevent unknown cookie language value */
	if(!in_array($_COOKIE['vlang'],['en','jp','vn'])) {
		$_COOKIE['vlang'] = 'en';
	}
	
	if ($_COOKIE['vlang'] == 'en') {
		$url6 = "menu-html_en.html";
		$url7 = "register_en.html";
	} else if ($_COOKIE['vlang'] == 'vn') {
		$url6 = "menu-html_vn.html";
		$url7 = "register_vn.html";
	} else {
		$url6 = "menu-html_jp.html";
		$url7 = "register_jp.html";
	}
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array(
		"main_tpl"		=> $url1,
		"detail_tpl"	=> $url2,
		"right_tpl"		=> $url3,
		"left_tpl"		=> $url4,
		"top_tpl"		=> $url5,
		"menu_tpl"		=> $url6,
		"desc_tpl"		=> $url7,
	));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	
	#region Content
	
	if ($_COOKIE['vlang'] == 'en') { $sql1 = "select * from flc_ie where ine_id != '1' and ine_id != '2' order by ine_name_en asc;"; }
	else if ($_COOKIE['vlang'] == 'vn') { $sql1 = "select * from flc_ie where ine_id != '1' and ine_id != '2' order by ine_name_vn asc;"; }
	else { $sql1 = "select * from flc_ie where ine_id != '1' and ine_id != '2' order by ine_name_jp asc;"; }
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($_COOKIE['vlang'] == 'en') { $inename = $dbarr1['ine_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $inename = $dbarr1['ine_name_vn']; }
		else { $inename = $dbarr1['ine_name_jp']; }
		$ineid = $dbarr1['ine_id'];
		
		$tpl->assign("##ineid##", $ineid);
		$tpl->assign("##inename##", $inename);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	$sql1_1 = "select * from flc_ie where ine_id = '1';";
	$result1_1 = mysql_query($sql1_1);
	while ($dbarr1_1 = mysql_fetch_array($result1_1)) { 
		if ($_COOKIE['vlang'] == 'en') { $inename_1 = $dbarr1_1['ine_name_en']; } 
		else if ($_COOKIE['vlang'] == 'vn') { $inename_1 = $dbarr1_1['ine_name_vn']; }
		else { $inename_1 = $dbarr1_1['ine_name_jp']; }
	}
	
	$sql1_2 = "select * from flc_ie where ine_id = '2';";
	$result1_2 = mysql_query($sql1_2);
	while ($dbarr1_2 = mysql_fetch_array($result1_2)) { 
		if ($_COOKIE['vlang'] == 'en') { $inename_2 = $dbarr1_2['ine_name_en']; } 
		else if ($_COOKIE['vlang'] == 'vn') { $inename_2 = $dbarr1_2['ine_name_vn']; }
		else { $inename_2 = $dbarr1_2['ine_name_jp']; }
	}
	
	if ($_COOKIE['vlang'] == 'en') { $sql2 = "select * from flc_province where prv_id != '1' and prv_id != '2' order by prv_name_en asc;"; }
	else if ($_COOKIE['vlang'] == 'vn') { $sql2 = "select * from flc_province where prv_id != '1' and prv_id != '2' order by prv_name_vn asc;"; }
	else { $sql2 = "select * from flc_province where prv_id != '1' and prv_id != '2' order by prv_name_jp asc;"; }
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
		
		if ($_COOKIE['vlang'] == 'en') { $prvname = $dbarr2['prv_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $prvname = $dbarr2['prv_name_vn']; }
		else { $prvname = $dbarr2['prv_name_jp']; }
		$prvid = $dbarr2['prv_id'];
		
		$tpl->assign("##prvid##", $prvid);
		$tpl->assign("##prvname##", $prvname);
		$tpl->parse ("#####ROW#####", '.rows_2');
		
	}
	
	$sql2_1 = "select * from flc_province where prv_id = '1';";
	$result2_1 = mysql_query($sql2_1);
	while ($dbarr2_1 = mysql_fetch_array($result2_1)) { 
		if ($_COOKIE['vlang'] == 'en') { $prvname_1 = $dbarr2_1['prv_name_en']; } 
		else if ($_COOKIE['vlang'] == 'vn') { $prvname_1 = $dbarr2_1['prv_name_vn']; }
		else { $prvname_1 = $dbarr2_1['prv_name_jp']; }
	}
	
	$sql2_2 = "select * from flc_province where prv_id = '2';";
	$result2_2 = mysql_query($sql2_2);
	while ($dbarr2_2 = mysql_fetch_array($result2_2)) { 
		if ($_COOKIE['vlang'] == 'en') { $prvname_2 = $dbarr2_2['prv_name_en']; } 
		else if ($_COOKIE['vlang'] == 'vn') { $prvname_2 = $dbarr2_2['prv_name_vn']; }
		else { $prvname_2 = $dbarr2_2['prv_name_jp']; }
	}
	
	$sql4 = "select * from flc_country where cty_id != '1' order by cty_order asc;"; 
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) {
		
		if ($_COOKIE['vlang'] == 'en') { $ctyname = $dbarr4['cty_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $ctyname = $dbarr4['cty_name_vn']; }
		else { $ctyname = $dbarr4['cty_name_jp']; }
		$ctyid = $dbarr4['cty_id'];
		
		$tpl->assign("##ctyid##", $ctyid);
		$tpl->assign("##ctyname##", $ctyname);
		$tpl->parse ("#####ROW#####", '.rows_3');
		
	}
	
	$sql4_1 = "select * from flc_country where cty_id = '1';";
	$result4_1 = mysql_query($sql4_1);
	while ($dbarr4_1 = mysql_fetch_array($result4_1)) { 
		if ($_COOKIE['vlang'] == 'en') { $ctyname_1 = $dbarr4_1['cty_name_en']; $ctynamedefault = "Vietnam"; } 
		else if ($_COOKIE['vlang'] == 'vn') { $ctyname_1 = $dbarr4_1['cty_name_vn']; $ctynamedefault = "Việt Nam"; }
		else { $ctyname_1 = $dbarr4_1['cty_name_jp']; $ctynamedefault = "ベトナム"; }
	}
	
	$sqlcat = "select * from flc_category where cat_pos != 'm' order by cat_order asc;"; 
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
		
	}
	
	// Random security number
	$random = random(0);
	$confirmcode = $random[1].$random[2].$random[3].$random[4];
	
	#end region
	
	
	$tpl->assign("##inename_1##", $inename_1);
	$tpl->assign("##inename_2##", $inename_2);
	$tpl->assign("##prvname_1##", $prvname_1);
	$tpl->assign("##prvname_2##", $prvname_2);
	$tpl->assign("##ctyname_1##", $ctyname_1);
	$tpl->assign("##ctynamedefault##", $ctynamedefault);
	$tpl->assign("##confirmcode##", $confirmcode);
	$tpl->assign("##randomnum##", $random[0]);
	$tpl->assign("##captcha_site_key##", $captchaSiteKey);

	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DESC_AREA##", "desc_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
	
?>
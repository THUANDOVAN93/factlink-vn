<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_profile_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_SESSION['vmd'];
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "profile_edit";
	$currentrec = $memid;
	$currentuserid = $_SESSION['vmd']; 
	$currentuserper = "mem";
	
	$sqlusl0 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl0 = mysql_query($sqlusl0);
	
	$sqlusl1 = "select * from flc_uselog where usl_filepage = '$currentpage' and usl_filerec = '$currentrec';"; 
	$resultusl1 = mysql_query($sqlusl1);
	while ($dbarrusl1 = mysql_fetch_array($resultusl1)) { 
	
		$usltimestamp = $dbarrusl1['usl_timestamp'];
		
		if ($usltimestamp > $limittimestamp) { 
			
			$_SESSION['vlock_userid'] = $dbarrusl1['usl_userid'];
			$_SESSION['vlock_userper'] = $dbarrusl1['usl_userper'];
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_lock.php\">"; exit(); 
			
		} else { $usldel = "t"; }
		
	}
	
	if ($usldel == 't') { 
	
		$sqlusl2 = "delete from flc_uselog where usl_timestamp = '$usltimestamp';"; 
		$resultusl2 = mysql_query($sqlusl2);
		
	}
	
	$sqlusl3 = "insert into flc_uselog (usl_filepage, usl_filerec, usl_userid, usl_userper) values ('$currentpage', '$currentrec', '$currentuserid', '$currentuserper');"; 
	$resultusl3 = mysql_query($sqlusl3);
	
	// --------------------
	
	$sql3 = "select * from flc_member where mem_id = '$memid';"; 
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) {
		
		$memcomnameen = stripslashes($dbarr3['mem_comname_en']); 
		$memcomnamejp = stripslashes($dbarr3['mem_comname_jp']); 
		$memcomnamevn = stripslashes($dbarr3['mem_comname_vn']); 
		$memnational = stripslashes($dbarr3['mem_national']);
		$memsubdescen = stripslashes($dbarr3['mem_subdesc_en']); 
		$memsubdescjp = stripslashes($dbarr3['mem_subdesc_jp']); 
		$memsubdescvn = stripslashes($dbarr3['mem_subdesc_vn']); 
		$memaddress1en = stripslashes($dbarr3['mem_address1_en']); 
		$memaddress1jp = stripslashes($dbarr3['mem_address1_jp']); 
		$memaddress1vn = stripslashes($dbarr3['mem_address1_vn']);
		$memaddressine1 = stripslashes($dbarr3['mem_addressine1']);
		$memaddressprv1 = stripslashes($dbarr3['mem_addressprv1']); if ($memaddressprv1 == '001') { $ctydisable = ""; } else { $ctydisable = "disabled"; }
		$memaddresscty1 = stripslashes($dbarr3['mem_addresscty1']);
		$memaddresszip1 = stripslashes($dbarr3['mem_addresszip1']);
		$memcomtel = stripslashes($dbarr3['mem_comtel']);
		$memcomfax = stripslashes($dbarr3['mem_comfax']);
		$memcontacten = stripslashes($dbarr3['mem_contactname_en']); 
		$memcontactjp = stripslashes($dbarr3['mem_contactname_jp']); 
		$memcontactvn = stripslashes($dbarr3['mem_contactname_vn']); 
		$mempositionen = stripslashes($dbarr3['mem_contactposition_en']); 
		$mempositionjp = stripslashes($dbarr3['mem_contactposition_jp']); 
		$mempositionvn = stripslashes($dbarr3['mem_contactposition_vn']); 
		$memgender = stripslashes($dbarr3['mem_contactgender']);
		$memmail = stripslashes($dbarr3['mem_contactmail']);
		$memmail_oth = stripslashes($dbarr3['mem_oth_contactmail']);
		$memtel = stripslashes($dbarr3['mem_contacttel']);
		$mempackage = stripslashes($dbarr3['mem_package']);
		$memsort = stripslashes($dbarr3['mem_sort']);
		$memcategory = explode(" ", $dbarr3['mem_category']); 
		$memcate = $memcategory[0];
		
	}
	
	if ($memnational == 'jp') { $memnjp = "checked"; $memnvn = ""; $memnoo = ""; } 
	else if ($memnational == 'vn') { $memnjp = ""; $memnvn = "checked"; $memnoo = ""; } 
	else { $memnjp = ""; $memnvn = ""; $memnoo = "checked"; } 
	
	if ($memgender == 'm') { $memgenderm = "checked"; $memgenderf = ""; } else { $memgenderm = ""; $memgenderf = "checked"; } 
	
	if ($_COOKIE['vlang'] == 'en') { $sql1 = "select * from flc_ie where ine_id != '1' and ine_id != '2' order by ine_name_en asc;"; }
	else if ($_COOKIE['vlang'] == 'vn') { $sql1 = "select * from flc_ie where ine_id != '1' and ine_id != '2' order by ine_name_vn asc;"; }
	else { $sql1 = "select * from flc_ie where ine_id != '1' and ine_id != '2' order by ine_name_jp asc;"; }
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($_COOKIE['vlang'] == 'en') { $inename = $dbarr1['ine_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $inename = $dbarr1['ine_name_vn']; }
		else { $inename = $dbarr1['ine_name_jp']; }
		$ineid = $dbarr1['ine_id'];
		
		if ($memaddressine1 == $ineid) { $ineselected = "selected"; $inedefault = ""; } else { $ineselected = ""; $inedefault = "selected"; }
		
		$tpl->assign("##ineid##", $ineid);
		$tpl->assign("##inename##", $inename);
		$tpl->assign("##ineselected##", $ineselected);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	$sql1_1 = "select * from flc_ie where ine_id = '1';";
	$result1_1 = mysql_query($sql1_1);
	while ($dbarr1_1 = mysql_fetch_array($result1_1)) { 
		if ($_COOKIE['vlang'] == 'en') { $inename_1 = $dbarr1_1['ine_name_en']; } 
		else if ($_COOKIE['vlang'] == 'vn') { $inename_1 = $dbarr1_1['ine_name_vn']; }
		else { $inename_1 = $dbarr1_1['ine_name_jp']; }
	}
	
	if ($memaddressine1 == '1') { $ineselected_1 = "selected"; $inedefault = ""; } else { $ineselected_1 = ""; $inedefault = "selected"; }
	
	$sql1_2 = "select * from flc_ie where ine_id = '2';";
	$result1_2 = mysql_query($sql1_2);
	while ($dbarr1_2 = mysql_fetch_array($result1_2)) { 
		if ($_COOKIE['vlang'] == 'en') { $inename_2 = $dbarr1_2['ine_name_en']; } 
		else if ($_COOKIE['vlang'] == 'vn') { $inename_2 = $dbarr1_2['ine_name_vn']; }
		else { $inename_2 = $dbarr1_2['ine_name_jp']; }
	}
	
	if ($memaddressine1 == '2') { $ineselected_2 = "selected"; $inedefault = ""; } else { $ineselected_2 = ""; $inedefault = "selected"; }
	
	if ($_COOKIE['vlang'] == 'en') { $sql2 = "select * from flc_province where prv_id != '1' and prv_id != '2' order by prv_name_en asc;"; }
	else if ($_COOKIE['vlang'] == 'vn') { $sql2 = "select * from flc_province where prv_id != '1' and prv_id != '2' order by prv_name_vn asc;"; }
	else { $sql2 = "select * from flc_province where prv_id != '1' and prv_id != '2' order by prv_name_jp asc;"; }
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
		
		if ($_COOKIE['vlang'] == 'en') { $prvname = $dbarr2['prv_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $prvname = $dbarr2['prv_name_vn']; }
		else { $prvname = $dbarr2['prv_name_jp']; }
		$prvid = $dbarr2['prv_id'];
		
		if ($memaddressprv1 == $prvid) { $prvselected = "selected"; $prvdefault = ""; } else { $prvselected = ""; $prvdefault = "selected"; }
		
		$tpl->assign("##prvid##", $prvid);
		$tpl->assign("##prvname##", $prvname);
		$tpl->assign("##prvselected##", $prvselected);
		$tpl->parse ("#####ROW#####", '.rows_2');
		
	}
	
	$sql2_1 = "select * from flc_province where prv_id = '1';";
	$result2_1 = mysql_query($sql2_1);
	while ($dbarr2_1 = mysql_fetch_array($result2_1)) { 
		if ($_COOKIE['vlang'] == 'en') { $prvname_1 = $dbarr2_1['prv_name_en']; } 
		else if ($_COOKIE['vlang'] == 'vn') { $prvname_1 = $dbarr2_1['prv_name_vn']; }
		else { $prvname_1 = $dbarr2_1['prv_name_jp']; }
	}
	
	if ($memaddressprv1 == '1') { $prvselected_1 = "selected"; $prvdefault = ""; } else { $prvselected_1 = ""; $prvdefault = "selected"; }
	
	$sql2_2 = "select * from flc_province where prv_id = '2';";
	$result2_2 = mysql_query($sql2_2);
	while ($dbarr2_2 = mysql_fetch_array($result2_2)) { 
		if ($_COOKIE['vlang'] == 'en') { $prvname_2 = $dbarr2_2['prv_name_en']; } 
		else if ($_COOKIE['vlang'] == 'vn') { $prvname_2 = $dbarr2_2['prv_name_vn']; }
		else { $prvname_2 = $dbarr2_2['prv_name_jp']; }
	}
	
	if ($memaddressprv1 == '2') { $prvselected_2 = "selected"; $prvdefault = ""; } else { $prvselected_2 = ""; $prvdefault = "selected"; }
	
	$sql4 = "select * from flc_country where cty_id != '1' order by cty_order asc;"; 
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) {
		
		if ($_COOKIE['vlang'] == 'en') { $ctyname = $dbarr4['cty_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $ctyname = $dbarr4['cty_name_vn']; }
		else { $ctyname = $dbarr4['cty_name_jp']; }
		$ctyid = $dbarr4['cty_id'];
		
		if ($memaddresscty1 == $ctyid) { $ctyselected = "selected"; $ctydefault = ""; } else { $ctyselected = ""; $ctydefault = "selected"; }
		
		$tpl->assign("##ctyid##", $ctyid);
		$tpl->assign("##ctyname##", $ctyname);
		$tpl->assign("##ctyselected##", $ctyselected);
		$tpl->parse ("#####ROW#####", '.rows_3');
		
	}
	
	$sql4_1 = "select * from flc_country where cty_id = '1';";
	$result4_1 = mysql_query($sql4_1);
	while ($dbarr4_1 = mysql_fetch_array($result4_1)) { 
		if ($_COOKIE['vlang'] == 'en') { $ctyname_1 = $dbarr4_1['cty_name_en']; $ctynamedefault = "Vietnam"; } 
		else if ($_COOKIE['vlang'] == 'vn') { $ctyname_1 = $dbarr4_1['cty_name_vn']; $ctynamedefault = "Việt Nam"; }
		else { $ctyname_1 = $dbarr4_1['cty_name_jp']; $ctynamedefault = "ベトナム"; }
	}
	
	if ($memaddresscty1 == '1') { $ctyselected_1 = "selected"; $ctydefault = ""; } else { $ctyselected_1 = ""; $ctydefault = "selected"; }
	
	$sql5 = "select * from flc_bulletin_cate where mem_id = '$memid';"; 
	$result5 = mysql_query($sql5);
	while ($dbarr5 = mysql_fetch_array($result5)) { $bucsort = $dbarr5['buc_sort']; }
	
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
		
		if ($catid == $memcate) { $catselected = "selected"; $catdefault = ""; } else { $catselected = ""; $catdefault = "selected"; }
		
		$tpl->assign("##catid##", $catid);
		$tpl->assign("##catname##", $catname);
		$tpl->assign("##catselected##", $catselected);
		$tpl->parse ("#####ROW#####", '.rows_cat');
		
	}
	
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##memcomnameen##", $memcomnameen);
	$tpl->assign("##memcomnamejp##", $memcomnamejp);
	$tpl->assign("##memcomnamevn##", $memcomnamevn);
	$tpl->assign("##memnjp##", $memnjp);
	$tpl->assign("##memnvn##", $memnvn);
	$tpl->assign("##memnoo##", $memnoo);
	$tpl->assign("##memsubdescen##", $memsubdescen);
	$tpl->assign("##memsubdescjp##", $memsubdescjp);
	$tpl->assign("##memsubdescvn##", $memsubdescvn);
	$tpl->assign("##memaddress1en##", $memaddress1en);
	$tpl->assign("##memaddress1jp##", $memaddress1jp);
	$tpl->assign("##memaddress1vn##", $memaddress1vn);
	$tpl->assign("##memaddresszip1##", $memaddresszip1);
	$tpl->assign("##memcomtel##", $memcomtel);
	$tpl->assign("##memcomfax##", $memcomfax);
	$tpl->assign("##memcontacten##", $memcontacten);
	$tpl->assign("##memcontactjp##", $memcontactjp);
	$tpl->assign("##memcontactvn##", $memcontactvn);
	$tpl->assign("##mempositionen##", $mempositionen);
	$tpl->assign("##mempositionjp##", $mempositionjp);
	$tpl->assign("##mempositionvn##", $mempositionvn);
	$tpl->assign("##memgenderm##", $memgenderm);
	$tpl->assign("##memgenderf##", $memgenderf);
	$tpl->assign("##memmail##", $memmail);
	$tpl->assign("##memmail_oth##", $memmail_oth);
	$tpl->assign("##memtel##", $memtel);
	$tpl->assign("##mempackage##", $mempackage);
	$tpl->assign("##memcat##", $memcate);
	$tpl->assign("##memsort##", $memsort);
	$tpl->assign("##bucsort##", $bucsort);
	$tpl->assign("##inename_1##", $inename_1);
	$tpl->assign("##inename_2##", $inename_2);
	$tpl->assign("##ineselected_1##", $ineselected_1);
	$tpl->assign("##ineselected_2##", $ineselected_2);
	$tpl->assign("##inedefault##", $inedefault);
	$tpl->assign("##prvname_1##", $prvname_1);
	$tpl->assign("##prvname_2##", $prvname_2);
	$tpl->assign("##prvselected_1##", $prvselected_1);
	$tpl->assign("##prvselected_2##", $prvselected_2);
	$tpl->assign("##prvdefault##", $prvdefault);
	$tpl->assign("##ctyname_1##", $ctyname_1);
	$tpl->assign("##ctyselected_1##", $ctyselected_1);
	$tpl->assign("##ctynamedefault##", $ctynamedefault);
	$tpl->assign("##ctydefault##", $ctydefault);
	$tpl->assign("##ctydisable##", $ctydisable);
	$tpl->assign("##catdefault##", $catdefault);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
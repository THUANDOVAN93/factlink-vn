<?php

	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') {
		
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">";
		exit();
	}
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_default.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array(
		"main_tpl" => $url1,
		"detail_tpl" => $url2)
	);
	
	mysql_query("use $db_name;");
	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	if ($_COOKIE['vlang'] == 'en') {

		$sql1 = "select * from flc_member where mem_expirewarning = 't' order by mem_comname_en asc;";
	} elseif ($_COOKIE['vlang'] == 'vn') {

		$sql1 = "select * from flc_member where mem_expirewarning = 't' order by mem_comname_vn asc;";
	} else {

		$sql1 = "select * from flc_member where mem_expirewarning = 't' order by mem_comname_jp asc;";
	}

	$result1 = mysql_query($sql1);

	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($_COOKIE['vlang'] == 'en') {

			$memcomname = $dbarr1['mem_comname_en'];
		} elseif ($_COOKIE['vlang'] == 'vn') {

			$memcomname = $dbarr1['mem_comname_vn'];
		} else {

			$memcomname = $dbarr1['mem_comname_jp'];
		}

		$memid = $dbarr1['mem_id'];
		$memstart = $dbarr1['mem_startdate']; 
		$memend = $dbarr1['mem_enddate'];
		$memstatus = $dbarr1['mem_status'];
		
		if  ($memend != '') {
	
			$tempenddate = explode(" ", $memend);
			$memenddate = explode("-", date("Y-m-d", strtotime("-1 day", mktime(0,0,0,addzero2(mcvsubtonum($tempenddate[1])),$tempenddate[0],$tempenddate[2]))));
			$memcontract = $memstart." - ".$memenddate[2]." ".mcvzerotosub($memenddate[1])." ".$memenddate[0];
		} else {

			$memcontract = "";
		}
		
		if ($memstatus == 'd') {

			$memstatus = "<span class=\"red_n\">DISABLE</span>";
		} else {

			$memstatus = "<span class=\"green_n\">ENABLE</span>";
		}
		
		$tpl->assign("##memid##", $memid);
		$tpl->assign("##memcomname##", $memcomname);
		$tpl->assign("##memcontract##", $memcontract);
		$tpl->assign("##memend##", $memend);
		$tpl->assign("##status##", $memstatus);
		$tpl->parse ("#####ROW#####", '.rows_membsc');
	}
	
	// Banner - Basic
	$sql2 = "select * from flc_banner where ban_expirewarning = 't' and ban_type = 'bsc' order by ban_page asc, ban_side asc, ban_sort asc, ban_name asc;";
	$result2 = mysql_query($sql2);

	while ($dbarr2 = mysql_fetch_array($result2)) {
		
		$banid = $dbarr2['ban_id'];
		$banname = $dbarr2['ban_name']; 
		$banpage = $dbarr2['ban_page']; 
		$banside = $dbarr2['ban_side']; 
		$banstart = $dbarr2['ban_startdate']; 
		$banend = $dbarr2['ban_enddate'];
		$bansort = $dbarr2['ban_sort'];
		$banstatus = $dbarr2['ban_status'];
		
		if  ($banend != '') {
	
			$tempenddate = explode(" ", $banend);
			$banenddate = explode("-", date("Y-m-d", strtotime("-1 day", mktime(0,0,0,addzero2(mcvsubtonum($tempenddate[1])),$tempenddate[0],$tempenddate[2]))));
			$bancontract = $banstart." - ".$banenddate[2]." ".mcvzerotosub($banenddate[1])." ".$banenddate[0];
		} else {

			$bancontract = "";
		}
		
		$sql3 = "select * from flc_pospage where psp_code = '$banpage';";
		$result3 = mysql_query($sql3);

		while ($dbarr3 = mysql_fetch_array($result3)) { 
		
			if ($_COOKIE['vlang'] == 'en') {

				$banpage = $dbarr3['psp_name_en'];
			} elseif ($_COOKIE['vlang'] == 'vn') {

				$banpage = $dbarr3['psp_name_vn'];
			} else {

				$banpage = $dbarr3['psp_name_jp'];
			}
		}
		
		if ($banside != '') {

			$banpage = $banpage." - ".strtoupper($banside);
		} else {

			$banpage = $banpage;
		}
				
		if ($banstatus != 'd') {

			$banstatus = "<a href=\"adm_banner_set_disable.php?id=".$banid."&type=".$type."\"><img src=\"images/icon_enable_01.png\" alt=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		} else {

			$banstatus = "<a href=\"adm_banner_set_enable.php?id=".$banid."&type=".$type."\"><img src=\"images/icon_disable_01.png\" alt=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		}
		
		$tpl->assign("##banid##", $banid);
		$tpl->assign("##banname##", $banname);
		$tpl->assign("##banpage##", $banpage);
		$tpl->assign("##bancontract##", $bancontract);
		$tpl->assign("##banend##", $banend);
		$tpl->assign("##bantype##", $type);
		$tpl->assign("##bansort##", $bansort);
		$tpl->assign("##banstatus##", $banstatus);
		$tpl->parse ("#####ROW#####", '.rows_banbsc');
	}
	
	// Banner - Special
	$sql4 = "select * from flc_banner where ban_expirewarning = 't' and ban_type = 'spc' order by ban_page asc, ban_side asc, ban_sort asc, ban_name asc;";
	$result4 = mysql_query($sql4);

	while ($dbarr4 = mysql_fetch_array($result4)) {
		
		$banid = $dbarr4['ban_id'];
		$banname = $dbarr4['ban_name']; 
		$banpage = $dbarr4['ban_page']; 
		$banstart = $dbarr4['ban_startdate']; 
		$banend = $dbarr4['ban_enddate'];
		$bansort = $dbarr4['ban_sort'];
		$banstatus = $dbarr4['ban_status'];
		
		if  ($banend != '') {
	
			$tempenddate = explode(" ", $banend);
			$banenddate = explode("-", date("Y-m-d", strtotime("-1 day", mktime(0,0,0,addzero2(mcvsubtonum($tempenddate[1])),$tempenddate[0],$tempenddate[2]))));
			$bancontract = $banstart." - ".$banenddate[2]." ".mcvzerotosub($banenddate[1])." ".$banenddate[0];
			
		} else {

			$bancontract = "";
		}
		
		$sql5 = "select * from flc_pospage where psp_code = '$banpage';";
		$result5 = mysql_query($sql5);

		while ($dbarr5 = mysql_fetch_array($result5)) { 
		
			if ($_COOKIE['vlang'] == 'en') {

				$banpage = $dbarr5['psp_name_en'];
			} elseif ($_COOKIE['vlang'] == 'vn') {

				$banpage = $dbarr5['psp_name_vn'];
			} else {

				$banpage = $dbarr5['psp_name_jp'];
			}
		}
		
		if ($banstatus != 'd') {

			$banstatus = "<a href=\"adm_banner_set_disable.php?id=".$banid."&type=".$type."\"><img src=\"images/icon_enable_01.png\" alt=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		} else {

			$banstatus = "<a href=\"adm_banner_set_enable.php?id=".$banid."&type=".$type."\"><img src=\"images/icon_disable_01.png\" alt=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		}
		
		$tpl->assign("##banid##", $banid);
		$tpl->assign("##banname##", $banname);
		$tpl->assign("##banpage##", $banpage);
		$tpl->assign("##bancontract##", $bancontract);
		$tpl->assign("##banend##", $banend);
		$tpl->assign("##bantype##", $type);
		$tpl->assign("##bansort##", $bansort);
		$tpl->assign("##banstatus##", $banstatus);
		$tpl->parse ("#####ROW#####", '.rows_banspc');
	}
	
	// Banner - Special  CATEGORY
	$timestamp = time();
	$from = date("Y-m-01 00:00:00",$timestamp);
	$datestamp=explode("-",date("Y-m-d", strtotime($from . " + 1 month")));
	$dates=mcvnumtosub($datestamp[1]).' '.$datestamp[0];
	$datecurrent=explode("-",date("Y-m-d"));
	$dcurrent=mcvnumtosub($datecurrent[1]).' '.$datecurrent[0];
	$sql8 = "select * from flc_banner_cate where bac_expirewarning = 't' and bac_type = 'spc' and bac_enddate LIKE '%$dates%' or bac_enddate LIKE '%$dcurrent%' order by mem_id DESC, bac_name asc;";
	$result8 = mysql_query($sql8);

	while ($dbarr8 = mysql_fetch_array($result8)) {
		
		$catid = $dbarr8['cat_id'];
		$bacid = $dbarr8['bac_id'];
		$bacname = $dbarr8['bac_name']; 
		$bacstart = $dbarr8['bac_startdate']; 
		$bacend = $dbarr8['bac_enddate'];
		$bacsort = $dbarr8['bac_sort'];
		$bacstatus = $dbarr8['bac_status'];
		
		if ($bacend != '') {
	
			$tempenddate = explode(" ", $bacend);
			$bacenddate = explode("-", date("Y-m-d", strtotime("-1 day", mktime(0,0,0,addzero2(mcvsubtonum($tempenddate[1])),$tempenddate[0],$tempenddate[2]))));
			$baccontract = $bacstart." - ".$bacenddate[2]." ".mcvzerotosub($bacenddate[1])." ".$bacenddate[0];
			
		} else {

			$baccontract = "";
		}
		
		$sql9 = "select * from flc_category where cat_id = '$catid';";
		$result9 = mysql_query($sql9);

		while ($dbarr9 = mysql_fetch_array($result9)) { 
		
			if ($_COOKIE['vlang'] == 'en') {

				$catname = $dbarr9['cat_name_en'];
			} elseif ($_COOKIE['vlang'] == 'vn') {

				$catname = $dbarr9['cat_name_vn'];
			} else {

				$catname = $dbarr9['cat_name_jp'];
			}
		}
		
		if ($bacstatus != 'd') {

			$bacstatus = "<a href=\"adm_bacner_set_disable.php?id=".$bacid."&type=".$type."\"><img src=\"images/icon_enable_01.png\" alt=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		} else {

			$bacstatus = "<a href=\"adm_bacner_set_enable.php?id=".$bacid."&type=".$type."\"><img src=\"images/icon_disable_01.png\" alt=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		}
		
		$tpl->assign("##bacid##", $bacid);
		$tpl->assign("##bacname##", $bacname);
		$tpl->assign("##bacpage##", $bacpage);
		$tpl->assign("##baccontract##", $baccontract);
		$tpl->assign("##bacend##", $bacend);
		$tpl->assign("##bactype##", $type);
		$tpl->assign("##bacsort##", $bacsort);
		$tpl->assign("##bacstatus##", $bacstatus);
		$tpl->assign("##catname##", $catname);
		$tpl->parse ("#####ROW#####", '.rows_bacspc');
	}
	
	// Inquiry
	$sql6 = "select * from flc_mail where mal_warning = 't' or (mal_case = '4' and mal_send = 'n') order by mal_id desc;";
	$result6 = mysql_query($sql6);

	while ($dbarr6 = mysql_fetch_array($result6)) {
		
		$inrid = $dbarr6['mal_id'];
		$inrsubj = $dbarr6['mal_subj']; 
		$inrdate = $dbarr6['mal_date']; 
		$inrstatus = $dbarr6['mal_status']; 
		$inrmemid = $dbarr6['mem_id'];
		$mal_send = $dbarr6['mal_send'];
		$mal_case = $dbarr6['mal_case'];

		// Build link iquiry view
		$malViewLink = "adm_inquiry_view.php?id=".$inrid."&inrmemid=".$inrmemid;
		if ($mal_case == '4') {
			$malViewLink = "adm_mail_product_view.php?id=".$inrid."&inrmemid=".$inrmemid;
		}


		// End
		
		$sql7 = "select * from flc_member where mem_id = '$inrmemid';";
		$result7 = mysql_query($sql7);

		while ($dbarr7 = mysql_fetch_array($result7)) { 
		
			if ($_COOKIE['vlang'] == 'en') {

				$memcomname = $dbarr7['mem_comname_en'];
			} elseif ($_COOKIE['vlang'] == 'vn') {

				$memcomname = $dbarr7['mem_comname_vn'];
			} else {

				$memcomname = $dbarr7['mem_comname_jp'];
			}

			if ($dbarr7['mem_package'] !== "") {
				$stickyInqType = "sticky-type-paid";
			} else {
				$stickyInqType = "sticky-type-free";
			}
		}
		
		if ($inrstatus == 'n') {

			$inrstatus = "enable";
			$inrstatusalt = "New";
		} else {

			$inrstatus = "disable";
			$inrstatusalt = "";
		}

		if ($mal_send=='' || $mal_send=='n') {

			$isenmail="wait.jpg";
		} elseif ($mal_send=='y') {

			$isenmail="approve.jpg";
		}

		$tpl->assign("##malViewLink##", $malViewLink);
		$tpl->assign("##sendmail##", $isenmail);
		$tpl->assign("##inrid##", $inrid);
		$tpl->assign("##inrmemid##", $inrmemid);
		$tpl->assign("##inrsubj##", $inrsubj);
		$tpl->assign("##inrdate##", $inrdate);
		$tpl->assign("##inrstatus##", $inrstatus);
		$tpl->assign("##memcomname##", $memcomname);
		$tpl->assign("##stickyInqType##", $stickyInqType);
		$tpl->parse ("#####ROW#####", '.rows_meminq');
	}
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
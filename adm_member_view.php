<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_view.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_GET['id'];
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$sql1 = "select * from flc_member where mem_id = '$memid';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
	
		$memusername = $dbarr1['mem_user'];
		$mempassword = $dbarr1['mem_pass'];
		$memfolder = $dbarr1['mem_folder'];
		$memcatid = $dbarr1['mem_category'];
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
		$memcomfax = $dbarr1['mem_comfax'];
		$memcontacten = $dbarr1['mem_contactname_en']; 
		$memcontactjp = $dbarr1['mem_contactname_jp']; 
		$memcontactvn = $dbarr1['mem_contactname_vn']; 
		$mempositionen = $dbarr1['mem_contactposition_en']; 
		$mempositionjp = $dbarr1['mem_contactposition_jp']; 
		$mempositionvn = $dbarr1['mem_contactposition_vn']; 
		$memmail = $dbarr1['mem_contactmail'];
		$memtel = $dbarr1['mem_contacttel'];
		$mempackage = $dbarr1['mem_package'];
		$memregistdate = $dbarr1['mem_registdate'];
		$memstartdate = $dbarr1['mem_startdate'];
		$memexpdate = $dbarr1['mem_enddate'];
		$memselflogin = $dbarr1['mem_selflogin'];
		$memlastlogindate = $dbarr1['mem_lastlogindate'];
		$memmemo1 = html($dbarr1['mem_memo1']);
		$memmemo2 = html($dbarr1['mem_memo2']);
		$memstatus = $dbarr1['mem_status'];
	
	}
	if($_SERVER['SERVER_NAME']!='localhost'){
		$dir = "/home/factlink/public_html/home/$mem_folder";
		 if (is_dir($dir)) {
			  "There are already folder";
		 }else{
				
			mkdir("/home/factlink/public_html/home/$mem_folder");
			chmod("/home/factlink/public_html/home/$mem_folder", 0777);
		 
		 }
	}else{
		
		$dir = "/home/$mem_folder";
		 if (is_dir($dir)) {
			  "There are already folder";
		 }else{
				
			mkdir("/home/$mem_folder");
			chmod("/home/$mem_folder", 0777);
		 
		 }
		
	}
		
	if  ($memexpdate != '') {
	
		$tempenddate = explode(" ", $memexpdate);
		$memenddate = explode("-", date("Y-m-d", strtotime("-1 day", mktime(0,0,0,addzero2(mcvsubtonum($tempenddate[1])),$tempenddate[0],$tempenddate[2]))));
		$memcontract = $memstartdate." - ".$memenddate[2]." ".mcvzerotosub($memenddate[1])." ".$memenddate[0];
		
	} else { $memcontract = ""; }
	
	if ($mempackage == '') { 
		
		$memtype = "Free Member"; 
		$memtypepic = "images/member_typefree_".$_COOKIE['vlang'].".png"; 
		
	} else { 
		
		$sql4 = "select * from flc_package where pck_id = '$mempackage';";
		$result4 = mysql_query($sql4);
		while ($dbarr4 = mysql_fetch_array($result4)) { $memtype = $dbarr4['pck_name_en']; }
		$memtypepic = "images/member_typebasic_".$_COOKIE['vlang'].".png";
		
	}
	
	if ($memstatus == 'd') { $memstatus = "<span class=\"red_n\">DISABLE</span>"; }
	else { $memstatus = "<span class=\"green_n\">ENABLE</span>"; }
	
	if ($memselflogin != '0') { $memloginhis = $memselflogin." [ Last Login : ".$memlastlogindate." ]"; } else { $memloginhis = $memselflogin; }
	
	$memurl = "<a href=\"https://www.fact-link.com.vn/home/".$memfolder."/\" target=\"_blank\">https://www.fact-link.com.vn/home/".$memfolder."/</a>";
	
	$sql2 = "select * from flc_ie where ine_id = '$memaddressine1';";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) { $inenameen = $dbarr2['ine_name_en']; $inenamejp = $dbarr2['ine_name_jp']; $inenamevn = $dbarr2['ine_name_vn']; }
	
	$sql3 = "select * from flc_province where prv_id = '$memaddressprv1';";
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) { $prvnameen = $dbarr3['prv_name_en']; $prvnamejp = $dbarr3['prv_name_jp']; $prvnamevn = $dbarr3['prv_name_vn']; }
	
	$sql4 = "select * from flc_country where cty_id = '$memaddresscty1';";
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) { $ctynameen = $dbarr4['cty_name_en']; $ctynamejp = $dbarr4['cty_name_jp']; $ctynamevn = $dbarr4['cty_name_vn']; }
	
	// contract history
	/*$sql4 = "select * from flc_contract_hist where mem_id = '$memid' order by cth_type desc, cth_startdate asc;";
	$result4 = mysql_query($sql4);
	$cntsql4 = mysql_num_rows($result4);
	while ($dbarr4 = mysql_fetch_array($result4)) { 
		
		$cthcnt = $cthcnt + 1;
		
		$cthid = $dbarr4['cth_id']; 
		$cthpackage = $dbarr4['cth_package']; 
		$cthstatus = $dbarr4['cth_status']; 
		$cthstartdate = explode("-", $dbarr4['cth_startdate']); 
		$cthexpdate = explode("-", $dbarr4['cth_enddate']);
		$cthenddate = explode("-", date("Y-m-d", strtotime("-1 day", mktime(0,0,0,$cthexpdate[1],$cthexpdate[2],$cthexpdate[0]))));
		
		//$cthcontract = $cthstartdate." - ".$cthenddate;
		$cthcontract = $cthstartdate[2]." ".mcvzerotosub($cthstartdate[1])." ".$cthstartdate[0]." - ".$cthenddate[2]." ".mcvzerotosub($cthenddate[1])." ".$cthenddate[0];
		
		if ($cthstatus == 'd') { $cthstatus = "<span class=\"red_n\">EXPIRED</span>"; } else { $cthstatus = ""; }
		
		$sql5 = "select * from flc_package where pck_id = '$cthpackage';";
		$result5 = mysql_query($sql5);
		while ($dbarr5 = mysql_fetch_array($result5)) { $cthpackname = $dbarr5['pck_name_en']; }
		
		if ($cthcnt < $cntsql4) { $cthline = "<tr><td colspan=\"5\" valign=\"top\"><img src=\"images/line_frame_08.png\" width=\"740\" height=\"10\" /></td></tr>"; } else { $cthline = ""; }
		
		$tpl->assign("##memid##", $memid);
		$tpl->assign("##cthid##", $cthid);
		$tpl->assign("##cthpackname##", $cthpackname);
		$tpl->assign("##cthcontract##", $cthcontract);
		$tpl->assign("##cthstatus##", $cthstatus);		
		$tpl->assign("##cthline##", $cthline);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}*/
	
	$sqlcat = "select * from flc_category where cat_id = '$memcatid';"; 
	$resultcat = mysql_query($sqlcat);
	while ($dbarrcat = mysql_fetch_array($resultcat)) {
	
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
			
			$catname = $catundername."　・　".$catname; 
			
		}
		
	}
	
	// language
	if ($_COOKIE['vlang'] == 'en') { 
	
		$memcomname = $memcomnameen;
		$memcomaddress = $memaddress1en;
		$memcontact = $memcontacten;
		$memposition = $mempositionen;
		$inename = $inenameen;
		$prvname = $prvnameen;
		$ctyname = $ctynameen;
	
	} else if ($_COOKIE['vlang'] == 'vn') {
	
		$memcomname = $memcomnamevn;
		$memcomaddress = $memaddress1vn;
		$memcontact = $memcontactvn;
		$memposition = $mempositionvn;
		$inename = $inenamevn;
		$prvname = $prvnamevn;
		$ctyname = $ctynamevn;
	
	} else {
	
		$memcomname = $memcomnamejp;
		$memcomaddress = $memaddress1jp;
		$memcontact = $memcontactjp;
		$memposition = $mempositionjp;
		//$inename = $inenamejp;
		//$prvname = $prvnamejp;
		//$ctyname = $ctynamejp;
		$inename = $inenameen;
		$prvname = $prvnameen;
		$ctyname = $ctynameen;
	
	}
	
	if ($memaddressine1 == '001' || $memaddressine1 == '002') { $inename = ""; } else { $inename = $inename."</br>"; }
	if ($memaddressprv1 == '001') { $prvname = ""; } else { $prvname = ", ".$prvname; }
	
	$memcomaddress = $inename.html($memcomaddress).$prvname." ".$memaddresszip1." ".$ctyname;
	
	//if ($memposition != '') { $memcontact = $memcontact." [ ".$memposition." ]"; }
	
	$tpl->assign("##memcomname##", $memcomname);
	$tpl->assign("##memcomaddress##", $memcomaddress);
	$tpl->assign("##memcomtel##", $memcomtel);
	$tpl->assign("##memcomfax##", $memcomfax);
	$tpl->assign("##memcontact##", $memcontact);
	$tpl->assign("##memposition##", $memposition);
	$tpl->assign("##memtel##", $memtel);
	$tpl->assign("##memmail##", $memmail);
	$tpl->assign("##memtype##", $memtype);
	$tpl->assign("##memtypepic##", $memtypepic);
	$tpl->assign("##memurl##", $memurl);
	$tpl->assign("##memloginhis##", $memloginhis);
	$tpl->assign("##memregistdate##", $memregistdate);
	$tpl->assign("##memcontract##", $memcontract);
	$tpl->assign("##memexpdate##", $memexpdate);
	$tpl->assign("##memusername##", $memusername);
	$tpl->assign("##mempassword##", $mempassword);
	$tpl->assign("##memmemo1##", $memmemo1);
	$tpl->assign("##memmemo2##", $memmemo2);
	$tpl->assign("##memstatus##", $memstatus);
	$tpl->assign("##memcatname##", $catname);
	$tpl->assign("##memid##", $memid);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
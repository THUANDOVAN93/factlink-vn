<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_default.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_SESSION['vmd'];
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vmd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$sql1 = "select * from flc_member where mem_id = '$memid';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
	
		$memfolder = $dbarr1['mem_folder'];
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
	
	//$memfree = "images/member_panelfree_".$_COOKIE['vlang'].".png";
	//$membasic = "images/member_panelbasic_".$_COOKIE['vlang'].".png";
	//$membanbsc = "images/member_panelbanbsc_".$_COOKIE['vlang'].".png";
	//$membancat = "images/member_panelbancat_".$_COOKIE['vlang'].".png";
	//$memstaff = "images/member_panelstaff_".$_COOKIE['vlang'].".png";
	
	if ($memselflogin != '0') { $memloginhis = $memselflogin." [ Last Login : ".$memlastlogindate." ]"; } else { $memloginhis = $memselflogin; }
	
	$memurl = "<a href=\"http://www.fact-link.com.vn/home/".$memfolder."/\" target=\"_blank\">http://www.fact-link.com.vn/home/".$memfolder."/</a>";
	
	$sql2 = "select * from flc_ie where ine_id = '$memaddressine1';";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) { $inenameen = $dbarr2['ine_name_en']; $inenamejp = $dbarr2['ine_name_jp']; $inenamevn = $dbarr2['ine_name_vn']; }
	
	$sql3 = "select * from flc_province where prv_id = '$memaddressprv1';";
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) { $prvnameen = $dbarr3['prv_name_en']; $prvnamejp = $dbarr3['prv_name_jp']; $prvnamevn = $dbarr3['prv_name_vn']; }
	
	$sql4 = "select * from flc_country where cty_id = '$memaddresscty1';";
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) { $ctynameen = $dbarr4['cty_name_en']; $ctynamejp = $dbarr4['cty_name_jp']; $ctynamevn = $dbarr4['cty_name_vn']; }
	
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
	//$tpl->assign("##memfree##", $memfree);
	//$tpl->assign("##membasic##", $membasic);
	//$tpl->assign("##membanbsc##", $membanbsc);
	//$tpl->assign("##membancat##", $membancat);
	//$tpl->assign("##memstaff##", $memstaff);
	$tpl->assign("##memurl##", $memurl);
	$tpl->assign("##memloginhis##", $memloginhis);
	$tpl->assign("##memregistdate##", $memregistdate);
	$tpl->assign("##memcontract##", $memcontract);
	$tpl->assign("##memid##", $memid);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
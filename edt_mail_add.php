<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_mail_add.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_SESSION['vmd'];
	$inrid = $_GET['re'];
	
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
		$memaddresszip1 = $dbarr1['mem_addresszip1'];
		$memcomtel = $dbarr1['mem_comtel'];
		$memcomfax = $dbarr1['mem_comfax'];
		$memcontacten = $dbarr1['mem_contactname_en']; 
		$memcontactjp = $dbarr1['mem_contactname_jp']; 
		$memcontactvn = $dbarr1['mem_contactname_vn']; 
		$memmail = $dbarr1['mem_contactmail'];
	
	}
	
	$sql2 = "select * from flc_ie where ine_id = '$memaddressine1';";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) { $inenameen = $dbarr2['ine_name_en']; $inenamejp = $dbarr2['ine_name_jp']; $inenamevn = $dbarr2['ine_name_vn']; }
	
	$sql3 = "select * from flc_province where prv_id = '$memaddressprv1';";
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) { $prvnameen = $dbarr3['prv_name_en']; $prvnamejp = $dbarr3['prv_name_jp']; $prvnamevn = $dbarr3['prv_name_vn']; }
	
	if ($inrid != '') {
	
		$sql4 = "select * from flc_mail where mal_id = '$inrid';";
		$result4 = mysql_query($sql4);
		while ($dbarr4 = mysql_fetch_array($result4)) {
		
			$replysubj = "RE : ".$dbarr4['mal_subj'];
			$replyto = $dbarr4['mal_from_name'];
			$replymail = $dbarr4['mal_from_mail'];
		
		}
	
	} else { $replysubj = ""; $replyto = ""; $replymail = ""; }
	
	// language
	if ($_COOKIE['vlang'] == 'en') { 
	
		$memcomname = $memcomnameen;
		$memcomaddress = $memaddress1en;
		$memcontact = $memcontacten;
		$inename = $inenameen;
		$prvname = $prvnameen;
	
	} else if ($_COOKIE['vlang'] == 'vn') {
	
		$memcomname = $memcomnamevn;
		$memcomaddress = $memaddress1vn;
		$memcontact = $memcontactvn;
		$inename = $inenamevn;
		$prvname = $prvnamevn;
	
	} else {
	
		$memcomname = $memcomnamejp;
		$memcomaddress = $memaddress1jp;
		$memcontact = $memcontactjp;
		$inename = $inenamejp;
		$prvname = $prvnamejp;
	
	}
	
	if ($memcomine == '001' || $memcomine == '002') { $inename = ""; } else { $inename = $inename."</br>"; }
	if ($memcomprv == '001') { $prvname = ""; } else { $prvname = ", ".$prvname; }
	
	$memcomaddress = $inename.html($memcomaddress).$prvname." ".$memaddresszip1;
	
	$sender_info = $memcontact."<br>".$memcomname."<br>TEL : ".$memcomtel." FAX : ".$memcomfax."<br>E-MAIL : ".$memmail;
	
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##memmail##", $memmail);
	$tpl->assign("##sender_info##", $sender_info);
	$tpl->assign("##replyto##", $replyto);
	$tpl->assign("##replysubj##", $replysubj);
	$tpl->assign("##replymail##", $replymail);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
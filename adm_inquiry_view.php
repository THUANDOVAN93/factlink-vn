<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_inquiry_view.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$inrid = $_GET['id'];
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	$sql1 = "select * from flc_mail where mal_id = '$inrid';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
	
		$mem_id = $dbarr1['mem_id'];
		$inrsubject = $dbarr1['mal_subj'];
		$inrcontent = html($dbarr1['mal_detail']);
		$inrcompany = $dbarr1['mal_company'];
		$inrdepartment = $dbarr1['mal_department'];
		$inrname = $dbarr1['mal_from_name'];
		$inrmail = $dbarr1['mal_from_mail'];
		$inrtel = $dbarr1['mal_tel'];
		$inrfax = $dbarr1['mal_fax'];
		$mal_id = $dbarr1['mal_id'];
	}

	$sql2 = "select mem_comname_en, mem_contactmail from flc_member where mem_id = '$mem_id';";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
		$memcomname = $dbarr2['mem_comname_en'];
		$memcontactmail = $dbarr2['mem_contactmail'];
	}
	
	$tpl->assign("##inrid##", $inrid);
	$tpl->assign("##inrsubject##", $inrsubject);
	$tpl->assign("##inrcontent##", $inrcontent);
	$tpl->assign("##inrcompany##", $inrcompany);
	$tpl->assign("##inrdepartment##", $inrdepartment);
	$tpl->assign("##inrname##", $inrname);
	$tpl->assign("##inrtel##", $inrtel);
	$tpl->assign("##inrfax##", $inrfax);
	$tpl->assign("##inrmail##", $inrmail);
	$tpl->assign("##mal_id##", $mal_id);
	$tpl->assign("##mem_id##", $mem_id);
	$tpl->assign("##memcomname##", $memcomname);
	$tpl->assign("##memcontactmail##", $memcontactmail);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
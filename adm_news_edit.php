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
	$url2 = "adm_news_edit.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array(
		"main_tpl" => $url1, 
		"detail_tpl" => $url2
	));
	
	mysql_query("use $db_name;");
	
	$nwsid = $_GET['id'];
	$langCode = "jp";
	if (!empty($_COOKIE['vlang'])) {
		$langCode = $_COOKIE['vlang'];
	}
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$limittimestamp = date("Y-m-d H:i:s", $timelength);
	$currenttimestamp = date("Y-m-d H:i:s");
	
	$currentpage = "news_edit";
	$currentrec = $nwsid;
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
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_lock.php\">";

			exit(); 
		} else {
			$usldel = "t";
		}
	}
	
	if ($usldel == 't') { 
	
		$sqlusl2 = "delete from flc_uselog where usl_timestamp = '$usltimestamp';";
		$resultusl2 = mysql_query($sqlusl2);
	}
	
	$sqlusl3 = "insert into flc_uselog (usl_filepage, usl_filerec, usl_userid, usl_userper) values ('$currentpage', '$currentrec', '$currentuserid', '$currentuserper');"; 
	$resultusl3 = mysql_query($sqlusl3);
	
	// --------------------

	$sql3 = "select * from flc_news where nws_id = '$nwsid';"; 
	$result3 = mysql_query($sql3);

	while ($dbarr3 = mysql_fetch_array($result3)) {
	
		$nwsnwgid = $dbarr3['nwg_id'];
		$nwsnweid = $dbarr3['nwe_id'];
		$nwstitleen = $dbarr3['nws_title_en'];
		$nwstitlejp = $dbarr3['nws_title_jp'];
		$nwstitlejp02 = $dbarr3['nws_title_jp'];
		$nwstitlevn = $dbarr3['nws_title_vn'];
		$nwssumen = $dbarr3['nws_compend_en'];
		$nwssumjp = $dbarr3['nws_compend_jp'];
		$nwssumvn = $dbarr3['nws_compend_vn'];
		$nwsdetailen = $dbarr3['nws_detail_en'];
		$nwsdetailjp = $dbarr3['nws_detail_jp'];
		$nwsdetailvn = $dbarr3['nws_detail_vn'];
		$nwsday = $dbarr3['nws_day'];
		$nwsmonth = $dbarr3['nws_month']; $nwsmonth = mcvzerotosub($nwsmonth);
		$nwsyear = $dbarr3['nws_year'];
		$nwsshow = $dbarr3['nws_show'];

		if ($nwsshow == 't') {
			$nwsshow = "checked";
		} else {
			$nwsshow = "";
		}

		$nwsstatus = $dbarr3['nws_status'];

		if ($nwsstatus == 'd') {
			$nwsstatus = "checked";
		} else {
			$nwsstatus = "";
		}

		$nwsmemo = $dbarr3['nws_memo'];
	}	
	
	/* Convert [br] to actual [LineBreak] for <textarea> */
	$nwstitleen = str_replace('[br]',PHP_EOL,$nwstitleen);
	$nwstitlejp = str_replace('[br]',PHP_EOL,$nwstitlejp);
	$nwstitlejp02 = str_replace('[br]',PHP_EOL,$nwstitlejp02);
	$nwstitlevn = str_replace('[br]',PHP_EOL,$nwstitlevn);
	$nwssumen = str_replace('[br]',PHP_EOL,$nwssumen);
	$nwssumjp = str_replace('[br]',PHP_EOL,$nwssumjp);
	$nwssumvn = str_replace('[br]',PHP_EOL,$nwssumvn);
	$nwsdetailen = str_replace('[br]',PHP_EOL,$nwsdetailen);
	$nwsdetailjp = str_replace('[br]',PHP_EOL,$nwsdetailjp);
	$nwsdetailvn = str_replace('[br]',PHP_EOL,$nwsdetailvn);
	$nwsmemo = str_replace('[br]',PHP_EOL,$nwsmemo);

	// Parse Meta Content

	$sqlGetSeoData = "SELECT attribute_value FROM flc_pag_metadata WHERE pag_id = '$nwsid' AND attribute_code = 'new' AND attribute_name = 'seo';";
	$seoDataList = mysql_query($sqlGetSeoData);
	if (mysql_num_rows($seoDataList) == 1) {
		$rs = mysql_fetch_assoc($seoDataList);
		$seoDataItem = $rs['attribute_value'];
		$seoDataItem = json_decode($seoDataItem, true);

		$metaTitEN = $seoDataItem['meta_title']['en'];
		$metaTitJP = $seoDataItem['meta_title']['jp'];
		$metaTitVN = $seoDataItem['meta_title']['vn'];
		$metaDescEN = $seoDataItem['meta_desc']['en'];
		$metaDescJP = $seoDataItem['meta_desc']['jp'];
		$metaDescVN = $seoDataItem['meta_desc']['vn'];

		if (empty($metaTitEN)) {
			$metaTitEN = $nwstitleen;
		}
		if (empty($metaTitJP)) {
			$metaTitJP = $nwstitlejp;
		}
		if (empty($metaTitVN)) {
			$metaTitVN = $nwstitlevn;
		}
		if (empty($metaDescEN)) {
			$metaDescEN = $meta_description_en;
		}
		if (empty($metaDescJP)) {
			$metaDescJP = $meta_description_jp;
		}
		if (empty($metaDescVN)) {
			$metaDescVN = $meta_description_vn;
		}
	} else {
		$metaTitEN = $nwstitleen;
		$metaTitJP = $nwstitlejp;
		$metaTitVN = $nwstitlevn;
		$metaDescEN = $meta_description_en;
		$metaDescJP = $meta_description_jp;
		$metaDescVN = $meta_description_vn;
	}

	$tpl->assign("##metaTitEN##", $metaTitEN);
	$tpl->assign("##metaTitJP##", $metaTitJP);
	$tpl->assign("##metaTitVN##", $metaTitVN);
	$tpl->assign("##metaDescEN##", $metaDescEN);
	$tpl->assign("##metaDescJP##", $metaDescJP);
	$tpl->assign("##metaDescVN##", $metaDescVN);
	
	
	// End Parse Meta Content
		
	if ($langCode == 'en') {
		$sql1 = "select * from flc_news_genre order by nwg_name_en asc;";
	} elseif ($langCode == 'vn') {
		$sql1 = "select * from flc_news_genre order by nwg_name_vn asc;";
	} else {
		$sql1 = "select * from flc_news_genre order by nwg_name_jp asc;";
	}

	$result1 = mysql_query($sql1);

	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($langCode == 'en') {

			$nwgname = $dbarr1['nwg_name_en'];
		} elseif ($langCode == 'vn') {

			$nwgname = $dbarr1['nwg_name_vn'];
		} else {

			$nwgname = $dbarr1['nwg_name_jp'];
		}

		$nwgid = $dbarr1['nwg_id'];

		if ($nwgid == $nwsnwgid) {

			$nwgselected = "selected"; $nwgdefault = "";
		} else {

			$nwgselected = "";
			$nwgdefault = "selected";
		}
		
		$tpl->assign("##nwgid##", $nwgid);
		$tpl->assign("##nwgname##", $nwgname);
		$tpl->assign("##nwgselected##", $nwgselected);
		$tpl->parse ("#####ROW#####", '.rows_nwg');		
	}
	
	if ($langCode == 'en') {

		$sql2 = "select * from flc_news_editor order by nwe_name_en asc;";
	} elseif ($langCode == 'vn') {

		$sql2 = "select * from flc_news_editor order by nwe_name_vn asc;";
	} else {

		$sql2 = "select * from flc_news_editor order by nwe_name_jp asc;";
	}

	$result2 = mysql_query($sql2);

	while ($dbarr2 = mysql_fetch_array($result2)) {
		
		if ($langCode == 'en') {

			$nwename = $dbarr2['nwe_name_en'];
		} elseif ($langCode == 'vn') {

			$nwename = $dbarr2['nwe_name_vn'];
		} else {

			$nwename = $dbarr2['nwe_name_jp'];
		}

		$nweid = $dbarr2['nwe_id'];

		if ($nweid == $nwsnweid) {

			$nweselected = "selected";
			$nwedefault = "";
		} else {

			$nweselected = "";
			$nwedefault = "selected";
		}
		
		$tpl->assign("##nweid##", $nweid);
		$tpl->assign("##nwename##", $nwename);
		$tpl->assign("##nweselected##", $nweselected);
		$tpl->parse ("#####ROW#####", '.rows_nwe');
	}
	
	$sday = selectday($nwsday);
	$smonth = selectmonth($nwsmonth);
	$syear = $nwsyear;
	
	$tpl->assign("##admid##", $_SESSION['vd']);
	$tpl->assign("##nwsid##", $nwsid);
	$tpl->assign("##nwstitleen##", stripslashes($nwstitleen));
	$tpl->assign("##nwstitlejp##",stripslashes($nwstitlejp));
	$tpl->assign("##nwstitlevn##", stripslashes($nwstitlevn));
	$tpl->assign("##nwssumen##", stripslashes($nwssumen));
	$tpl->assign("##nwssumjp##", stripslashes($nwssumjp));
	$tpl->assign("##nwssumvn##", stripslashes($nwssumvn));
	$tpl->assign("##nwsdetailen##", stripslashes($nwsdetailen));
	$tpl->assign("##nwsdetailjp##", stripslashes($nwsdetailjp));
	$tpl->assign("##nwsdetailvn##", stripslashes($nwsdetailvn));
	$tpl->assign("##nwsmemo##", stripslashes($nwsmemo));
	$tpl->assign("##nwsshow##", stripslashes($nwsshow));
	$tpl->assign("##nwsstatus##", $nwsstatus);
	$tpl->assign("##nwgdefault##", stripslashes($nwgdefault));
	$tpl->assign("##nwedefault##", stripslashes($nwedefault)); 
	$tpl->assign("##sday##", $sday);
	$tpl->assign("##smonth##", $smonth);
	$tpl->assign("##syear##", $syear);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
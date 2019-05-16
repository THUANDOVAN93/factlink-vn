<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_introduce_set.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$start = $_GET['start'];
	$limit = 50;
	
	$pagesql = "select * from flc_introduce_set;";
	$page = pagecal($limit, $start, $pagesql, "adm_introduce_set.php", "");
	
	$sql1 = "select * from flc_introduce_set order by ins_id asc limit $start,$limit;";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		$intname = "";
		
		$insid = $dbarr1['ins_id'];
		$ins1 = $dbarr1['ins_1'];
		$ins2 = $dbarr1['ins_2'];
		$ins3 = $dbarr1['ins_3'];
		$insdate = $dbarr1['ins_date'];
		
		$sql2 = "select * from flc_introduce where int_id = '$ins1';";
		$result2 = mysql_query($sql2);
		while ($dbarr2 = mysql_fetch_array($result2)) { 
			if ($_COOKIE['vlang'] == 'en') { $intname1 = $dbarr2['int_name_en']; }
			else if ($_COOKIE['vlang'] == 'vn') { $intname1 = $dbarr2['int_name_vn']; }
			else { $intname1 = $dbarr2['int_name_jp']; }
			$intname = $intname.$intname1."<br>";
		}
		
		$sql3 = "select * from flc_introduce where int_id = '$ins2';";
		$result3 = mysql_query($sql3);
		while ($dbarr3 = mysql_fetch_array($result3)) { 
			if ($_COOKIE['vlang'] == 'en') { $intname2 = $dbarr3['int_name_en']; }
			else if ($_COOKIE['vlang'] == 'vn') { $intname2 = $dbarr3['int_name_vn']; }
			else { $intname2 = $dbarr3['int_name_jp']; }
			$intname = $intname.$intname2."<br>";
		}
		
		$sql4 = "select * from flc_introduce where int_id = '$ins3';";
		$result4 = mysql_query($sql4);
		while ($dbarr4 = mysql_fetch_array($result4)) { 
			if ($_COOKIE['vlang'] == 'en') { $intname3 = $dbarr4['int_name_en']; }
			else if ($_COOKIE['vlang'] == 'vn') { $intname3 = $dbarr4['int_name_vn']; }
			else { $intname3 = $dbarr4['int_name_jp']; }
			$intname = $intname.$intname3."<br>";
		}
		
		$intname = substr($intname,0,-4);
		
		$tpl->assign("##insid##", $insid);
		$tpl->assign("##intname##", $intname);
		$tpl->assign("##insdate##", $insdate);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
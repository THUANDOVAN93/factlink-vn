<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_bulletin_add.html";
	
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
	
	if ($_COOKIE['vlang'] == 'en') { $sql3 = "select * from flc_pospage order by psp_name_en asc;";  }
	else if ($_COOKIE['vlang'] == 'vn') { $sql3 = "select * from flc_pospage order by psp_name_vn asc;";  }
	else { $sql3 = "select * from flc_pospage order by psp_name_jp asc;";  }
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) { 
	
		if ($_COOKIE['vlang'] == 'en') { $pspname = $dbarr3['psp_name_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $pspname = $dbarr3['psp_name_vn']; }
		else { $pspname = $dbarr3['psp_name_jp']; }
		$pspcode = $dbarr3['psp_code']; 
		
		$tpl->assign("##pspcode##", $pspcode);
		$tpl->assign("##pspname##", $pspname);
		$tpl->parse ("#####ROW#####", '.rows_pospage');
		
	}
	
	$tpl->assign("##admid##", $_SESSION['vd']);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
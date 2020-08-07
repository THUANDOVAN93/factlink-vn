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
	$url2 = "adm_feature.html";
	
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
	
	$pagesql = "select * from flc_feature;";
	$page = pagecal($limit, $start, $pagesql, "adm_feature.php", "");
	
	$sql1 = "select * from flc_feature order by fea_id desc limit $start,$limit;";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if($_COOKIE['vlang'] == 'en') {
			$featitle = $dbarr1['fea_title_en'];
		} elseif ($_COOKIE['vlang'] == 'vn') {
			$featitle = $dbarr1['fea_title_vn'];
		} else {
			$featitle = $dbarr1['fea_title_jp'];
		}
		
		$feaid = $dbarr1['fea_id'];
		$feadate = $dbarr1['fea_date'];
		$feashow = $dbarr1['fea_show'];
		$feaarchive = $dbarr1['fea_archive'];
		
		/* Show "[Archive]" if fea_archive not Zero */
		if ($feaarchive != '0') {
			$featitle = $featitle." <font color=\"#CC0000\">[".$lb_archive."]</font>";
		}
		
		if ($feashow == 't') {
			$feashow = "
				<a href=\"adm_feature_set_disable.php?id=".$feaid."\">
					<img src=\"images/icon_enable_01.png\" alt=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" />
				</a>
			";
		} else {
			$feashow = "
				<a href=\"adm_feature_set_enable.php?id=".$feaid."\">
					<img src=\"images/icon_disable_01.png\" alt=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" />
				</a>
			";
		}
		
		$tpl->assign("##feaid##", $feaid);
		$tpl->assign("##featitle##", $featitle);
		$tpl->assign("##feadate##", $feadate);
		$tpl->assign("##feashow##", $feashow);
		$tpl->parse ("#####ROW#####", '.rows_1');
		
	}
	
	$tpl->assign("##page##", $page);
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
	
?>
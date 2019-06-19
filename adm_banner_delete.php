<?php
	ini_set("session.gc_maxlifetime", "18000");
	session_start();

	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	// Escape special charactars
	$_GET = array_map('mysql_real_escape_string',$_GET);
	
	mysql_query("use $db_name;");

	$inrid = $_GET['id'];

	// --- Global Template Section



	$sqlusl0 = "delete from flc_banner where ban_id = '$inrid';";
	$resultusl0 = mysql_query($sqlusl0);

	if($resultusl0){

		if($_GET['bannertype']=="spc"){$bannertype="spc";}
		if($_GET['bannertype']=="bsc"){$bannertype="bpc";}
		 echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_banner.php?start=0&type=$bannertype\">"; exit();
		 }else{

	echo"<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit();
		 }

?>

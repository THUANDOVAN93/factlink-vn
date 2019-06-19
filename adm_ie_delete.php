<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	
	mysql_query("use $db_name;");
	
	$ineid = $_GET['id'];
	$start =$_GET['start'];
	// --- Global Template Section	
	
	
	
	$sqlusl0 = "delete from  flc_ie where ine_id = '$ineid';"; 
	$resultusl0 = mysql_query($sqlusl0);
	
	if($resultusl0){
		
		 echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_ie.php?start=$start\">"; exit(); 
		 }else{
	
	echo"<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit();
		 }
	
?>
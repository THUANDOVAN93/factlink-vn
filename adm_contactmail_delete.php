<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	
	mysql_query("use $db_name;");
	
	$inrid = $_GET['id'];
	
	// --- Global Template Section	
	
	
	
	$sqlusl0 = "delete from flc_contact where ctt_id = '$inrid';"; 
	$resultusl0 = mysql_query($sqlusl0);
	
	if($resultusl0){
		
		 echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_contact.php?start=0\">"; exit(); 
		 }else{
	
	echo"<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit();
		 }
	
?>
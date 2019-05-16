<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	
	mysql_query("use $db_name;");
	
	$inrid = $_GET['id'];
	
	// --- Global Template Section	
	
	
	
//	$sqlusl0 = "delete from flc_banner where ban_id = '$inrid';"; 
//	$resultusl0 = mysql_query($sqlusl0);


	$path="./images/feature";
	$sql="select* from flc_feature where fea_id = '$inrid'; ";
	$query=mysql_query($sql);
	while($fetch=mysql_fetch_array($query)){
		
		
		if($fetch['fea_type']=='.jpg'){$fetch['fea_id'];}
		else{$filenamefeature=$fetch['fea_id'];}
		
		
		unlink("$path/$filenamefeature"."-F."."jpg");
		unlink("$path/$filenamefeature"."-F1."."jpg");
		unlink("$path/$filenamefeature"."-F2."."jpg");
		
		}
	$sqlusl0 = "delete from flc_feature where fea_id = '$inrid';"; 
	$resultusl0 = mysql_query($sqlusl0);

	if($resultusl0){

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_feature.php?start=0\">"; exit(); 
		 }else{
	
	echo"<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit();
		 }
	
?>
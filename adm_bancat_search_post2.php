<?php
	session_start();
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	
	$h_type = $_POST['h_type'];
	$t_memcat = $_POST['t_memcat'];
	
	$_SESSION['vsearchbaccateid'] = $t_memcat;
	
	if ($t_memcat != "") { $sql = "select * from flc_banner_cate where bac_type = '$h_type' and cat_id = '$t_memcat'";	}
	else { $sql = "select * from flc_banner_cate where bac_id = ''"; }
	
	$_SESSION['vsearchbac'] = $sql;
	
	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_bancat2.php?start=0&type=$h_type\">"; 
	exit();
?>
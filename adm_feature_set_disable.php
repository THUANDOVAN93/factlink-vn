<?php
	session_start();
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	
	$feaid = $_GET['id'];
		
	$sql2 = "update flc_feature set fea_archive = '1', fea_show = '' where fea_id = '$feaid';";
	$result2 = mysql_query($sql2);	
?>
<script language="JavaScript">history.back()</script>
<?php
	session_start();
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	
	$feaid = $_GET['id'];
	
	$sql1 = "update flc_feature set fea_archive = '1' where fea_show = 't';";
	$result1 = mysql_query($sql1);
		
	$sql2 = "update flc_feature set fea_archive = '0', fea_show = 't' where fea_id = '$feaid';";
	$result2 = mysql_query($sql2);
	
	$sql3 = "update flc_feature set fea_show = '' where fea_id != '$feaid';";
	$result3 = mysql_query($sql3);
	
?>
<script language="JavaScript">history.back()</script>
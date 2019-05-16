<?php
	session_start();
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	
	$bulid = $_GET['id'];
	
	$sql1 = "update flc_bulletin set bul_status = 'd' where bul_id = '$bulid';";
	$result1 = mysql_query($sql1);
	
?>
<script language="JavaScript">history.back()</script>
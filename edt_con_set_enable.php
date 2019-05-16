<?php
	session_start();
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	
	$conid = $_GET['con'];
	$pageid = $_GET['page'];
	$langcode = $_GET['lang'];
		
	$sql1 = "update flc_content set con_status = '' where con_id = '$conid';";
	$result1 = mysql_query($sql1);
	
?>
<script language="JavaScript">history.back()</script>
<?php
	session_start();
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	
	$eventId = $_GET['id'];
	
	$sql1 = "update flc_events set status = 'd' where id = '$eventId';"; 
	$result1 = mysql_query($sql1);
	
?>
<script language="JavaScript">history.back()</script>
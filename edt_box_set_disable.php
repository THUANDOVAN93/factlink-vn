<?php
	session_start();
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	
	$boxid = $_GET['box'];
	$pageid = $_GET['page'];
	$langcode = $_GET['lang'];
		
	$sql1 = "update flc_present_box set box_status = 'd' where box_id = '$boxid';";
	$result1 = mysql_query($sql1);
	
?>
<script language="JavaScript">history.back()</script>
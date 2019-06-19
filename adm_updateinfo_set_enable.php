<?php
	session_start();
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	
	$uifid = $_GET['id'];
	
	$sql2 = "update flc_upinfo set uif_show = 't' where uif_id = '$uifid';";
	$result2 = mysql_query($sql2);
	
	$sql3 = "update flc_upinfo set uif_show = '' where uif_id != '$uifid';";
	$result3 = mysql_query($sql3);
	
?>
<script language="JavaScript">history.back()</script>
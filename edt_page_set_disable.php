<?php
	session_start();
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	
	$memid = $_GET['id'];
	$pageid = $_GET['page'];
		
	$sql1 = "update flc_page set pag_status = 'd' where pag_id = '$pageid';";
	$result1 = mysql_query($sql1);
	
?>
<script language="JavaScript">history.back()</script>
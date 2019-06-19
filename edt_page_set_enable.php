<?php
	session_start();
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	
	$memid = $_GET['id'];
	$pageid = $_GET['page'];
	
	$sql1 = "update flc_page set pag_status = '' where pag_id = '$pageid';";
	$result1 = mysql_query($sql1);
	
	$sql0 = "select * from flc_page where pag_id = '$pageid';"; 
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $pagtype = $dbarr0['pag_type']; }
	
	if ($pagtype != 'hom') {
	
		$checkpackage = checkfreemem($memid);
		if ($checkpackage == '') { $sql9 = "update flc_page set pag_status = 'd' where pag_id = '$pageid';"; $result9 = mysql_query($sql9); }
	
	}
	
?>
<script language="JavaScript">history.back()</script>
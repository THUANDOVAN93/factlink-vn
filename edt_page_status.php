<?php
	session_start();
	
	//include_once("./include/global_config.php");
	//include_once("./include/global_function.php");
	
	//mysql_query("use $db_name;");
	
	$pageid = $_GET['page'];
	$status = $_GET['status'];
		
	if ($status == 'off') { $sql1 = "update flc_page set pag_status = 'd' where pag_id = '$pageid';"; $result1 = mysql_query($sql1); }
	else if ($status == 'on') { $sql1 = "update flc_page set pag_status = '' where pag_id = '$pageid';"; $result1 = mysql_query($sql1); }
	
	//echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_page.php\">";
		
	//exit();
?>
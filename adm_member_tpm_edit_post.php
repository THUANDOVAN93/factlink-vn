<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_memid = $_POST['h_memid'];
	$t_tpm = $_POST['t_tpm'];

	$sql1 = "update flc_member set mem_template = '$t_tpm' where mem_id = '$h_memid';";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_view.php?id=$h_memid\">";

	exit();
?>

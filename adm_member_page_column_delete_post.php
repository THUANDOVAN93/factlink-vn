<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_memid = $_POST['h_memid'];
	$h_langcode = $_POST['h_langcode'];
	$h_conid = $_POST['h_conid'];
	$h_pagid = $_POST['h_pagid'];

	$sql1 = "delete from flc_content  where con_id = '$h_conid';";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_page_column_add.php?id=$h_memid&page=$h_pagid&lang=$h_langcode\">";

	exit();
?>

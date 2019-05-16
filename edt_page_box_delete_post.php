<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_memid = $_POST['h_memid'];
	$h_langcode = $_POST['h_langcode'];
	$h_boxid = $_POST['h_boxid'];
	$h_pagid = $_POST['h_pagid'];

	if ($_SESSION['vmd'] != $h_memid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql1 = "delete from flc_present_box  where box_id = '$h_boxid';";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_page_box_add.php?page=$h_pagid&lang=$h_langcode\">";

	exit();
?>

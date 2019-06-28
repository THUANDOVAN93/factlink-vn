<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$eventId = $_GET['id'];

	$sql1 = "delete from flc_events where id = '$eventId';";
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_events.php?start=0\">";
	exit();
?>

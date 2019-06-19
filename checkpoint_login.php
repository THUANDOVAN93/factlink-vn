<?php
	session_start(); 

	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	
	$cp_user = $_POST['cp_user'];
	$cp_pass = $_POST['cp_pass'];

	$sql1 = "select * from flc_user where usr_user = '$cp_user' and usr_pass = '$cp_pass';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		$_SESSION['vd'] = $dbarr1['usr_id'];
		$_SESSION['vp'] = $dbarr1['usr_per'];
		
	}
	
	mysql_close($link);
	echo "<meta http-equiv = \"refresh\" content = \"0;URL = index.php\">"; 
	exit();
?>
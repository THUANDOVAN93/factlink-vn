<?php

	session_start(); 

	include_once("./include/global_config.php");
	
	mysql_query("use $db_name;");
	
	$cp_user = mysql_real_escape_string($_POST['cp_user']);
	$cp_pass = mysql_real_escape_string($_POST['cp_pass']);

	
	$sql1 = "select * from flc_user where usr_user = '$cp_user' and usr_pass = '$cp_pass';";
	$result1 = mysql_query($sql1)or die("din't query sql sever");
	
	while($dbarr1 = mysql_fetch_array($result1)) {
		$_SESSION['vd'] = $dbarr1['usr_id'];
		$_SESSION['vp'] = $dbarr1['usr_per'];
	}
	
	mysql_close($link);
	
	if ($_SESSION['vd'] != '') {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_index.php\">";
	} else { 
		echo "<meta http-equiv = \"refresh\" content = \"1;URL = adm_login.html\">"; 
	}
	exit();
?>
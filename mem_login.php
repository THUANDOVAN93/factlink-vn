<?php

	session_start(); 

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	
	$t_memuser = mysql_real_escape_string($_POST['t_memuser']);
	$t_mempass = mysql_real_escape_string($_POST['t_mempass']);

	
	$sql1 = "select * from flc_member where mem_user = '$t_memuser' and mem_pass = '$t_mempass' and mem_status != 'd';";
	$result1 = mysql_query($sql1);
	
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		$memstatus = $dbarr1['mem_status'];
		
		if ($memstatus == 'd') {
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = register.php\">";
		}
		
		
		$_SESSION['vmd'] = $dbarr1['mem_id'];
		$memid = $dbarr1['mem_id'];
		
		$selflogin = $dbarr1['mem_selflogin'];
		$selflogin = $selflogin + 1;
		
		$sql2 = "update flc_member set mem_selflogin = '$selflogin', mem_lastlogindate = '$nowdate' where mem_id = '$memid';";
		$result2 = mysql_query($sql2);
		
	}
	
	mysql_close($link);
	
	if ($_SESSION['vmd'] != '') {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_index.php\">";
	} else {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_login_fail.php\">";
	}
	
	exit();
	
?>
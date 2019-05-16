<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$t_memcat = $_POST['t_memcat'];
	$t_type = $_POST['t_type'];

	$_SESSION['vsearchcateid'] = $t_memcat;
	$_SESSION['vsearchcatetype'] = $t_type;

	if ($t_memcat != "") {

		if ($t_type == 'basic') { $sql = "select * from flc_member where mem_category like '%$t_memcat%' and mem_package != ''"; }
		else { $sql = "select * from flc_member where mem_category like '%$t_memcat%' and mem_package = ''";	}

	} else { $sql = "select * from flc_member where mem_id = ''"; }

	$_SESSION['vsearchcate'] = $sql;

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_searchcate.php?start=0\">";
	exit();
?>

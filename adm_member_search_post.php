<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$t_search = $_POST['t_search'];
	$t_type = $_POST['t_type'];

	$_SESSION['vsearchword'] = $t_search;
	$_SESSION['vsearchtype'] = $t_type;

	if ($t_search != "") {

		$sql = "select * from flc_member where (mem_comname_en like '%$t_search%' or ";
		$sql = $sql."mem_comname_jp like '%$t_search%' or ";
		$sql = $sql."mem_comname_vn like '%$t_search%' or ";
		$sql = $sql."mem_comname_aka like '%$t_search%')";

		if ($t_type == 'basic') { $sql = $sql." and mem_package != ''"; }
		else if ($t_type == 'free') { $sql = $sql." and mem_package = ''"; }

	} else {

		if ($t_type == 'basic') { $sql = "select * from flc_member where mem_package != ''"; }
		else if ($t_type == 'free') { $sql = "select * from flc_member where mem_package = ''"; }
		else { $sql = "select * from flc_member"; }

	}

	$_SESSION['vsearch'] = $sql;

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_search.php?start=0\">";
	exit();
?>

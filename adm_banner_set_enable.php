<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");

	$banid = $_GET['id'];
	$bantype = $_GET['type'];

	$sql4 = "select * from flc_banner where ban_id = '$banid';";
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) { $banpage = $dbarr4['ban_page']; $banside = $dbarr4['ban_side']; }

	$sql0 = "select * from flc_banner where ban_type = '$bantype' and ban_page = '$banpage' and ban_side = '$banside' order by ban_sort desc limit 0,1;";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $bansort = $dbarr0['ban_sort'] + 1; } if ($bansort == '') { $bansort = 1; }

	if ($bantype == 'spc' && $banpage != 'idx') {

		$sql2 = "update flc_banner set ban_status = 'd' where ban_type = 'spc' and ban_page = '$banpage';";
		$result2 = mysql_query($sql2);

		$bansort = 0;

	}

	$sql1 = "update flc_banner set ban_status = '', ban_sort = '$bansort' where ban_id = '$banid';";
	$result1 = mysql_query($sql1);

?>
<script language="JavaScript">history.back()</script>

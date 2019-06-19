<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	
	// Escape special charactars
	$_GET = array_map('mysql_real_escape_string',$_GET);

	$banid = $_GET['id'];
	$bantype = $_GET['type'];

	$sql0 = "select * from flc_banner where ban_id = '$banid';";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $bansort = $dbarr0['ban_sort']; $banpage = $dbarr0['ban_page']; $banside = $dbarr0['ban_side']; }

	if ($bantype == 'bsc') {

		if ($bansort != '0') {

			$sql2 = "select * from flc_banner where ban_type = '$bantype' and ban_page = '$banpage' and ban_side = '$banside' and ban_sort > '$bansort' order by ban_sort asc;";
			$result2 = mysql_query($sql2);
			while ($dbarr2 = mysql_fetch_array($result2)) {

				$upbanid = $dbarr2['ban_id'];
				$newbansort = $dbarr2['ban_sort'] - 1;

				$sql3 = "update flc_banner set ban_sort = '$newbansort' where ban_id = '$upbanid';";
				$result3 = mysql_query($sql3);

			}

		}

	}

	$sql1 = "update flc_banner set ban_status = 'd', ban_sort = '0' where ban_id = '$banid';";
	$result1 = mysql_query($sql1);

?>
<script language="JavaScript">history.back()</script>

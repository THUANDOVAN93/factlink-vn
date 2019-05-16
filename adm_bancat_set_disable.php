<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_GET = array_map('mysql_real_escape_string',$_GET);

	$bacid = $_GET['id'];
	$bactype = $_GET['type'];

	$sql0 = "select * from flc_banner_cate where bac_id = '$bacid';";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $bacsort = $dbarr0['bac_sort']; }

	if ($bactype == 'bsc') {

		$sql2 = "select * from flc_banner_cate where bac_type = '$bactype' and bac_sort > '$bacsort' order by bac_sort asc;";
		$result2 = mysql_query($sql2);
		while ($dbarr2 = mysql_fetch_array($result2)) {

			$upbacid = $dbarr2['bac_id'];
			$newbacsort = $dbarr2['bac_sort'] - 1;

			$sql3 = "update flc_banner_cate set bac_sort = '$newbacsort' where bac_id = '$upbacid';";
			$result3 = mysql_query($sql3);

		}

	}

	$sql1 = "update flc_banner_cate set bac_status = 'd', bac_sort = '0' where bac_id = '$bacid';";
	$result1 = mysql_query($sql1);

?>
<script language="JavaScript">history.back()</script>

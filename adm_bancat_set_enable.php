<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_GET = array_map('mysql_real_escape_string',$_GET);

	$bacid = $_GET['id'];
	$bactype = $_GET['type'];

	$sql0 = "select * from flc_banner_cate where bac_type = '$bactype' order by bac_sort desc limit 0,1;";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { $bacsort = $dbarr0['bac_sort'] + 1; }

	if ($bactype == 'spc') {

		$sql3 = "select * from flc_banner_cate where bac_id = '$bacid';";
		$result3 = mysql_query($sql3);
		while ($dbarr3 = mysql_fetch_array($result3)) { $catid = $dbarr3['cat_id']; }

		$sql2 = "update flc_banner_cate set bac_status = 'd' where bac_type = 'spc' and cat_id = '$catid';";
		$result2 = mysql_query($sql2);

		$bacsort = 0;

	}

	$sql1 = "update flc_banner_cate set bac_status = '', bac_sort = '$bacsort' where bac_id = '$bacid';";
	$result1 = mysql_query($sql1);

?>
<script language="JavaScript">history.back()</script>

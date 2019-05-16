<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
		
	mysql_query("use $db_name;");

	$h_banid = $_POST['h_banid'];
	$h_bantype = $_POST['h_bantype'];
	$h_bansort = $_POST['h_bansort'];
	$h_pospage = $_POST['h_pospage'];
	$h_posside = $_POST['h_posside'];
	$t_sort = $_POST['t_sort'];

	if (sortnumcheck($t_sort) == 'f') { $t_sort = $h_bansort; }

	$sql4 = "select * from flc_banner where ban_type = 'bsc' and ban_page = '$h_pospage' and ban_side = '$h_posside' order by ban_sort desc limit 0,1;";
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) { $maxsort = $dbarr4['ban_sort']; } if ($t_sort > $maxsort) { $t_sort = $maxsort; }

	if ($t_sort != $h_bansort) {

		if ($t_sort < $h_bansort) {

			$sql1 = "select * from flc_banner where ban_type = 'bsc' and ban_page = '$h_pospage' and ban_side = '$h_posside' and ban_sort >= '$t_sort' and ban_sort < '$h_bansort';";
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {

				$banid = $dbarr1['ban_id'];
				$newsort = $dbarr1['ban_sort'] + 1;

				$sql2 = "update flc_banner set ban_sort = '$newsort' where ban_id = '$banid';";
				$result2 = mysql_query($sql2);

				$sortcheck = "t";

			}

		}

		if ($t_sort > $h_bansort) {

			$sql1 = "select * from flc_banner where ban_type = 'bsc' and ban_page = '$h_pospage' and ban_side = '$h_posside' and ban_sort > '$h_bansort' and ban_sort <= '$t_sort';";
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {

				$banid = $dbarr1['ban_id'];
				$newsort = $dbarr1['ban_sort'] - 1;

				$sql2 = "update flc_banner set ban_sort = '$newsort' where ban_id = '$banid';";
				$result2 = mysql_query($sql2);

				$sortcheck = "t";

			}

		}

		if ($sortcheck == 't') {

			$sql3 =  "update flc_banner set ban_sort = '$t_sort' where ban_id = '$h_banid';";
			$result3 = mysql_query($sql3);

		}

	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_banner.php?start=0&type=$h_bantype\">";

	exit();
?>

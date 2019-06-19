<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	mysql_query("use $db_name;");

	$h_bulid = $_POST['h_bulid'];
	$h_bulsort = $_POST['h_bulsort'];
	$h_pospage = $_POST['h_pospage'];
	$h_posside = $_POST['h_posside'];
	$t_sort = $_POST['t_sort'];

	if (sortnumcheck($t_sort) == 'f') { $t_sort = $h_bulsort; }

	$sql4 = "select * from flc_bulletin where bul_page = '$h_pospage' and bul_side = '$h_posside' order by bul_sort desc limit 0,1;";
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) { $maxsort = $dbarr4['bul_sort']; } if ($t_sort > $maxsort) { $t_sort = $maxsort; }

	if ($t_sort != $h_bulsort) {

		if ($t_sort < $h_bulsort) {

			$sql1 = "select * from flc_bulletin where bul_page = '$h_pospage' and bul_side = '$h_posside' and bul_sort >= '$t_sort' and bul_sort < '$h_bulsort';";
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {

				$bulid = $dbarr1['bul_id'];
				$newsort = $dbarr1['bul_sort'] + 1;

				$sql2 = "update flc_bulletin set bul_sort = '$newsort' where bul_id = '$bulid';";
				$result2 = mysql_query($sql2);

				$sortcheck = "t";

			}

		}

		if ($t_sort > $h_bulsort) {

			$sql1 = "select * from flc_bulletin where bul_page = '$h_pospage' and bul_side = '$h_posside' and bul_sort > '$h_bulsort' and bul_sort <= '$t_sort';";
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {

				$bulid = $dbarr1['bul_id'];
				$newsort = $dbarr1['bul_sort'] - 1;

				$sql2 = "update flc_bulletin set bul_sort = '$newsort' where bul_id = '$bulid';";
				$result2 = mysql_query($sql2);

				$sortcheck = "t";

			}

		}

		if ($sortcheck == 't') {

			$sql3 =  "update flc_bulletin set bul_sort = '$t_sort' where bul_id = '$h_bulid';";
			$result3 = mysql_query($sql3);

		}

	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_bulletin.php?start=0\">";

	exit();
?>

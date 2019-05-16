<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_memid = $_POST['h_memid'];
	$h_catid = $_POST['h_catid'];
	$h_memsort = $_POST['h_memsort'];
	$t_sort = $_POST['t_sort'];

	if (sortnumcheck($t_sort) == 'f') { $t_sort = $h_memsort; }

	$sql4 = "select * from flc_member where mem_category = '$h_catid' and mem_package != '' order by mem_sort desc limit 0,1;";
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) { $maxsort = $dbarr4['mem_sort']; } if ($t_sort > $maxsort) { $t_sort = $maxsort; }

	if ($t_sort != $h_memsort) {

		if ($t_sort < $h_memsort) {

			$sql1 = "select * from flc_member where mem_category = '$h_catid' and mem_package != '' and mem_sort >= '$t_sort' and mem_sort < '$h_memsort';";
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {

				$memid = $dbarr1['mem_id'];
				$newsort = $dbarr1['mem_sort'] + 1;

				$sql2 = "update flc_member set mem_sort = '$newsort' where mem_id = '$memid';";
				$result2 = mysql_query($sql2);

				$sortcheck = "t";

			}

		}

		if ($t_sort > $h_memsort) {

			$sql1 = "select * from flc_member where mem_category = '$h_catid' and mem_package != '' and mem_sort > '$h_memsort' and mem_sort <= '$t_sort';";
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {

				$memid = $dbarr1['mem_id'];
				$newsort = $dbarr1['mem_sort'] - 1;

				$sql2 = "update flc_member set mem_sort = '$newsort' where mem_id = '$memid';";
				$result2 = mysql_query($sql2);

				$sortcheck = "t";

			}

		}

		if ($sortcheck == 't') {

			$sql3 =  "update flc_member set mem_sort = '$t_sort' where mem_id = '$h_memid';";
			$result3 = mysql_query($sql3);

		}

	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_searchcate.php?start=0\">";

	exit();
?>

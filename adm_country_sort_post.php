<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_ctyid = $_POST['h_ctyid'];
	$h_ctyorder = $_POST['h_ctyorder'];
	$t_sort = $_POST['t_sort'];

	if (sortnumcheck($t_sort) == 'f') { $t_sort = $h_ctyorder; }

	$sql4 = "select * from flc_country order by cty_order desc limit 0,1;";
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) { $maxsort = $dbarr4['cty_order']; } if ($t_sort > $maxsort) { $t_sort = $maxsort; }

	if ($t_sort != $h_ctyorder) {

		if ($t_sort < $h_ctyorder) {

			$sql1 = "select * from flc_country where cty_order >= '$t_sort' and cty_order < '$h_ctyorder';";
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {

				$ctyid = $dbarr1['cty_id'];
				$newsort = $dbarr1['cty_order'] + 1;

				$sql2 = "update flc_country set cty_order = '$newsort' where cty_id = '$ctyid';";
				$result2 = mysql_query($sql2);

				$sortcheck = "t";

			}

		}

		if ($t_sort > $h_ctyorder) {

			$sql1 = "select * from flc_country where cty_order > '$h_ctyorder' and cty_order <= '$t_sort';";
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {

				$ctyid = $dbarr1['cty_id'];
				$newsort = $dbarr1['cty_order'] - 1;

				$sql2 = "update flc_country set cty_order = '$newsort' where cty_id = '$ctyid';";
				$result2 = mysql_query($sql2);

				$sortcheck = "t";

			}

		}

		if ($sortcheck == 't') {

			$sql3 =  "update flc_country set cty_order = '$t_sort' where cty_id = '$h_ctyid';";
			$result3 = mysql_query($sql3);

		}

	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_country.php?start=0\">";

	exit();
?>

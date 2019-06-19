<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_catid = $_POST['h_catid'];
	$h_catorder = $_POST['h_catorder'];
	$t_sort = $_POST['t_sort'];

	if (sortnumcheck($t_sort) == 'f') { $t_sort = $h_catorder; }

	$sql4 = "select * from flc_category order by cat_order desc limit 0,1;";
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) { $maxsort = $dbarr4['cat_order']; } if ($t_sort > $maxsort) { $t_sort = $maxsort; }

	if ($t_sort != $h_catorder) {

		if ($t_sort < $h_catorder) {

			$sql1 = "select * from flc_category where cat_order >= '$t_sort' and cat_order < '$h_catorder';";
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {

				$catid = $dbarr1['cat_id'];
				$newsort = $dbarr1['cat_order'] + 1;

				$sql2 = "update flc_category set cat_order = '$newsort' where cat_id = '$catid';";
				$result2 = mysql_query($sql2);

				$sortcheck = "t";

			}

		}

		if ($t_sort > $h_catorder) {

			$sql1 = "select * from flc_category where cat_order > '$h_catorder' and cat_order <= '$t_sort';";
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {

				$catid = $dbarr1['cat_id'];
				$newsort = $dbarr1['cat_order'] - 1;

				$sql2 = "update flc_category set cat_order = '$newsort' where cat_id = '$catid';";
				$result2 = mysql_query($sql2);

				$sortcheck = "t";

			}

		}

		if ($sortcheck == 't') {

			$sql3 =  "update flc_category set cat_order = '$t_sort' where cat_id = '$h_catid';";
			$result3 = mysql_query($sql3);

		}

	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_category.php?start=0\">";

	exit();
?>

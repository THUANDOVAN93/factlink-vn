<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_memid = $_POST['h_memid'];
	$h_mempackage = $_POST['h_mempackage'];
	$h_memcat = $_POST['h_memcat'];
	$h_memsort = $_POST['h_memsort'];
	$h_bucsort = $_POST['h_bucsort'];
	$t_package = $_POST['t_package'];
	$t_day = $_POST['t_day'];
	$t_month = $_POST['t_month'];
	$t_year = $_POST['t_year'];
	$t_memcat = $_POST['t_memcat'];

	if ($t_day == '' || $t_month == '' || $t_year == '') { $t_startdate = ""; } else { $startdate = $t_day." ".$t_month." ".$t_year; }

	if ($t_package != '') {

		// Package
		$sql3 = "select * from flc_package where pck_id = '$t_package';";
		$result3 = mysql_query($sql3);
		while ($dbarr3 = mysql_fetch_array($result3)) { $pckmonth = $dbarr3['pck_month']; }
		//while ($dbarr3 = mysql_fetch_array($result3)) { $pckday = $dbarr3['pck_day']; }

		// Expire
		$gap = explode(" ", $startdate);
		$gap[1] = mcvsubtonum($gap[1]);
		$endyear = $gap[2];

		$endmonth = $gap[1] + $pckmonth;

		for ($em=$endmonth;$em>12;$em-12) {
			$endmonth = $endmonth - 12;
			$endyear = $endyear + 1;
			$em = $endmonth;
		}

		$mlimit = explode("-",monthcal($endmonth, $endyear));
		if ($gap[0] > $mlimit[2]) { $endday = $mlimit[2]; } else { $endday = $gap[0]; }

		$enddate = addzero2($endday)." ".mcvnumtosub($endmonth)." ".$endyear;

		// Pre expire
		$preyear = $endyear;
		$premonth = $endmonth - 1; // Warning 1 month before expire
		if ($premonth < 1) { $premonth = 12; $preyear = $preyear - 1; }

		$mlimit = explode("-",monthcal($premonth, $preyear));
		if ($gap[0] > $mlimit[2]) { $preday = $mlimit[2]; } else { $preday = $gap[0]; }

		$preenddate = addzero2($preday)." ".mcvnumtosub($premonth)." ".$preyear;

		/*
		// Expire date
		$len = $pckday;
		$gap = explode(" ", $startdate);
		$gap[1] = mcvsubtonum($gap[1]);
		$gap[3] = "";
		$end = expcal($gap[0], $gap[1], $gap[2], $gap[3], $len);

		$tmpend = explode(" ", $end);

		$checkend = $tmpend[2]."-".addzero2($tmpend[1])."-".addzero2($tmpend[0])." 00:00:00";
		if ($checkend <= date("Y-m-d H:i:s")) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_view.php?id=$h_memid\">"; exit(); }

		$tmpend[1] = mcvnumtosub($tmpend[1]);
		$tmpend[0] = addzero2($tmpend[0]);

		$enddate = $tmpend[0]." ".$tmpend[1]." ".$tmpend[2];

		// Pre-Expire date
		$len = $pckday - 30;
		$gap = explode(" ", $startdate);
		$gap[1] = mcvsubtonum($gap[1]);
		$gap[3] = "";
		$preend = expcal($gap[0], $gap[1], $gap[2], $gap[3], $len);

		$tmppreend = explode(" ", $preend);

		$checkpreend = $tmppreend[2]."-".addzero2($tmppreend[1])."-".addzero2($tmppreend[0])." 00:00:00";
		if ($checkpreend <= date("Y-m-d H:i:s")) { $warning = "t"; } else { $warning = ""; }

		$tmppreend[1] = mcvnumtosub($tmppreend[1]);
		$tmppreend[0] = addzero2($tmppreend[0]);

		$preenddate = $tmppreend[0]." ".$tmppreend[1]." ".$tmppreend[2];
		*/

		// Sort
		if ($h_mempackage != '') {

			if ($h_memcat != $t_memcat) {

				// Member Section
				$sql8 = "select * from flc_member where mem_category = '$h_memcat' and mem_package != '' and mem_sort > '$h_memsort' order by mem_sort asc;";
				$result8 = mysql_query($sql8);
				while ($dbarr8 = mysql_fetch_array($result8)) {

					$upmemid = $dbarr8['mem_id'];
					$newmemsort = $dbarr8['mem_sort'] - 1;

					$sql9 = "update flc_member set mem_sort = '$newmemsort' where mem_id = '$upmemid';";
					$result9 = mysql_query($sql9);

				}

				$sql7 = "select * from flc_member where mem_category = '$t_memcat' and mem_package != '' order by mem_sort desc limit 0,1;";
				$result7 = mysql_query($sql7);
				while ($dbarr7 = mysql_fetch_array($result7)) { $memsort = $dbarr7['mem_sort']; }
				$h_memsort = $memsort + 1;

				// Bulletin Cate Section
				$sql12 = "select * from flc_bulletin_cate where cat_id = '$h_memcat' and buc_page = 'sch' and buc_side ='r' and buc_sort > '$h_bucsort' order by buc_sort asc;";
				$result12 = mysql_query($sql12);
				while ($dbarr12 = mysql_fetch_array($result12)) {

					$upbucid = $dbarr12['buc_id'];
					$newbucsort = $dbarr12['buc_sort'] - 1;

					$sql13 = "update flc_bulletin_cate set buc_sort = '$newbucsort' where buc_id = '$upbucid';";
					$result13 = mysql_query($sql13);

				}

				$sql14 = "select * from flc_bulletin_cate where cat_id = '$t_memcat' and buc_page = 'sch' and buc_side ='r' order by buc_sort desc limit 0,1;";
				$result14 = mysql_query($sql14);
				while ($dbarr14 = mysql_fetch_array($result14)) { $bucsort = $dbarr14['buc_sort']; }
				$bucsort = $bucsort + 1;

			}  else { $bucsort = $h_bucsort; }

		} else {

			$sql4 = "select * from flc_member where mem_category = '$t_memcat' and mem_package != '' order by mem_sort desc limit 0,1;";
			$result4 = mysql_query($sql4);
			while ($dbarr4 = mysql_fetch_array($result4)) { $memsort = $dbarr4['mem_sort']; }
			$h_memsort = $memsort + 1;

			$sql15 = "select * from flc_bulletin_cate where cat_id = '$t_memcat' and buc_page = 'sch' and buc_side ='r' order by buc_sort desc limit 0,1;";
			$result15 = mysql_query($sql15);
			while ($dbarr15 = mysql_fetch_array($result15)) { $bucsort = $dbarr15['buc_sort']; }
			$bucsort = $bucsort + 1;

		}

		$membermark = "t";

	} else {

		if ($h_mempackage != '') {

			$sql5 = "select * from flc_member where mem_category = '$h_memcat' and mem_pacakge != '' and mem_sort > '$h_memsort' order by mem_sort asc;";
			$result5 = mysql_query($sql5);
			while ($dbarr5 = mysql_fetch_array($result5)) {

				$upmemid = $dbarr5['mem_id'];
				$newmemsort = $dbarr5['mem_sort'] - 1;

				$sql6 = "update flc_member set mem_sort = '$newmemsort' where mem_id = '$upmemid';";
				$result6 = mysql_query($sql6);

			}

			$sql10 = "select * from flc_bulletin_cate where cat_id = '$h_memcat' and buc_page = 'sch' and buc_side ='r' and buc_sort > '$h_bucsort' order by buc_sort asc;";
			$result10 = mysql_query($sql10);
			while ($dbarr10 = mysql_fetch_array($result10)) {

				$upbucid = $dbarr10['buc_id'];
				$newbucsort = $dbarr10['buc_sort'] - 1;

				$sql11 = "update flc_bulletin_cate set buc_sort = '$newbucsort' where buc_id = '$upbucid';";
				$result11 = mysql_query($sql11);

			}

		}

		// Page
		$sqlexpmem2 = "select pag_id from flc_page where mem_id = '$h_memid' and pag_type != 'prf' and pag_type != 'hom';";
		$resultexpmem2 = mysql_query($sqlexpmem2);
		while ($dbarrexpmem2 = mysql_fetch_array($resultexpmem2)) {

			$exppagid = $dbarrexpmem2['pag_id'];

			$sqlexpmem3 = "update flc_page set pag_status = 'd' where pag_id = '$exppagid';";
			$resultexpmem3 = mysql_query($sqlexpmem3);

		}
		// ----

		$h_memsort = 0;
		$startdate = ""; $enddate = ""; $preenddate = ""; $warning = ""; $membermark = "";
		$bucsort = 0; $bucstatus = "d";

	}

	$sql1 = "update flc_member set mem_category = '$t_memcat', mem_package = '$t_package', mem_startdate = '$startdate', mem_preenddate = '$preenddate',
					mem_enddate = '$enddate', mem_expirewarning = '$warning', mem_sort = '$h_memsort', mem_status = '' where mem_id = '$h_memid';";
	$result1 = mysql_query($sql1);

	$sql2 = "update flc_bulletin_cate set cat_id = '$t_memcat', buc_sort = '$bucsort', buc_status = '$bucstatus' where mem_id = '$h_memid';";
	$result2 = mysql_query($sql2);

	$sql3 = "update flc_profile set prf_membermark = '$membermark' where mem_id = '$h_memid';";
	$result3 = mysql_query($sql3);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_view.php?id=$h_memid\">";

	exit();
?>

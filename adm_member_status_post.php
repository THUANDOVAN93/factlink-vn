<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_memid = $_POST['h_memid'];
	$t_status = $_POST['t_status'];
	$m_status = $_POST['m_status'];

	if ($t_status == 'disable') {

		$sqlexpmem = "select mem_id from flc_member where mem_id = '$h_memid';";
		$resultexpmem = mysql_query($sqlexpmem);
		while ($dbarrexpmem = mysql_fetch_array($resultexpmem)) {

			$expmemid = $dbarrexpmem['mem_id'];
			$expmemsort = $dbarrexpmem['mem_sort'];
			$expmemcategory = explode(" ", $dbarrexpmem['mem_category']);
			$expmemcate = $expmemcategory[0];

			// Member
			$sqlexpmem8 = "select * from flc_member where mem_category = '$expmemcat' and mem_package != '' and mem_sort > '$expmemsort' order by mem_sort asc;";
			$resultexpmem8 = mysql_query($sqlexpmem8);
			while ($dbarrexpmem8 = mysql_fetch_array($resultexpmem8)) {

				$expupmemid = $dbarrexpmem8['mem_id'];
				$expnewmemsort = $dbarrexpmem8['mem_sort'] - 1;

				$sqlexpmem9 = "update flc_member set mem_sort = '$expnewmemsort' where mem_id = '$expupmemid';";
				$resultexpmem9 = mysql_query($sqlexpmem9);

			}

			$sqlexpmem1 = "update flc_member set mem_startdate = '', mem_preenddate = '', mem_enddate = '', mem_package = '', mem_expirewarning = '', mem_sort = '0', mem_status = 'd' where mem_id = '$expmemid';";
			$resultexpmem1 = mysql_query($sqlexpmem1);

			// Page
			$sqlexpmem2 = "select pag_id from flc_page where mem_id = '$expmemid' and pag_type != 'prf';";
			$resultexpmem2 = mysql_query($sqlexpmem2);
			while ($dbarrexpmem2 = mysql_fetch_array($resultexpmem2)) {

				$exppagid = $dbarrexpmem2['pag_id'];

				$sqlexpmem3 = "update flc_page set pag_status = 'd' where pag_id = '$exppagid';";
				$resultexpmem3 = mysql_query($sqlexpmem3);

			}

			// Bulletin - Category
			$sqlexpmem4 = "select * from flc_bulletin_cate where mem_id = '$expmemid';";
			$resultexpmem4 = mysql_query($sqlexpmem4);
			while ($dbarrexpmem4 = mysql_fetch_array($resultexpmem4)) {

				$expbucid = $dbarrexpmem4['buc_id'];
				$expbuccatid = $dbarrexpmem4['cat_id'];
				$expbucpage = $dbarrexpmem4['buc_page'];
				$expbucside = $dbarrexpmem4['buc_side'];
				$expbucsort = $dbarrexpmem4['buc_sort'];

			}

			$sqlexpmem5 = "select * from flc_bulletin_cate where cat_id = '$expbuccatid', buc_page = '$expbucpage', buc_side = '$expbucside', buc_sort > '$expbucsort' order by buc_sort asc;";
			$resultexpmem5 = mysql_query($sqlexpmem5);
			while ($dbarrexpmem5 = mysql_fetch_array($resultexpmem5)) {

				$expupbucid = $dbarrexpmem5['buc_id'];
				$expnewbucsort = $dbarrexpmem5['buc_sort'] - 1;

				$sqlexpmem6 = "update flc_bulletin_cate set buc_sort = '$expnewbucsort' where buc_id = '$expupbucid';";
				$resultexpmem6 = mysql_query($sqlexpmem6);

			}

			$sqlexpmem7 = "update flc_bulletin_cate set buc_status = 'd', buc_sort = '0' where mem_id = '$expmemid';";
			$resultexpmem7 = mysql_query($sqlexpmem7);

		}

	} else {

		$sql1 = "update flc_member set mem_status = '' where mem_id = '$h_memid';";
		$result1 = mysql_query($sql1);

	}
    if ($m_status == 'disable') {

			$sqlmagazine = "update flc_member  set mem_mailop_mag='0' where mem_id = '$h_memid';";
			$resultmagazine = mysql_query($sqlmagazine);

	}
	if ($m_status == 'enable') {

			$sqlmagazine = "update flc_member  set mem_mailop_mag='1' where mem_id = '$h_memid';";
			$resultmagazine = mysql_query($sqlmagazine);

	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_view.php?id=$h_memid\">";

	exit();
?>

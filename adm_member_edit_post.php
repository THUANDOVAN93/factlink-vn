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
	$t_comname_en = $_POST['t_comname_en'];
	$t_comname_jp = $_POST['t_comname_jp'];
	$t_comname_vn = $_POST['t_comname_vn'];
	$t_memsubdesc_en = $_POST['t_memsubdesc_en'];
	$t_memsubdesc_jp = $_POST['t_memsubdesc_jp'];
	$t_memsubdesc_vn = $_POST['t_memsubdesc_vn'];
	$t_memcat = $_POST['t_memcat'];
	$t_memcat_second = $_POST['t_memcat_second'];
	$t_comie = $_POST['t_comie'];
	$t_comaddress_en = $_POST['t_comaddress_en'];
	$t_comaddress_jp = $_POST['t_comaddress_jp'];
	$t_comaddress_vn = $_POST['t_comaddress_vn'];
	$t_comprovince = $_POST['t_comprovince'];
	$t_comcountry = $_POST['t_comcountry'];
	$t_comzip = $_POST['t_comzip'];
	$t_comtel = $_POST['t_comtel'];
	$t_comfax = $_POST['t_comfax'];
	$t_contact_en = $_POST['t_contact_en'];
	$t_contact_jp = $_POST['t_contact_jp'];
	$t_contact_vn = $_POST['t_contact_vn'];
	$t_position_en = $_POST['t_position_en'];
	$t_position_jp = $_POST['t_position_jp'];
	$t_position_vn = $_POST['t_position_vn'];
	$t_gender = $_POST['t_gender'];
	$t_mail = $_POST['t_mail'];
	$t_oth_contactmail = $_POST['t_oth_contactmail'];
	$t_tel = $_POST['t_tel'];
	$t_memo1 = $_POST['t_memo1'];
	$t_memo2 = $_POST['t_memo2'];
	$t_national = $_POST['t_national']; // National for sorting in category, added 2011.07.04, for VN only

	
	/* Convert LineBreak character to string [br] */
	$t_comaddress_en = str_replace('\\r\\n','[br]',($t_comaddress_en));
	$t_comaddress_jp = str_replace('\\r\\n','[br]',($t_comaddress_jp));
	$t_comaddress_vn = str_replace('\\r\\n','[br]',($t_comaddress_vn));
	$t_oth_contactmail = str_replace('\\r\\n','[br]',($t_oth_contactmail));
	$t_memo1 = str_replace('\\r\\n','[br]',($t_memo1));
	$t_memo2 = str_replace('\\r\\n','[br]',($t_memo2));
	
	
	if ($t_comprovince == '001' && $t_comcountry == '') { $t_comcountry = "001"; }

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
			$h_bucsort = $bucsort + 1;

		}

	}

	$sql1 = "update flc_member set mem_category = '$t_memcat', mem_category_second = '$t_memcat_second', mem_comname_en = '$t_comname_en', mem_comname_jp = '$t_comname_jp', mem_comname_vn = '$t_comname_vn',
					mem_national = '$t_national', mem_subdesc_en = '$t_memsubdesc_en', mem_subdesc_jp = '$t_memsubdesc_jp', mem_subdesc_vn = '$t_memsubdesc_vn',
					mem_address1_en = '$t_comaddress_en', mem_address1_jp = '$t_comaddress_jp', mem_address1_vn = '$t_comaddress_vn',
					mem_addressine1 = '$t_comie', mem_addressprv1 = '$t_comprovince', mem_addresscty1 = '$t_comcountry', mem_addresszip1 = '$t_comzip', mem_comtel = '$t_comtel',
					mem_comfax = '$t_comfax', mem_contactname_en = '$t_contact_en', mem_contactname_jp = '$t_contact_jp',
					mem_contactname_vn = '$t_contact_vn', mem_contactposition_en = '$t_position_en', mem_contactposition_jp = '$t_position_jp',
					mem_contactposition_vn = '$t_position_vn', mem_contactgender = '$t_gender', mem_contactmail = '$t_mail', mem_oth_contactmail = '$t_oth_contactmail', mem_contacttel = '$t_tel',
					mem_memo1 = '$t_memo1', mem_memo2 = '$t_memo2', mem_sort = '$h_memsort'
					where mem_id = '$h_memid';";
	$result1 = mysql_query($sql1);

	$sql2 = "update flc_bulletin_cate set cat_id = '$t_memcat', buc_sort = '$h_bucsort' where mem_id = '$h_memid';";
	$result2 = mysql_query($sql2);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_view.php?id=$h_memid\">";

	exit();
?>

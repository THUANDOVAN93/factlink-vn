<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$t_nwg = $_POST['t_nwg'];
	$t_nwe = $_POST['t_nwe'];
	$t_title_en = addslashes($_POST['t_title_en']);
	$t_title_jp = addslashes($_POST['t_title_jp']);
	$t_title_vn = addslashes($_POST['t_title_vn']);
	$t_sum_en = addslashes($_POST['t_sum_en']);
	$t_sum_jp = addslashes($_POST['t_sum_jp']);
	$t_sum_vn = addslashes($_POST['t_sum_vn']);
	$t_detail_en = addslashes($_POST['t_detail_en']);
	$t_detail_jp = addslashes($_POST['t_detail_jp']);
	$t_detail_vn = addslashes($_POST['t_detail_vn']);
	$t_memo = addslashes($_POST['t_memo']);
	$t_day = $_POST['t_day'];
	$t_month = $_POST['t_month']; $t_month = addzero2(mcvsubtonum($t_month));
	$t_year = $_POST['t_year'];
	$t_show = $_POST['t_show'];
	$t_status = $_POST['t_status'];


	if ($_SESSION['vd'] != $h_admid) {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">";
		exit();
	}

	/* Convert LineBreak character to string [br] */
	$t_title_en = str_replace('\\r\\n','[br]',stripcslashes($t_title_en));
	$t_sum_en = str_replace('\\r\\n','[br]',stripcslashes($t_sum_en));	
	$t_detail_en = str_replace('\\r\\n','[br]',stripcslashes($t_detail_en));

	$t_title_jp = str_replace('\\r\\n','[br]',stripcslashes($t_title_jp));
	$t_sum_jp = str_replace('\\r\\n','[br]',stripcslashes($t_sum_jp));	
	$t_detail_jp = str_replace('\\r\\n','[br]',stripcslashes($t_detail_jp));

	$t_title_vn = str_replace('\\r\\n','[br]',stripcslashes($t_title_vn));
	$t_sum_vn = str_replace('\\r\\n','[br]',stripcslashes($t_sum_vn));	
	$t_detail_vn = str_replace('\\r\\n','[br]',stripcslashes($t_detail_vn));

	$t_memo = str_replace('\\r\\n','[br]',stripcslashes($t_memo));
	
	$sql1 = "insert into flc_news (nwg_id, nwe_id, nws_title_en, nws_title_jp, nws_title_vn, nws_compend_en, nws_compend_jp, nws_compend_vn,
					nws_detail_en, nws_detail_jp, nws_detail_vn, nws_year, nws_month, nws_day, nws_date, nws_time, nws_show, nws_status, nws_memo)
					values ('$t_nwg', '$t_nwe', '$t_title_en', '$t_title_jp', '$t_title_vn', '$t_sum_en', '$t_sum_jp', '$t_sum_vn',
					'$t_detail_en', '$t_detail_jp', '$t_detail_vn', '$t_year', '$t_month', '$t_day', '$nowdate', '$nowtime', '$t_show', '$t_status', '$t_memo');";

					
	$result1 = mysql_query($sql1);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_news.php?start=0\">";
	exit();
?>

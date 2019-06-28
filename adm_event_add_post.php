<?php

	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");

	$_POST = array_map('mysql_real_escape_string', $_POST);
	
	$h_admid = $_POST['h_admid'];
	$t_title_en = addslashes($_POST['t_title_en']);
	$t_title_jp = addslashes($_POST['t_title_jp']);
	$t_title_vn = addslashes($_POST['t_title_vn']);

	$t_detail_en = addslashes($_POST['t_detail_en']);
	$t_detail_jp = addslashes($_POST['t_detail_jp']);
	$t_detail_vn = addslashes($_POST['t_detail_vn']);

	$t_status = $_POST['t_status'];
	$t_new_id = $_POST['t_news'];

	$mediaFile = $_FILES['t_event_image'];

	/* Convert LineBreak character to string [br] */
	$t_title_en = str_replace('\\r\\n','[br]',stripcslashes($t_title_en));
	$t_detail_en = str_replace('\\r\\n','[br]',stripcslashes($t_detail_en));

	$t_title_jp = str_replace('\\r\\n','[br]',stripcslashes($t_title_jp));
	$t_detail_jp = str_replace('\\r\\n','[br]',stripcslashes($t_detail_jp));

	$t_title_vn = str_replace('\\r\\n','[br]',stripcslashes($t_title_vn));
	$t_detail_vn = str_replace('\\r\\n','[br]',stripcslashes($t_detail_vn));

	if ($_SESSION['vd'] != $h_admid) {

		echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">";
		exit();
	}
	
	$sqlAddEvent = "insert into flc_events (
	event_new_id,
	event_name_en,
	event_name_vn,
	event_name_jp,
	event_desc_en,
	event_desc_vn,
	event_desc_jp,
	status
	)
	values (
	'$t_new_id',
	'$t_title_en',
	'$t_title_vn',
	'$t_title_jp',
	'$t_detail_en',
	'$t_detail_vn',
	'$t_detail_jp',
	'$t_status'
	);";

	if (mysql_query($sqlAddEvent)) {

		$sqlGetEventId = "SELECT `id` FROM `flc_events` WHERE 1 ORDER BY id DESC LIMIT 1;";
		$rsGetEventId = mysql_query($sqlGetEventId);
		$dataEventId = mysql_fetch_array($rsGetEventId);

		$eventId = $dataEventId['id'];

		$mediaExt = getFileExtend($mediaFile, ['jpg', 'jpeg']);

		if (!$mediaExt) {
			exit("Please upload jpg file !");
		}

		$pathMedia = "images/events/ev-".$eventId.'.jpg';
		if (!move_uploaded_file($mediaFile['tmp_name'], $pathMedia)) {
			var_dump("Can not upload images");exit();
		}
	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_events.php?start=0\">";
	exit();
?>

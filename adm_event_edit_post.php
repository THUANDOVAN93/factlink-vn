<?php

	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");

	$_POST = array_map('mysql_real_escape_string', $_POST);
	
	$t_title_en = addslashes($_POST['t_title_en']);
	$t_title_jp = addslashes($_POST['t_title_jp']);
	$t_title_vn = addslashes($_POST['t_title_vn']);

	$t_detail_en = addslashes($_POST['t_detail_en']);
	$t_detail_jp = addslashes($_POST['t_detail_jp']);
	$t_detail_vn = addslashes($_POST['t_detail_vn']);

	$t_status = $_POST['t_status'];
	$t_new_id = $_POST['t_news'];
	$t_event_id = $_GET['id'];

	$mediaFile = $_FILES['t_event_image'];

	/* Convert LineBreak character to string [br] */
	$t_title_en = str_replace('\\r\\n','[br]',stripcslashes($t_title_en));
	$t_detail_en = str_replace('\\r\\n','[br]',stripcslashes($t_detail_en));

	$t_title_jp = str_replace('\\r\\n','[br]',stripcslashes($t_title_jp));
	$t_detail_jp = str_replace('\\r\\n','[br]',stripcslashes($t_detail_jp));

	$t_title_vn = str_replace('\\r\\n','[br]',stripcslashes($t_title_vn));
	$t_detail_vn = str_replace('\\r\\n','[br]',stripcslashes($t_detail_vn));

	$sqlEditEvent = "UPDATE `flc_events` SET
	`event_new_id` =  '$t_new_id',
	`event_name_en` = '$t_title_en',
	`event_name_vn` = '$t_title_vn',
	`event_name_jp` = '$t_title_jp',
	`event_desc_en` = '$t_detail_en',
	`event_desc_vn` = '$t_detail_vn',
	`event_desc_jp` = '$t_detail_jp',
	`status`= '$t_status'
	WHERE id = '$t_event_id';";

	if (mysql_query($sqlEditEvent)) {

		$mediaExt = getFileExtend($mediaFile, ['jpg', 'jpeg']);

		$pathMedia = "images/events/ev-".$t_event_id.'.jpg';
		move_uploaded_file($mediaFile['tmp_name'], $pathMedia);
	}

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_events.php?start=0\">";
	exit();
?>

<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_admid = $_POST['h_admid'];
	$h_intid = $_POST['h_intid'];
	$t_name_en = addslashes($_POST['t_name_en']);
	$t_name_jp = addslashes($_POST['t_name_jp']);
	$t_name_vn = addslashes($_POST['t_name_vn']);
	$t_title_en = addslashes($_POST['t_title_en']);
	$t_title_jp = addslashes($_POST['t_title_jp']);
	$t_title_vn = addslashes($_POST['t_title_vn']);
	$t_detail_en = addslashes($_POST['t_detail_en']);
	$t_detail_jp = addslashes($_POST['t_detail_jp']);
	$t_detail_vn = addslashes($_POST['t_detail_vn']);
	$t_link = $_POST['t_link'];
	$t_image = $_FILES['t_image'];
	$t_imagewidth = 160;
	$t_imagedisable = $_POST['t_imagedisable'];
	
	/* Convert LineBreak character to string [br] */
	$t_name_en = str_replace('\\\r\\\n','[br]',($t_name_en));
	$t_name_jp = str_replace('\\\r\\\n','[br]',($t_name_jp));
	$t_name_vn = str_replace('\\\r\\\n','[br]',($t_name_vn));
	$t_title_en = str_replace('\\\r\\\n','[br]',($t_title_en));
	$t_title_jp = str_replace('\\\r\\\n','[br]',($t_title_jp));
	$t_title_vn = str_replace('\\\r\\\n','[br]',($t_title_vn));
	$t_detail_en = str_replace('\\\r\\\n','[br]',($t_detail_en));
	$t_detail_jp = str_replace('\\\r\\\n','[br]',($t_detail_jp));
	$t_detail_vn = str_replace('\\\r\\\n','[br]',($t_detail_vn));
	$t_link = str_replace('\\\r\\\n','[br]',($t_link));

	if ($_SESSION['vd'] != $h_admid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql1 = "update flc_introduce set int_name_en = '$t_name_en', int_name_jp = '$t_name_jp', int_name_vn = '$t_name_vn',
					int_title_en = '$t_title_en', int_title_jp = '$t_title_jp', int_title_vn = '$t_title_vn',
					int_detail_en = '$t_detail_en', int_detail_jp = '$t_detail_jp', int_detail_vn = '$t_detail_vn', int_link = '$t_link',
					int_date = '$nowdate' where int_id = '$h_intid';";
	$result1 = mysql_query($sql1);

	if ($_FILES['t_image']['size'] > 0) {
		$t_imagedisable = "";
		$newfile = $h_intid."-T.jpg";
		$imgpath = "images/introduce/".$newfile;
		move_uploaded_file($_FILES['t_image']['tmp_name'], $imgpath);
		$imgdms = getimagesize($imgpath); if ($t_imagewidth == '') { $t_imagewidth = $imgdms[0]; }
		$sql4 = "update flc_introduce set int_image = 't' where int_id = '$h_intid';";
		$result4 = mysql_query($sql4);
	}

	if ($t_imagedisable == 't') { $sql5 = "update flc_introduce set int_image = '', int_image_width = '' where int_id = '$h_intid';"; }
	else { $sql5 = "update flc_introduce set int_image_width = '$t_imagewidth' where int_id = '$h_intid';"; }
	$result5 = mysql_query($sql5);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_introduce.php?start=0\">";
	exit();
?>

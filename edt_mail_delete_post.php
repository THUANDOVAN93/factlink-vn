<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_inrid = $_POST['h_inrid'];
	$h_pageid = $_POST['h_pageid'];
	$h_box = $_POST['h_box'];

	$sql1 = "update flc_mail set mal_status = 'd' where mal_id = '$h_inrid';";
	$result1 = mysql_query($sql1);

	if ($h_box == 'out') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_mail_outbox.php?start=$h_pageid\">";  }
	else { echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_mail_inbox.php?start=$h_pageid\">";  }

	exit();
?>

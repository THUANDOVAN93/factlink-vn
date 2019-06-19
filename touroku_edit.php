<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure.html"; 
	$url2 = "touroku_edit.html";
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	$pagecode = "reg";
	if ($_COOKIE['vlang'] == 'en') { $url6 = "menu_en.html"; } else if ($_COOKIE['vlang'] == 'vn') { $url6 = "menu_vn.html"; } else { $url6 = "menu_jp.html"; }
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "right_tpl" => $url3, "left_tpl" => $url4, "top_tpl" => $url5, "menu_tpl" => $url6));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	$memid = $_GET['id'];
	$code = $_GET['code'];
	
	$sql1 = "select * from flc_member where mem_id = '$memid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) { $memuser = $dbarr1['mem_user']; $memfolder = $dbarr1['mem_folder']; }
	
	if ($code == 'both') {
		
		if ($_COOKIE['vlang'] == 'en') { $codecheck = "Username and Path Name you created are already used by other account, or there are special characters included. Please create new one."; }
		else if ($_COOKIE['vlang'] == 'vn') { $codecheck = "Username and Path Name you created are already used by other account, or there are special characters included. Please create new one.่"; }
		else { $codecheck = "ユーザー名、ご希望名は他のユーザーによりすでに使用されているか、または特殊な文字が含まれている可能性があるのでご使用できません。新しいユーザー名を作成してください。"; }
		
		$value_memuser = ""; $value_memfolder = "";
	
	} else if ($code == 'user') {
		
		if ($_COOKIE['vlang'] == 'en') { $codecheck = "Username you created is already used by other account, or there are special characters included. Please create new one."; }
		else if ($_COOKIE['vlang'] == 'vn') { $codecheck = "Username you created is already used by other account, or there are special characters included. Please create new one."; }
		else { $codecheck = "ご希望のユーザー名は既に使用されているか、不正な文字が含まれています。再度ご入力ください。"; }
		
		$pathdisable = "disabled";
		$value_memuser = ""; $value_memfolder = $memfolder;
	
	} else if ($code == 'path') {
	
		if ($_COOKIE['vlang'] == 'en') { $codecheck = "Path Name you created is already used by other account, or there are special characters included. Please create new one."; }
		else if ($_COOKIE['vlang'] == 'vn') { $codecheck = "Path Name you created is already used by other account, or there are special characters included. Please create new one."; }
		else { $codecheck = "ご希望名は他のユーザーによりすでに使用されているか、または特殊な文字が含まれている可能性があるのでご使用できません。新しいユーザー名を作成してください。"; }
		
		$userdisable = "disabled";
		$value_memuser = $memuser; $value_memfolder = "";
	
	} else { echo "<meta http-equiv = \"refresh\" content = \"0;URL = touroku.php\">"; exit(); }
	
	
	// Random security number
	$random = random(0);
	$confirmcode = $random[1].$random[2].$random[3].$random[4];
	
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##code##", $code); 
	$tpl->assign("##codecheck##", $codecheck);
	$tpl->assign("##value_memuser##", $value_memuser);
	$tpl->assign("##value_memfolder##", $value_memfolder);
	$tpl->assign("##userdisable##", $userdisable);
	$tpl->assign("##pathdisable##", $pathdisable);
	$tpl->assign("##confirmcode##", $confirmcode);
	$tpl->assign("##randomnum##", $random[0]);
	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
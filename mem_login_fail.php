<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure.html"; 
	$url2 = "mem_login_fail.html";
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	$pagecode = "ctt";
	if ($_COOKIE['vlang'] == 'en') { $url6 = "menu_en.html"; } else if ($_COOKIE['vlang'] == 'vn') { $url6 = "menu_vn.html"; } else { $url6 = "menu_jp.html"; }
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "right_tpl" => $url3, "left_tpl" => $url4, "top_tpl" => $url5, "menu_tpl" => $url6));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	if ($_COOKIE['vlang'] == 'en') { 
		$failtext_1 = "Username and/or Password incorrect."; 
		$failtext_2 = "Please check your username and password then login again. If you cannot login after trying <br />several times, please contact Fact-Link. <a href=\"contact.php\">Go to contact form, click here.</a>";
	} else if ($_COOKIE['vlang'] == 'vn') { 
		$failtext_1 = "Username and/or Password incorrect."; 
		$failtext_2 = "Please check your username and password then login again. If you cannot login after trying <br />several times, please contact Fact-Link. <a href=\"contact.php\">Go to contact form, click here.</a>";
	} else { 
		$failtext_1 = "ユーザー名、パスワードが違います。"; 
		$failtext_2 = "再度、ユーザー名、パスワードをご確認の上、ご入力ください。<br />何度かお試しを頂いてもログイン出来ない場合、<br />
		「お問い合わせフォーム」からお問い合わせください。<a href=\"contact.php\">こちらをクリック。</a>"; 
	}
	
	$failtext = "<h2 class=\"form_margin\"><img src=\"images/icon_delete_01.png\" width=\"20\" height=\"20\" align=\"absmiddle\" /> <span class=\"red_n\">".$failtext_1."</span></h2><br />".$failtext_2;
	
	$tpl->assign("##failtext##", $failtext);
	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
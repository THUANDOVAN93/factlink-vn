<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure.html"; 
	$url2 = "qform_done.html";
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	$pagecode = "ctt";
	if ($_COOKIE['lang'] == 'en') { $url6 = "menu_en.html"; } else if ($_COOKIE['lang'] == 'th') { $url6 = "menu_th.html"; } else { $url6 = "menu_jp.html"; }
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "right_tpl" => $url3, "left_tpl" => $url4, "top_tpl" => $url5, "menu_tpl" => $url6));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	if ($_COOKIE['lang'] == 'en') { $fintext = "<span class=\"red_b\">Submitted.</span><br />We need to confirm the information with the registration.<br />Please wait for a while, we will contact you as soon as possible. Sorry for inconvenience."; }
	else if ($_COOKIE['lang'] == 'th') { $fintext = "<span class=\"red_b\">รับข้อมูลเรียบร้อยแล้ว</span><br />เจ้าหน้าที่ Fact-Link จำเป็นต้องตรวจสอบความถูกต้องของข้อมูลกับข้อมูลลงทะเบียน และจะติดต่อกลับไปให้เร็วที่สุด<br />ขออภัยในความไม่สะดวก"; }
	else { $fintext = "<span class=\"red_b\">完了しました。</span><br />ファクトリンク事務局から登録内容をご確認の上、ご連絡致しますので少々お待ちください。<br />お手数をお掛けしましてすみませんが、何卒よろしくお願いします。"; }
	
	$tpl->assign("##fintext##", $fintext);
	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
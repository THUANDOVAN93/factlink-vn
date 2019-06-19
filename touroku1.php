<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
// ======================================================================================

	$pagecode = "reg"; 
	
	$lang = $_GET['lang']; 
	
	if ($_SESSION['utp'] == 'mem' && $_SESSION['uid'] != '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error_login.php?lang=$lang&code=6\">"; exit(); } /*error  : already login, cannot register while logged in */ 
	
	if ($lang == '') { $lang = $_COOKIE['lang']; echo "<meta http-equiv = \"refresh\" content = \"0;URL = touroku1.php?lang=$lang\">"; exit(); }
	setcookie("lang", $lang, $cookieexpire);
	
	if ($lang == $langlocal) { $lang = "lc"; }
	if ($lang != 'jp' && $lang != 'lc' && $lang != 'en') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error_404.html\">"; exit(); }
	
// ======================================================================================
	
	$url1 = "main_structure.html"; 
	$url2 = "main_touroku1.html";
	$url3 = "main_rightpanel.html";
	$url4 = "main_leftpanel.html";
	$url5 = "main_toppanel.html";
	$url6 = "main_searchpanel.html";
	if ($_SESSION['uid'] != '') { $url7 = "main_userpanel.html"; } else { $url7 = "main_loginform.html"; }
	if ($lang == 'en') { $url8 = "main_menu_en.html"; $url9 = "main_touroku1_en.html"; } else if ($lang == 'lc') { $url8 = "main_menu_lc.html"; $url9 = "main_touroku1_lc.html"; } else { $url8 = "main_menu_jp.html"; $url9 = "main_touroku1_jp.html"; }
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "right_tpl" => $url3, "left_tpl" => $url4, "top_tpl" => $url5, "searchpanel_tpl" => $url6, "mempanel_tpl" => $url7, "menu_tpl" => $url8, "desc_tpl" => $url9));
	
// ======================================================================================
	
	mysql_query("use $db_name;");

// ======================================================================================

	// Global Section Include
	if ($lang == 'en') { include_once("./include/global_text_en.php"); } else if ($lang == 'lc') { include_once("./include/global_text_lc.php"); } else { include_once("./include/global_text_jp.php"); }
	include_once("./include/global_user.php");
	include_once("./include/global_mainsite.php");
		
// ======================================================================================
	

	
// ======================================================================================
// PRIMARY CATEGORY SELECT
// ======================================================================================
	
	$result1 = mysql_query("select * from fl_category_group order by ctg_order asc;");
	while ($dbarr1 = mysql_fetch_array($result1)) { 
		
			$regcatelist = $regcatelist."<optgroup label=\"".$dbarr1[$ctgnamebylang]."\">"; 
				
			$result2 = mysql_query("select * from fl_category where ctg_id = '".$dbarr1['ctg_id']."' order by ctr_order asc;");
			while ($dbarr2 = mysql_fetch_array($result2)) { 
			
					$regcatelist = $regcatelist."<option value=\"".$dbarr2['ctr_id']."\">".$dbarr2[$ctrnamebylang]."</option>";
			
			}
			
			$regcatelist = $regcatelist."</optgroup>";
			
	}
	
	
// ======================================================================================
// RANDOM CAPTCHA
// ======================================================================================
	
	$randomcc = randomcaptcha();
	$randomccmd5 = md5($randomcc);
	
	$cccreate = fopen("images/confirmcode/ccimage.php", "w");
	
	$cccode = "<?php
	header('Content-Type: image/png');
	\$rancode = str_split('$randomcc');
	\$ranbg = rand(1, 5); 
	\$dest = imagecreatefrompng('bg_'.\$ranbg.'.png');
	\$startpoint = \"1\".\$rancode[0].\$rancode[1];
	for (\$i=0;\$i<=3;\$i++) {
		\$ranno = rand(1, 2);
		\$src = imagecreatefrompng('no_'.\$ranno.'_'.\$rancode[\$i].'.png'); 
		imagecopy(\$dest, \$src, \$startpoint, 5, 0, 0, 20, 20); 
		\$startpoint = \$startpoint + 20;
	}
	imagepng(\$dest);
	imagedestroy(\$src);
	?>";
	
	fwrite($cccreate, $cccode);
	fclose($cccreate);
	
// ======================================================================================
	
	mysql_close($link);
	
// ======================================================================================
	
	$tpl->assign("##regcatelist##", $regcatelist);
	$tpl->assign("##randomccmd5##", $randomccmd5);
	$tpl->assign("##localurl##", $localurl);
	
	$tpl->assign("##lang##", lclangswitch($lang, $langlocal));
	$tpl->assign("##setlangjp##", "touroku1.php?lang=jp");
	$tpl->assign("##setlanglc##", "touroku1.php?lang=$langlocal");
	$tpl->assign("##setlangen##", "touroku1.php?lang=en");
	$tpl->assign("##langlabeljp##", $langlabel_jp);
	$tpl->assign("##langlabellc##", $langlabel_lc);
	$tpl->assign("##langlabelen##", $langlabel_en);
	$tpl->assign("##text_titlebar##", $txtb_index);
	$tpl->assign("##text_keyword##", $txkw_index);
	$tpl->assign("##text_description##", $txdc_index);
	
// ======================================================================================
	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##SEARCHPANEL_AREA##", "searchpanel_tpl");
	$tpl->parse ("##MEMPANEL_AREA##", "mempanel_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("##DESC_AREA##", "desc_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "edt_structure.html"; 
	$url2 = "edt_page_column_add.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_SESSION['vmd'];
	$pagid = $_GET['page'];
	$langcode = $_GET['lang'];
	
	if ($langcode != 'en' && $langcode != 'jp' && $langcode != 'vn') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=4\">"; exit(); }
	
	$checkpackage = checkfreemem($memid);
	if ($checkpackage == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=5\">"; exit(); }
	
	// --- Global Template Section	
	include_once("./include/global_edtvalue.php");
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vmd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	// --------------------
	
	$sql0 = "select * from flc_page where mem_id = '$memid' and pag_type = 'prf';"; 
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) { 
		$prfshowen = $dbarr0['pag_show_en']; 
		$prfshowvn = $dbarr0['pag_show_vn']; 
		$prfshowjp = $dbarr0['pag_show_jp']; 
	}
	
	if ($langcode == 'en') { if ($prfshowen != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=3\">"; exit(); } }
	if ($langcode == 'vn') { if ($prfshowvn != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=3\">"; exit(); } }
	if ($langcode == 'jp') { if ($prfshowjp != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=3\">"; exit(); } }
	
	$sql1 = "select * from flc_page where pag_id = '$pagid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) { 
		$pagnameen = $dbarr1['pag_name_en']; 
		$pagnamejp = $dbarr1['pag_name_jp']; 
		$pagnamevn = $dbarr1['pag_name_vn'];
		$pagshowen = $dbarr1['pag_show_en']; 
		$pagshowvn = $dbarr1['pag_show_vn']; 
		$pagshowjp = $dbarr1['pag_show_jp']; 
	}
	
	$sql2 = "select * from flc_content where pag_id = '$pagid' order by con_sort asc;"; 
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
		
		if ($langcode == 'en') { $contitle = $dbarr2['con_title_en']; }
		else if ($langcode == 'vn') { $contitle = $dbarr2['con_title_vn']; }
		else { $contitle = $dbarr2['con_title_jp']; }
		$conid = $dbarr2['con_id']; 
		$consort = $dbarr2['con_sort']; 
		$constatus = $dbarr2['con_status']; 
		
		if ($constatus != 'd') { $constatus = "<a href=\"edt_con_set_disable.php?page=".$pagid."&lang=".$langcode."&con=".$conid."\"><img src=\"images/icon_enable_01.png\" alt=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
		else { $constatus = "<a href=\"edt_con_set_enable.php?page=".$pagid."&lang=".$langcode."&con=".$conid."\"><img src=\"images/icon_disable_01.png\" alt=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
		
		if ($pagshowen == 't') { 
			$iconviewen = "<a href=\"mem_content.php?id=".$memid."&page=".$pagid."&lang=en\" target=\"_blank\"><img src=\"images/icon_view_01.png\" alt=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconediten = "<a href=\"edt_page_column_edit.php?con=".$conid."&lang=en\"><img src=\"images/icon_edit_01.png\" alt=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		} else { 
			$iconviewen = "<img src=\"images/icon_view_02.png\" alt=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" />"; 
			$iconediten = "<img src=\"images/icon_edit_02.png\" alt=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" />";
		}
		
		if ($pagshowvn == 't') { 
			$iconviewvn = "<a href=\"mem_content.php?id=".$memid."&page=".$pagid."&lang=vn\" target=\"_blank\"><img src=\"images/icon_view_01.png\" alt=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconeditvn = "<a href=\"edt_page_column_edit.php?con=".$conid."&lang=vn\"><img src=\"images/icon_edit_01.png\" alt=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		} else { 
			$iconviewvn = "<img src=\"images/icon_view_02.png\" alt=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" />"; 
			$iconeditvn = "<img src=\"images/icon_edit_02.png\" alt=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" />";
		}
		
		if ($pagshowjp == 't') { 
			$iconviewjp = "<a href=\"mem_content.php?id=".$memid."&page=".$pagid."&lang=jp\" target=\"_blank\"><img src=\"images/icon_view_01.png\" alt=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconeditjp = "<a href=\"edt_page_column_edit.php?con=".$conid."&lang=jp\"><img src=\"images/icon_edit_01.png\" alt=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		} else { 
			$iconviewjp = "<img src=\"images/icon_view_02.png\" alt=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" />"; 
			$iconeditjp = "<img src=\"images/icon_edit_02.png\" alt=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" />";
		}
		
		$collist = $collist."<tr>
            <td>".$constatus."</td>
			<td>".$consort."</td>
            <td>".subhtml($contitle)."</td>
            <td><div align=\"center\">".$iconeditjp."</div></td>
			<td><div align=\"center\">".$iconeditvn."</div></td>
			<td><div align=\"center\">".$iconediten."</div></td>
			<td><div align=\"center\"><a href=\"edt_page_column_delete.php?con=".$conid."&lang=".$langcode."\"><img src=\"images/icon_delete_01.png\" alt=\"".$lb_alt_delete."\" width=\"20\" height=\"20\" border=\"0\" /></a></div></td>
          </tr>
		  <tr>
            <td colspan=\"7\"><img src=\"images/line_frame_08.png\" width=\"740\" height=\"10\" /></td>
            </tr>";
	
	}
	
	$sqlptc = "select * from flc_pattern_content order by ptc_name_en asc;"; 
	$resultptc = mysql_query($sqlptc);
	while ($dbarrptc = mysql_fetch_array($resultptc)) {
	
		$ptcid = $dbarrptc['ptc_id'];
		$ptcname = $dbarrptc['ptc_name_en']; 
		if ($ptcid == '1') { $ptcselected = "selected"; } else { $ptcselected = ""; }
		
		$tpl->assign("##ptcid##", $ptcid);
		$tpl->assign("##ptcname##", $ptcname);
		$tpl->assign("##ptcselected##", $ptcselected);
		$tpl->parse ("#####ROW#####", '.rows_ptc');
		
	}
	
	$sqlclf = "select * from flc_color_font order by clf_name_en asc;"; 
	$resultclf = mysql_query($sqlclf);
	while ($dbarrclf = mysql_fetch_array($resultclf)) {
	
		$clfid = $dbarrclf['clf_id'];
		$clfname = $dbarrclf['clf_name_en']; 
		$clfcode = $dbarrclf['clf_code']; 
		if ($clfid == $defaultclfid) { $clfselected = "selected"; } else { $clfselected = ""; }
		
		$tpl->assign("##clfid##", $clfid);
		$tpl->assign("##clfname##", $clfname);
		$tpl->assign("##clfcode##", $clfcode);
		$tpl->assign("##clfselected##", $clfselected);
		$tpl->parse ("#####ROW#####", '.rows_clf');
		
	}
	
	if ($langcode == 'en') { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "English Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Anh"; } else { $langcodefull = "英語のページ"; }
		$pagname = $pagnameen;
	
	} else if ($langcode == 'vn') { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Vietnamese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Việt"; } else { $langcodefull = "ベトナム語のページ"; }
		$pagname = $pagnamevn;
		
	} else { 
	
		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Japanese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Nhật"; } else { $langcodefull = "日本語のページ"; }
		$pagname = $pagnamejp;
		
	}
	
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##pagid##", $pagid);
	$tpl->assign("##langcode##", $langcode);
	$tpl->assign("##langcodefull##", $langcodefull);
	$tpl->assign("##pagname##", subhtml($pagname));
	$tpl->assign("##viewen##", $iconviewen);
	$tpl->assign("##viewjp##", $iconviewjp);
	$tpl->assign("##viewvn##", $iconviewvn);
	$tpl->assign("##collist##", $collist);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
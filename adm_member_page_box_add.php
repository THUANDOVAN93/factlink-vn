<?php
	ini_set("session.gc_maxlifetime", "18000");
	session_start();

	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }

	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	// Escape special charactars
	$_GET = array_map('mysql_real_escape_string',$_GET);

	$url1 = "adm_structure.html";
	$url2 = "adm_member_page_box_add.html";

	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));

	mysql_query("use $db_name;");

	$memid = $_GET['id'];
	$pagid = $_GET['page'];
	$langcode = $_GET['lang'];

	if ($langcode != 'en' && $langcode != 'jp' && $langcode != 'vn') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=4\">"; exit(); }

	$checkpackage = checkfreemem($memid);
	if ($checkpackage == '') { $freemem = "t"; } else { $freemem = ""; }

	// --- Global Template Section
	include_once("./include/global_edtvalue.php");

	// --- Check Use Log

	$currentuserid = $_SESSION['vd'];

	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';";
	$resultusl1 = mysql_query($sqlusl1);

	// --------------------

	$sql0 = "select * from flc_member where mem_id = '$memid';";
	$result0 = mysql_query($sql0);
	while ($dbarr0 = mysql_fetch_array($result0)) {

		if ($_COOKIE['vlang'] == 'en') { $memcomname = $dbarr0['mem_comname_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $memcomname = $dbarr0['mem_comname_vn']; }
		else { $memcomname = $dbarr0['mem_comname_jp']; }

	}

	$sql3 = "select * from flc_page where mem_id = '$memid' and pag_type = 'prf';";
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) {
		$prfshowen = $dbarr3['pag_show_en'];
		$prfshowvn = $dbarr3['pag_show_vn'];
		$prfshowjp = $dbarr3['pag_show_jp'];
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

	$sql2 = "select * from flc_present_box where pag_id = '$pagid' order by box_sort asc;";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {

		$boxid = $dbarr2['box_id'];
		$boxsort = $dbarr2['box_sort'];
		$boxstatus = $dbarr2['box_status'];

		if ($boxstatus != 'd') { $boxstatus = "<a href=\"edt_box_set_disable.php?page=".$pagid."&lang=".$langcode."&box=".$boxid."\"><img src=\"images/icon_enable_01.png\" alt=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
		else { $boxstatus = "<a href=\"edt_box_set_enable.php?page=".$pagid."&lang=".$langcode."&box=".$boxid."\"><img src=\"images/icon_disable_01.png\" alt=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }

		if ($pagshowen == 't') {
			$iconviewen = "<a href=\"mem_present.php?id=".$memid."&page=".$pagid."&lang=en\" target=\"_blank\"><img src=\"images/icon_view_01.png\" alt=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
			$iconediten = "<a href=\"adm_member_page_box_edit.php?id=".$memid."&box=".$boxid."&lang=en\"><img src=\"images/icon_edit_01.png\" alt=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		} else {
			$iconviewen = "<img src=\"images/icon_view_02.png\" alt=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" />";
			$iconediten = "<img src=\"images/icon_edit_02.png\" alt=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" />";
		}

		if ($pagshowvn == 't') {
			$iconviewvn = "<a href=\"mem_present.php?id=".$memid."&page=".$pagid."&lang=vn\" target=\"_blank\"><img src=\"images/icon_view_01.png\" alt=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
			$iconeditvn = "<a href=\"adm_member_page_box_edit.php?id=".$memid."&box=".$boxid."&lang=vn\"><img src=\"images/icon_edit_01.png\" alt=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		} else {
			$iconviewvn = "<img src=\"images/icon_view_02.png\" alt=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" />";
			$iconeditvn = "<img src=\"images/icon_edit_02.png\" alt=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" />";
		}

		if ($pagshowjp == 't') {
			$iconviewjp = "<a href=\"mem_present.php?id=".$memid."&page=".$pagid."&lang=jp\" target=\"_blank\"><img src=\"images/icon_view_01.png\" alt=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
			$iconeditjp = "<a href=\"adm_member_page_box_edit.php?id=".$memid."&box=".$boxid."&lang=jp\"><img src=\"images/icon_edit_01.png\" alt=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		} else {
			$iconviewjp = "<img src=\"images/icon_view_02.png\" alt=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" />";
			$iconeditjp = "<img src=\"images/icon_edit_02.png\" alt=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" />";
		}

		$boxlist = $boxlist."<tr>
            <td>".$boxstatus."</td>
            <td>".$boxsort."</td>
            <td><div align=\"center\">".$iconeditjp."</div></td>
			<td><div align=\"center\">".$iconeditvn."</div></td>
			<td><div align=\"center\">".$iconediten."</div></td>
			<td><div align=\"center\"><a href=\"adm_member_page_box_delete.php?id=".$memid."&box=".$boxid."&lang=".$langcode."\"><img src=\"images/icon_delete_01.png\" alt=\"".$lb_alt_delete."\" width=\"20\" height=\"20\" border=\"0\" /></a></div></td>
          </tr>
		  <tr>
            <td colspan=\"6\"><img src=\"images/line_frame_08.png\" width=\"740\" height=\"10\" /></td>
            </tr>";

	}

	/*$sqlptc = "select * from flc_pattern_content order by ptc_name_en asc;";
	$resultptc = mysql_query($sqlptc);
	while ($dbarrptc = mysql_fetch_array($resultptc)) {

		$ptcid = $dbarrptc['ptc_id'];
		$ptcname = $dbarrptc['ptc_name_en'];
		if ($ptcid == '1') { $ptcselected = "selected"; } else { $ptcselected = ""; }

		$tpl->assign("##ptcid##", $ptcid);
		$tpl->assign("##ptcname##", $ptcname);
		$tpl->assign("##ptcselected##", $ptcselected);
		$tpl->parse ("#####ROW#####", '.rows_ptc');

	}*/

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

	} else if ($langcode == 'vn') {

		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Vietnamese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Việt"; } else { $langcodefull = "ベトナム語のページ"; }

	} else {

		if ($_COOKIE['vlang'] == 'en') { $langcodefull = "Japanese Page"; } else if ($_COOKIE['vlang'] == 'vn') { $langcodefull = "Trang tiếng Nhật"; } else { $langcodefull = "日本語のページ"; }

	}

	$tpl->assign("##freemem##", $freemem);
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##memcomname##", $memcomname);
	$tpl->assign("##pagid##", $pagid);
	$tpl->assign("##langcode##", $langcode);
	$tpl->assign("##langcodefull##", $langcodefull);
	$tpl->assign("##pagname##", $pagname);
	$tpl->assign("##viewen##", $iconviewen);
	$tpl->assign("##viewjp##", $iconviewjp);
	$tpl->assign("##viewvn##", $iconviewvn);
	$tpl->assign("##boxlist##", $boxlist);

	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>

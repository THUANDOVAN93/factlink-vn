<?php 

	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if($_SESSION['vp'] != 'exe') {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">";
		exit();
	}
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "adm_structure.html"; 
	$url2 = "adm_member_page.html";
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_GET['id'];
	
	// --- Global Template Section	
	include_once("./include/global_admvalue.php");
	
	
	
	// --- Check Use Log
	
	$currentuserid = $_SESSION['vd'];
	
	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';"; 
	$resultusl1 = mysql_query($sqlusl1);
	
	
	
	
	// --------------------
	
	$sql1 = "select * from flc_member where mem_id = '$memid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) { 
	
		if ($_COOKIE['vlang'] == 'en') { $memcomname = $dbarr1['mem_comname_en']; }
		else if ($_COOKIE['vlang'] == 'vn') { $memcomname = $dbarr1['mem_comname_vn']; }
		else { $memcomname = $dbarr1['mem_comname_jp']; }
		
	}
	
	// Profile row
	
	$sql2 = "select * from flc_page where mem_id = '$memid' and pag_type = 'prf';"; 
	$result2 = mysql_query($sql2);
	$cntprf = mysql_num_rows($result2);
	
	if ($cntprf > 0) {
	
		$prfnew_jp = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />";
		$prfnew_vn = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />";
		$prfnew_en = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />";
		
		while ($dbarr2 = mysql_fetch_array($result2)) {
		
			if ($_COOKIE['vlang'] == 'en') {
				$pagname = $dbarr2['pag_name_en'];
			} else if ($_COOKIE['vlang'] == 'vn') {
				$pagname = $dbarr2['pag_name_vn'];
			} else {
				$pagname = $dbarr2['pag_name_jp'];
			}
			
			$pagid = $dbarr2['pag_id'];
			$pagshowen = $dbarr2['pag_show_en']; 
			$pagshowvn = $dbarr2['pag_show_vn']; 
			$pagshowjp = $dbarr2['pag_show_jp']; 
			
		}
		
		$pagstatus = "<img src=\"images/icon_enable_01.png\" width=\"20\" height=\"20\" />"; 
		
		if ($pagshowen == 't') { 
			$prf_en = "t";
			$iconviewen = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=en\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconediten = "<a href=\"adm_member_page_profile_edit.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpanden = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		} else {
			$iconviewen = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			$iconediten = "<a href=\"adm_member_page_profile_edit.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpanden = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		if ($pagshowvn == 't') { 
			$prf_vn = "t";
			$iconviewvn = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=vn\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconeditvn = "<a href=\"adm_member_page_profile_edit.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpandvn = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		} else { 
			$iconviewvn = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			$iconeditvn = "<a href=\"adm_member_page_profile_edit.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpandvn = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		if ($pagshowjp == 't') { 
			$prf_jp = "t";
			$iconviewjp = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=jp\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconeditjp = "<a href=\"adm_member_page_profile_edit.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpandjp = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		} else { 
			$iconviewjp = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			$iconeditjp = "<a href=\"adm_member_page_profile_edit.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpandjp = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		$prflist = "<tr>
            <td colspan=\"5\"><img src=\"images/line_frame_08.png\" width=\"740\" height=\"10\" /></td>
            </tr>
			<tr>
            <td>".$pagstatus."</td>
            <td>".subhtml($pagname)."</td>
            <td><div align=\"center\">".$iconviewjp."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconeditjp."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpandjp."</div></td>
			<td><div align=\"center\">".$iconviewvn."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconeditvn."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpandvn."</div></td>
			<td><div align=\"center\">".$iconviewen."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconediten."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpanden."</div></td>
          </tr>";
	
	} else {
	
		$prfnew_jp = "<a href=\"adm_member_page_profile_add.php?id=".$memid."&lang=jp\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>";
		$prfnew_vn = "<a href=\"adm_member_page_profile_add.php?id=".$memid."&lang=vn\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>";
		$prfnew_en = "<a href=\"adm_member_page_profile_add.php?id=".$memid."&lang=en\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>";
	
	}
	
	
	
	/*  */
	call_user_func(function(){
		
		// echo "<h1>Test</h1>";
		// $query = 'SELECT * FROM `flc_page` WHERE `mem_id` = 00045478';
		// $query = mysql_query($query);
		// while($fetch = mysql_fetch_assoc($query)){
			// echo "<pre>".print_r($fetch,true)."</pre>";
		// }
		// exit;
		
	});
	
	
	// Home row
	
	$sql3 = "select * from flc_page where mem_id = '$memid' and pag_type = 'hom';"; 
	$result3 = mysql_query($sql3);
	$cnthom = mysql_num_rows($result3);
	
	if ($cnthom > 0) {
	
		$homnew_jp = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />";
		$homnew_vn = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />";
		$homnew_en = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />";
		
		while ($dbarr3 = mysql_fetch_array($result3)) {
		
			if ($_COOKIE['vlang'] == 'en') { $pagname = $dbarr3['pag_name_en']; }
			else if ($_COOKIE['vlang'] == 'vn') { $pagname = $dbarr3['pag_name_vn']; }
			else { $pagname = $dbarr3['pag_name_jp']; }
			$pagid = $dbarr3['pag_id'];
			$pagstatus = $dbarr3['pag_status'];
			$pagshowen = $dbarr3['pag_show_en']; 
			$pagshowvn = $dbarr3['pag_show_vn']; 
			$pagshowjp = $dbarr3['pag_show_jp']; 
		
		}
		
		if ($pagstatus != 'd') {
			$pagstatus = "<a href=\"edt_page_set_disable.php?id=".$memid."&page=".$pagid."\"><img src=\"images/icon_enable_01.png\" title=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		} else {
			$pagstatus = "<a href=\"edt_page_set_enable.php?id=".$memid."&page=".$pagid."\"><img src=\"images/icon_disable_01.png\" title=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		}
		
		if ($pagshowen == 't') { 
			$iconviewen = "<a href=\"mem_home.php?id=".$memid."&page=".$pagid."&lang=en\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconediten = "<a href=\"adm_member_page_home_edit.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpanden = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		} else { 
			$iconviewen = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			if ($prf_en == 't') {
				$iconediten = "<a href=\"adm_member_page_home_edit.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
			} else {
				$iconediten = "<img src=\"images/icon_edit_02.png\" width=\"20\" height=\"20\" border=\"0\" />";
			}
			$iconexpanden = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		if ($pagshowvn == 't') { 
			$iconviewvn = "<a href=\"mem_home.php?id=".$memid."&page=".$pagid."&lang=vn\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconeditvn = "<a href=\"adm_member_page_home_edit.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpandvn = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		} else { 
			$iconviewvn = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			if ($prf_vn == 't') { $iconeditvn = "<a href=\"adm_member_page_home_edit.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $iconeditvn = "<img src=\"images/icon_edit_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; }
			$iconexpandvn = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		if ($pagshowjp == 't') { 
			$iconviewjp = "<a href=\"mem_home.php?id=".$memid."&page=".$pagid."&lang=jp\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconeditjp = "<a href=\"adm_member_page_home_edit.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpandjp = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		} else { 
			$iconviewjp = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			if ($prf_jp == 't') { $iconeditjp= "<a href=\"adm_member_page_home_edit.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $iconeditjp = "<img src=\"images/icon_edit_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; }
			$iconexpandjp = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		$homlist = "<tr>
            <td colspan=\"5\"><img src=\"images/line_frame_08.png\" width=\"740\" height=\"10\" /></td>
            </tr>
			<tr>
            <td>".$pagstatus."</td>
            <td>".subhtml($pagname)."</td>
            <td><div align=\"center\">".$iconviewjp."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconeditjp."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpandjp."</div></td>
			<td><div align=\"center\">".$iconviewvn."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconeditvn."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpandvn."</div></td>
			<td><div align=\"center\">".$iconviewen."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconediten."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpanden."</div></td>
          </tr>";
	
	} else {
	
		if ($prf_jp == 't') { $homnew_jp = "<a href=\"adm_member_page_home_add.php?id=".$memid."&lang=jp\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>"; }
		else { $homnew_jp = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />"; }
		if ($prf_vn == 't') { $homnew_vn = "<a href=\"adm_member_page_home_add.php?id=".$memid."&lang=vn\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>"; }
		else { $homnew_vn = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />"; }
		if ($prf_en == 't') { $homnew_en = "<a href=\"adm_member_page_home_add.php?id=".$memid."&lang=en\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>"; }
		else { $homnew_en = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />"; }
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// Inquiry row
	
	$sql4 = "select * from flc_page where mem_id = '$memid' and pag_type = 'inq';"; 
	$result4 = mysql_query($sql4);
	$cntinq = mysql_num_rows($result4);
	
	if ($cntinq > 0) {
	
		$inqnew_jp = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />";
		$inqnew_vn = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />";
		$inqnew_en = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />";
		
		while ($dbarr4 = mysql_fetch_array($result4)) {
		
			if ($_COOKIE['vlang'] == 'en') { $pagname = $dbarr4['pag_name_en']; }
			else if ($_COOKIE['vlang'] == 'vn') { $pagname = $dbarr4['pag_name_vn']; }
			else { $pagname = $dbarr4['pag_name_jp']; }
			$pagid = $dbarr4['pag_id'];
			$pagstatus = $dbarr4['pag_status'];
			$pagshowen = $dbarr4['pag_show_en']; 
			$pagshowvn = $dbarr4['pag_show_vn']; 
			$pagshowjp = $dbarr4['pag_show_jp']; 
		
		}
		
		if ($pagstatus != 'd') { $pagstatus = "<a href=\"edt_page_set_disable.php?id=".$memid."&page=".$pagid."\"><img src=\"images/icon_enable_01.png\" title=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
		else { $pagstatus = "<a href=\"edt_page_set_enable.php?id=".$memid."&page=".$pagid."\"><img src=\"images/icon_disable_01.png\" title=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
		
		if ($pagshowen == 't') { 
			$iconviewen = "<a href=\"mem_inquiry.php?id=".$memid."&page=".$pagid."&lang=en\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconediten = "<a href=\"adm_member_page_inquiry_edit.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpanden = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		} else { 
			$iconviewen = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			if ($prf_en == 't') { $iconediten = "<a href=\"adm_member_page_inquiry_edit.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $iconediten = "<img src=\"images/icon_edit_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; }
			$iconexpanden = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		if ($pagshowvn == 't') { 
			$iconviewvn = "<a href=\"mem_inquiry.php?id=".$memid."&page=".$pagid."&lang=vn\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconeditvn = "<a href=\"adm_member_page_inquiry_edit.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpandvn = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		} else { 
			$iconviewvn = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			if ($prf_vn == 't') { $iconeditvn = "<a href=\"adm_member_page_inquiry_edit.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $iconeditvn = "<img src=\"images/icon_edit_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; }
			$iconexpandvn = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		if ($pagshowjp == 't') { 
			$iconviewjp = "<a href=\"mem_inquiry.php?id=".$memid."&page=".$pagid."&lang=jp\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconeditjp = "<a href=\"adm_member_page_inquiry_edit.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpandjp = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		} else { 
			$iconviewjp = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			if ($prf_jp == 't') { $iconeditjp= "<a href=\"adm_member_page_inquiry_edit.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $iconeditjp = "<img src=\"images/icon_edit_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; }
			$iconexpandjp = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		$inqlist = "<tr>
            <td colspan=\"5\"><img src=\"images/line_frame_08.png\" width=\"740\" height=\"10\" /></td>
            </tr>
			<tr>
            <td>".$pagstatus."</td>
            <td>".subhtml($pagname)."</td>
            <td><div align=\"center\">".$iconviewjp."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconeditjp."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpandjp."</div></td>
			<td><div align=\"center\">".$iconviewvn."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconeditvn."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpandvn."</div></td>
			<td><div align=\"center\">".$iconviewen."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconediten."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpanden."</div></td>
          </tr>";
	
	} else {
	
		if ($prf_jp == 't') { $inqnew_jp = "<a href=\"adm_member_page_inquiry_add.php?id=".$memid."&lang=jp\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>"; }
		else { $inqnew_jp = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />"; }
		if ($prf_vn == 't') { $inqnew_vn = "<a href=\"adm_member_page_inquiry_add.php?id=".$memid."&lang=vn\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>"; }
		else { $inqnew_vn = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />"; }
		if ($prf_en == 't') { $inqnew_en = "<a href=\"adm_member_page_inquiry_add.php?id=".$memid."&lang=en\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>"; }
		else { $inqnew_en = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />"; }
		
	}
	
	
	
	// Content row
	
	$sql5 = "select * from flc_page where mem_id = '$memid' and pag_type = 'con' order by pag_sort asc;"; 
	$result5 = mysql_query($sql5);
	$cntcon = mysql_num_rows($result5);
	
	if ($cntcon > 0) {
	
		while ($dbarr5 = mysql_fetch_array($result5)) {
		
			if ($_COOKIE['vlang'] == 'en') { $pagname = $dbarr5['pag_name_en']; }
			else if ($_COOKIE['vlang'] == 'vn') { $pagname = $dbarr5['pag_name_vn']; }
			else { $pagname = $dbarr5['pag_name_jp']; }
			$pagid = $dbarr5['pag_id'];
			$pagstatus = $dbarr5['pag_status'];
			$pagshowen = $dbarr5['pag_show_en']; 
			$pagshowvn = $dbarr5['pag_show_vn']; 
			$pagshowjp = $dbarr5['pag_show_jp']; 
			
			if ($pagstatus != 'd') { $pagstatus = "<a href=\"edt_page_set_disable.php?id=".$memid."&page=".$pagid."\"><img src=\"images/icon_enable_01.png\" title=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $pagstatus = "<a href=\"edt_page_set_enable.php?id=".$memid."&page=".$pagid."\"><img src=\"images/icon_disable_01.png\" title=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			
		if ($pagshowen == 't') { 
			$iconviewen = "<a href=\"mem_content.php?id=".$memid."&page=".$pagid."&lang=en\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconediten = "<a href=\"adm_member_page_content_edit.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpanden = "<a href=\"adm_member_page_column_add.php?id=".$memid."&page=".$pagid."&lang=en\" ><img src=\"images/icon_expand_01.png\" title=\"".$lb_alt_expand."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
		} else { 
			$iconviewen = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			if ($prf_en == 't') { $iconediten= "<a href=\"adm_member_page_content_edit.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $iconediten = "<img src=\"images/icon_edit_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; }
			$iconexpanden = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		if ($pagshowvn == 't') { 
			$iconviewvn = "<a href=\"mem_content.php?id=".$memid."&page=".$pagid."&lang=vn\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconeditvn = "<a href=\"adm_member_page_content_edit.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpandvn = "<a href=\"adm_member_page_column_add.php?id=".$memid."&page=".$pagid."&lang=vn\" ><img src=\"images/icon_expand_01.png\" title=\"".$lb_alt_expand."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
		} else { 
			$iconviewvn = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			if ($prf_vn == 't') { $iconeditvn = "<a href=\"adm_member_page_content_edit.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $iconeditvn = "<img src=\"images/icon_edit_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; }
			$iconexpandvn = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		if ($pagshowjp == 't') { 
			$iconviewjp = "<a href=\"mem_content.php?id=".$memid."&page=".$pagid."&lang=jp\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconeditjp = "<a href=\"adm_member_page_content_edit.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpandjp = "<a href=\"adm_member_page_column_add.php?id=".$memid."&page=".$pagid."&lang=jp\" ><img src=\"images/icon_expand_01.png\" title=\"".$lb_alt_expand."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
		} else { 
			$iconviewjp = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			if ($prf_jp == 't') { $iconeditjp= "<a href=\"adm_member_page_content_edit.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $iconeditjp = "<img src=\"images/icon_edit_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; }
			$iconexpandjp = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
			
			$conlist = $conlist."<tr>
            <td colspan=\"5\"><img src=\"images/line_frame_08.png\" width=\"740\" height=\"10\" /></td>
            </tr>
			<tr>
            <td>".$pagstatus."</td>
            <td>".subhtml($pagname)."</td>
            <td><div align=\"center\">".$iconviewjp."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconeditjp."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpandjp."</div></td>
			<td><div align=\"center\">".$iconviewvn."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconeditvn."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpandvn."</div></td>
			<td><div align=\"center\">".$iconviewen."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconediten."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpanden."</div></td>
          </tr>";
		
		}
	
	} 
	
	if ($prf_jp == 't') { $connew_jp = "<a href=\"adm_member_page_content_add.php?id=".$memid."&lang=jp\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>"; }
	else { $connew_jp = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />"; }
	if ($prf_vn == 't') { $connew_vn = "<a href=\"adm_member_page_content_add.php?id=".$memid."&lang=vn\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>"; }
	else { $connew_vn = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />"; }
	if ($prf_en == 't') { $connew_en = "<a href=\"adm_member_page_content_add.php?id=".$memid."&lang=en\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>"; }
	else { $connew_en = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />"; }
	
	
	
	// Presentation row
	
	$sql6 = "select * from flc_page where mem_id = '$memid' and pag_type = 'pst' order by pag_sort asc;"; 
	$result6 = mysql_query($sql6);
	$cntpst = mysql_num_rows($result6);
	
	if ($cntpst > 0) {
	
		$pstnew_jp = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />";
		$pstnew_vn = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />";
		$pstnew_en = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />";
		
		while ($dbarr6 = mysql_fetch_array($result6)) {
		
			if ($_COOKIE['vlang'] == 'en') { $pagname = $dbarr6['pag_name_en']; }
			else if ($_COOKIE['vlang'] == 'vn') { $pagname = $dbarr6['pag_name_vn']; }
			else { $pagname = $dbarr6['pag_name_jp']; }
			$pagid = $dbarr6['pag_id'];
			$pagstatus = $dbarr6['pag_status'];
			$pagshowen = $dbarr6['pag_show_en']; 
			$pagshowvn = $dbarr6['pag_show_vn']; 
			$pagshowjp = $dbarr6['pag_show_jp']; 
		
		}
		
		if ($pagstatus != 'd') {
			$pagstatus = "<a href=\"edt_page_set_disable.php?id=".$memid."&page=".$pagid."\"><img src=\"images/icon_enable_01.png\" title=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		} else {
			$pagstatus = "<a href=\"edt_page_set_enable.php?id=".$memid."&page=".$pagid."\"><img src=\"images/icon_disable_01.png\" title=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
		}
		
		if ($pagshowen == 't') { 
			$iconviewen = "<a href=\"mem_present.php?id=".$memid."&page=".$pagid."&lang=en\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconediten = "<a href=\"adm_member_page_present_edit.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpanden = "<a href=\"adm_member_page_box_add.php?id=".$memid."&page=".$pagid."&lang=en\" ><img src=\"images/icon_expand_01.png\" title=\"".$lb_alt_expand."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
		} else { 
		
			$iconviewen = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			
			if ($prf_en == 't') {
				$iconediten= "<a href=\"adm_member_page_present_edit.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>";
			} else {
				$iconediten = "<img src=\"images/icon_edit_02.png\" width=\"20\" height=\"20\" border=\"0\" />";
			}
			
			$iconexpanden = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 

		}
		
		if ($pagshowvn == 't') { 
			$iconviewvn = "<a href=\"mem_present.php?id=".$memid."&page=".$pagid."&lang=vn\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconeditvn = "<a href=\"adm_member_page_present_edit.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpandvn = "<a href=\"adm_member_page_box_add.php?id=".$memid."&page=".$pagid."&lang=vn\" ><img src=\"images/icon_expand_01.png\" title=\"".$lb_alt_expand."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
		} else { 
			$iconviewvn = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			if ($prf_vn == 't') { $iconeditvn = "<a href=\"adm_member_page_present_edit.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $iconeditvn = "<img src=\"images/icon_edit_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; }
			$iconexpandvn = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		if ($pagshowjp == 't') { 
			$iconviewjp = "<a href=\"mem_present.php?id=".$memid."&page=".$pagid."&lang=jp\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconeditjp = "<a href=\"adm_member_page_present_edit.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpandjp = "<a href=\"adm_member_page_box_add.php?id=".$memid."&page=".$pagid."&lang=jp\" ><img src=\"images/icon_expand_01.png\" title=\"".$lb_alt_expand."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
		} else { 
			$iconviewjp = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			if ($prf_jp == 't') { $iconeditjp= "<a href=\"adm_member_page_present_edit.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $iconeditjp = "<img src=\"images/icon_edit_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; }
			$iconexpandjp = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		$pstlist = "<tr>
            <td colspan=\"5\"><img src=\"images/line_frame_08.png\" width=\"740\" height=\"10\" /></td>
            </tr>
			<tr>
            <td>".$pagstatus."</td>
            <td>".subhtml($pagname)."</td>
            <td><div align=\"center\">".$iconviewjp."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconeditjp."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpandjp."</div></td>
			<td><div align=\"center\">".$iconviewvn."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconeditvn."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpandvn."</div></td>
			<td><div align=\"center\">".$iconviewen."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconediten."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpanden."</div></td>
          </tr>";
	
	} else {
	
		if ($prf_jp == 't') { $pstnew_jp = "<a href=\"adm_member_page_present_add.php?id=".$memid."&lang=jp\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>"; }
		else { $pstnew_jp = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />"; }
		
		if ($prf_vn == 't') { $pstnew_vn = "<a href=\"adm_member_page_present_add.php?id=".$memid."&lang=vn\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>"; }
		else { $pstnew_vn = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />"; }
		
		if ($prf_en == 't') { $pstnew_en = "<a href=\"adm_member_page_present_add.php?id=".$memid."&lang=en\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>"; }
		else { $pstnew_en = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />"; }
		
	}

	// Product row
	$sql7 = "select * from flc_page where mem_id = '$memid' and pag_type = 'pro';"; 
	$result7 = mysql_query($sql7);
	$totalPageProduct = mysql_num_rows($result7);

	// Check if have product
	$sqlCountProduct = "select count(*) as count from flc_products where SupplierID = $memid;";

	$rsNumProduct = mysql_query($sqlCountProduct);
	$numProduct = mysql_fetch_array($rsNumProduct);
	$totalProduct = (int)$numProduct['count'];
	// End check
	
	if ( $totalPageProduct > 0 && $totalProduct !== 0 ) {
	
		$productnew_jp = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />";
		$productnew_vn = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />";
		$productnew_en = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />";
		
		while ($dbarr7 = mysql_fetch_array($result7)) {
		
			if ($_COOKIE['vlang'] == 'en') { $pagname = $dbarr7['pag_name_en']; }
			else if ($_COOKIE['vlang'] == 'vn') { $pagname = $dbarr7['pag_name_vn']; }
			else { $pagname = $dbarr7['pag_name_jp']; }
			$pagid = $dbarr7['pag_id'];
			$pagstatus = $dbarr7['pag_status'];
			$pagshowen = $dbarr7['pag_show_en']; 
			$pagshowvn = $dbarr7['pag_show_vn']; 
			$pagshowjp = $dbarr7['pag_show_jp']; 
		
		}
		
		if ($pagstatus != 'd') { $pagstatus = "<a href=\"edt_page_set_disable.php?id=".$memid."&page=".$pagid."\"><img src=\"images/icon_enable_01.png\" title=\"".$lb_alt_on."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
		else { $pagstatus = "<a href=\"edt_page_set_enable.php?id=".$memid."&page=".$pagid."\"><img src=\"images/icon_disable_01.png\" title=\"".$lb_alt_off."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
		
		if ($pagshowen == 't') { 
			$iconviewen = "<a href=\"mem_inquiry.php?id=".$memid."&page=".$pagid."&lang=en\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconediten = "<a href=\"adm_member_page_inquiry_edit.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpanden = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		} else { 
			$iconviewen = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			if ($prf_en == 't') { $iconediten = "<a href=\"adm_member_page_inquiry_edit.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $iconediten = "<img src=\"images/icon_edit_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; }
			$iconexpanden = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		if ($pagshowvn == 't') { 
			$iconviewvn = "<a href=\"mem_inquiry.php?id=".$memid."&page=".$pagid."&lang=vn\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconeditvn = "<a href=\"adm_member_page_inquiry_edit.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpandvn = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		} else { 
			$iconviewvn = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			if ($prf_vn == 't') { $iconeditvn = "<a href=\"adm_member_page_inquiry_edit.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $iconeditvn = "<img src=\"images/icon_edit_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; }
			$iconexpandvn = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		if ($pagshowjp == 't') { 
			$iconviewjp = "<a href=\"mem_inquiry.php?id=".$memid."&page=".$pagid."&lang=jp\"target=\"_blank\"><img src=\"images/icon_view_01.png\" title=\"".$lb_alt_view."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconeditjp = "<a href=\"adm_member_page_inquiry_edit.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; 
			$iconexpandjp = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		} else { 
			$iconviewjp = "<img src=\"images/icon_view_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
			if ($prf_jp == 't') { $iconeditjp= "<a href=\"adm_member_page_inquiry_edit.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/icon_edit_01.png\" title=\"".$lb_alt_edit."\" width=\"20\" height=\"20\" border=\"0\" /></a>"; }
			else { $iconeditjp = "<img src=\"images/icon_edit_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; }
			$iconexpandjp = "<img src=\"images/icon_expand_02.png\" width=\"20\" height=\"20\" border=\"0\" />"; 
		}
		
		$productlist = "<tr>
            <td colspan=\"5\"><img src=\"images/line_frame_08.png\" width=\"740\" height=\"10\" /></td>
            </tr>
			<tr>
            <td>".$pagstatus."</td>
            <td>".subhtml($pagname)."</td>
            <td><div align=\"center\">".$iconviewjp."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconeditjp."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpandjp."</div></td>
			<td><div align=\"center\">".$iconviewvn."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconeditvn."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpandvn."</div></td>
			<td><div align=\"center\">".$iconviewen."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconediten."<img src=\"images/blank.png\" width=\"5\" height=\"20\" />".$iconexpanden."</div></td>
          </tr>";
	
	} else {
	
		if ($prf_jp == 't') { $productnew_jp = "<a href=\"adm_member_page_product_add.php?id=".$memid."&lang=jp\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>"; }
		else { $productnew_jp = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />"; }
		if ($prf_vn == 't') { $productnew_vn = "<a href=\"adm_member_page_product_add.php?id=".$memid."&lang=vn\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>"; }
		else { $productnew_vn = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />"; }
		if ($prf_en == 't') { $productnew_en = "<a href=\"adm_member_page_product_add.php?id=".$memid."&lang=en\"><img src=\"images/icon_create_01.png\" width=\"70\" height=\"30\" border=\"0\" title=\"".$lb_alt_create."\" /></a>"; }
		else { $productnew_en = "<img src=\"images/icon_create_02.png\" width=\"70\" height=\"30\" border=\"0\" />"; }
		
	}

	// end product list
	
	// -------------------------
	
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##memcomname##", $memcomname);
	$tpl->assign("##langcode##", $langcode);
	$tpl->assign("##prfnew_jp##", $prfnew_jp);
	$tpl->assign("##prfnew_vn##", $prfnew_vn);
	$tpl->assign("##prfnew_en##", $prfnew_en);
	$tpl->assign("##prflist##", $prflist);
	$tpl->assign("##homnew_jp##", $homnew_jp);
	$tpl->assign("##homnew_vn##", $homnew_vn);
	$tpl->assign("##homnew_en##", $homnew_en);
	$tpl->assign("##homlist##", $homlist);
	$tpl->assign("##inqnew_jp##", $inqnew_jp);
	$tpl->assign("##inqnew_vn##", $inqnew_vn);
	$tpl->assign("##inqnew_en##", $inqnew_en);
	$tpl->assign("##inqlist##", $inqlist);

	$tpl->assign("##productnew_jp##", $productnew_jp);
	$tpl->assign("##productnew_vn##", $productnew_vn);
	$tpl->assign("##productnew_en##", $productnew_en);
	$tpl->assign("##productlist##", $productlist);
	
	$tpl->assign("##connew_jp##", $connew_jp);
	$tpl->assign("##connew_vn##", $connew_vn);
	$tpl->assign("##connew_en##", $connew_en);
	$tpl->assign("##conlist##", $conlist);
	$tpl->assign("##pstnew_jp##", $pstnew_jp);
	$tpl->assign("##pstnew_vn##", $pstnew_vn);
	$tpl->assign("##pstnew_en##", $pstnew_en);
	$tpl->assign("##pstlist##", $pstlist);
	$tpl->assign("##tab_en##", $tab_en);
	$tpl->assign("##tab_vn##", $tab_vn);
	$tpl->assign("##tab_jp##", $tab_jp);
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
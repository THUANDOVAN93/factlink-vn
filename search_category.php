<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	
	$url1 = "structure-new.html"; 
	$url2 = "search_result.html";
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	$url7 = "InfoTop.html";
	$url8 = "Link_Footer.html";
	$url9 = "Link_Footer2.html";
	$url10 = "Link_Footer3.html";
	$url11 = "SearchMenubar1.html";	
	$url12 = "SearchMenubar2.html";
	$url13 = "SearchMenubar3.html";
	$url14 = "SearchMenubar4.html";
	$pagecode = "sch";
	
	$searchid = $_GET['id'];
	$searchcatid = $searchid;
	$searchtype = "cate";
	
	
	/* Set default language cookie */
	if(empty($_COOKIE['vlang'])) {
		$_COOKIE['vlang'] = 'en';
	}
	
	/* Prevent unknown cookie language value */
	if(!in_array($_COOKIE['vlang'],['en','jp','vn'])) {
		$_COOKIE['vlang'] = 'en';
	}
	
	if ($_COOKIE['vlang'] == 'en') { $url6 = "menu-html_en.html"; } else if ($_COOKIE['vlang'] == 'vn') { $url6 = "menu-html_vn.html"; } else { $url6 = "menu-html_jp.html"; }
	
	
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2, "right_tpl" => $url3, "left_tpl" => $url4, "top_tpl" => $url5, "menu_tpl" => $url6, "Info_tpl" => $url7, "linkFooter_tpl" => $url8,
		"linkFooter_tpl2" => $url9, "linkFooter_tpl3" => $url10,"SearchMenubar_tpl1" => $url11, "SearchMenubar_tpl2" => $url12, "SearchMenubar_tpl3" => $url13, "SearchMenubar_tpl4" => $url14 ));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	// exit(microtime(true));
	
	$start = $_GET['start'];
	$limit = 30;
	
	 $sql9 = "select * from flc_category where cat_id = '$searchid';";
	 // echo "<pre>".print_r($sql9,true)."</pre>"; exit;
	 
	 
	$result9 = mysql_query($sql9);
	while ($dbarr9 = mysql_fetch_array($result9)) { $searchworden = str_replace("@"," - ",$dbarr9['cat_name_en']); $searchwordjp = str_replace("@"," - ",$dbarr9['cat_name_jp']); $searchwordvn = str_replace("@"," - ",$dbarr9['cat_name_vn']); }
	
	if ($_COOKIE['vlang'] == 'en') { $searchword = $searchworden; }
	else if ($_COOKIE['vlang'] == 'vn') { $searchword = $searchwordvn; }
	else { $searchword = $searchwordjp; }
	
	$pagesql = "select * from flc_member where (mem_category = '$searchid' or mem_category_second = '$searchid') and mem_status != 'd';";
	$resultsearchlist = mysql_query($pagesql);
	$cntsearchlist = mysql_num_rows($resultsearchlist); 
	
	if ($cntsearchlist == 0 || $start > $cntsearchlist) { $resulttable = "<tr><td valign=\"top\"><div align=\"center\"><br><br>".$lb_searchfail."<br><br></div></td></tr>"; }
	else {
		
		$page = pagecal($limit, $start, $pagesql, "search_category.php", "?id=$searchid");
		
		$arrlist = array();
		$cntlist = 1;

		//BASIC
		$sql1 = "select mem_id from flc_member where (mem_category = '$searchid' or mem_category_second = '$searchid') and mem_package != '' and mem_status != 'd' order by mem_sort asc;"; 
		$result1 = mysql_query($sql1);
		$specMemberId = array();
		while ($dbarr1 = mysql_fetch_array($result1)) {
			if ($dbarr1['mem_id'] === '00002479') {
				$specMemberId = $dbarr1['mem_id'];
			} else {
				$arrlist[$cntlist] = $dbarr1['mem_id'];
				$cntlist = $cntlist + 1;
			}
		}

		//randum member basic
		shuffle($arrlist);

		// add special member to position top 3
		if (!empty($specMemberId)) {
			$positionTop3 = rand(0,2);
			array_splice($arrlist, $positionTop3, 0, $specMemberId);
			$cntlist = $cntlist + 1;
		}

		array_unshift($arrlist,"");
		unset($arrlist[0]);
		//FREE
		$sql1 = "select mem_id from flc_member where (mem_category = '$searchid' or mem_category_second = '$searchid') and mem_package = '' and mem_status != 'd' order by mem_id asc;"; 
		$result1 = mysql_query($sql1);
		while ($dbarr1 = mysql_fetch_array($result1)) {
			$arrlist[$cntlist] = $dbarr1['mem_id'];
			$cntlist = $cntlist + 1;
		}

		// End by ThuanDo
		
		$startlist = $start + 1;
		$alllist = $start + $limit; 
		if ($alllist > $cntsearchlist) { $alllist = $cntsearchlist; }
		
		for ($list=$startlist;$list<=$alllist;$list++) {
		
			$memidlist = $arrlist[$list];
			
			$sql1 = "select * from flc_member where mem_id = '$memidlist';"; 
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {
				$memfolder = $dbarr1['mem_folder']; 
				$mempackage = $dbarr1['mem_package'];
				$memnational = $dbarr1['mem_national']; 
				$mem_addressine1 = $dbarr1['mem_addressine1']; // join to flc_ie
			    $mem_addressine2 = $dbarr1['mem_addressine2']; // join to flc_ie
				if ($memnational == 'jp') { $memnationalbg = "#FFFFFF"; $memnationaltitle = $lb_njp; }
				else if ($memnational == 'vn') { $memnationalbg = "#CC0000"; $memnationaltitle = $lb_nvn; }
				else { $memnationalbg = "#004F94"; $memnationaltitle = $lb_nother; }
				
				if ($_COOKIE['vlang'] == 'en') { $memcomname = $dbarr1['mem_comname_en']; $memsubdesc = $dbarr1['mem_subdesc_en']; }
				else if ($_COOKIE['vlang'] == 'vn') { $memcomname = $dbarr1['mem_comname_vn']; $memsubdesc = $dbarr1['mem_subdesc_vn']; }
				else { $memcomname = $dbarr1['mem_comname_jp']; $memsubdesc = $dbarr1['mem_subdesc_jp']; }
				
				if ($memsubdesc != '') { $memsubdesc = "<br />".$memsubdesc; }
				//southern_en.png central_en.png northern_en.png
				$pagshowen = ""; $pagshowjp = ""; $pagshowvn = ""; $langset = ""; 
				$langen = "<img src=\"images/tpl_en_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
				$langjp = "<img src=\"images/tpl_jp_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
				$langvn = "<img src=\"images/tpl_vn_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
				
				$sql2 = "select * from flc_page where pag_type = 'prf' and mem_id = '$memidlist';"; 
				$result2 = mysql_query($sql2);
				while ($dbarr2 = mysql_fetch_array($result2)) {
					
					$pagid = $dbarr2['pag_id'];
					$pagshowen = $dbarr2['pag_show_en'];
					$pagshowjp = $dbarr2['pag_show_jp'];
					$pagshowvn = $dbarr2['pag_show_vn'];
					
					if ($pagshowen == 't') { $langen = "<a href=\"mem_profile.php?id=".$memidlist."&page=".$pagid."&lang=en\" target=\"_blank\"><img src=\"images/tpl_en_01.png\" alt=\"English\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
							
					if ($pagshowjp == 't') { $langjp = "<a href=\"mem_profile.php?id=".$memidlist."&page=".$pagid."&lang=jp\" target=\"_blank\"><img src=\"images/tpl_jp_01.png\" alt=\"日本語\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
								
					if ($pagshowvn == 't') { $langvn = "<a href=\"mem_profile.php?id=".$memidlist."&page=".$pagid."&lang=vn\" target=\"_blank\"><img src=\"images/tpl_vn_01.png\" alt=\"Việt Nam\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
							
				} // $result2
				
				$langarr = array();
				if ($pagshowjp == 't') { $langarr[0] = "jp"; } else { $langarr[0] = ""; }
				if ($pagshowvn == 't') { $langarr[1] = "vn"; } else { $langarr[1] = ""; }
				if ($pagshowen == 't') { $langarr[2] = "en"; } else { $langarr[2] = ""; }
				
				for ($i=0;$i<=2;$i++) { 
					if ($langarr[$i] != '') { $langset = $langarr[$i]; }
					if ($langset == $_COOKIE['vlang']) { $i = $i + 3; } 
				}
				
				//if ($langset != '') { $memcomname = "<a href=\"mem_profile.php?id=".$memidlist."&page=".$pagid."&lang=".$langset."\" target=\"_blank\">".$memcomname."</a>"; } 
				if ($langset != '') { $memcomname = "<a href=\"home/".$memfolder."\" target=\"_blank\">".$memcomname."</a>"; } 
				
				if ($mempackage != '') {
					// start display sector name on table flc_ie
					
					$sql_sector="SELECT * FROM flc_member WHERE mem_id='$memidlist'";
					$query_sector=mysql_db_query($db_name,$sql_sector);
					while($fetch_sector=mysql_fetch_array($query_sector)){
						 $addressine1=$fetch_sector['mem_addressine1'];
						 $addressine2=$fetch_sector['mem_addressine2'];
						 
						 if($addressine1!= ""){
				         $sql_ie_sector1="SELECT * FROM  flc_ie WHERE flc_ie.ine_id='$addressine1'";
					     $query_ie1=mysql_query($sql_ie_sector1);
					     while($fetch_ie1=mysql_fetch_array($query_ie1)){
						 $sector1=$fetch_ie1['sector'];
						
						if($sector1=='north'){$img_sector1="&nbsp;&nbsp;<img src=\"images/sector/north_".$_COOKIE['vlang'].".png\" width=\"72\" height=\"24\" border=\"0\" />";}
						if($sector1=='south'){$img_sector1="&nbsp;&nbsp;<img src=\"images/sector/south_".$_COOKIE['vlang'].".png\" width=\"72\" height=\"24\" border=\"0\" />";}	
						if($sector1=='central'){$img_sector1="&nbsp;&nbsp;<img src=\"images/sector/central_".$_COOKIE['vlang'].".png\" width=\"72\" height=\"24\" border=\"0\" />";}
						if($sector1!='north' && $sector1!='south' && $sector1!='central'  ){$img_sector1="&nbsp;&nbsp;<img src=\"images/sector/other_".$_COOKIE['vlang'].".png\" width=\"72\" height=\"24\" border=\"0\" />";}
						
					   } // end  while($fetch_ie1
					}// end if	$mem_addressine21
					
					if($addressine2!= "" && $addressine2!=$addressine1){
				         $sql_ie_sector2="SELECT * FROM  flc_ie WHERE flc_ie.ine_id='$addressine2'";
					     $query_ie2=mysql_query($sql_ie_sector2);
					     while($fetch_ie2=mysql_fetch_array($query_ie2)){
						 $sector2=$fetch_ie2['sector'];
						
						if($sector2=='north'){$img_sector2="&nbsp;&nbsp;<img src=\"images/sector/north_".$_COOKIE['vlang'].".png\" width=\"72\" height=\"24\" border=\"0\" />";}
						if($sector2=='south'){$img_sector2="&nbsp;&nbsp;<img src=\"images/sector/south_".$_COOKIE['vlang'].".png\" width=\"72\" height=\"24\" border=\"0\" />";}	
						if($sector2=='central'){$img_sector2="&nbsp;&nbsp;<img src=\"images/sector/central_".$_COOKIE['vlang'].".png\" width=\"72\" height=\"24\" border=\"0\" />";}
						if($sector2!='north' && $sector2!='south' && $sector2!='central'  ){$img_sector2="&nbsp;&nbsp;<img src=\"images/sector/other_".$_COOKIE['vlang'].".png\" width=\"72\" height=\"24\" border=\"0\" />";}
						
					   } // end  while($fetch_ie1
					}else{$img_sector2="";}// end if	$mem_addressine21	
					
						
						}// while
					
					// $_COOKIE['vlang']."<br>".$_GET['lang'];
						
				   // END display sector name on table flc_ie
					
				 //
						 $resulttable = $resulttable."<tr>
						<td valign=\"top\"><table width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                          <tr>
                            <td width=\"22\" bordercolor=\"#999999\" bgcolor=\"".$memnationalbg."\" style=\"border-style:solid; border-width:1px;\"><img src=\"images/bg_nation_".$memnational.".jpg\" width=\"20\" height=\"22\" title=\"".$memnationaltitle."\" /></td>
							<td width=\"5\" valign=\"top\">&nbsp;</td>
							<td width=\"800\" valign=\"top\" ><table class=\"archive_table\" width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" bgcolor=\"#FFDDDD\">
                           <tr><td><span class=\"default_head\">".$memcomname."</span>".$memsubdesc."<br /><br />".$langjp." ".$langvn." ".$langen."&nbsp;".$img_sector1."&nbsp;".$img_sector2."</td></tr>
						 </table></td>
                          </tr>
                        </table></td>
						
						
					</tr>
					  <tr><td valign=\"top\"><img src=\"images/blank.png\" width=\"560\" height=\"5\" /></td></tr>";
					  //
				} else if ($mempackage == '') {
				
					$resulttable = $resulttable."<tr>
						<td valign=\"top\"><table width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                          <tr>
                            <td width=\"22\" bordercolor=\"#999999\" bgcolor=\"".$memnationalbg."\" style=\"border-style:solid; border-width:1px;\"><img src=\"images/bg_nation_".$memnational.".jpg\" width=\"20\" height=\"22\" title=\"".$memnationaltitle."\" /></td>
							<td width=\"5\" valign=\"top\">&nbsp;</td>
							<td width=\"800\" valign=\"top\" ><table class=\"archive_table\" width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" bgcolor=\"#EEEEEE\">
                           <tr><td><span class=\"default_head\">".$memcomname."</span>".$memsubdesc."<br /><br />".$langjp." ".$langvn." ".$langen."</td></tr>
						 </table></td>
                          </tr>
                        </table></td>
					</tr>
					  <tr><td valign=\"top\"><img src=\"images/blank.png\" width=\"560\" height=\"5\" /></td></tr>";
				
				} //else if ($mempackage == '') {
				
			} 
					
		}
	
	} // -82
	
	
	
	
	
	$tpl->assign("##resultword##", $searchword);
	$tpl->assign("##resulttable##", $resulttable);
	$tpl->assign("##page##", $page);
	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("##INFOTOP_AREA##", "Info_tpl");
	$tpl->parse ("##LinkFooter_AREA##", "linkFooter_tpl");
	$tpl->parse ("##LinkFooter_AREA2##", "linkFooter_tpl2");
	$tpl->parse ("##LinkFooter_AREA3##", "linkFooter_tpl3");
	$tpl->parse ("##SearchMenubar_AREA1##", "SearchMenubar_tpl1");
	$tpl->parse ("##SearchMenubar_AREA2##", "SearchMenubar_tpl2");
	$tpl->parse ("##SearchMenubar_AREA3##", "SearchMenubar_tpl3");
	$tpl->parse ("##SearchMenubar_AREA4##", "SearchMenubar_tpl4");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
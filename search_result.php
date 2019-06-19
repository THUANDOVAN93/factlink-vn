<?php
	//error_reporting(-1);
	//ini_set('display_errors', 'On'); 

	/* Sphinx Search Config */
	$hostnameSphinx = "127.0.0.1";
	$portSphinx 	= 9306;
	$connSphinx = new mysqli($hostnameSphinx, null, null, null, $portSphinx);
	if ($connSphinx->connect_error) {
		throw new Exception('Connection Error: ['.$connSphinx->connect_errno.'] '.$connSphinx->connect_error, $connSphinx->connect_errno);
	}
	$maxMatechesSphinx = 1000;
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
	
	/* Set default language cookie */
	if(empty($_COOKIE['vlang'])) {
		$lang = 'en';
	}
	
	/* Prevent unknown cookie language value */
	if(!in_array($_COOKIE['vlang'],['en','jp','vn'])) {
		$lang = 'en';
	}
	
	$lang = $_COOKIE['vlang'];
	
	if ($lang == 'en') {
		$url6 = "menu-html_en.html";
	} else if ($lang == 'vn') {
		$url6 = "menu-html_vn.html";
	} else {
		$url6 = "menu-html_jp.html";
	}
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array(
		"main_tpl"		=> $url1,
		"detail_tpl"	=> $url2,
		"right_tpl"		=> $url3,
		"left_tpl" => $url4,
		"top_tpl" => $url5,
		"menu_tpl" => $url6,
		"Info_tpl" => $url7,
		"linkFooter_tpl" => $url8,
		"linkFooter_tpl2" => $url9,
		"linkFooter_tpl3" => $url10,
		"SearchMenubar_tpl1" => $url11,
		"SearchMenubar_tpl2" => $url12,
		"SearchMenubar_tpl3" => $url13,
		"SearchMenubar_tpl4" => $url14
	));
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	$start = $_GET['start'];
	$limit = 30;

	$seachOption = $_SESSION['vsearch_option'];

	// Seach by Product

	if ( $seachOption == "product" ) {

		// SPHINX SEARCH ENGINE HERE
		$results = array();
		$sqlRoot = "select p.*, m.mem_folder, m.mem_comname_en, m.mem_comname_jp, m.mem_comname_vn from flc_products p, flc_member m where p.SupplierID = m.mem_id and productID IN (";
		$searchKey = mysql_real_escape_string($_SESSION['vsearch_key']);
		//$searchKey = str_replace('@', ' ', $searchKey);
		$searchKey = preg_replace('~[\\\\/:*?@"<>()|]~', ' ', $searchKey);
		$sqphixSql = "SELECT * FROM test2 WHERE MATCH('".$searchKey."*') limit 0,".$maxMatechesSphinx;
		$resource = $connSphinx->query($sqphixSql);
		if ($resource->num_rows !== 0) {
			while ($row = $resource->fetch_assoc()) {
				$results[] = $row['id'];
			}
			$resource->free_result();
			$numProductSphinx = count($results);
			$tempSphix = 0;
			foreach ($results as $key => $value) {
				if (++$tempSphix === $numProductSphinx) {
					$sqlRoot .= "$value)";
				} else {
					$sqlRoot .= "$value,";
				}
			}	
		} else {
			$numProductSphinx = 0;
		}
		
		if ($numProductSphinx === 0) { 
			$resulttable = "<tr><td valign=\"top\"><div align=\"center\"><br><br>".$lb_searchfail."<br><br></div></td></tr>"; 
		} else {
			$page = pagecal($limit, $start, $sqlRoot, "search_result.php", "");
			$sqlGetProduct = $sqlRoot."order by ProductID limit $start,$limit;";
			$rsGetProduct = mysql_query($sqlGetProduct);
			$resulttable = "<tr><td class=\"wrap-product-search\">";

			while ( $productItem = mysql_fetch_array($rsGetProduct) ) {
				if ( $lang == 'en' ) {

					$productName = $productItem['ProductNameEN'];
					$supplierName = $productItem['mem_comname_en'];

				} elseif ( $lang == 'vn' ) {

					$productName = $productItem['ProductNameVN'];
					$supplierName = $productItem['mem_comname_vn'];

				} else {

					$productName = $productItem['ProductNameJP'];
					$supplierName = $productItem['mem_comname_jp'];

				}

				// Buil link product
				$sourceImage = 'home/'.$productItem['mem_folder'].'/products/';
				$imgLink = $sourceImage.$productItem['ProductID'].'-L.jpg';

				if (!file_exists($imgLink)) {
					$imgLink = 'image/products/product.png';
				}

				$productId = $productItem['ProductID'];
				$productHref = "product_detail.php?proid=".$productId;

				$resulttable = $resulttable."
						<div class=\"box-product-search\">
							<div class=\"product-search-image\">
								<figure>
					            	<a href=\"".$productHref."\" target=\"_blank\"><img src=\"".$imgLink."\" alt=\"".$productName."\"></a>
					            </figure>
							</div>
							<div class=\"product-search-tit\">
								<a href=\"".$productHref."\" target=\"_blank\">".$productName."</a>
							</div>
							<div class=\"product-search-sup\">
							".$supplierName."
							</div>
						</div>";
			}
			$resulttable = $resulttable."</td></tr>";
		}
	} elseif($seachOption == "company") {

		// SPHINX SEARCH ENGINE HERE
		$results = array();
		$sqlRoot = "select * from flc_member where mem_id IN ("; 
		$searchKey = mysql_real_escape_string($_SESSION['vsearch_key']);
		//$searchKey = str_replace('@', ' ', $searchKey);
		$searchKey = preg_replace('~[\\\\/:*?@"<>()|]~', ' ', $searchKey);
		$sqphixSql = "SELECT * FROM test1 WHERE MATCH('".$searchKey."*') limit 0,".$maxMatechesSphinx." option ranker=WORDCOUNT";
		$resource = $connSphinx->query($sqphixSql);
		if ($resource->num_rows !== 0) {
			while ($row = $resource->fetch_assoc()) {
				$results[] = sprintf("%08d", $row['id']);
			}
			$resource->free_result();

			$numMemberSphinx = count($results);
			$tempSphix = 0;
			$idList = "";

			foreach ($results as $key => $value) {
				if (++$tempSphix === $numMemberSphinx) {
					$sqlRoot .= "$value)";
					$idList .=  $value;
				} else {
					$sqlRoot .= "$value,";
					$idList .=  "$value, ";
				}
			}

			$sqlBasicMember = $sqlRoot." and mem_package != '' and mem_status != 'd' limit $start,$limit;";
			$sqlCountMemberActive = $sqlRoot." and mem_status != 'd';";
			$resultCountMemberActive = mysql_query($sqlCountMemberActive);
			$countMemberActive = mysql_num_rows($resultCountMemberActive);
		} else {
			//$numMemberSphinx = 0;
			$countMemberActive = 0;
		}


		// GET ID MEMBER
		
		if ($countMemberActive === 0) {

			$resulttable = "<tr><td valign=\"top\"><div align=\"center\"><br><br>".$lb_searchfail."<br><br></div></td></tr>";
		} else {
			$page = pagecal($limit, $start, $sqlRoot, "search_result.php", "");
			$result0 = mysql_query($sqlBasicMember);
			$cntbasic = mysql_num_rows($result0);
			if ($cntbasic <= $limit) {
			$cntfree = $limit - $cntbasic;
			$limitbasic = $cntbasic;
			$startbasic = $start;
			} else {
				$cntfree = 0;
				$limitbasic = $limit;
				$startbasic = $start;
			}
			
			//$sql1 = $sqlRoot." and mem_package != '' and mem_status != 'd' order by mem_sort asc limit $startbasic,$limitbasic;";
			$sql1 = $sqlRoot." and mem_package != '' and mem_status != 'd' order by mem_sort asc limit $startbasic,$limitbasic;";
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {
				
				$memid = $dbarr1['mem_id'];
				$mem_addressine1 = $dbarr1['mem_addressine1'];
				$mem_addressine2 = $dbarr1['mem_addressine2'];
				
				if ($lang == 'en') { $memcomname = $dbarr1['mem_comname_en']; $memsubdesc = $dbarr1['mem_subdesc_en']; }
				else if ($lang == 'vn') { $memcomname = $dbarr1['mem_comname_vn']; $memsubdesc = $dbarr1['mem_subdesc_vn']; }
				else { $memcomname = $dbarr1['mem_comname_jp']; $memsubdesc = $dbarr1['mem_subdesc_jp']; }
				
				$pagshowen = ""; $pagshowjp = ""; $pagshowvn = ""; $langset = ""; 
				$langen = "<img src=\"images/tpl_en_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
				$langjp = "<img src=\"images/tpl_jp_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
				$langvn = "<img src=\"images/tpl_vn_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
				
				$sql2 = "select * from flc_page where pag_type = 'prf' and mem_id = '$memid';"; 
				$result2 = mysql_query($sql2);
				while ($dbarr2 = mysql_fetch_array($result2)) {
					
					$pagid = $dbarr2['pag_id'];
					$pagshowen = $dbarr2['pag_show_en'];
					$pagshowjp = $dbarr2['pag_show_jp'];
					$pagshowvn = $dbarr2['pag_show_vn'];
					
					if ($pagshowen == 't') { $langen = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=en\" target=\"_blank\"><img src=\"images/tpl_en_01.png\" alt=\"English\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
							
					if ($pagshowjp == 't') { $langjp = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=jp\" target=\"_blank\"><img src=\"images/tpl_jp_01.png\" alt=\"日本語\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
								
					if ($pagshowvn == 't') { $langvn = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=vn\" target=\"_blank\"><img src=\"images/tpl_vn_01.png\" alt=\"Việt Nam\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
							
				}
				
				$langarr = array();
				if ($pagshowjp == 't') { $langarr[0] = "jp"; } else { $langarr[0] = ""; }
				if ($pagshowvn == 't') { $langarr[1] = "vn"; } else { $langarr[1] = ""; }
				if ($pagshowen == 't') { $langarr[2] = "en"; } else { $langarr[2] = ""; }
				
				for ($i=0;$i<=2;$i++) { 
					if ($langarr[$i] != '') { $langset = $langarr[$i]; }
					if ($langset == $lang) { $i = $i + 3; } 
				}
				
				// start display sector name on table flc_ie
				$sql_ie_sector="SELECT * FROM  flc_ie WHERE flc_ie.ine_id='$mem_addressine1'";
				$query_ie=mysql_query($sql_ie_sector);
				while($fetch_ie=mysql_fetch_array($query_ie)){
					$sector=$fetch_ie['sector'];
					
					if($sector=='north'){$img_sector="&nbsp;&nbsp;<img src=\"images/sector/north_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}
					if($sector=='south'){$img_sector="&nbsp;&nbsp;<img src=\"images/sector/south_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}	
					if($sector=='central'){$img_sector="&nbsp;&nbsp;<img src=\"images/sector/central_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}
					if($sector!='north' && $sector!='south' && $sector!='central' || $sector=='' ){$img_sector="&nbsp;&nbsp;<img src=\"images/sector/other_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}
					$tpl->assign("##img_sector##", $img_sector);
					}
				if($mem_addressine2!=""){
					
				   $sql_ie_sector="SELECT * FROM  flc_ie WHERE flc_ie.ine_id='$mem_addressine2'";
				$query_ie=mysql_query($sql_ie_sector);
				while($fetch_ie=mysql_fetch_array($query_ie)){
					$sector2=$fetch_ie['sector'];
					
					if($sector2=='north'){$img_sector2="&nbsp;&nbsp;<img src=\"images/sector/north_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}
					if($sector2=='south'){$img_sector2="&nbsp;&nbsp;<img src=\"images/sector/south_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}	
					if($sector2=='central'){$img_sector2="&nbsp;&nbsp;<img src=\"images/sector/central_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}
					if($sector2!='north' && $sector2!='south' && $sector2!='central' || $sector2=='' ){$img_sector2="&nbsp;&nbsp;<img src=\"images/sector/other_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}
					//$tpl->assign("##img_sector2##", $img_sector2);
				   }
				} else{
					$tpl->assign("##img_sector2##", "");
				}	
							
				// END display sector name on table flc_ie
				if ($langset != '') {
					$memcomname = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=".$langset."\" target=\"_blank\">".$memcomname."</a>";
				} 
				$resulttable = $resulttable."<tr><td valign=\"top\"><table width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
			  <tr>
				<td width=\"10\" valign=\"top\" bgcolor=\"#CC0000\">&nbsp;</td>
				<td width=\"10\" valign=\"top\" bgcolor=\"#FFDDDD\">&nbsp;</td>
				<td width=\"790\" valign=\"top\" bgcolor=\"#FFDDDD\"><table width=\"790\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
					<td><img src=\"images/blank.png\" width=\"540\" height=\"5\" /></td>
				  </tr>
				  <tr>
					<td><span class=\"default_head\">".$memcomname."</span> <br />
					  ".$memsubdesc."</td>
				  </tr>
				  <tr>
					<td><img src=\"images/blank.png\" width=\"540\" height=\"10\" /></td>
				  </tr>
				  <tr>
					<td>".$langjp." ".$langvn." ".$langen."&nbsp;".$img_sector."&nbsp;".$img_sector2."</td>
				  </tr>
				</table></td>
			  </tr>
			  <tr>
				<td colspan=\"3\" valign=\"top\"><img src=\"images/line_body_01.png\" width=\"800\" height=\"20\" /></td></tr></table></td></tr>";
				
			} 	
			
			if ($cntfree > 0) {
				if ($start == 0) {
					$startfree = $start;
				} else {
					$startfree = $start - $cntallbasic;
				}
				$limitfree = $limit - $cntbasic;
				//$sql3 = $sqlRoot." and mem_package = '' and mem_status != 'd' order by mem_id asc limit $startfree,$limitfree;";
				$sql3 = $sqlRoot." and mem_package = '' and mem_status != 'd' order by FIELD(mem_id, $idList) limit $startfree,$limitfree;";
				$result3 = mysql_query($sql3);
				while ($dbarr3 = mysql_fetch_array($result3)) {
					$memid = $dbarr3['mem_id'];

					if ($lang == 'en') {
						$memcomname = $dbarr3['mem_comname_en'];
						$memsubdesc = $dbarr3['mem_subdesc_en'];
					} elseif ($lang == 'vn') {
						$memcomname = $dbarr3['mem_comname_vn'];
						$memsubdesc = $dbarr3['mem_subdesc_vn'];
					} else {
						$memcomname = $dbarr3['mem_comname_jp'];
						$memsubdesc = $dbarr3['mem_subdesc_jp'];
					}
					
					$pagshowen = "";
					$pagshowjp = "";
					$pagshowvn = "";
					$langset = ""; 
					$langen = "<img src=\"images/tpl_en_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
					$langjp = "<img src=\"images/tpl_jp_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
					$langvn = "<img src=\"images/tpl_vn_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
					
					$sql4 = "select * from flc_page where pag_type = 'prf' and mem_id = '$memid';"; 

					$result4 = mysql_query($sql4);
					while ($dbarr4 = mysql_fetch_array($result4)) {
						
						$pagid = $dbarr4['pag_id'];
						$pagshowen = $dbarr4['pag_show_en'];
						$pagshowjp = $dbarr4['pag_show_jp'];
						$pagshowvn = $dbarr4['pag_show_vn'];
						
						if ($pagshowen == 't') {
							$langen = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=en\" target=\"_blank\"><img src=\"images/tpl_en_01.png\" alt=\"English\" width=\"24\" height=\"24\" border=\"0\" /></a>";
						}
						
						if ($pagshowjp == 't') {
							$langjp = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=jp\" target=\"_blank\"><img src=\"images/tpl_jp_01.png\" alt=\"日本語\" width=\"24\" height=\"24\" border=\"0\" /></a>";
						}
						
						if ($pagshowvn == 't') {
							$langvn = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=vn\" target=\"_blank\"><img src=\"images/tpl_vn_01.png\" alt=\"Việt Nam\" width=\"24\" height=\"24\" border=\"0\" /></a>";
						}
					
					}
					
					$langarr = array();
					if ($pagshowjp == 't') { $langarr[0] = "jp"; } else { $langarr[0] = ""; }
					if ($pagshowvn == 't') { $langarr[1] = "vn"; } else { $langarr[1] = ""; }
					if ($pagshowen == 't') { $langarr[2] = "en"; } else { $langarr[2] = ""; }
					
					for ($i=0;$i<=2;$i++) { 
						if ($langarr[$i] != '') { $langset = $langarr[$i]; }
						if ($langset == $lang) { $i = $i + 3; } 
					}
					
					if ($langset != '') {
						$memcomname = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=".$langset."\" target=\"_blank\">".$memcomname."</a>";
					} 
					
					$resulttable = $resulttable."<tr><td valign=\"top\"><table width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
					<td width=\"10\" valign=\"top\" bgcolor=\"#CCCCCC\">&nbsp;</td>
					<td width=\"10\" valign=\"top\">&nbsp;</td>
					<td width=\"790\" valign=\"top\"><table width=\"790\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					  <tr>
						<td><img src=\"images/blank.png\" width=\"540\" height=\"5\" /></td>
					  </tr>
					  <tr>
						<td><span class=\"default_head\">".$memcomname."</span> <br />
						  ".$memsubdesc."</td>
					  </tr>
					  <tr>
						<td><img src=\"images/blank.png\" width=\"540\" height=\"10\" /></td>
					  </tr>
					  <tr>
						<td>".$langjp." ".$langvn." ".$langen."</td>
					  </tr>
					</table></td>
				  </tr>
				  <tr>
					<td colspan=\"3\" valign=\"top\"><img src=\"images/line_body_01.png\" width=\"800\" height=\"20\" /></td></tr></table></td></tr>";
					
				} 
			
			}
					
			$resulttable = substr($resulttable,0,-62);
			$resulttable = $resulttable."02.png\" width=\"800\" height=\"20\" /></td></tr></table></td></tr>";
		
		}
	} else {

		$pagesql = $_SESSION['vsearch_list']."and mem_status != 'd';";
	
	
		$resultsearchlist = mysql_query($pagesql);
		$cntsearchlist = mysql_num_rows($resultsearchlist); 
		
		if ($cntsearchlist == 0 || $start > $cntsearchlist) { $resulttable = "<tr><td valign=\"top\"><div align=\"center\"><br><br>".$lb_searchfail."<br><br></div></td></tr>"; }

		else {
		
			$page = pagecal($limit, $start, $pagesql, "search_result.php", "");
			
			$sqlbasic = $_SESSION['vsearch_list']."and mem_package != '' and mem_status != 'd';"; 
			$resultbasic = mysql_query($sqlbasic);
			$cntallbasic = mysql_num_rows($resultbasic); 
			
			$sql0 = $_SESSION['vsearch_list']."and mem_package != '' and mem_status != 'd' limit $start,$limit;"; 
			$result0 = mysql_query($sql0);
			$cntbasic = mysql_num_rows($result0); 
			
			if ($cntbasic <= $limit) { $cntfree = $limit - $cntbasic; $limitbasic = $cntbasic; $startbasic = $start; }
			else { $cntfree = 0; $limitbasic = $limit; $startbasic = $start; }
			
			$sql1 = $_SESSION['vsearch_list']."and mem_package != '' and mem_status != 'd' order by mem_sort asc limit $startbasic,$limitbasic;"; 
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {
				
				$memid = $dbarr1['mem_id'];
				$mem_addressine1 = $dbarr1['mem_addressine1'];
				$mem_addressine2 = $dbarr1['mem_addressine2'];
				
				if ($lang == 'en') { $memcomname = $dbarr1['mem_comname_en']; $memsubdesc = $dbarr1['mem_subdesc_en']; }
				else if ($lang == 'vn') { $memcomname = $dbarr1['mem_comname_vn']; $memsubdesc = $dbarr1['mem_subdesc_vn']; }
				else { $memcomname = $dbarr1['mem_comname_jp']; $memsubdesc = $dbarr1['mem_subdesc_jp']; }
				
				$pagshowen = ""; $pagshowjp = ""; $pagshowvn = ""; $langset = ""; 
				$langen = "<img src=\"images/tpl_en_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
				$langjp = "<img src=\"images/tpl_jp_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
				$langvn = "<img src=\"images/tpl_vn_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
				
				$sql2 = "select * from flc_page where pag_type = 'prf' and mem_id = '$memid';"; 
				$result2 = mysql_query($sql2);
				while ($dbarr2 = mysql_fetch_array($result2)) {
					
					$pagid = $dbarr2['pag_id'];
					$pagshowen = $dbarr2['pag_show_en'];
					$pagshowjp = $dbarr2['pag_show_jp'];
					$pagshowvn = $dbarr2['pag_show_vn'];
					
					if ($pagshowen == 't') { $langen = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=en\" target=\"_blank\"><img src=\"images/tpl_en_01.png\" alt=\"English\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
							
					if ($pagshowjp == 't') { $langjp = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=jp\" target=\"_blank\"><img src=\"images/tpl_jp_01.png\" alt=\"日本語\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
								
					if ($pagshowvn == 't') { $langvn = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=vn\" target=\"_blank\"><img src=\"images/tpl_vn_01.png\" alt=\"Việt Nam\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
							
				}
				
				$langarr = array();
				if ($pagshowjp == 't') { $langarr[0] = "jp"; } else { $langarr[0] = ""; }
				if ($pagshowvn == 't') { $langarr[1] = "vn"; } else { $langarr[1] = ""; }
				if ($pagshowen == 't') { $langarr[2] = "en"; } else { $langarr[2] = ""; }
				
				for ($i=0;$i<=2;$i++) { 
					if ($langarr[$i] != '') { $langset = $langarr[$i]; }
					if ($langset == $lang) { $i = $i + 3; } 
				}
				
				// start display sector name on table flc_ie
						$sql_ie_sector="SELECT * FROM  flc_ie WHERE flc_ie.ine_id='$mem_addressine1'";
						$query_ie=mysql_query($sql_ie_sector);
						while($fetch_ie=mysql_fetch_array($query_ie)){
							$sector=$fetch_ie['sector'];
							
							if($sector=='north'){$img_sector="&nbsp;&nbsp;<img src=\"images/sector/north_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}
							if($sector=='south'){$img_sector="&nbsp;&nbsp;<img src=\"images/sector/south_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}	
							if($sector=='central'){$img_sector="&nbsp;&nbsp;<img src=\"images/sector/central_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}
							if($sector!='north' && $sector!='south' && $sector!='central' || $sector=='' ){$img_sector="&nbsp;&nbsp;<img src=\"images/sector/other_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}
							$tpl->assign("##img_sector##", $img_sector);
							}
						if($mem_addressine2!=""){
							
						   $sql_ie_sector="SELECT * FROM  flc_ie WHERE flc_ie.ine_id='$mem_addressine2'";
						$query_ie=mysql_query($sql_ie_sector);
						while($fetch_ie=mysql_fetch_array($query_ie)){
							$sector2=$fetch_ie['sector'];
							
							if($sector2=='north'){$img_sector2="&nbsp;&nbsp;<img src=\"images/sector/north_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}
							if($sector2=='south'){$img_sector2="&nbsp;&nbsp;<img src=\"images/sector/south_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}	
							if($sector2=='central'){$img_sector2="&nbsp;&nbsp;<img src=\"images/sector/central_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}
							if($sector2!='north' && $sector2!='south' && $sector2!='central' || $sector2=='' ){$img_sector2="&nbsp;&nbsp;<img src=\"images/sector/other_".$lang.".png\" width=\"72\" height=\"24\" border=\"0\" />";}
							//$tpl->assign("##img_sector2##", $img_sector2);
						   }
						}else{$tpl->assign("##img_sector2##", "");}	
							
					   // END display sector name on table flc_ie
				if ($langset != '') { $memcomname = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=".$langset."\" target=\"_blank\">".$memcomname."</a>"; } 
				
					$resulttable = $resulttable."<tr><td valign=\"top\"><table width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
					<td width=\"10\" valign=\"top\" bgcolor=\"#CC0000\">&nbsp;</td>
					<td width=\"10\" valign=\"top\" bgcolor=\"#FFDDDD\">&nbsp;</td>
					<td width=\"790\" valign=\"top\" bgcolor=\"#FFDDDD\"><table width=\"790\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					  <tr>
						<td><img src=\"images/blank.png\" width=\"540\" height=\"5\" /></td>
					  </tr>
					  <tr>
						<td><span class=\"default_head\">".$memcomname."</span> <br />
						  ".$memsubdesc."</td>
					  </tr>
					  <tr>
						<td><img src=\"images/blank.png\" width=\"540\" height=\"10\" /></td>
					  </tr>
					  <tr>
						<td>".$langjp." ".$langvn." ".$langen."&nbsp;".$img_sector."&nbsp;".$img_sector2."</td>
					  </tr>
					</table></td>
				  </tr>
				  <tr>
					<td colspan=\"3\" valign=\"top\"><img src=\"images/line_body_01.png\" width=\"800\" height=\"20\" /></td></tr></table></td></tr>";
				
			} 	
			
			if ($cntfree > 0) {
			
				if ($start == 0) { $startfree = $start; } else { $startfree = $start - $cntallbasic; }
				$limitfree = $limit - $cntbasic;
				
				$sql3 = $_SESSION['vsearch_list']."and mem_package = '' and mem_status != 'd' order by mem_id asc limit $startfree,$limitfree;";
				
				$result3 = mysql_query($sql3);
				while ($dbarr3 = mysql_fetch_array($result3)) {
					
					$memid = $dbarr3['mem_id'];
					
					if ($lang == 'en') { $memcomname = $dbarr3['mem_comname_en']; $memsubdesc = $dbarr3['mem_subdesc_en']; }
					else if ($lang == 'vn') { $memcomname = $dbarr3['mem_comname_vn']; $memsubdesc = $dbarr3['mem_subdesc_vn']; }
					else { $memcomname = $dbarr3['mem_comname_jp']; $memsubdesc = $dbarr3['mem_subdesc_jp']; }
					
					$pagshowen = ""; $pagshowjp = ""; $pagshowvn = ""; $langset = ""; 
					$langen = "<img src=\"images/tpl_en_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
					$langjp = "<img src=\"images/tpl_jp_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
					$langvn = "<img src=\"images/tpl_vn_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
					
					$sql4 = "select * from flc_page where pag_type = 'prf' and mem_id = '$memid';"; 

					$result4 = mysql_query($sql4);
					while ($dbarr4 = mysql_fetch_array($result4)) {
						
						$pagid = $dbarr4['pag_id'];
						$pagshowen = $dbarr4['pag_show_en'];
						$pagshowjp = $dbarr4['pag_show_jp'];
						$pagshowvn = $dbarr4['pag_show_vn'];
						
						if ($pagshowen == 't') { $langen = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=en\" target=\"_blank\"><img src=\"images/tpl_en_01.png\" alt=\"English\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
						
						if ($pagshowjp == 't') { $langjp = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=jp\" target=\"_blank\"><img src=\"images/tpl_jp_01.png\" alt=\"日本語\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
						
						if ($pagshowvn == 't') { $langvn = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=vn\" target=\"_blank\"><img src=\"images/tpl_vn_01.png\" alt=\"Việt Nam\" width=\"24\" height=\"24\" border=\"0\" /></a>"; }
					
					}
					
					$langarr = array();
					if ($pagshowjp == 't') { $langarr[0] = "jp"; } else { $langarr[0] = ""; }
					if ($pagshowvn == 't') { $langarr[1] = "vn"; } else { $langarr[1] = ""; }
					if ($pagshowen == 't') { $langarr[2] = "en"; } else { $langarr[2] = ""; }
					
					for ($i=0;$i<=2;$i++) { 
						if ($langarr[$i] != '') { $langset = $langarr[$i]; }
						if ($langset == $lang) { $i = $i + 3; } 
					}
					
					if ($langset != '') { $memcomname = "<a href=\"mem_profile.php?id=".$memid."&page=".$pagid."&lang=".$langset."\" target=\"_blank\">".$memcomname."</a>"; } 
					
						$resulttable = $resulttable."<tr><td valign=\"top\"><table width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
					  <tr>
						<td width=\"10\" valign=\"top\" bgcolor=\"#CCCCCC\">&nbsp;</td>
						<td width=\"10\" valign=\"top\">&nbsp;</td>
						<td width=\"790\" valign=\"top\"><table width=\"790\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
						  <tr>
							<td><img src=\"images/blank.png\" width=\"540\" height=\"5\" /></td>
						  </tr>
						  <tr>
							<td><span class=\"default_head\">".$memcomname."</span> <br />
							  ".$memsubdesc."</td>
						  </tr>
						  <tr>
							<td><img src=\"images/blank.png\" width=\"540\" height=\"10\" /></td>
						  </tr>
						  <tr>
							<td>".$langjp." ".$langvn." ".$langen."</td>
						  </tr>
						</table></td>
					  </tr>
					  <tr>
						<td colspan=\"3\" valign=\"top\"><img src=\"images/line_body_01.png\" width=\"800\" height=\"20\" /></td></tr></table></td></tr>";
					
				} 
			
			}
			
			$resulttable = substr($resulttable,0,-62);
			$resulttable = $resulttable."02.png\" width=\"800\" height=\"20\" /></td></tr></table></td></tr>";
		
		}
	}
	
	// End By ThuanDo
	// Temp announcement2
	
	if ($lang == 'en') {
		$announcetext2 = "<p>Search for factories and businesses</p>";
	} else if ($lang == 'vn') {
		$announcetext2 = "<p>Search for factories and businesses</p>";
	} else { $announcetext2 = "<p>工場・企業の検索</p>"; }
	
	if ($announcetext2 != '') {
		$announce2 = "<tr>
		<td valign=\"top\" class=\"grey_s\">".$announcetext2."</td>
	  </tr>";
	} else { $announce2 = ""; }
	
	$tpl->assign("##announce2##", $announce2);
	//
	// Temp Link Foooter
	
	if ($lang == 'en') {
		$Linktext = "<p class=\"linkfooter\"><a href=\"http://www.fact-link.com.vn/\" target=\"_blank\">Fact-Link Viet Nam is here</a></p>";
	} else if ($lang == 'vn') {
		$Linktext = "<p class=\"linkfooter\"><a href=\"http://www.fact-link.com.vn/\" target=\"_blank\">Fact-Link Viet Nam is here</a></p>";
	} else { $Linktext = "<p class=\"linkfooter\"><a href=\"http://www.fact-link.com.vn/\" target=\"_blank\">ファクトリンク ベトナムはこちら</a></p>"; }
	
	if ($Linktext != '') {
		$LinkF = "<tr>
		<td valign=\"top\" class=\"grey_s\">".$Linktext."</td>
	  </tr>";
	} else { $LinkF = ""; }
	
	
	$tpl->assign("##LinkF##", $LinkF);
	//
	
	// Temp Link Foooter2	
	if ($lang == 'en') {
		$Linktext2 = "<p class=\"linkfooter\"><a href=\"http://www.fact-link.com.vn/\" target=\"_blank\">Fact-Link Indonesia is here</a></p>";
	} else if ($lang == 'vn') {
		$Linktext2 = "<p class=\"linkfooter\"><a href=\"http://www.fact-link.com.vn/\" target=\"_blank\">Fact-Link Indonesia is here</a></p>";
	} else { $Linktext2 = "<p class=\"linkfooter\"><a href=\"http://www.fact-link.com.vn/\" target=\"_blank\">ファクトリンク インドネシアはこちら</a></p>"; }
	
	if ($Linktext2 != '') {
		$LinkF2 = "<tr>
		<td valign=\"top\" class=\"grey_s\">".$Linktext2."</td>
	  </tr>";
	} else { $LinkF2 = ""; }
	
	$tpl->assign("##LinkF2##", $LinkF2);
	//
	
	// Temp Link Foooter3	
	if ($lang == 'en') {
		$Linktext3 = "<p class=\"linkfooter\"><a href=\"http://www.fact-link.com.vn/\" target=\"_blank\">Thailand real estate information is here.</a></p>";
	} else if ($lang == 'vn') {
		$Linktext3 = "<p class=\"linkfooter\"><a href=\"http://www.fact-link.com.vn/\" target=\"_blank\">Thailand real estate information is here.</a></p>";
	} else { $Linktext3 = "<p class=\"linkfooter\"><a href=\"http://www.fact-link.com.vn/\" target=\"_blank\">タイの不動産情報はこちら</a></p>"; }
	
	if ($Linktext3 != '') {
		$LinkF3 = "<tr>
		<td valign=\"top\" class=\"grey_s\">".$Linktext3."</td>
	  </tr>";
	} else { $LinkF3 = ""; }
	
	$tpl->assign("##LinkF3##", $LinkF3);
	//
	// Temp SearchMenubar1
	if ($lang == 'en') {
		$SearchMenubartext1 = "<div class=\"dropdown-head\"><button type=\"button\" onclick=\"dt('#dropdown-category');\"><span lang=\"en\">Search by Category</span></button></div>";
	} else if ($lang == 'vn') {
		$SearchMenubartext1 = "<div class=\"dropdown-head\"><button type=\"button\" onclick=\"dt('#dropdown-category');\"><span lang=\"en\">Search by Category</span></button></div>";
	} else { $SearchMenubartext1 = "<div class=\"dropdown-head\"><button type=\"button\" onclick=\"dt('#dropdown-category');\"><span lang=\"en\">業種から探す</span></button></div>"; }
	
	if ($SearchMenubartext1 != '') {
		$SearchMenubar1 = "<tr>
		<td valign=\"top\" class=\"grey_s\">".$SearchMenubartext1."</td>
	  </tr>";
	} else { $SearchMenubar1 = ""; }
	
	$tpl->assign("##SearchMenubar1##", $SearchMenubar1);
	//

	// Temp SearchMenubarProduct
	if ($lang == 'en') {
		$SearchMenubarProductText = "<div class=\"dropdown-head\"><button type=\"button\" onclick=\"dt('#dropdown-product');\"><span lang=\"en\">Search by Product</span></button></div>";
	} else if ($lang == 'vn') {
		$SearchMenubarProductText = "<div class=\"dropdown-head\"><button type=\"button\" onclick=\"dt('#dropdown-product');\"><span lang=\"en\">Search by Product</span></button></div>";
	} else { $SearchMenubarProductText = "<div class=\"dropdown-head\"><button type=\"button\" onclick=\"dt('#dropdown-product');\"><span lang=\"en\">製品から探す</span></button></div>"; }
	
	if ($SearchMenubarProductText != '') {
		$SearchMenubarProduct = "<tr>
		<td valign=\"top\" class=\"grey_s\">".$SearchMenubarProductText."</td>
	  </tr>";
	} else { $SearchMenubarProduct = ""; }
	
	$tpl->assign("##SearchMenubarProduct##", $SearchMenubarProduct);
	
	// Temp SearchMenubar2
	if ($lang == 'en') {
		$SearchMenubartext2 = "<div class=\"dropdown-head\"><button type=\"button\" onclick=\"dt('#dropdown-ie');\"><span lang=\"en\">Search by I.E.</span></button></div>";
	} else if ($lang == 'vn') {
		$SearchMenubartext2 = "<div class=\"dropdown-head\"><button type=\"button\" onclick=\"dt('#dropdown-ie');\"><span lang=\"en\">Search by I.E.</span></button></div>";
	} else { $SearchMenubartext2 = "<div class=\"dropdown-head\"><button type=\"button\" onclick=\"dt('#dropdown-ie');\"><span lang=\"en\">工業団地から探す</span></button></div>"; }
	
	if ($SearchMenubartext2 != '') {
		$SearchMenubar2 = "<tr>
		<td valign=\"top\" class=\"grey_s\">".$SearchMenubartext2."</td>
	  </tr>";
	} else { $SearchMenubar2 = ""; }
		
	$tpl->assign("##SearchMenubar2##", $SearchMenubar2);
	//
	// Temp SearchMenubar3
	if ($lang == 'en') {
		$SearchMenubartext3 = "<div class=\"dropdown-head\"><button type=\"button\" onclick=\"dt('#dropdown-province');\"><span lang=\"en\">Search by Province</span></button></div>";
	} else if ($lang == 'vn') {
		$SearchMenubartext3 = "<div class=\"dropdown-head\"><button type=\"button\" onclick=\"dt('#dropdown-province');\"><span lang=\"en\">Search by Province</span></button></div>";
	} else { $SearchMenubartext3 = "<div class=\"dropdown-head\"><button type=\"button\" onclick=\"dt('#dropdown-province');\"><span lang=\"en\">県から探す</span></button></div>"; }
	
	if ($SearchMenubartext3 != '') {
		$SearchMenubar3 = "<tr>
		<td valign=\"top\" class=\"grey_s\">".$SearchMenubartext3."</td>
	  </tr>";
	} else { $SearchMenubar3 = ""; }
	
	$tpl->assign("##SearchMenubar3##", $SearchMenubar3);
	//
	// Temp SearchMenubar4
	if ($lang == 'en') {
		$SearchMenubartext4 = "<div class=\"dropdown-head\"><button type=\"button\" onclick=\"dt('#dropdown-country');\"><span lang=\"en\">Search by Country</span></button></div>";
	} else if ($lang == 'vn') {
		$SearchMenubartext4 = "<div class=\"dropdown-head\"><button type=\"button\" onclick=\"dt('#dropdown-country');\"><span lang=\"en\">Search by Country</span></button></div>";
	} else { $SearchMenubartext4 = "<div class=\"dropdown-head\"><button type=\"button\" onclick=\"dt('#dropdown-country');\"><span lang=\"en\">国から探す</span></button></div>"; }
	
	if ($SearchMenubartext4 != '') {
		$SearchMenubar4 = "<tr>
		<td valign=\"top\" class=\"grey_s\">".$SearchMenubartext4."</td>
	  </tr>";
	} else { $SearchMenubar4 = ""; }	
	
	$tpl->assign("##SearchMenubar4##", $SearchMenubar4);
	//
	
	$tpl->assign("##resultword##", $_SESSION['vsearch_word']);
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
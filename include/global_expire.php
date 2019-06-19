<?php

// -- Auto Expire Section --
	
	$sqlexpmem = "select * from flc_member where mem_enddate = '$nowdate';";
	$resultexpmem = mysql_query($sqlexpmem);
	while ($dbarrexpmem = mysql_fetch_array($resultexpmem)) {
		
		$expmemid = $dbarrexpmem['mem_id'];
		$expmemsort = $dbarrexpmem['mem_sort'];
		$expmemcate = $dbarrexpmem['mem_category'];
		
		// Member
		$sqlexpmem8 = "select * from flc_member where mem_category = '$expmemcate' and mem_sort > '$expmemsort' order by mem_sort asc;";
		$resultexpmem8 = mysql_query($sqlexpmem8);
		while ($dbarrexpmem8 = mysql_fetch_array($resultexpmem8)) {
		
			$expupmemid = $dbarrexpmem8['mem_id'];
			$expnewmemsort = $dbarrexpmem8['mem_sort'] - 1; 
				
			$sqlexpmem9 = "update flc_member set mem_sort = '$expnewmemsort' where mem_id = '$expupmemid';";
			$resultexpmem9 = mysql_query($sqlexpmem9);
		
		}
		
		$sqlexpmem1 = "update flc_member set mem_startdate = '', mem_preenddate = '', mem_enddate = '', mem_package = '', mem_expirewarning = '', mem_sort = '0' where mem_id = '$expmemid';";
		$resultexpmem1 = mysql_query($sqlexpmem1);
		
		// Page
		$sqlexpmem2 = "select pag_id from flc_page where mem_id = '$expmemid' and pag_type != 'prf' and pag_type != 'hom';";
		$resultexpmem2 = mysql_query($sqlexpmem2);
		while ($dbarrexpmem2 = mysql_fetch_array($resultexpmem2)) {
		
			$exppagid = $dbarrexpmem2['pag_id'];
			
			$sqlexpmem3 = "update flc_page set pag_status = 'd' where pag_id = '$exppagid';";
			$resultexpmem3 = mysql_query($sqlexpmem3);
		
		}
		
		// Bulletin - Category
		$sqlexpmem4 = "select * from flc_bulletin_cate where mem_id = '$expmemid';";
		$resultexpmem4 = mysql_query($sqlexpmem4);
		while ($dbarrexpmem4 = mysql_fetch_array($resultexpmem4)) { 
			
			$expbucid = $dbarrexpmem4['buc_id']; 
			$expbuccatid = $dbarrexpmem4['cat_id']; 
			$expbucpage = $dbarrexpmem4['buc_page']; 
			$expbucside = $dbarrexpmem4['buc_side']; 
			$expbucsort = $dbarrexpmem4['buc_sort']; 
		
		}
		
		$sqlexpmem5 = "select * from flc_bulletin_cate where cat_id = '$expbuccatid', buc_page = '$expbucpage', buc_side = '$expbucside', buc_sort > '$expbucsort' order by buc_sort asc;";
		$resultexpmem5 = mysql_query($sqlexpmem5);
		while ($dbarrexpmem5 = mysql_fetch_array($resultexpmem5)) {
		
			$expupbucid = $dbarrexpmem5['buc_id'];
			$expnewbucsort = $dbarrexpmem5['buc_sort'] - 1; 
				
			$sqlexpmem6 = "update flc_bulletin_cate set buc_sort = '$expnewbucsort' where buc_id = '$expupbucid';";
			$resultexpmem6 = mysql_query($sqlexpmem6);
		
		}
		
		$sqlexpmem7 = "update flc_bulletin_cate set buc_status = 'd', buc_sort = '0' where mem_id = '$expmemid';";
		$resultexpmem7 = mysql_query($sqlexpmem7);
		
			// mail **
		
	}
	
	$expcurrentdate = date("Y-m-d");
	$sqlexpmem10 = "update flc_contract_hist set cth_status = 'd' where cth_enddate = '$expcurrentdate';";
	$resultexpmem10 = mysql_query($sqlexpmem10);
	
	// Banner
	$sqlexpban = "select ban_id from flc_banner where ban_enddate = '$nowdate';";
	$resultexpban = mysql_query($sqlexpban);
	while ($dbarrexpban = mysql_fetch_array($resultexpban)) {
	
		$expbanid = $dbarrexpban['ban_id'];
		
		$sqlexpban1 = "select * from flc_banner where ban_id = '$expbanid';"; 
		$resultexpban1 = mysql_query($sqlexpban1);
		while ($dbarrexpban1 = mysql_fetch_array($resultexpban1)) { $expbantype = $dbarrexpban1['ban_type']; $expbanpage = $dbarrexpban1['ban_page']; $expbanside = $dbarrexpban1['ban_side']; $expbansort = $dbarrexpban1['ban_sort']; }
		
		if ($expbantype == 'bsc') {
		
			$sqlexpban2 = "select * from flc_banner where ban_type = 'bsc' and ban_page = '$expbanpage' and ban_side = '$expbanside' and ban_sort > '$expbansort' order by ban_sort asc;"; 
			$resultexpban2 = mysql_query($sqlexpban2);
			while ($dbarrexpban2 = mysql_fetch_array($resultexpban2)) { 
				
				$upbanid = $dbarrexpban2['ban_id'];
				$newbansort = $dbarrexpban2['ban_sort'] - 1; 
				
				$sqlexpban3 = "update flc_banner set ban_sort = '$newbansort' where ban_id = '$upbanid';";
				$resultexpban3 = mysql_query($sqlexpban3);
				
			}
		
		}
		
		$sqlexpban4 = "update flc_banner set ban_startdate = '', ban_preenddate = '', ban_enddate = '', ban_package = '', ban_expirewarning = '', ban_sort = '0', ban_status = 'd' where ban_id = '$expbanid';";
		$resultexpban4 = mysql_query($sqlexpban4);
	
	}
	
	// Banner - Category
	$sqlexpbac = "select bac_id from flc_banner_cate where bac_enddate = '$nowdate';";
	$resultexpbac = mysql_query($sqlexpbac);
	while ($dbarrexpbac = mysql_fetch_array($resultexpbac)) {
	
		$expbacid = $dbarrexpbac['bac_id'];
		
		$sqlexpbac1 = "select * from flc_banner_cate where bac_id = '$expbacid';"; 
		$resultexpbac1 = mysql_query($sqlexpbac1);
		while ($dbarrexpbac1 = mysql_fetch_array($resultexpbac1)) { $expbactype = $dbarrexpbac1['bac_type']; $expbacpage = $dbarrexpbac1['bac_page']; $expbacsort = $dbarrexpbac1['bac_sort']; $expbaccatid = $dbarrexpbac1['cat_id']; }
		
		if ($expbactype == 'bsc') { //*** Add for VN only - Jun 2013 ***
		
			$sqlexpbac2 = "select * from flc_banner_cate where bac_type = 'bsc' and cat_id = '$expbaccatid' and bac_sort > '$expbacsort' order by bac_sort asc;"; 
			$resultexpbac2 = mysql_query($sqlexpbac2);
			while ($dbarrexpbac2 = mysql_fetch_array($resultexpbac2)) { 
				
				$upbacid = $dbarrexpbac2['bac_id'];
				$newbacsort = $dbarrexpbac2['bac_sort'] - 1; 
				
				$sqlexpbac3 = "update flc_banner_cate set bac_sort = '$newbacsort' where bac_id = '$upbacid';";
				$resultexpbac3 = mysql_query($sqlexpbac3);
				
			}
		
		}
		
		$sqlexpbac4 = "update flc_banner_cate set bac_startdate = '', bac_preenddate = '', bac_enddate = '', bac_package = '', bac_expirewarning = '', bac_sort = '0', bac_status = 'd' where bac_id = '$expbacid';";
		$resultexpbac4 = mysql_query($sqlexpbac4);
	
	}
	
// -- Auto Pre-Expire Warning Section --
	
	$sqlpremem = "select mem_id from flc_member where mem_preenddate = '$nowdate';";
	$resultpremem = mysql_query($sqlpremem);
	while ($dbarrpremem = mysql_fetch_array($resultpremem)) {
	
		$prememid = $dbarrpremem['mem_id'];
		
		// Member
		$sqlpremem1 = "update flc_member set mem_expirewarning = 't' where mem_id = '$prememid';";
		$resultpremem1 = mysql_query($sqlpremem1);
		
			// mail **
	}
	
	// Banner
	
	$sqlpreban = "select ban_id from flc_banner where ban_preenddate = '$nowdate';";
	$resultpreban = mysql_query($sqlpreban);
	while ($dbarrpreban = mysql_fetch_array($resultpreban)) {
	
		$prebanid = $dbarrpreban['ban_id'];
		
		$sqlpreban1 = "update flc_banner set ban_expirewarning = 't' where ban_id = '$prebanid';";
		$resultpreban1 = mysql_query($sqlpreban1);
	
	}
	
	// Banner Category
	
	$sqlprebac = "select bac_id from flc_banner_cate where bac_preenddate = '$nowdate';";
	$resultprebac = mysql_query($sqlprebac);
	while ($dbarrprebac = mysql_fetch_array($resultprebac)) {
	
		$prebacid = $dbarrprebac['bac_id'];
		
		$sqlprebac1 = "update flc_banner_cate set bac_expirewarning = 't' where bac_id = '$prebacid';";
		$resultprebac1 = mysql_query($sqlprebac1);
	
	}
	
	// Inquiry
	
	$sqlwarninq = "select mal_id from flc_mail where mal_warningdate = '$nowdate';";
	$resultwarninq = mysql_query($sqlwarninq);
	while ($dbarrwarninq = mysql_fetch_array($resultwarninq)) {
	
		$warninqid = $dbarrwarninq['mal_id'];
		
		$sqlwarninq1 = "update flc_mail set mal_warning = 't' where mal_id = '$warninqid';";
		$resultwarninq1 = mysql_query($sqlwarninq1);
	
	}
	
// -- Auto Update Section --
		
		$sqlupdate = "select * from flc_update where upd_id = '1';";
		$resultupdate = mysql_query($sqlupdate);
		while ($dbarrupdate = mysql_fetch_array($resultupdate)) { $upddate = $dbarrupdate['upd_date']; }
		
		if ($upddate != $nowdate) {
			
			$sqlpospage = "select * from flc_pospage order by psp_id asc;";
			$resultpospage = mysql_query($sqlpospage);
			while ($dbarrpospage = mysql_fetch_array($resultpospage)) {
			
				$pospagecode = $dbarrpospage['psp_code'];
			
				// Basic Banner - all page r
				$sqlbscloopr = "select * from flc_banner where ban_sort != '0' and ban_type = 'bsc' and ban_page = '$pospagecode' and ban_side = 'r' order by ban_sort asc;"; // add ban_side to solve loop problem 2012.10.27
				$resultbscloopr = mysql_query($sqlbscloopr);
				$cntbscloopr = mysql_num_rows($resultbscloopr);
				while ($dbarrbscloopr = mysql_fetch_array($resultbscloopr)) {
				
					$newbsclooprid = $dbarrbscloopr['ban_id'];
					$newbsclooprsort = $dbarrbscloopr['ban_sort'] + 1;
					if ($newbsclooprsort > $cntbscloopr) { $newbsclooprsort = 1; }
					
					$sqlbscloopr1 = "update flc_banner set ban_sort = '$newbsclooprsort' where ban_id = '$newbsclooprid';";
					$resultbscloopr1 = mysql_query($sqlbscloopr1);
					
				}
				
				// Basic Banner - all page l
				$sqlbscloopl = "select * from flc_banner where ban_sort != '0' and ban_type = 'bsc' and ban_page = '$pospagecode' and ban_side = 'l' order by ban_sort asc;"; // add ban_side to solve loop problem 2012.10.27
				$resultbscloopl = mysql_query($sqlbscloopl);
				$cntbscloopl = mysql_num_rows($resultbscloopl);
				while ($dbarrbscloopl = mysql_fetch_array($resultbscloopl)) {
				
					$newbsclooplid = $dbarrbscloopl['ban_id'];
					$newbsclooplsort = $dbarrbscloopl['ban_sort'] + 1;
					if ($newbsclooplsort > $cntbscloopl) { $newbsclooplsort = 1; }
					
					$sqlbscloopl1 = "update flc_banner set ban_sort = '$newbsclooplsort' where ban_id = '$newbsclooplid';";
					$resultbscloopl1 = mysql_query($sqlbscloopl1);
					
				}
				
			}
			
			// Bulletin - Category
			$sqlbucloop2 = "select * from flc_category order by cat_id asc;";
			$resultbucloop2 = mysql_query($sqlbucloop2);
			while ($dbarrbucloop2 = mysql_fetch_array($resultbucloop2)) {
			
				$bucloopcatid = $dbarrbucloop2['cat_id'];
				
				$sqlbucloop = "select * from flc_bulletin_cate where cat_id = '$bucloopcatid' and buc_sort != '0' and buc_page = 'sch' and buc_side = 'r' order by buc_sort asc;";
				$resultbucloop = mysql_query($sqlbucloop);
				$cntbucloop = mysql_num_rows($resultbucloop);
				while ($dbarrbucloop = mysql_fetch_array($resultbucloop)) {
				
					$newbucloopid = $dbarrbucloop['buc_id'];
					$newbucloopsort = $dbarrbucloop['buc_sort'] + 1;
					if ($newbucloopsort > $cntbucloop) { $newbucloopsort = 1; }
					
					$sqlbucloop1 = "update flc_bulletin_cate set buc_sort = '$newbucloopsort' where buc_id = '$newbucloopid';";
					$resultbucloop1 = mysql_query($sqlbucloop1);
					
				}
				
			}
			
			// Update Log
			$sqlupdate1 = "update flc_update set upd_date = '$nowdate' where upd_id = '1';";
			$resultupdate1 = mysql_query($sqlupdate1);
		
		} 
				
	// -----------------------------------

?>
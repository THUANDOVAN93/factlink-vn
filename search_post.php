<?php
	session_start();
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	
	$h_type = $_POST['h_type'];
	$t_searchcomname = $_POST['t_searchcomname'];
	$t_searchkeyword = $_POST['t_searchkeyword'];
	
	$type = $_GET['type'];
	$searchid = $_GET['id'];
	$t_search_op = $_POST['t_search_op'];
	
	$_SESSION['vsearch_cateid'] = "";
	
	if ($h_type == 'word') {
		
		if ($t_searchcomname == '' && $t_searchkeyword == '') { 
			$sql = "select * from flc_member where mem_id = '' "; 
			$_SESSION['vsearch_list'] = $sql;
			$_SESSION['vsearch_word'] = ""; 
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = search_result.php?start=0\">"; 
			exit();
		} else {
			$sql = "select * from flc_member where ";
		}
		
		if ($t_searchcomname != '') {

			if ($t_search_op == 'company') {
				$sql = "select * from flc_member where ";
				$sql = $sql."(mem_comname_en like '%$t_searchcomname%' or ";
				$sql = $sql."mem_comname_jp like '%$t_searchcomname%' or ";
				$sql = $sql."mem_comname_vn like '%$t_searchcomname%' or ";
				$sql = $sql."mem_comname_aka like '%$t_searchcomname%') and ";				
			}

			if ($t_search_op == 'product') {
				$sql = "select p.*, m.mem_folder, m.mem_comname_en, m.mem_comname_jp, m.mem_comname_vn from flc_products p, flc_member m where p.SupplierID = m.mem_id and ";
				$sql = $sql."(p.ProductNameEN like '%$t_searchcomname%' or ";
				$sql = $sql."p.ProductNameJP like '%$t_searchcomname%' or ";
				$sql = $sql."p.ProductNameVN like '%$t_searchcomname%') ";
			}

			$searchword = $searchcom.$t_searchcomname." / ";
		
		} 
		
		if ($t_searchkeyword != '') {
						
			$t_searchkeyword = str_replace(", ", " ", $t_searchkeyword);
			$t_searchkeyword = str_replace(",", " ", $t_searchkeyword);
			$t_searchkeyword = str_replace("、", " ", $t_searchkeyword);
			$t_searchkeyword = str_replace("　", " ", $t_searchkeyword);
			
			$sql = $sql."(";
			
			$word2 = explode(" ",$t_searchkeyword);
			$cnt2 = count($word2);
				for ($i = 0; $i < $cnt2; $i++) {
					$sql = $sql."(mem_seokeyword like '%$word2[$i]%' or ";
					//$sql = $sql."mem_seocomdesc like '%$word2[$i]%' or ";
					$sql = $sql."mem_product_en like '%$word2[$i]%' or mem_product_jp like '%$word2[$i]%' or mem_product_vn like '%$word2[$i]%' or ";
					$sql = $sql."mem_business_en like '%$word2[$i]%' or mem_business_jp like '%$word2[$i]%' or mem_business_vn like '%$word2[$i]%' or ";
					$sql = $sql."mem_address1_en like '%$word2[$i]%' or mem_address1_jp like '%$word2[$i]%' or mem_address1_vn like '%$word2[$i]%') and ";
				}
			
			$sql = substr($sql,0,-5);
			$sql = $sql.") ";
			
			$searchword = $searchword.$searchkey.$t_searchkeyword." / ";
		
		} else {
			$sql = substr($sql,0,-5);
		}
		
		$searchword = substr($searchword,0,-3);
		$_SESSION['vsearch_word'] = $searchword;
	
	} else {
	
		if ($type == 'cate') {
			
			$sql = "select * from flc_member where mem_category like '%$searchid%' ";
			$_SESSION['vsearch_cateid'] = $searchid;
			
			$sql1 = "select * from flc_category where cat_id = '$searchid';"; 
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {
				$searchen = str_replace("@"," - ",$dbarr1['cat_name_en']);
				$searchjp = str_replace("@"," - ",$dbarr1['cat_name_jp']);
				$searchvn = str_replace("@"," - ",$dbarr1['cat_name_vn']);
			}
			
		} elseif ($type == 'ie') {
		
			$sql = "select * from flc_member where (mem_addressine1 = '$searchid' or ";
			$sql = $sql."mem_addressine2 = '$searchid' or ";
			$sql = $sql."mem_addressine3 = '$searchid' or ";
			$sql = $sql."mem_addressine4 = '$searchid' or ";
			$sql = $sql."mem_addressine5 = '$searchid') ";
			
			$sql1 = "select * from flc_ie where ine_id = '$searchid';"; 
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {
				$searchen = $dbarr1['ine_name_en'];
				$searchjp = $dbarr1['ine_name_jp'];
				$searchvn = $dbarr1['ine_name_vn'];
			}
		
		} elseif ($type == 'prov') {
		
			$sql = "select * from flc_member where (mem_addressprv1 = '$searchid' or ";
			$sql = $sql."mem_addressprv2 = '$searchid' or ";
			$sql = $sql."mem_addressprv3 = '$searchid' or ";
			$sql = $sql."mem_addressprv4 = '$searchid' or ";
			$sql = $sql."mem_addressprv5 = '$searchid') ";
			
			$sql1 = "select * from flc_province where prv_id = '$searchid';"; 
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {
				$searchen = $dbarr1['prv_name_en'];
				$searchjp = $dbarr1['prv_name_jp'];
				$searchvn = $dbarr1['prv_name_vn'];
			}
		
		} elseif ($type == 'ctry') {
		
			$sql1 = "select * from flc_country where cty_id = '$searchid';"; 
			$result1 = mysql_query($sql1);
			while ($dbarr1 = mysql_fetch_array($result1)) {
				$searchen = $dbarr1['cty_name_en'];
				$searchjp = $dbarr1['cty_name_jp'];
				$searchvn = $dbarr1['cty_name_vn'];
			}
			
			$sql = "select * from flc_member where (mem_addresscty1 = '$searchid') ";
		
		} else {

			echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=6\">";
			exit();

		}
		
		if ($_COOKIE['vlang'] == 'en') {

			$searchtitle = $searchen;

		} elseif ($_COOKIE['vlang'] == 'vn') {

			$searchtitle = $searchvn;

		} else {

			$searchtitle = $searchjp;
		}
		
		$_SESSION['vsearch_word'] = $searchtitle;
			
	}
	
	$_SESSION['vsearch_key'] = $t_searchcomname;
	$_SESSION['vsearch_list'] = $sql;
	$_SESSION['vsearch_type'] = $type;
	$_SESSION['vsearch_option'] = $t_search_op;
	
	echo "<meta http-equiv = \"refresh\" content = \"0;URL = search_result.php?start=0\">";
	exit();
?>
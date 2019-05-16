<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	
	mysql_query("use $db_name;");
	
	$inrid = $_GET['id'];
	
	// --- Global Template Section	
	
	
	
	$sqlusl0 = "delete from flc_mail where mal_id = '$inrid';"; 
	$resultusl0 = mysql_query($sqlusl0);

	//$allow[] = 'https://www.fact-link.com.vn/contact_supplier.php';
	$detectRedirect[] = 'https://www.factlinkvn.com/adm_mail_products_manager.php';
	
	if($resultusl0){
		
		if(!in_array($_SERVER["HTTP_REFERER"],$detectRedirect)) {

			echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_mail_products_manager.php\">";
			exit();
			
		}
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_index.php\">"; exit();
	}else {
	
		echo"<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit();
	}
	
?>
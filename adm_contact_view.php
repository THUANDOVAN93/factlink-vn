<?php
	ini_set("session.gc_maxlifetime", "18000");
	session_start();

	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }

	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	$url1 = "adm_structure.html";
	$url2 = "adm_contact_view.html";

	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));

	mysql_query("use $db_name;");

	$cttid = $_GET['id'];

	// --- Global Template Section
	include_once("./include/global_admvalue.php");

	// --- Check Use Log

	$currentuserid = $_SESSION['vd'];

	$sqlusl1 = "delete from flc_uselog where usl_userid = '$currentuserid';";
	$resultusl1 = mysql_query($sqlusl1);

	// --------------------

	$sql1 = "select * from flc_contact where ctt_id = '$cttid';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {

		$cttsubject = html($dbarr1['ctt_subject']);
		$cttdetail = html($dbarr1['ctt_detail']);
		$cttcontact = html($dbarr1['ctt_contact']);
		$cttcompany = html($dbarr1['ctt_company']);
		$ctttel = html($dbarr1['ctt_tel']);
		$cttmobile = html($dbarr1['ctt_mobile']);
		$cttfax = html($dbarr1['ctt_fax']);
		$cttmail = html($dbarr1['ctt_mail']);
		$cttdate = html($dbarr1['ctt_date']);
		$ctttime = html($dbarr1['ctt_time']); 

	}

	$tpl->assign("##cttid##", $cttid);
	$tpl->assign("##cttsubject##", $cttsubject);
	$tpl->assign("##cttdetail##", $cttdetail);
	$tpl->assign("##cttcontact##", $cttcontact);
	$tpl->assign("##cttcompany##", $cttcompany);
	$tpl->assign("##ctttel##", $ctttel);
	$tpl->assign("##cttmobile##", $cttmobile);
	$tpl->assign("##cttfax##", $cttfax);
	$tpl->assign("##cttmail##", $cttmail);
	$tpl->assign("##cttdate##", $cttdate);
	$tpl->assign("##ctttime##", $ctttime);

	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>

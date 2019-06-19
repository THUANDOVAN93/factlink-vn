<?php
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	
	$magid = $_GET['id'];
	
	$sql1 = "select * from flc_magazine where mag_id = '$magid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		$magsubject = $dbarr1['mag_subject']; 
		$magdetail = html($dbarr1['mag_detail']); 
		
	}
	
	// --- Mail Section
	
	$subject = $magsubject;
	$detail = "<html>
<body>
<table width=\"650\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">
  <tr>
    <td colspan=\"3\"><img src=\"http://www.fact-link.com.vn/2010/images/mail_01.jpg\" width=\"650\" height=\"75\" /></td>
  </tr>
  <tr>
    <td width=\"20\" background=\"http://www.fact-link.com.vn/2010/images/mail_02.jpg\">&nbsp;</td>
    <td width=\"610\"><p><font style=\"color: #CC0000; font-weight: bold; font-size: 18px;\">".$magsubject."</font><br />
      <br />
        <br />
        <font color=\"#000000\">".$magdetail."</font>
    </p>
    </td>
    <td width=\"20\" background=\"http://www.fact-link.com.vn/2010/images/mail_03.jpg\">&nbsp;</td>
  </tr>
  <tr>
    <td colspan=\"3\"><img src=\"http://www.fact-link.com.vn/2010/images/mail_04.jpg\" width=\"650\" height=\"40\" /></td>
  </tr>
</table>
</body>
</html>";

	$header = "Content-type: text/html; charset=utf-8"."\r\n"."From: Fact-Link <gookguu@fact-link.com>"; 
		
	$sql2 = "select * from flc_member where mem_status = '' and mem_mailop_mag = '1' order by mem_id asc;"; 
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) { 
	$mem_contactmail=$dbarr2['mem_contactmail'];
	if($mem_contactmail!='')
	
	{ mail($dbarr2['mem_contactmail'], $subject, $detail, $header); }
	
	// for test
//	mail("newalway_33216@hotmail.com", $subject, $detail, $header); 
	}

	$sql3 = "update flc_magazine set mag_status = 's', mag_sentdate = '$nowdate', mag_senttime = '$nowtime' where mag_id = '$magid';"; 
	$result3 = mysql_query($sql3);
	
	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_magazine.php?start=0\">"; 
	exit();
?>
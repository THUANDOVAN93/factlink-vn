<?php
	ini_set("session.gc_maxlifetime", "18000");
	set_time_limit(10000);
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	
	$magid = $_POST['id'];
	$nationality =$_POST['ntl']
	$sql1 = "select * from flc_magazine where mag_id = '$magid';"; 
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		$magsubject = $dbarr1['mag_subject']; 
		$magdetail = html($dbarr1['mag_detail']); 	
	}
	
	// --- Mail Section
function send_mail($name,$mem_contactmail,$subject,$detail){
	
 $mail =  new PHPMailer(true);
 $mail->IsSMTP();
 try {
 $mail->SMTPDebug = 2;	
 $mail->IsHTML(true);
 $mail->CharSet = "UTF-8";
 $mail->SMTPAuth   = true;
 $mail->Port = 465;
 $mail->SMTPSecure = "ssl";
 $mail->Host = "c2.vinahost.vn";
 $mail->Username = "staff@fact-link.com.vn";
 $mail->Password = "staff2019";
 $mail->SetFrom("staff@fact-link.com.vn", "fact-link.com.vn");
 $mail->Subject = $subject;
 $mail->Body = $detail;	
 $test= (explode(",",$mem_contactmail));
 foreach ($test as $names => $emails) {
       $mail->AddAddress($emails,$name);
 }
 $mail->AddBCC("noreply@fact-link.com.vn", "staff-fact-link.com");
// $mail->Send();
//echo "Success"."-->".'['.$names.']'."-".$emails."</br>";
		if(!$mail->Send()){
			return 0;
			$mail->ClearAllRecipients();	
			$mail->ClearAddresses();
			exit();
			}
		else{ 
			return 1;
			$mail->ClearAllRecipients();	
			$mail->ClearAddresses();			
			}
}catch (phpmailerException $e) {
	echo $e->errorMessage(); //Pretty error messages from PHPMailer
}catch (Exception $e) {
	echo $e->getMessage(); //Boring error messages from anything else!
}		
	}		
	$name = "Customer";
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
	//require(dirname(__FILE__)."/PHPMailer/class.phpmailer.php");
	  require(dirname(__FILE__)."/PHPMailer/class.phpmailer.php");
	//require_once('../class.pop3.php'); // required for POP before SMTP
 $header = "Content-type: text/html; charset=utf-8"."\r\n"."From: Fact-Link <staff@fact-link.com>"; 	
	$sql2 = "select * from flc_member where mem_status = '' and mem_mailop_mag = '1'  ;"; 
	$result2 = mysql_query($sql2);
while ($dbarr2 = mysql_fetch_array($result2)) { 
	$mem_contactmail=$dbarr2['mem_contactmail'];
		if($mem_contactmail!=' '){ 
		send_mail($name,$mem_contactmail,$subject,$detail);		
  		}
	}	 
/************************************************************************************************************/	
	$sql3 = "update flc_magazine set mag_status = '', mag_sentdate = '$nowdate', mag_senttime = '$nowtime' where mag_id = '$magid';"; 
	//$result3 = mysql_query($sql3);
	//echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_magazine.php?start=0\">"; 
	exit();	
?>
<?php

	exit('UNDER CONSTRUCTION');

	ini_set("session.gc_maxlifetime", "18000");
	set_time_limit(10000);
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
	function send_mail($name,$mem_contactmail,$subject,$detail){
		
		require_once(dirname(__FILE__)."/PHPMailer/class.phpmailer.php");
		
		try {
			
			$mail =  new PHPMailer(true);
			$mail->IsSMTP();
			$mail->SMTPDebug = 2;	
			$mail->IsHTML(true);
			
			/* Config */
			$mail->CharSet		= 'utf-8';
			$mail->SMTPAuth		= true;
			$mail->SMTPSecure	= 'ssl';
			$mail->Host			= 'smtp.gmail.com';
			$mail->Port			= 465;
			$mail->Username		= 'factlinkvn@gmail.com';
			$mail->Password		= '123456factlinkvn';
			$mail->IsSMTP();
		
			/*  */
			$mail->SetFrom("staff@fact-link.com.vn", "fact-link.com.vn");
			$mail->Subject = $subject;
			$mail->Body = $detail;
			$mail->MsgHTML($detail);
			
			
			/*  */
			$emailList= explode(',',$mem_contactmail);
			foreach ($emailList as $names => $email) {
				$email = trim($email);
				$mail->AddBCC($email,$name);
			}
			
			/* Send all email */
			$send = $mail->Send();
			
			/* Clear data */
			$mail->ClearAllRecipients();	
			$mail->ClearAddresses();
	
			/* Return Success or failed send result */
			return $send;
	
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

	
	/* Send email */
	$sql2 = "select * from flc_member where mem_status = '' and mem_mailop_mag = '1'  ;"; 
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
		
		/* Prepare email list as variable */
		$mem_contactmail = $dbarr2['mem_contactmail'];
		
		/* Send email to contact list if not empty */
		if(!empty(trim($mem_contactmail))){ 
			send_mail($name,$mem_contactmail,$subject,$detail);
  		}
		
	}
	
	/* Send same email to Staff also */
	send_mail($name,'factlinkvn@gmail.com',$subject,$detail);
	
/************************************************************************************************************/

	/* Update data when everything finish */
	$sql3 = "update flc_magazine set mag_status = '', mag_sentdate = '$nowdate', mag_senttime = '$nowtime' where mag_id = '$magid';"; 
	$result3 = mysql_query($sql3);
	
	/* Redirect back to ..... page */
	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_magazine.php?start=0\">"; 
	exit();
	
?>
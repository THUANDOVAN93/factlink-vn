<?php

	session_start();
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	
	
	
	
	/* Only accept submit data from following URI to prevent XSS attack */
	$allow[] = 'https://www.fact-link.com.vn/contact.php';
	$allow[] = 'https://fact-link.com.vn/contact.php';
	$allow[] = 'https://www.fact-link.com.vn/contact';
	$allow[] = 'https://fact-link.com.vn/contact';
	
	if(!in_array($_SERVER["HTTP_REFERER"],$allow)){
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_done.php?case=url\">";
		exit();
	}

	//reCaptcha Validator
	// $ip = $_SERVER['REMOTE_ADDR'];
	// $captchaToken = $_POST['g-recaptcha-response'];
	// $isValidCaptcha = validateReCaptcha($captchaSecretKey, $captchaToken, $ip);
	// if ($isValidCaptcha == false) {
	// 	echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_done.php?case=bot\">";
	// 	exit();
	// }
	
	mysql_query("use $db_name;");

	$t_company = mysql_escape_string($_POST['t_company']);
	$t_contact = mysql_real_escape_string($_POST['t_contact']);
	$t_tel = mysql_real_escape_string($_POST['t_tel']);
	$t_fax = mysql_real_escape_string($_POST['t_fax']);
	$t_mobile = mysql_real_escape_string($_POST['t_mobile']);
	$t_mail = mysql_real_escape_string($_POST['t_mail']);
	$t_subject = mysql_real_escape_string($_POST['t_subject']);
	$t_detail = mysql_real_escape_string($_POST['t_detail']);

	// Spam mail check
	if (substr_count($t_detail,"</a>") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_done.php\">"; exit(); }
	if (substr_count($t_detail,"[/url]") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_done.php\">"; exit(); }
	if (substr_count($t_detail,"[/link]") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_done.php\">"; exit(); }

	
	
	$sql1 = "
		insert into flc_contact (
			ctt_company, ctt_contact, ctt_tel,
			ctt_mobile, ctt_fax, ctt_mail,
			ctt_subject, ctt_detail, ctt_date, ctt_time
		) values (
			'$t_company', '$t_contact', '$t_tel', '$t_mobile', '$t_fax',
			'$t_mail', '$t_subject', '$t_detail', '$nowdate', '$nowtime'
		);";
	
	$result1 = mysql_query($sql1);

	
	
	
	
	
	
	
	// --- Mail Section

	$subject = "[お問い合わせ] Contact from website";
	$detail = "<html>
<body>
<table width=\"650\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">
  <tr>
    <td colspan=\"3\"><img src=\"http://www.fact-link.com.vn/images/mail_01.jpg\" width=\"650\" height=\"75\" /></td>
  </tr>
  <tr>
    <td width=\"20\" background=\"http://www.fact-link.com.vn/images/mail_02.jpg\">&nbsp;</td>
    <td width=\"610\"><p><font style=\"color: #CC0000; font-weight: bold; font-size: 18px;\">Contact from website</font><br />
      <br />
        <br />
        <font color=\"#00000\"><strong>件名 / Subject</strong></font><br />
		<font color=\"#00000\">".$t_subject."</font><br /><br />
		<font color=\"#00000\"><strong>内容 / Detail</strong></font><br />
		<font color=\"#00000\">".html($t_detail)."</font><br />
        <br />
        <br />
        <font color=\"#000000\"><strong>差出人 / By</strong></font><br />
    <font color=\"#000000\">".$t_contact."</font><br />
	<font color=\"#000000\"><strong>会社名 / Company</strong></font><br />
	<font color=\"#000000\">".$t_company."</font><br />
	<font color=\"#000000\"><strong>E-mail</strong></font><br />
	<font color=\"#000000\">".$t_mail."</font><br />
    <font color=\"#000000\"><strong>Tel.</strong></font><br />
    <font color=\"#000000\">".$t_tel."</font><br />
	<font color=\"#000000\"><strong>Mobile</strong></font><br />
    <font color=\"#000000\">".$t_mobile."</font><br />
	<font color=\"#000000\"><strong>Fax</strong></font><br />
	<font color=\"#000000\">".$t_fax."</font>
    </p>
    </td>
    <td width=\"20\" background=\"http://www.fact-link.com.vn/images/mail_03.jpg\">&nbsp;</td>
  </tr>
  <tr>
    <td colspan=\"3\"><img src=\"http://www.fact-link.com.vn/images/mail_04.jpg\" width=\"650\" height=\"40\" /></td>
  </tr>
</table>
</body>
</html>";


	
	/** PHPMailer
	 *	(always try/catch third party SourceCode)
	 */
	try {
		
		
		// $header = "Content-type: text/html; charset=utf-8"."\r\n"."From: Fact-Link <admin_vn@fact-link.com.vn>";
		// mail("factlinkvn.noreply@gmail.com", $subject, $detail, $header);
		
		/* Prepare PHPMailer */
		require_once("PHPMailer/class.smtp.php");
		require_once("PHPMailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->SMTPDebug = false;

		/* Config */
		$mail->CharSet		= 'utf-8';
		$mail->SMTPAuth		= true;
		$mail->SMTPSecure	= 'ssl';
		$mail->Host			= 'smtp.gmail.com';
		$mail->Port			= 465;
		$mail->Username		= 'factlinkportvn@gmail.com';
		$mail->Password		= '123456factlinkvn';
		$mail->IsSMTP();		
		
		/* Prepare Email content */
		$mail->SetFrom("admin_vn@fact-link.com.vn",'Fact-Link');
		$mail->Subject = $subject;
		$mail->MsgHTML($detail);
		//$mail->AddAddress("factlinkvn@gmail.com");
		$mail->AddAddress("info@fact-link.com.vn");
		// $mail->AddAddress($t_mail);

		/* Send email! */
		if(!$mail->Send()) {
			// echo "Mailer Error: " . $mail->ErrorInfo;
			// exit;
		} else {
			// echo "Message sent!";
		}
		
	} catch(Exception $exception) {
		throw $exception;
	}
	
	
	
	
	/* Redirect */
	echo "<meta http-equiv=\"refresh\" content = \"0;URL = contact_done.php\">";
	exit();
	
?>

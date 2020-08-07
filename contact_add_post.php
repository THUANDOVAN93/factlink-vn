<?php

	session_start();

	require_once("./vendor/autoload.php");
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

	if(!empty($_POST['flc-bot-prevent'])) {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_done.php?case=bot\">";
		exit();
	}

	$dataForm = array();

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['b_ok'])) {
		$dataForm['userConfirmCode'] = $_POST['t_confirm'];
		$dataForm['constraintCode'] = $_POST['h_random'];
	} else {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_done.php?case=bot\">";
		exit();
	}

	if ($dataForm['userConfirmCode'] != $dataForm['constraintCode']) {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_done.php?case=code\">";
		exit();
	}

	//reCaptcha Validator
	$ip = $_SERVER['REMOTE_ADDR'];
	$captchaToken = $_POST['g-recaptcha-response'];
	$isValidCaptcha = validateReCaptcha($captchaSecretKey, $captchaToken, $ip);
	if ($isValidCaptcha == false) {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_done.php?case=captcha\">";
		exit();
	}
	
	mysql_query("use $db_name;");

	$t_company = mysql_escape_string($_POST['t_company']);
	$t_contact = mysql_real_escape_string($_POST['t_contact']);
	$t_tel = mysql_real_escape_string($_POST['t_tel']);
	$t_fax = mysql_real_escape_string($_POST['t_fax']);
	$t_mobile = mysql_real_escape_string($_POST['t_mobile']);
	$t_mail = mysql_real_escape_string($_POST['t_mail']);
	$t_subject = mysql_real_escape_string($_POST['t_subject']);
	$t_detail = mysql_real_escape_string($_POST['t_detail']);
	$t_address = mysql_real_escape_string($_POST['t_address']);

	use Symfony\Component\Validator\Constraints as Assert;
	use Symfony\Component\Validator\Validation;

	$validator = Validation::createValidator();

	$input = [
		'companyName' => $t_company,
		'userName' => $t_contact,
		'userPhone' => $t_tel,
		'userMail' => $t_mail,
		'mailSubject' => $t_subject,
		'mailContent' => $t_detail,
	];

	$groups = new Assert\GroupSequence(['Default', 'custom']);

	$constraint = new Assert\Collection([
		'companyName' => new Assert\Length([
			'min' => 1,
			'max' => 1000,
		]),
		'userName' => new Assert\Length([
			'min' => 1,
			'max' => 1000,
		]),
		'userPhone' => new Assert\Regex([
			'pattern' => '/^(\(0\))?[0-9]+$/',
			'message' => 'Please input phone number correctly.',
		]),
		'userMail' => new Assert\Email(),
		'mailSubject' => new Assert\Length([
			'min' => 1,
			'max' => 1000,
		]),
		'mailContent' => new Assert\Length([
			'min' => 1,
			'max' => 5000,
		]),
	]);

	$violations = $validator->validate($input, $constraint, $groups);

	if (0 !== count($violations)) {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_done.php?case=validator\">";
		exit();
	}


	// Spam mail check
	if (substr_count($t_detail,"</a>") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_done.php?case=warn\">"; exit(); }
	if (substr_count($t_detail,"[/url]") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_done.php?case=warn\">"; exit(); }
	if (substr_count($t_detail,"[/link]") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_done.php?case=warn\">"; exit(); }
	
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
	<font color=\"#000000\"><strong>住所 / Address</strong></font><br />
	<font color=\"#000000\">".$t_address."</font><br />
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

	try {
		require_once("PHPMailer/class.smtp.php");
		require_once("PHPMailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->SMTPDebug = false;
		$mail->CharSet		= 'utf-8';
		$mail->SMTPAuth		= true;
		$mail->SMTPSecure	= 'ssl';
		$mail->Host			= 'smtp.gmail.com';
		$mail->Port			= 465;
		$mail->Username		= 'factlinkportvn@gmail.com';
		$mail->Password		= '123456factlinkvn';
		$mail->IsSMTP();		
		$mail->SetFrom("factlinkportvn@gmail.com",'Fact-Link');
		$mail->Subject = $subject;
		$mail->MsgHTML($detail);
		$mail->AddAddress("info@fact-link.com.vn");
		$mail->Send();
	} catch(Exception $exception) {
		throw $exception;
	}
	echo "<meta http-equiv=\"refresh\" content = \"0;URL = contact_done.php\">";
	exit();
	
?>

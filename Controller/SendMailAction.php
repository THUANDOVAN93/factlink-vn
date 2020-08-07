<?php
// error_reporting(-1);
// ini_set('display_errors', 'on');
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../PHPMailer/class.smtp.php';
require_once __DIR__.'/../PHPMailer/class.phpmailer.php';
require_once __DIR__.'/../include/global_config.php';
require_once __DIR__.'/../include/global_function.php';

mysql_query("use $db_name;");
//require_once __DIR__.'/../include/global_memvalue.php';

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

$request = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
$http = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_SCHEME);
$host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);

$dataForm = array();

$dataForm['pageId'] = $_POST['pageId'];
$dataForm['memberId'] = $_POST['memberId'];
$dataForm['langCode'] = $_POST['langCode'];

$urlRedirectSuccess = "Location: ".$http."://".$host."/mem_inquiry_done.php?id=".$dataForm['memberId']."&page=".$dataForm['pageId']."&lang=".$dataForm['langCode']."&code=1";
$urlRedirectFail = "Location: ".$http."://".$host."/mem_inquiry_done.php?id=".$dataForm['memberId']."&page=".$dataForm['pageId']."&lang=".$dataForm['langCode']."&code=2";

if(!empty($_POST['flc-bot-prevent'])) {
	header($urlRedirectFail);
	exit();
}

//reCaptcha Validator
$ip = $_SERVER['REMOTE_ADDR'];
$captchaToken = $_POST['g-recaptcha-response'];
$isValidCaptcha = validateReCaptcha($captchaSecretKey, $captchaToken, $ip);

if ($isValidCaptcha == false) {
	header($urlRedirectFail);
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
	$dataForm['companyName'] = $_POST['companyName'];
	$dataForm['userName'] = $_POST['userName'];
	$dataForm['userAddress'] = $_POST['userAddress'];
	$dataForm['userPhone'] = $_POST['userPhone'];
	$dataForm['userMail'] = $_POST['userMail'];
	$dataForm['mailSubject'] = $_POST['mailSubject'];
	$dataForm['mailContent'] = $_POST['mailContent'];
	$dataForm['memberName'] = $_POST['memberName'];
	$dataForm['userConfirmCode'] = $_POST['t_confirm'];
	$dataForm['constraintCode'] = $_POST['h_random'];
} else {
	header($urlRedirectFail);
	exit();
}

if ($dataForm['userConfirmCode'] != $dataForm['constraintCode']) {
	header($urlRedirectFail);
	exit();
}

$validator = Validation::createValidator();

$input = [
	'companyName' => $dataForm['companyName'],
	'userName' => $dataForm['userName'],
	'userPhone' => $dataForm['userPhone'],
	'userMail' => $dataForm['userMail'],
	'mailSubject' => $dataForm['mailSubject'],
	'mailContent' => $dataForm['mailContent'],
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
	header($urlRedirectFail);
	exit();
}

$len = 1;
$gap = explode(" ", $nowdate);
$gap[1] = mcvsubtonum($gap[1]);
$gap[3] = "";
$warn = expcal($gap[0], $gap[1], $gap[2], $gap[3], $len);

$tmpwarn = explode(" ", $warn);
$tmpwarn[1] = mcvnumtosub($tmpwarn[1]);
$tmpwarn[0] = addzero2($tmpwarn[0]);

$warndate = $tmpwarn[0]." ".$tmpwarn[1]." ".$tmpwarn[2];

$sqlAddInquiry = "insert into flc_mail (
		mem_id,
		mal_from_name,
		mal_address,
		mal_from_mail,
		mal_company,
		mal_tel,
		mal_subj,
		mal_detail,
		mal_date,
		mal_time,
		mal_warningdate,
		mal_ip,
		mal_box,
		mal_warning,
		mal_status,
		mal_send
	)
	values (
		'".$dataForm['memberId']."',
		'".$dataForm['userName']."',
		'".$dataForm['userAddress']."',
		'".$dataForm['userMail']."',
		'".$dataForm['companyName']."',
		'".$dataForm['userPhone']."',
		'".$dataForm['mailSubject']."',
		'".$dataForm['mailContent']."',
		'$nowdate',
		'$nowtime',
		'$warndate',
		'$get_ip',
		'i',
		't',
		'd',
		'n'
	);"
;
$resultAddInquiry = mysql_query($sqlAddInquiry)or die(mysql_error());

$subject = "Contact Of Member";
$body = "
<html>
<body>
<table width=\"650\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">
	<tr>
		<td>Title</td>
		<td>
			".$dataForm['mailSubject']."
		</td>
	</tr>
	<tr>
		<td>Company</td>
		<td>
			".$dataForm['companyName']."
		</td>
	</tr>
	<tr>
		<td>Name</td>
		<td>
			".$dataForm['userName']."
		</td>
	</tr>
	<tr>
		<td>Address</td>
		<td>
			".$dataForm['userAddress']."
		</td>
	</tr>
	<tr>
		<td>Phone</td>
		<td>
			".$dataForm['userPhone']."
		</td>
	</tr>
	<tr>
		<td>Email</td>
		<td>
			".$dataForm['userMail']."
		</td>
	</tr>
	<tr>
		<td>Content</td>
		<td>
			".$dataForm['mailContent']."
		</td>
	</tr>
	<tr>
		<td>Supplier</td>
		<td>
			".$dataForm['memberName']."
		</td>
	</tr>
</table>
</body>
</html>";

$subjectConfirm = "［お問い合わせを受け付けました / We received your inquiry］ファクトリンクベトナム / Fact-Link.com.vn";
$bodyConfirm = "
<html>
<body>
<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">
	<tr>
		<td>
		ファクトリンクベトナムにお問い合わせありがとうございます。<br>
		送信内容は以下の通りです。担当者がご連絡をさせていただきます。<br>
		こちらのメールは送信専用ですので返信をしないでください。<br><br>
		Thank you for contacting to Fact-Link Vietnam. We receive
		your inquiry. We will contact to you shortly.<br>
		Please be noted that this email is only for sending, please do not reply to this email.<br>
		<br>
		------------------------------------------------------------
		<br>
		</td>
	</tr>
	<tr>
		<td>会社名 / Company name<br>".$dataForm['companyName']."</td>
	</tr>
	<tr>
		<td>お名前 / Name<br>".$dataForm['userName']."</td>
	</tr>
	<tr>
		<td>電話番号 / Phone<br>".$dataForm['userPhone']."</td>
	</tr>
	<tr>
		<td>E-mail<br>".$dataForm['userMail']."</td>
	</tr>
	<tr>
		<td>件名 / Subject<br>".$dataForm['mailSubject']."</td>
	</tr>
	<tr>
		<td>お問い合わせ内容 / Inquiry<br>".$dataForm['mailContent']."</td>
	</tr>
	<tr>
		<td>
		<br>
		------------------------------------------------------------
		<br>
		FACT-LINK MARKETPLACE CO.,LTD<br>
		Address: 602/43 Dien Bien Phu, Ward 22, Binh Thanh District, Ho Chi Minh City (Google Map)<br>
		Email : info@fact-link.com.vn<br>
		Phone : (+84) 888 767 138
		<br>
		------------------------------------------------------------
		<br>
		</td>
	</tr>
</table>
</body>
</html>";

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
$mail->SetFrom("noreply@fact-link.com.vn", "Fact-Link Vietnam");
$mail->Subject = "$subject";
$mail->MsgHTML($body);
$mail->AddAddress("info@fact-link.com.vn", "Staff");

if (!$mail->Send()) {
	header($urlRedirectFail);
	exit();
}

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
$mail->SetFrom("noreply@fact-link.com.vn", "Fact-Link Vietnam");
$mail->Subject = "$subjectConfirm";
$mail->MsgHTML($bodyConfirm);
$mail->AddAddress($dataForm['userMail'], "Customer");
$mail->Send();

header($urlRedirectSuccess);
exit();
?>
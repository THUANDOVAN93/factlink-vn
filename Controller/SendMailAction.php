<?php
error_reporting(-1);
ini_set('display_errors', 'on');
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
	$dataForm['companyName'] = $_POST['companyName'];
	$dataForm['userName'] = $_POST['userName'];
	$dataForm['userAddress'] = $_POST['userAddress'];
	$dataForm['userPhone'] = $_POST['userPhone'];
	$dataForm['userMail'] = $_POST['userMail'];
	$dataForm['mailSubject'] = $_POST['mailSubject'];
	$dataForm['mailContent'] = $_POST['mailContent'];
	$dataForm['memberName'] = $_POST['memberName'];
} else {
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
		'max' => 200,
	]),
	'userName' => new Assert\Length([
		'min' => 1,
		'max' => 200,
	]),
	'userPhone' => new Assert\Regex([
		'pattern' => '/^(\(0\))?[0-9]+$/',
		'message' => 'Please input phone number correctly.',
	]),
	'userMail' => new Assert\Email(),
	'mailSubject' => new Assert\Length([
		'min' => 1,
		'max' => 300,
	]),
	'mailContent' => new Assert\Length([
		'min' => 1,
		'max' => 500,
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
		'$getip',
		'i',
		't',
		'd',
		'n'
	);"
;
$resultAddInquiry = mysql_query($sqlAddInquiry)or die(mysql_error());

$subject = "Contact Of Free Member";
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
//$mail->AddAddress("thuandovan93@gmail.com", "Staff");

if (!$mail->Send()) {
	header($urlRedirectFail);
	exit();
}

header($urlRedirectSuccess);
exit();
?>
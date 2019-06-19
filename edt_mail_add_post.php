<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_memid = $_POST['h_memid'];
	$h_memmail = $_POST['h_memmail'];
	$h_sender = $_POST['h_sender'];
	$t_to = $_POST['t_to'];
	$t_mail = $_POST['t_mail'];
	$t_subject = $_POST['t_subject'];
	$t_detail = $_POST['t_detail'];

	if ($_SESSION['vmd'] != $h_memid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql1 = "insert into flc_mail (mem_id, mal_to_name, mal_to_mail, mal_subj, mal_detail, mal_date, mal_time, mal_ip, mal_box)
					values ('$h_memid', '$t_to', '$t_mail', '$t_subject', '$t_detail', '$nowdate', '$nowtime', '$getip', 'o');";
	$result1 = mysql_query($sql1);

	// Mail section

	$detail = "<html>
<body>
<table width=\"650\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">
  <tr>
    <td colspan=\"3\"><img src=\"http://www.fact-link.com.vn/images/mail_01.jpg\" width=\"650\" height=\"75\" /></td>
  </tr>
  <tr>
    <td width=\"20\" background=\"http://www.fact-link.com.vn/images/mail_02.jpg\">&nbsp;</td>
    <td width=\"610\">
        <font color=\"#00000\">".$t_to."</font><br /><br />
		<font color=\"#00000\"><strong>件名 / Subject</strong></font><br />
		<font color=\"#00000\">".$t_subject."</font><br /><br />
		<font color=\"#00000\"><strong>詳細 / Detail</strong></font><br />
		<font color=\"#00000\">".html($t_detail)."</font><br />
        <br />
        <br />
        <font color=\"#000000\"><strong>差出人 / From</strong></font><br />
    <font color=\"#000000\">".$h_sender."</font>
    </td>
    <td width=\"20\" background=\"http://www.fact-link.com.vn/images/mail_03.jpg\">&nbsp;</td>
  </tr>
  <tr>
    <td colspan=\"3\"><img src=\"http://www.fact-link.com.vn/images/mail_04.jpg\" width=\"650\" height=\"40\" /></td>
  </tr>
</table>
</body>
</html>";

	//$header = "Content-type: text/html; charset=utf-8"."\r\n"."From: Fact-Link <admin_vn@fact-link.com.vn>";

	//mail($t_mail, $t_subject, $detail, $header);
	//mail($h_memmail, $t_subject, $detail, $header);
	$body = "$detail";
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

	//$mail->SetFrom("info@fact-link.com.vn", "$header");
	$mail->SetFrom("$h_memmail", "Fact-Link Vietnam");
	$mail->AddReplyTo("$h_memmail", "Supplier");
	$mail->Subject = "$t_subject";
	$mail->MsgHTML($body);
	$mail->AddAddress("$t_mail", "Customer");
	$mail->AddAddress("$h_memmail", "Supplier");
	$mail->AddAddress("factlinkvn.noreply@gmail.com", "Staff");

	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
		exit;
	} else {
		// echo "Message sent!";
	}
	/* End PHPMailer */

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_mail_outbox.php?start=0\">";
	exit();
?>

<?php

session_start();

if (!isset($_SESSION['vd'])) {
	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">";
	exit();
}
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
 	$_POST = array_map('mysql_real_escape_string', $_POST);

	if (isset($_GET['mal_id'])) {
		$mal_id = $_GET['mal_id'];
	}

	if (isset($_POST['mailid'])) {
		$mal_id = $_POST['mailid'];
	}

	if (isset($_POST['mal_id'])) {
		$mal_id = $_POST['mal_id'];
	}
	
	mysql_query("use $db_name;");

	$sql1 = "select * from flc_mail where mal_id = '$mal_id';";
	$result1 = mysql_query($sql1) or die('mail error');
	while ($dbarr1 = mysql_fetch_array($result1)) {

		$memid = $dbarr1['mem_id'];
		$inrsubject = $dbarr1['mal_subj'];
		$inrcontent = html($dbarr1['mal_detail']);
		$inrcompany = $dbarr1['mal_company'];
		$inrdepartment = $dbarr1['mal_department'];
		$inrname = $dbarr1['mal_from_name'];
		$inrmail = $dbarr1['mal_from_mail'];
		$inrtel = $dbarr1['mal_tel'];
		$inrfax = $dbarr1['mal_fax'];
		$mal_id = $dbarr1['mal_id'];
	    $mal_date = $dbarr1['mal_date'];
		$mal_time = $dbarr1['mal_time'];
	}

	$sql2 = "select * from flc_member where mem_id = '$memid';";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {

		$memcomname = $dbarr2['mem_comname_en'];
		$memcontactname = $dbarr2['mem_contactname_en'];
		$memcontactmail = $dbarr2['mem_contactmail'];
		$mem_oth_contactmail = $dbarr2['mem_oth_contactmail'];
		$memberPackage = $dbarr2['mem_package'];
		$memberUserLogin = $dbarr2['mem_user'];
		$memberPassLogin = $dbarr2['mem_pass'];
	}

	$subject = "[ ファクトリンク (Fact-link.com.vn) ] お問合わせメールが届いております。You have got new enquiry mail.";
    $detailForPaid = "<html>
<body>
<table width=\"650\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">
  <tr>
    <td colspan=\"3\"><img src=\"https://www.fact-link.com.vn/images/mail_01.jpg\" width=\"650\" height=\"75\" /></td>
  </tr>
  <tr>
    <td width=\"20\" background=\"https://www.fact-link.com.vn/images/mail_02.jpg\">&nbsp;</td>
    <td width=\"610\"><p><font style=\"color: #CC0000; font-weight: bold; font-size: 18px;\">お問い合わせメール / Inquiry Mail</font><br />
      <br />
	  <font color=\"#00000\"><strong>".$memcomname."</strong><br />
	  Dear ".$memcontactname."<br />
	  <br />
        <font color=\"#00000\">製造業ポータルサイト <a herf=\"https://www.fact-link.com.vn\" target=\"_blank\">Fact-Link.com</a> にて開設されております 御社ホームページのメールフォームから、<br />新しいお問合わせがありました。
お客様のアカウントにログインして、内容をご確認ください。<br /><br />You have received a new enquiry message from your website. <br />Please login in order to read your new message.</font><br />
		<br />
 <font color=\"#00000\">------------------------------------------------------------<br />
 <strong>名前 / Name :</strong> ".$inrname."<br />
 <strong>件名 / Subject :</strong> ".$inrsubject."<br />
 <strong>時刻 / Date :</strong> ".$mal_date." ".$mal_time."<br />
------------------------------------------------------------</font><br />
		<br />
<font color=\"#00000\">内容を確認するには....<br />
1. <a herf=\"https://www.fact-link.com.vn\" target=\"_blank\">https://www.fact-link.com.vn</a> へアクセスします。<br />
2. アカウントにログインします。<br />
3. メール - 受信をクリックします。<br />
<br />
To read your new message<br />
1. Please go to <a herf=\"https://www.fact-link.com.vn\" target=\"_blank\">https://www.fact-link.com.vn</a><br />
2. Login to your account<br />
3. Click on 'Mail - Inbox' menu to read your new enquiry message<br />
<br />
------------------------------------------------------------</font><br />
<br />
<font color=\"#00000\">内容を確認するには....<br />
担当はベトナム人のTruc (info@fact-link.com.vn、(+84) 888 767 138)となりますので、何か不明点がございましたらご連絡をいただければ幸いです。</br>
If you have any further support, please contact us via email: Ms. Truc ( info@fact-link.com.vn, (+ 84) 888 767 138) 
<br />
------------------------------------------------------------</font>
<font color=\"#00000\"><br />
このメールには返信できません。<br />
Don't reply this E-mail.<br />
</font>
    </p>
    </td>
    <td width=\"20\" background=\"https://www.fact-link.com.vn/images/mail_03.jpg\">&nbsp;</td>
  </tr>
  <tr>
    <td colspan=\"3\"><img src=\"https://www.fact-link.com.vn/images/mail_04.jpg\" width=\"650\" height=\"40\" /></td>
  </tr>
</table>
</body>
</html>";


$detailForFree = "<html>
<body>
<table width=\"650\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">
  <tr>
    <td colspan=\"3\"><img src=\"https://www.fact-link.com.vn/images/mail_01.jpg\" width=\"650\" height=\"75\" /></td>
  </tr>
  <tr>
    <td width=\"20\" background=\"https://www.fact-link.com.vn/images/mail_02.jpg\">&nbsp;</td>
    <td width=\"610\"><p><font style=\"color: #CC0000; font-weight: bold; font-size: 18px;\">お問い合わせメール / Inquiry Mail</font><br />
      <br />
	  <font color=\"#00000\"><strong>".$memcomname."</strong><br />
	  Dear ".$memcontactname."<br />
	  <br />
        <font color=\"#00000\">製造業ポータルサイト <a herf=\"https://www.fact-link.com.vn\" target=\"_blank\">Fact-Link.com にて開設されております</a><br />御社ホームページのメールフォームから新しいお問合わせが<br />ありました。お客様のアカウントにログインして、内容をご確認ください。<br /><br />You have received a new enquiry message from your website. <br />Please login in order to read your new message.</font><br />
		<br />新しいお問い合わせ / New Inquiry<br />
 <font color=\"#00000\">------------------------------------------------------------<br />
 <strong>名前 / Name :</strong> ".$inrname."<br />
 <strong>電話 / Phone :</strong> ".$inrtel."<br />
 <strong>Eメール / Email :</strong> ".$inrmail."<br />
 <strong>件名 / Subject :</strong> ".$inrsubject."<br />
 <strong>詳細 / Detail :</strong> ".$inrcontent."<br />
 <strong>時刻 / Date :</strong> ".$mal_date." ".$mal_time."<br />
------------------------------------------------------------</font><br />
		<br />
<font color=\"#00000\">お問い合わせの連絡先に直接ご連絡いただくか、システムから返信することも可能です。<br />
返信をするには、<br />
1. <a herf=\"https://www.fact-link.com.vn\" target=\"_blank\">https://www.fact-link.com.vn</a> へアクセスします。<br />
2. アカウントにログインします。<br />
<strong>ユーザー名 : ".$memberUserLogin."</strong><br />
<strong>パスワード : ".$memberPassLogin."</strong><br />
3. メール - 受信をクリックします。<br />
<br />
To answer to this inquiry, you can contact directly to the contact above. 
<br />
Or, you can reply through system as follows.
<br />
1. Please go to <a herf=\"https://www.fact-link.com.vn\" target=\"_blank\">https://www.fact-link.com.vn</a><br />
<strong>UserName : ".$memberUserLogin."</strong><br />
<strong>Password : ".$memberPassLogin."</strong><br />
2. Login to your account<br />
3. Click on 'Mail - Inbox' menu to read your new enquiry message<br />
<br />
------------------------------------------------------------</font><br />
<br />
<font color=\"#00000\">ファクトリンク運営会社　問い合わせ先<br />
Contact of Fact-Link operation company
<br />
メール / Email  info@fact-link.com.vn
<br />
電話 / Phone (+ 84) 888 767 138
<br />
------------------------------------------------------------</font>
<font color=\"#00000\"><br />
このメールには返信できません。<br />
Don't reply this E-mail.<br />
</font>
    </p>
    </td>
    <td width=\"20\" background=\"https://www.fact-link.com.vn/images/mail_03.jpg\">&nbsp;</td>
  </tr>
  <tr>
    <td colspan=\"3\"><img src=\"https://www.fact-link.com.vn/images/mail_04.jpg\" width=\"650\" height=\"40\" /></td>
  </tr>
</table>
</body>
</html>";

if ($memberPackage !== "") {
	$detail = $detailForPaid;
} else {
	$detail = $detailForFree;
}

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
	
	$mail->SetFrom("info@fact-link.com.vn", "Fact-Link Vietnam");
	$mail->AddReplyTo("$inrmail", "$inrname");
	$mail->Subject = $subject;
	$mail->Body = $detail;
	$mail->MsgHTML($detail);
	$mail->AddAddress("$memcontactmail", "$memcomname");
	
	if (!empty($mem_oth_contactmail)) {

		$CC = explode(",",$mem_oth_contactmail);
		$CC = array_filter($CC,'strlen');	
		foreach($CC as $emailCC) {
			$mail->AddCC($emailCC);
		}
	}

	if ($mail->Send()) {
		
		$sql = "update flc_mail set mal_status='n', mal_send='y', mal_warning='' where mal_id='$_POST[mailid]';";
		mysql_query($sql);
		
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_index.php\">";
		exit();	
	}
} catch(Exception $exception) {

	throw $exception;
}

echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_index.php\">";
exit();
	
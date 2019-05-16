<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	//Spam ip check
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	//End Spam ip check

	mysql_query("use $db_name;");
	$_POST['h_random'];
	$_POST['t_confirmvalue'];
	$h_memid = $_POST['h_memid'];
	$h_pagid = $_POST['h_pagid'];
	$h_langcode = $_POST['h_langcode'];
	$t_company = $_POST['t_company'];
	$t_department = $_POST['t_department'];
	$t_name = $_POST['t_name'];
	$t_tel = $_POST['t_tel'];
	$t_fax = $_POST['t_fax'];
	$t_mail = $_POST['t_mail'];
	$t_subject = $_POST['t_subject'];
	$t_content = $_POST['t_content'];

	// Spam mail check


	 if(!isset($_SESSION["security_code"]) || !isset($_POST['t_confirm'])){?>
        <script>
		alert('Confirm Code Error');
		</script>
        <?

		echo "<meta http-equiv = \"refresh\" content = \"0;URL = $_SERVER[HTTP_REFERER]\">"; }
	 if($_SESSION["security_code"] != $_POST['t_confirm']){
		?>
        <script>
		alert('Confirm Code Error');
		</script>
        <?

		echo "<meta http-equiv = \"refresh\" content = \"0;URL = $_SERVER[HTTP_REFERER]\">";
		 }

	//Spam ip check
	/*

	if (substr_count($t_content,"<>") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "1";
	}
	if (substr_count($t_content,">") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "1";
	}
	if (substr_count($t_content,"<") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "1";
	}
	if (substr_count($t_content,"<a>") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "1";
	}
	if (substr_count($t_content,"<br>") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "1";
	}
	if (substr_count($t_content,"</br>") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "1";
	}
	if (substr_count($t_content,"br>") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "1";
	}
	if (substr_count($t_content,"<br") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "1";
	}
	if (substr_count($t_content,"br") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "1";
	}
	if (substr_count($t_content,"[/url]") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "2";
	 }
	if (substr_count($t_content,"[/link]") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "3";
	}
	if (substr_count($t_content,"€") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "3";
	}
	if (substr_count($t_content,"ㄣ") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "3";
	}*/
	//
	//if ($t_subject = '1' && $t_content = '1') { //echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "4";
	 //} // 2013.07.23




	// warning ip

	if ($t_subject != '') {
	//
		// Warning date
		$len = 1;
		$gap = explode(" ", $nowdate);
		$gap[1] = mcvsubtonum($gap[1]);
		$gap[3] = "";
		$warn = expcal($gap[0], $gap[1], $gap[2], $gap[3], $len);

		$tmpwarn = explode(" ", $warn);
		$tmpwarn[1] = mcvnumtosub($tmpwarn[1]);
		$tmpwarn[0] = addzero2($tmpwarn[0]);

		$warndate = $tmpwarn[0]." ".$tmpwarn[1]." ".$tmpwarn[2];

	 	$sql1 = "insert into flc_mail (mem_id, mal_from_name, mal_from_mail, mal_company, mal_department, mal_tel, mal_fax, mal_subj, mal_detail, mal_date, mal_time, mal_warningdate, mal_ip, mal_box, mal_warning, mal_status, mal_send)
						values ('$h_memid', '$t_name', '$t_mail', '$t_company', '$t_department', '$t_tel', '$t_fax', '$t_subject', '$t_content', '$nowdate', '$nowtime', '$warndate', '$getip', 'i', 't', 'd','n');";
		$result1 = mysql_query($sql1)or die(mysql_error());

		$sql2 = "select * from flc_member where mem_id = '$h_memid';";
		$result2 = mysql_query($sql2);
		while ($dbarr2 = mysql_fetch_array($result2)) { $memcomname = $dbarr2['mem_comname_en']; $memcontactname = $dbarr2['mem_contactname_en']; $memcontactmail = $dbarr2['mem_contactmail']; }

		?>
    <script language="javascript">
	window.location='mem_inquiry_done.php?id=<?=$h_memid;?>&page=<?=$h_pagid;?>&lang=<?=$h_langcode;?>&code=1'
	</script>

    <?
		$subject = "[ ファクトリンク (Fact-link.com.vn) ] お問合わせメールが届いております。You have got new enquiry mail.";
		$detail = "<html>
<body>
<table width=\"650\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">
  <tr>
    <td colspan=\"3\"><img src=\"http://www.fact-link.com.vn/images/mail_01.jpg\" width=\"650\" height=\"75\" /></td>
  </tr>
  <tr>
    <td width=\"20\" background=\"http://www.fact-link.com.vn/images/mail_02.jpg\">&nbsp;</td>
    <td width=\"610\"><p><font style=\"color: #CC0000; font-weight: bold; font-size: 18px;\">お問い合わせメール / Inquiry Mail</font><br />
      <br />
	  <font color=\"#00000\"><strong>".$memcomname."</strong><br />
	  Dear ".$memcontactname."<br />
	  <br />
        <font color=\"#00000\">製造業ポータルサイト <a herf=\"http://www.fact-link.com.vn\" target=\"_blank\">Fact-Link.com</a> にて開設されております 御社ホームページのメールフォームから、<br />新しいお問合わせがありました。
お客様のアカウントにログインして、内容をご確認ください。<br /><br />You have received a new enquiry message from your website. <br />Please login in order to read your new message.</font><br />
		<br />
 <font color=\"#00000\">------------------------------------------------------------<br />
 <strong>名前 / Name :</strong> ".$t_name."<br />
 <strong>件名 / Subject :</strong> ".$t_subject."<br />
 <strong>時刻 / Date :</strong> ".$nowdate." ".$nowtime."<br />
------------------------------------------------------------</font><br />
		<br />
<font color=\"#00000\">内容を確認するには....<br />
1. <a herf=\"http://www.fact-link.com.vn\" target=\"_blank\">http://www.fact-link.com.vn</a> へアクセスします。<br />
2. アカウントにログインします。<br />
3. メール - 受信をクリックします。<br />
<br />
To read your new message<br />
1. Please go to <a herf=\"http://www.fact-link.com.vn\" target=\"_blank\">http://www.fact-link.com.vn</a><br />
2. Login to your account<br />
3. Click on 'Mail - Inbox' menu to read your new enquiry message<br />
<br />
------------------------------------------------------------</font><br />
<br />
<font color=\"#00000\">このメールには返信できません。<br />
メッセージの送受信は当サイト上で行なってください。<br />
<br />
Don't reply this E-mail.<br />
Please check on Fact-link website.</font>
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

$header = "Content-type: text/html; charset=utf-8"."\r\n"."From: Fact-Link <info@fact-link.com.vn>";
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
$mail->Username		= 'factlinkvn@gmail.com';
$mail->Password		= '123456factlinkvn';
$mail->IsSMTP();
/* Prepare Email content */
$mail->SetFrom("admin_vn@fact-link.com.vn",'Fact-Link');
$mail->Subject = $subject;
$mail->MsgHTML($detail);
$mail->AddAddress("factlinkvn@gmail.com");
if(!$mail->Send()) {
 "Mailer Error: " . $mail->ErrorInfo;
};

} else { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=2\">"; exit();
?>
<script language="javascript">
window.location='mem_inquiry_done.php?id=<?=$h_memid;?>&page=<?=$h_pagid;?>&lang=<?=$h_langcode;?>&code=1'
</script>
<?php
echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">";
echo "7";
exit();
};
?>

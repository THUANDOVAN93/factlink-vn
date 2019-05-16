<?
session_start();
if (!isset($_SESSION['vd'])) { 
//echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit();
 }
	//echo $_SESSION['vd'];
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	
	$mid = $_GET['id']; 
	$mal_id = $_GET['mal_id']; 
	
	mysql_query("use $db_name;");
	

     // $_POST['mal_id']='00000631';
	$sql1 = "select * from flc_mail where mal_id = '$mid';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
	
		$memid = $dbarr1['mem_id'];
		$inrsubject = $dbarr1['mal_subj'];
		$inrcontent = html($dbarr1['mal_detail']);
		$inrcompany = $dbarr1['mal_company'];
		$inrdepartment = $dbarr1['mal_department'];
		$inrname = $dbarr1['mal_from_name'];
		$inrmail = $dbarr1['mal_from_mail'];
		$inrmailto = $dbarr1['mal_to_mail'];
		$inrmailtoname = $dbarr1['mal_to_name'];
		$inrtel = $dbarr1['mal_tel'];
		$inrfax = $dbarr1['mal_fax'];
		$mal_id = $dbarr1['mal_id'];
	    $mal_date = $dbarr1['mal_date'];
		$mal_time = $dbarr1['mal_time'];
	}
	//$_POST['mem_id']='00000631';
	

       $sql2 = "select * from flc_member where mem_id = '$memid';";
		$result2 = mysql_query($sql2);
		while ($dbarr2 = mysql_fetch_array($result2)) { 
		
		$memcomname = $dbarr2['mem_comname_en']; 
		$memcontactname = $dbarr2['mem_contactname_en']; 
		$memcontactmail = $dbarr2['mem_contactmail']; 
		
		} 
		
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
 <strong>名前 / Name :</strong> ".$inrname."<br />
 <strong>件名 / Subject :</strong> ".$inrsubject."<br />
 <strong>時刻 / Date :</strong> ".$mal_date." ".$mal_time."<br />
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

		//$header = "Content-type: text/html; charset=utf-8"."\r\n"."From: Fact-Link <info@fact-link.com.vn>"; 
		
		//mail($memcontactmail, $subject, $detail, $header);
		require_once('./PHPMailer/class.phpmailer.php');
 $mail =  new PHPMailer();
 $mail->IsSMTP();
 $mail->SMTPDebug = 2;
 $mail->IsHTML(true);
 $mail->CharSet = "UTF-8";
 $mail->SMTPAuth   = true;
 $mail->Host = "mail.fact-link.com";
 $mail->Username = "antz@fact-link.com";
 $mail->Password = "091568839";
 $mail->SetFrom("$inrmail", "$inrname");//$inrmail $inrname $inrmailto  $inrmail $inrname
 $mail->Subject = $subject;
 
 $mail->Body = $detail;//$htmlbody;
 //$mail->AddAddress("$inrmailto", "$inrmailtoname");
 $mail->AddAddress("info@fact-link.com.vn", "admin");
 //$mail->AddBCC("staff@fact-link.com.vn", "staff");
 $mail->Send();

		$sql = "update flc_mail set mal_status='n', mal_send='y', mal_warning='' where mal_id='$mid]';";
		$sqlquery=mysql_db_query($db_name, $sql)or die(mysql_error);


// echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=2\">"; exit(); 
 
  echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_index.php\">"; exit(); 

	
?>
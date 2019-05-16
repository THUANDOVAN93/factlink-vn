<?php

session_start();

if (!isset($_SESSION['vd'])) {
//echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit();
 }
	//echo $_SESSION['vd'];
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	
	
  // Escape special charactars
  $_POST = array_map('mysql_real_escape_string',$_POST);


	// $_POST['member'];//memid
	// $_POST['mailid'];//mailid
	// $_POST['mal_id'];//memid
	
	if(isset($_GET['id'])){$memid = $_GET['id'];}
	if(isset($_POST['member'])){$memid = $_GET['member'];}
	
	if(isset($_GET['mal_id'])){$mal_id = $_GET['mal_id']; }
	if(isset($_POST['mailid'])){$mal_id = $_POST['mailid']; }
	if(isset($_POST['mal_id'])){$mal_id = $_POST['mal_id']; }
	
	mysql_query("use $db_name;");


     // $_POST['mal_id']='00000631';
	//$sql1 = "select * from flc_mail where mal_id = '$mal_id';";
	$sql1 = "select m.*, p.ProductNameJP, p.ProductNameVN, p.ProductNameEN  from flc_mail m, flc_products p where mal_id = '$mal_id' and m.product_id = p.ProductID;";

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

		if ($_COOKIE['vlang'] == 'en') {
			$product_name = $dbarr1['ProductNameEN'];
		} elseif ($_COOKIE['vlang'] == 'vn') {
			$product_name = $dbarr1['ProductNameVN'];
		} else {
			$product_name = $dbarr1['ProductNameJP'];
		}
	}
	
	//$_POST['mem_id']='00000631';


	$sql2 = "select * from flc_member where mem_id = '$memid';";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {

		$memcomname = $dbarr2['mem_comname_en'];
		$memcontactname = $dbarr2['mem_contactname_en'];
		$memcontactmail = $dbarr2['mem_contactmail'];
		$mem_oth_contactmail = $dbarr2['mem_oth_contactmail'];

	}

		$subject = "[ ファクトリンク (Fact-link.com.vn) ] お問合わせメールが届いております。You have got new enquiry mail.";
     	$detail = "<html>
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
 <strong>製品 / Product :</strong> ".$product_name."<br />
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
担当はベトナム人のTruc (info@fact-link.com.vn、(+84) 888 767 138)となりますので、何か不明点がございましたらご連絡をいただければ幸いです。</br>
If you have any further support, please contact us via email: Ms. Truc ( info@fact-link.com.vn, 0888 767 138 ) 
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


	try {
		
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
		
		$mail->SetFrom("$inrmail", "$inrname");
		$mail->Subject = $subject;
		$mail->Body = $detail;

		$mail->MsgHTML($detail);



		
		/* Send this email to Memeber */
		$mail->AddAddress("$memcontactmail", "$memcomname");

		/* BCC this email to Fact-Link staff */
		$mail->AddBCC("staff@fact-link.com.vn", "staff");
		
		/* List of CC emails not empty */
		if(!empty($mem_oth_contactmail)) {

			/* Split multilple email to Array of Email's */
			$CC = explode(",",$mem_oth_contactmail);
			$CC = array_filter($CC,'strlen');
			
			/*  */
			foreach($CC as $emailCC) {
				$mail->AddCC($emailCC);
			}
			
		}
	
		/* SEND EMAIL!!! */
		if($mail->Send()) {
			
			/* Email send success then Update status data */
			$sql = "update flc_mail set mal_status='n', mal_send='y', mal_warning='' where mal_id='$_POST[mailid]';";
			mysql_query($sql) or die(mysql_error);
			
			/* Redirect when complete */
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_index.php\">";
			// exit('success');
			
		} else {
			
			// echo 'something wrong';
			
		}
	
	
	} catch(Exception $exception) {
		throw $exception;
	}
	
	
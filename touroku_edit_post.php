<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$t_emanresu_edit = $_POST['t_emanresu'];
	$t_emanhtap_edit = $_POST['t_emanhtap'];
	$h_memid = $_POST['h_memid'];
	$h_code = $_POST['h_code'];

	$sql2 = "select * from flc_member where mem_id = '$h_memid';";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {

		$t_emanresu = $dbarr2['mem_user'];
		$t_password = $dbarr2['mem_pass'];
		$t_emanhtap = $dbarr2['mem_folder'];
		$t_emanmoc_en = $dbarr2['mem_comname_en'];
		$t_emanmoc_jp = $dbarr2['mem_comname_jp'];
		$t_sserddamoc_en = $dbarr2['mem_address1_en'];
		$t_eimoc = $dbarr2['mem_addressine1'];
		$t_ecnivorpmoc = $dbarr2['mem_addressprv1'];
		$t_yrtnuocmoc = $dbarr2['mem_addresscty1'];
		$t_pizmoc = $dbarr2['mem_addresszip1'];
		$t_letmoc = $dbarr2['mem_comtel'];
		$t_xafmoc = $dbarr2['mem_comfax'];
		$t_tcatnoc_en = $dbarr2['mem_contactname_en'];
		$t_tcatnoc_jp = $dbarr2['mem_contactname_jp'];
		$t_noitisop_en = $dbarr2['mem_contactposition_en'];
		$t_liam = $dbarr2['mem_contactmail'];
		$t_let = $dbarr2['mem_contacttel'];

	}

//	start  Barricade
if ($t_letmoc != '123456') {

	$sql4 = "select * from flc_ie where ine_id = '$t_eimoc';";
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) { $inename = $dbarr4['ine_name_en']; }

	$sql5 = "select * from flc_province where prv_id = '$t_ecnivorpmoc';";
	$result5 = mysql_query($sql5);
	while ($dbarr5 = mysql_fetch_array($result5)) { $prvname = $dbarr5['prv_name_en']; }

	if ($h_code == 'both') { $t_emanresu = $t_emanresu_edit; $t_emanhtap = $t_emanhtap_edit; }
	else if ($h_code == 'user') { $t_emanresu = $t_emanresu_edit; }
	else if ($h_code == 'path') { $t_emanhtap = $t_emanhtap_edit; }

	// user & path check section

	$charusername = charscheck($t_emanresu);
	$charpathname = charscheck($t_emanhtap);

	if ($charusername == 'f') { $usercheck = "f"; } else {
		$sql6 = "select * from flc_member where mem_user = '$t_emanresu' and mem_id != '$h_memid';";
		$result6 = mysql_query($sql6);
		while ($dbarr6 = mysql_fetch_array($result6)) { $usercheck = "f"; $confirmmail = "f"; }
	}

	if ($charpathname == 'f') { $pathcheck = "f"; } else {
		$sql7 = "select * from flc_member where mem_folder = '$t_emanhtap' and mem_id != '$h_memid';";
		$result7 = mysql_query($sql7);
		while ($dbarr7 = mysql_fetch_array($result7)) { $pathcheck = "f"; $confirmmail = "f"; }
	}

	if ($usercheck == 'f' && $pathcheck == 'f') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = touroku_edit.php?id=$h_memid&code=both\">"; exit(); }
	else { $sql8 = "update flc_member set mem_user = '$t_emanresu', mem_folder = '$t_emanhtap' where mem_id = '$h_memid';"; $result8 = mysql_query($sql8); }

	if ($usercheck == 'f') {
		$sql8 = "update flc_member set mem_user = '' where mem_id = '$h_memid';"; $result8 = mysql_query($sql8);
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = touroku_edit.php?id=$h_memid&code=user\">"; exit();
	} else { $sql8 = "update flc_member set mem_user = '$t_emanresu' where mem_id = '$h_memid';"; $result8 = mysql_query($sql8); }

	if ($pathcheck == 'f') {
		$sql8 = "update flc_member set mem_folder = '' where mem_id = '$h_memid';"; $result8 = mysql_query($sql8);
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = touroku_edit.php?id=$h_memid&code=path\">"; exit();
	} else { $sql8 = "update flc_member set mem_folder = '$t_emanhtap' where mem_id = '$h_memid';"; $result8 = mysql_query($sql8); }

	// --- Make Folder Section

	if ($pathcheck != 'f') {

		umask(0);
		if(!mkdir($_SERVER['DOCUMENT_ROOT'] . "/home/$t_emanhtap",0777,true)){
			exit("folder `home/$t_emanhtap` not exists");
		}

	}

	// --- Mail Section

		$subject = "[ ファクトリンク (Fact-link.com.vn) ] 会員登録のご確認　Membership Confirmation.";
		$detail = "<html>
		<body>
		<table width=\"650\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">
		  <tr>
		    <td colspan=\"3\"><img src=\"http://www.fact-link.com.vn/images/mail_01.jpg\" width=\"650\" height=\"75\" /></td>
		  </tr>
		  <tr>
		    <td width=\"20\" background=\"http://www.fact-link.com.vn/images/mail_02.jpg\">&nbsp;</td>
		    <td width=\"610\"><p><font style=\"color: #CC0000; font-weight: bold; font-size: 18px;\">会員情報の確認 / Membership confirmation</font><br />
		      <br />
			  <font color=\"#00000\">この度は 製造業ポータルサイト <strong>fact-link.com.vn</strong> へご入会いただき、誠にありがとうございます。<br />
		お客様からのご登録を、以下の通り受け付けさせていただきました。お客様のユーザー名とパスワードは以下の通りです。<br />
		<br />
		貴社ページを作成するには、ログインの上ページ情報の作成を行なってください。ページ情報の作成はログイン後の管理画面のメニュー「ページ管理」から行うことができます。ページ情報の作成後、貴社ページが公開されます。<br />
		<br />
		Thank you for your registration at <strong>fact-link.com.vn</strong>.<br />
		To create your page, you need to create / edit your company's information. Please log in with your account information and go to ' Page Management' Menu. After you create / edit your company's information, your companys' page will be published.<br />
		Your username and password is shown below :<br />
		<br />
		------------------------------------------------------------<br />
		■ログイン画面 / Login at :<br />
		<br />
		　　　http://www.fact-link.com.vn/<br />
		<br />
		------------------------------------------------------------<br />
		■アカウント情報 / Your account information :<br />
		<br />
		　<strong>ユーザー名 / Username :</strong> ".$t_emanresu."<br />
		　<strong>パスワード / Password :</strong> ".$t_password."<br />
		<br />
		パスワードはサイト上で変更できます。ログイン→パスワード変更<br />
		You can change your password by login at http://www.fact-link.com.vn/ and Change Password.<br />
		<br />
		★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★<br />
		当サイトの最大の魅力は、簡単にお客様自身のホームページを開設<br />
		できることです。専用ホームページを作ることで、インターネット<br />
		上で広く情報を発信したり、お問合せを受け付けたり、当サイトの<br />
		企業データベースへ登録することが可能となります。<br />
		ホームページの作成は非常に簡単です、ぜひご活用ください。<br />
		★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★<br />
		<br />
		You can make your website easily at http://www.fact-link.com.vn/<br />
		which will also link your website to our company's database<br />
		therefore you can promote your company and obtain more<br />
		business offers. Make the most use our service !<br />
		------------------------------------------------------------<br />
		■専用ホームページ領域 / This is your domain name :<br />
		<br />
		　http://www.fact-link.com.vn/home/".$t_emanhtap." <br />
		<br />
		この領域にお客様のホームページが作成されます。<br />
		ページ構築を行なうには、ホームページ作成ツールにログインしてください。<br />
		This URL will link to your webpage after created.<br />
		To create your webpage, please login and click Page Mangagement.<br />
		------------------------------------------------------------<br />
		■登録情報 / Your company's profile :<br />
		<br />
		　<strong>会社名 / Company name</strong><br />
		　".$t_emanmoc_jp."<br />
		　".$t_emanmoc_en."<br />
		　<strong>住所 / Address</strong><br />
		　".$t_sserddamoc_en." ".$prvname." ".$t_pizmoc." ".$t_yrtnuocmoc."<br />
		　<strong>工業団地 / Industrial Estate</strong><br />
		　".$inename."<br />
		　<strong>TEL</strong><br />
		　".$t_letmoc."<br />
		　<strong>FAX</strong><br />
		　".$t_xafmoc."<br />
		　<br />
		　<strong>担当者名 / Contact Name</strong><br />
		　".$t_tcatnoc_jp."<br />
		　".$t_tcatnoc_en."<br />
		　<strong>役職 / Position</strong><br />
		　".$t_noitisop_en."<br />
		　<strong>E-mail</strong><br />
		　".$t_liam."<br />
		　<strong>TEL</strong><br />
		　".$t_let."<br />
		　<br />
		登録情報はサイト上で変更できます。ログイン→ユーザー情報<br />
		To change your company's profile you need to login to our website.<br />
		------------------------------------------------------------<br />
		有料会員になると、ファクトリンク内で上位に表示され、より多くの情報を提供できます。詳しくは<a href=\"https://www.fact-link.com.vn/intro?lang=jp\" target=\"_blank\">こちら</a>をご覧ください。<br />
		If you become a paid member of Fact-Link Vietnam, your page will be shown more. Also you can provide richer information than now. For more
		details, please refer to <a href=\"https://www.fact-link.com.vn/intro?lang=en\" target=\"_blank\">this page</a>. 
		<br />
		------------------------------------------------------------<br />
		このメールは自動的に送信されております。一部のサービスは、<br />
		当サイトにて登録承認が行なわれた後に利用可能となりますので、<br />
		今しばらくお待ちください。<br />
		<br />
		もし、このメールに心当たりが無い場合は info@fact-link.com.vn までお知らせください。<br />
		今後とも 製造業ポータルサイト fact-link.com.vn をよろしくお願い申し上げます。<br />
		<br />
		This mail is automatically sent to you.<br />
		Part of our service will be activated after we confirm your registration.<br />
		If you have no information why this mail was sent to you,<br />
		contact : info@fact-link.com.vn <br />
		<br />
		------------------------------------------------------------<br />
		ベトナムの日系製造業を結ぶポータルサイト<br />
		http://www.fact-link.com.vn</font>
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
	$mail->SetFrom("info@fact-link.com.vn", "Fact-Link Vietnam");
	$mail->AddReplyTo("info@fact-link.com.vn", "Staff");
	$mail->Subject = "$subject";
	$mail->MsgHTML($body);
	$mail->AddAddress("$t_liam", "Customer"); // ผู้รับคนที่หนึ่ง
	$mail->AddAddress("factlinkvn.noreply@gmail.com", "staff"); // ผู้รับคนที่สอง

	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
		exit;
	} else {
		// echo "Message sent!";
	}

} // end  Barricade

		echo "<meta http-equiv = \"refresh\" content = \"0;URL = touroku_done.php?id=$h_memid\">";

	exit();
?>

<?php

	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	/* Only accept submit data from following URI to prevent XSS attack */
	$allow[] = 'https://www.fact-link.com.vn/touroku.php';
	$allow[] = 'https://fact-link.com.vn/touroku.php';
	
	if(!in_array($_SERVER["HTTP_REFERER"],$allow)){
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = touroku_done.php?id=$memid&case=adress\">";
		exit();
	}
	
	// Escape special charactars
	// $ip = $_SERVER['REMOTE_ADDR'];
	// $captchaToken = $_POST['g-recaptcha-response'];

	// $isValidCaptcha = validateReCaptcha($captchaSecretKey, $captchaToken, $ip);
	// if ($isValidCaptcha == false) {
	// 	echo "<meta http-equiv = \"refresh\" content = \"0;URL = touroku_done.php?id=$memid&case=bot\">";
	// 	exit();
	// }

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);

	

	$t_emanresu = $_POST['t_emanresu'];
	$t_emanhtap = $_POST['t_emanhtap'];
	$t_emanmoc_en = $_POST['t_emanmoc_en'];
	$t_emanmoc_jp = $_POST['t_emanmoc_jp'];
	$t_emanmoc_vn = $_POST['t_emanmoc_vn'];
	$t_tacmem = $_POST['t_tacmem'];
	$t_eimoc = $_POST['t_eimoc'];
	$t_sserddamoc_en = $_POST['t_sserddamoc_en'];
	$t_sserddamoc_jp = $_POST['t_sserddamoc_jp'];
	$t_sserddamoc_vn = $_POST['t_sserddamoc_vn'];
	$t_ecnivorpmoc = $_POST['t_ecnivorpmoc'];
	$t_yrtnuocmoc = $_POST['t_yrtnuocmoc'];
	$t_pizmoc = $_POST['t_pizmoc'];
	$t_letmoc = $_POST['t_letmoc'];
	$t_xafmoc = $_POST['t_xafmoc'];
	$t_tcatnoc_en = $_POST['t_tcatnoc_en'];
	$t_tcatnoc_jp = $_POST['t_tcatnoc_jp'];
	$t_tcatnoc_vn = $_POST['t_tcatnoc_vn'];
	$t_noitisop_en = $_POST['t_noitisop_en'];
	$t_noitisop_jp = $_POST['t_noitisop_jp'];
	$t_noitisop_vn = $_POST['t_noitisop_vn'];
	$t_redneg = $_POST['t_redneg'];
	$t_liam = $_POST['t_liam'];
	$t_othliam = $_POST['t_oth_contactmail'];
	$t_let = $_POST['t_let'];
	$t_national = $_POST['t_national']; // National for sorting in category, added 2011.07.04, for VN only


	// Prevent Spam From "SECRETCODE" Name
	if ($t_emanmoc_en == "SECRETCODE" || $t_emanmoc_jp == "SECRETCODE" || $t_emanmoc_vn == "SECRETCODE" || $t_emanresu == "SECRETCODE" || $t_emanhtap == "SECRETCODE" || $t_liam =="SECRETCODE" || $t_let == "SECRETCODE") {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = touroku_done.php?id=$memid&case=ip\">";
		exit();
	}
	//	start  Barricade
	if ($t_letmoc != '123456') {

		if ($t_emanmoc_jp == '') { $t_emanmoc_jp = $t_emanmoc_en; }
		if ($t_emanmoc_vn == '') { $t_emanmoc_vn = $t_emanmoc_en; }
		if ($t_sserddamoc_jp == '') { $t_sserddamoc_jp = $t_sserddamoc_en; }
		if ($t_sserddamoc_vn == '') { $t_sserddamoc_vn = $t_sserddamoc_en; }
		if ($t_tcatnoc_jp == '') { $t_tcatnoc_jp = $t_tcatnoc_en; }
		if ($t_tcatnoc_vn == '') { $t_tcatnoc_vn = $t_tcatnoc_en; }
		if ($t_noitisop_jp == '') { $t_noitisop_jp = $t_noitisop_en; }
		if ($t_noitisop_vn == '') { $t_noitisop_vn = $t_noitisop_en; }

		$t_password = randompass(0);


		$sql4 = "select * from flc_ie where ine_id = '$t_eimoc';";
		$result4 = mysql_query($sql4);
		while ($dbarr4 = mysql_fetch_array($result4)) {
			$inename = $dbarr4['ine_name_en'];
		}

		$sql5 = "select * from flc_province where prv_id = '$t_ecnivorpmoc';";
		$result5 = mysql_query($sql5);
		while ($dbarr5 = mysql_fetch_array($result5)) {
			$prvname = $dbarr5['prv_name_en'];
		}

		$sql9 = "select * from flc_country where cty_id = '$t_yrtnuocmoc';";
		$result9 = mysql_query($sql9);
		while ($dbarr9 = mysql_fetch_array($result9)) {
			$ctyname = $dbarr9['cty_name_en'];
		}



		$sql1 = "insert into flc_member (mem_pass, mem_comname_en, mem_comname_jp, mem_comname_vn, mem_category, mem_address1_en, mem_address1_jp, mem_address1_vn,
						mem_addressine1, mem_addressprv1, mem_addresscty1, mem_addresszip1, mem_comtel, mem_comfax, mem_contactname_en, mem_contactname_jp, mem_contactname_vn,
						mem_contactposition_en, mem_contactposition_jp, mem_contactposition_vn, mem_contactgender, mem_contactmail, mem_oth_contactmail, mem_contacttel, mem_template, mem_registdate, mem_registip, mem_national)
						values ('$t_password', '$t_emanmoc_en', '$t_emanmoc_jp', '$t_emanmoc_vn', '$t_tacmem', '$t_sserddamoc_en', '$t_sserddamoc_jp', '$t_sserddamoc_vn',
						'$t_eimoc', '$t_ecnivorpmoc', '$t_yrtnuocmoc', '$t_pizmoc', '$t_letmoc', '$t_xafmoc', '$t_tcatnoc_en', '$t_tcatnoc_jp', '$t_tcatnoc_vn', '$t_noitisop_en', '$t_noitisop_jp', '$t_noitisop_vn',
						'$t_redneg', '$t_liam', '$t_othliam', '$t_let', '001', '$nowdate', '$getip', '$t_national');";
		$result1 = mysql_query($sql1) or die('Can not issert member');




		/* Get `mem_id` after insert */
		$sql2 = "select * from flc_member order by mem_id desc limit 0,1;";
		$result2 = mysql_query($sql2);
		while ($dbarr2 = mysql_fetch_array($result2)) {
			$memid = $dbarr2['mem_id'];
		}

		/* Validate [a-z0-9-_] */
		$charusername = charscheck($t_emanresu);
		$charpathname = charscheck($t_emanhtap);

		/*  */
		if ($charusername == 'f') {
			$usercheck = "f";
		} else {
			$sql6 = "select * from flc_member where mem_user = '$t_emanresu';";
			$result6 = mysql_query($sql6);
			while ($dbarr6 = mysql_fetch_array($result6)) {
				$usercheck = "f";
				$confirmmail = "f";
			}
		}


		/*  */
		if ($charpathname == 'f') {
			$pathcheck = "f";
		} else {
			$sql7 = "select * from flc_member where mem_folder = '$t_emanhtap';";
			$result7 = mysql_query($sql7);
			while ($dbarr7 = mysql_fetch_array($result7)) {
				$pathcheck = "f";
				$confirmmail = "f";
			}
		}


		/*  */
		if ($usercheck == 'f' && $pathcheck == 'f') {
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = touroku_edit.php?id=$memid&code=both\">";
			exit();
		} else {
			$sql8 = "update flc_member set mem_user = '$t_emanresu', mem_folder = '$t_emanhtap' where mem_id = '$memid';";
			$result8 = mysql_query($sql8);
		}


		/*  */
		if ($usercheck == 'f') {
			$sql8 = "update flc_member set mem_user = '' where mem_id = '$memid';";
			$result8 = mysql_query($sql8);
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = touroku_edit.php?id=$memid&code=user\">";
			exit();
		} else {
			$sql8 = "update flc_member set mem_user = '$t_emanresu' where mem_id = '$memid';";
			$result8 = mysql_query($sql8);
		}


		/*  */
		if ($pathcheck == 'f') {
			$sql8 = "update flc_member set mem_folder = '' where mem_id = '$memid';";
			$result8 = mysql_query($sql8);
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = touroku_edit.php?id=$memid&code=path\">";
			exit();
		} else {
			$sql8 = "update flc_member set mem_folder = '$t_emanhtap' where mem_id = '$memid';";
			$result8 = mysql_query($sql8);
		}



		# region "Create Folder" ================================================================
		// --- Make Folder Section

		umask(0);
		if(!mkdir($_SERVER['DOCUMENT_ROOT'] . "/home/$t_emanhtap",0777,true)){
			exit("folder `home/$t_emanhtap` not exists");
		}
		

		# end region "Create folder"

		# region "Send Email" ===================================================================

		// require("./PHPMailer/class.phpmailer.php");

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
		お客様からのご登録を、以下の通り受け付けさせていただきました。<br />
		<br />
		当サイトのサービスを利用するには、まず基本情報の登録を行なってください。<br />
		お客様のユーザー名とパスワードは以下の通りです。<br />
		<br />
		Thank you for your registration at <strong>fact-link.com.vn</strong>.<br />
		To make use of our service, you need to provide your company's information.<br />
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
			<td width=\"20\" background=\"http://www.fact-link.com.vn/images/mail_03.jpg\">&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan=\"3\"><img src=\"http://www.fact-link.com.vn/images/mail_04.jpg\" width=\"650\" height=\"40\" /></td>
		  </tr>
		</table>
		</body>
		</html>";


		//.................................................... START PHPMAILER ...............................................................

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

		//.................................................END PHPMAILER..................................................................

		# end region "Send Email"



	} // end  Barricade

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = touroku_done.php?id=$memid\">";
	exit();

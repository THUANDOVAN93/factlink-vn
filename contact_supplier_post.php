<?php

	session_start();
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	/* Only accept submit data from following URI to prevent XSS attack */
	// $allow[] = 'https://www.fact-link.com.vn/contact_supplier.php';
	// $allow[] = 'https://fact-link.com.vn/contact_supplier.php';
	
	// $reURI = substr($_SERVER["HTTP_REFERER"], 0, strpos($_SERVER["HTTP_REFERER"], "?"));
	// if(!in_array($reURI,$allow)) {
	// 	echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_supplier_done.php?case=uri\">";
	// 	exit();
	// }
	
	mysql_query("use $db_name;");

	if ( isset($_POST['b_ok']) && !empty($_POST['b_ok']) ) {
		
		$t_company = mysql_real_escape_string($_POST['t_company']);
		$t_contact = mysql_real_escape_string($_POST['t_contact']);
		$t_tel = mysql_real_escape_string($_POST['t_tel']);
		$t_mobile = mysql_real_escape_string($_POST['t_mobile']);
		$t_fax = mysql_real_escape_string($_POST['t_fax']);
		$t_mail = mysql_real_escape_string($_POST['t_mail']);
		$t_subject = mysql_real_escape_string($_POST['t_subject']);
		$t_detail = mysql_real_escape_string($_POST['t_detail']);
		$t_product_name = mysql_real_escape_string($_POST['t_product_name']);
		$t_supplier_name = mysql_real_escape_string($_POST['t_supplier_name']);
		$t_supplier_id = mysql_real_escape_string($_POST['t_supplier_id']);
		$t_supplier_id_format = sprintf("%08d", $t_supplier_id);
		$t_product_id = mysql_real_escape_string($_POST['t_product_id']);

		// Spam mail check

		if (substr_count($t_detail,"</a>") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_supplier_done.php?case=secure\">"; exit();
		}
		if (substr_count($t_detail,"<>") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_supplier_done.php?case=secure\">"; exit();
		}
		if (substr_count($t_detail,">") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_supplier_done.php?case=secure\">"; exit();
		}
		if (substr_count($t_detail,"<") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_supplier_done.php?case=secure\">"; exit();
		}
		if (substr_count($t_detail,"<a>") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_supplier_done.php?case=secure\">"; exit();
		}
		if (substr_count($t_detail,"<br>") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_supplier_done.php?case=secure\">"; exit();
		}
		if (substr_count($t_detail,"</br>") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_supplier_done.php?case=secure\">"; exit();
		}
		if (substr_count($t_detail,"br>") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_supplier_done.php?case=secure\">"; exit();
		}
		if (substr_count($t_detail,"<br") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_supplier_done.php?case=secure\">"; exit();
		}
		if (substr_count($t_detail,"br") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_supplier_done.php?case=secure\">"; exit();
		}
		if (substr_count($t_detail,"[/url]") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_supplier_done.php?case=secure\">"; exit();
		 }
		if (substr_count($t_detail,"[/link]") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_supplier_done.php?case=secure\">"; exit();
		}
		if (substr_count($t_detail,"€") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_supplier_done.php?case=secure\">"; exit();
		}
		if (substr_count($t_detail,"ㄣ") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = contact_supplier_done.php?case=secure\">"; exit();
		}



		$arr_ip=explode(".",$get_ip);
		if(is_numeric($arr_ip[3])){
			if ($t_subject != '') {

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

				//Add mail contact
				// $sql1 = "
				// 	insert into flc_contact (
				// 		ctt_company, ctt_contact, ctt_tel,
				// 		ctt_mobile, ctt_fax, ctt_mail,
				// 		ctt_subject, ctt_detail, ctt_date, ctt_time
				// 	) values (
				// 		'$t_company', '$t_supplier_name', '$t_tel', '$t_mobile', '$t_fax',
				// 		'$t_mail', '$t_subject', '$t_detail', '$nowdate', '$nowtime'
				// 	);";
				
				// $result1 = mysql_query($sql1);

				// Code  inquiry mail product mal_case = 4
				$sql2 = "
					insert into
							flc_mail (
								mem_id,
								product_id,
								mal_from_name,
								mal_from_mail,
								mal_company,
								mal_tel,
								mal_fax,
								mal_subj,
								mal_detail,
								mal_date,
								mal_time,
								mal_warningdate,
								mal_ip,
								mal_box,
								mal_status,
								mal_send,
								mal_case
							)	values (
								'$t_supplier_id_format',
								'$t_product_id',
								'$t_company',
								'$t_mail',
								'$t_supplier_name',
								'$t_tel',
								'$t_fax',
								'$t_subject',
								'$t_detail',
								'$nowdate',
								'$nowtime',
								'$warndate',
								'$getip',
								'i',
								'n',
								'n',
								'4'
							);";
				$result2 = mysql_query($sql2);




				$sqlGetMailSup = "select mem_contactmail from flc_member where mem_id = $t_supplier_id_format;";
				$rsGetMailSup = mysql_query($sqlGetMailSup);
				$getMailSup = mysql_fetch_array($rsGetMailSup);
				$mailSup = $getMailSup['mem_contactmail'];


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
							      <font color=\"#00000\">製造業ポータルサイト <a herf=\"https://www.fact-link.com.vn\" target=\"_blank\">Fact-Link.com</a> にて開設されております 御社ホームページのメールフォームから、<br />新しいお問合わせがありました。
お客様のアカウントにログインして、内容をご確認ください。<br /><br />You have received a new enquiry message from your website. <br />Please login in order to read your new message.</font><br />
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
								<font color=\"#000000\"><strong>E-mail</strong></font><br />
								<font color=\"#000000\">".$t_mail."</font><br />
							    <font color=\"#000000\"><strong>Tel.</strong></font><br />
							    <font color=\"#000000\">".$t_tel."</font><br />
								<font color=\"#000000\"><strong>Mobile</strong></font><br />
							    <font color=\"#000000\">".$t_mobile."</font><br />
								<font color=\"#000000\"><strong>Fax</strong></font><br />
								<font color=\"#000000\">".$t_fax."</font><br />
								<font color=\"#000000\"><strong>Product</strong></font><br />
								<font color=\"#000000\">".$t_product_name."</font><br />
								<font color=\"#000000\"><strong>SKU</strong></font><br />
								<font color=\"#000000\">#".$t_product_id."</font><br />
								<font color=\"#000000\"><strong>Supplier</strong></font><br />
								<font color=\"#000000\">".$t_supplier_name."</font><br/>

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
								担当はベトナム人のTruc (info@fact-link.com.vn、0888 767 138 )となりますので、何か不明点がございましたらご連絡をいただければ幸いです。</br>
								If you have any further support, please contact us via email: Ms. Truc ( info@fact-link.com.vn, (+ 84) 888 767 138) 
								<br />
								------------------------------------------------------------</font>
								<font color=\"#00000\"><br />
								このメールには返信できません。<br />
								Don't reply this E-mail.<br />
								</font>
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

				/** PHPMailer
				 *	(always try/catch third party SourceCode)
				 */
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
					
					/* Prepare Email content */
					//$mail->SetFrom("info@fact-link.com.vn",'Fact-Link');
					$mail->SetFrom("factlinkportvn@gmail.com",'Fact-Link');
					$mail->Subject = $subject;
					$mail->MsgHTML($detail);
					$mail->AddAddress("info@fact-link.com.vn");
					//$mail->AddAddress("thuandovan93@gmail.com");
					//$mail->AddAddress($mailSup);

					/* Send email! */
					if(!$mail->Send()) {
					} else {
					}
					
				} catch ( Exception $exception ) {
					throw $exception;
				}

				echo "<meta http-equiv=\"refresh\" content = \"0;URL = contact_supplier_done.php\">";
				exit();				
			}
		}

	} else {
		echo "<meta http-equiv=\"refresh\" content = \"0;URL = contact_supplier_done.php?case=misva\">";
		exit();
	}
	echo "<meta http-equiv=\"refresh\" content = \"0;URL = contact_supplier_done.php\">";
	exit();
?>

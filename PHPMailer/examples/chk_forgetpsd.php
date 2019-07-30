<?php 
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	include_once("./include/function.php");
	ini_set("session.gc_maxlifetime", "18000");
  		$lang =$_COOKIE['lang'];
	
		
// Lang Dictionary Include
		if ($lang == 'en') { include_once("./lang/lang_en.php"); } 
		if ($lang == 'jp')  { include_once("./lang/lang_jp.php"); }
	//	if ($lang == 'lc' or $lang=='th') { include_once("./lang/lang_th.php"); } 
// ======================================================================================
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?
//echo $_POST['type'];
		 $type=$_POST['type'];
		 echo "User-->ระดับ :".$type."---------------->";
		 if($type=="person"){
		 
		 	$tb_name ="tb_person";
			$f_user="prs_user";
			$f_email="prs_email";
			$f_acti="prs_activation";

		 }
		 if($type=="company"){
		 
		 	$tb_name="tb_company";
			$f_user="cpn_user";
			$f_pass="cpn_pass";
			$f_email="cpn_contactemail";
			$and="";

		 }
		 //input form login
		 //input form login
		// if($_POST['login']){$cuser=$_POST['login'];}
		 if($_POST['email']){$cemail=$_POST['email'];}
		 
		 if(isset($cemail)){
			 $prs_activation=md5(generateRandomString());
		echo	 $sql_login="SELECT * FROM $tb_name WHERE    $f_email='$cemail' $and;";//$sql_login="SELECT * FROM $tb_name WHERE  $f_user ='$cuser' AND  $f_email='$cemail' $and;";
			 $query_login = mysql_db_query($db_name,$sql_login) ;
			 $num_login = mysql_num_rows($query_login); 
    		 while($fetch_login = mysql_fetch_array($query_login)){
				 if($type=="person"){
				 $prs_id=$fetch_login['prs_id'];
				 $prs_user=$fetch_login['prs_user'];	
				 $prs_pass=$fetch_login['prs_pass'];
				 }
				 if($type=="company"){//cpn_id	cpn_user	cpn_pass
				 $prs_id=$fetch_login['cpn_id'];
				 $prs_user=$fetch_login['cpn_user'];	
				 $prs_pass=$fetch_login['cpn_pass'];
					 }
				 $lgn++;
				 }
			  if($lgn>=1){
				  $message="ระบบได้จดส่ง ยูเซอร์เนมและรหัสผ่าน ไปยังอีเมล์ที่ได้ลงทะเบียนเรียบร้อยแล้ว (หากไม่มีอยู่ในอินบ๊อค กรุณาตรวจสอบจั๊งเมล์)";
				   strdecode("$prs_pass","$prs_user");
	//************************************* PHP Mailer call Function **************************************************//			   
				   
  require(dirname(__FILE__)."/PHPMailer/class.phpmailer.php");
 //
 //$htmlbody = file_get_contents("htmlemail-template.php");
 if($_COOKIE['lang']=='th' or $_COOKIE['lang']=='lc'){
  $htmlbody = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml">
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>maneki-job.com  </title>
 </head>
 
 
<body>
 <div dir="ltr"></div><div class="gmail_extra"><br><br>
<div class="gmail_quote">'.date("Y/m/d").' Maneki-job.com Member <span dir="ltr">&lt;
<a href="mailto:noreply@maneki-job.com" target="_blank">noreply@maneki-job.com</a>&gt;</span><br><blockquote class="gmail_quote" style="margin:0 0 0 .8ex;border-left:1px #ccc solid;padding-left:1ex">
<table width="100%" style="background:rgb(242,242,242)" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td>
<table align="center" style="width:750px" border="0" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td style="padding:30px 0px 15px;width:950px;text-align:center;color:rgb(102,102,102);font-family:thonburi,tahoma;font-size:13px">
				คุณได้รับอีเมล์ฉบับนี้เพราะคุณเป็น "สมาชิก" บนเว็บไซต์ <a style="color:rgb(102,102,102);font-family:Thonburi,Tahoma;font-size:13px;text-decoration:none" href="http://www.maneki-job.com" target="_blank">Maneki-job.com</a>
			</td>
		</tr>
		<tr>
			<td>
				<table width="750" style="border:1px solid rgb(207,207,207)" bgcolor="#ffffff" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td valign="top" style="padding:15px 25px 0px">
							<a title="Go to www.Maneki-job.com" style="border:currentColor;text-decoration:none" href="http://www.maneki-job.com" target="_blank">
                            <img src="cid:header" alt="MANEKI-JOB โอกาส..สร้างคน คน..สร้างงาน  เว็บไซต์หางาน สมัครงาน ยอดนิยมอันดับหนึ่งของคนไทย ผู้นำด้านสื่อกลางในการหางานที่ดีที่สุด" width="849" height="275" border="0" style="border: solid 1px; border-radius:5px;"></a>
							</td>
						</tr>
						<tr>
							<td style="margin:0px;padding:25px 25px 0px;color:rgb(51,51,51);font-family:thonburi,tahoma;font-size:15px;font-weight:bold">
								เรียน สมาชิก Maneki-job 
							</td>
						</tr>
						<tr>
							<td style="margin:0px;padding:15px 25px 0px;color:rgb(102,102,102);font-family:thonburi,tahoma;font-size:13px">
								
ยินดีต้อนรับสู่การเป็นสมาชิก Maneki-job ในการใช้บริการเว็บไซต์ครั้งต่อไปคุณสามารถใช้ชื่ออีเมล์หรือชื่อสมาชิกต่อไปนี้ ในการเข้าสู่ระบบได้ทันที  

							</td>
						</tr>
						<tr>
							<td style="font:bold 15px/normal thonburi,tahoma;margin:0px;padding:15px 25px 0px;color:rgb(51,51,51);font-size-adjust:none;font-stretch:normal">
							  <table width="750" style="text-align:center" border="0" cellspacing="0" cellpadding="0">
									<tbody>
										<tr>
											<td>
												<table width="670" style="background:rgb(242,242,242);text-align:left" border="0" cellspacing="0" cellpadding="0">
													<tbody>
														<tr>
															<td style="padding:5px 0px 0px;width:10%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px"><strong>ชื่อสมาชิก:</strong> </td>
                                                     <td style="padding:5px 0px 0px;width:90%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px">'.$prs_user.'</td>
														</tr>
														<tr>
															<td style="padding:5px 0px 0px;width:10%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px"><strong>รหัสผ่าน:</strong> </td>
                                                     <td style="padding:5px 0px 0px;width:90%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px">'.strdecode("$prs_pass","$prs_user").'</td>

														</tr>
														<tr>
														  <td style="padding:5px 0px 0px;width:10%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px"><strong>ชื่ออีเมล์:</strong></td>
														  <td style="padding:5px 0px 0px;width:90%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px"><a href="mailto:'.$cemail.'" style="padding:30px 0px 0px;color:rgb(111,203,243);font-family:Thonburi,Tahoma;font-size:13px;text-decoration:none" target="_blank">'.$cemail.'</a></td>
													  </tr>
														<tr>
														  <td style="padding:5px 0px 0px;width:10%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px">&nbsp;</td>
														  <td style="padding:5px 0px 0px;width:90%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px">&nbsp;</td>
													  </tr>
														<tr>
														  <td colspan="2" style="padding:5px 0px 0px;width:10%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px"><a href="http://www.facebook.com/manekijob" target="_blank"><img src="cid:like-fanpage" alt="" width="181" height="103" border="0"/></a></td>
													  </tr>
														
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
							  </table>
							  <br /></td>
						</tr>
						
						<tr>
							<td style="padding:30px 0px 0px;text-align:center;color:rgb(102,102,102);font-family:Thonburi,Tahoma;font-size:13px">หากมีข้อสงสัย กรุณาติดต่อทีมงาน Maneki-job ที่พร้อมให้คำแนะนำในการลงประกาศตำแหน่งงานกับคุณ 

</td>
						</tr>
                        <tr>
							<td style="padding:0px;text-align:center;color:rgb(102,102,102);font-family:Thonburi,Tahoma;font-size:13px">ที่หมายเลขโทรศัพท์ 02 260 3698 , 02 665 6170   หรือทางอีเมล์   <a style="padding:30px 0px 0px;color:rgb(111,203,243);font-family:Thonburi,Tahoma;font-size:13px;text-decoration:none" href="mailto:staff@maneki-job.com" target="_blank">staff@maneki-job.com</a></td>

						</tr>
						
						<tr>
							<td style="padding:20px 25px 5px;color:rgb(102,102,102);font-family:thonburi,tahoma;font-size:13px">ขอบพระคุณ</td>
						</tr>
						<tr>
							<td style="padding:0px 25px 50px;color:rgb(102,102,102);font-family:thonburi,tahoma;font-size:13px">ทีมงานเว็บไซต์ Maneki-job</td>
						</tr>
                        <tr>
							<td style="padding:0px 25px 50px;color:rgb(102,102,102);font-family:thonburi,tahoma;font-size:13px"></td>
						</tr> 
                        
					</tbody>
				</table>
			</td>
		</tr>
		
		<tr>
			<td style="padding:25px 0px 0px;text-align:center;color:rgb(153,153,153);font-family:Thonburi,Tahoma;font-size:12px">อีเมล์นี้จัดทำและส่งจากทีมงานผู้ดูแลเว็บไซต์  <a style="color:rgb(153,153,153);font-family:Thonburi,Tahoma;font-size:13px;text-decoration:none" href="http://www.Maneki-job.com" target="_blank">Maneki-job.com</a></td>

		</tr>
		<tr>
			<td style="padding:5px 0px 0px;text-align:center;color:rgb(153,153,153);font-family:Thonburi,Tahoma;font-size:12px">สงวนลิขสิทธิ์ 2557 บริษัท TDC อินเตอร์เนชั่นแนล, จำกัด 
75/35 อาคารริชมอนด์ออฟฟิศ. ชั้น 12A. </td>
		</tr>
		<tr>
			<td style="padding:5px 0px 0px;text-align:center;color:rgb(153,153,153);font-family:Thonburi,Tahoma;font-size:12px">ซอยสุขุมวิท 26, ถ. สุขุมวิท. คลองตันคลองเตยกรุงเทพฯ 10110 โทรศัพท์ <a style="color:rgb(153,153,153);font-family:Thonburi,Tahoma;font-size:12px;text-decoration:none" href="tel:026164000" target="_blank">+02 260 3698 , 02 665 6170 </a>โทรสาร <a style="color:rgb(153,153,153);font-family:Thonburi,Tahoma;font-size:12px;text-decoration:none" href="tel:022403666" target="_blank">+662-240-3666</a></td>

		</tr>
		<tr>
			<td style="padding:5px 0px 30px;text-align:center;color:rgb(153,153,153);font-family:Thonburi,Tahoma;font-size:12px">เว็บไซต์<a style="color:rgb(111,203,243);font-family:Thonburi,Tahoma;font-size:12px;text-decoration:none" href="http://www.maneki-job.com" target="_blank">www.maneki-job.com</a></td>

		</tr>
	</tbody>
</table>
</td>
</tr>
</tbody>
</table>


</blockquote></div><br></div>

 </body>
 </html>';
 }else{
 $htmlbody = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml">
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>maneki-job.com email</title>
 </head>
 
 
<body>
<div class="gmail_extra"><br><br>
<div class="gmail_quote">'.date("Y/m/d").'Maneki-job.com Member <span dir="ltr">&lt;
<a href="mailto:noreply@maneki-job.com" target="_blank">noreply@maneki-job.com</a>&gt;</span><br><blockquote class="gmail_quote" style="margin:0 0 0 .8ex;border-left:1px #ccc solid;padding-left:1ex">
<table width="100%" style="background:rgb(242,242,242)" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td>
<table align="center" style="width:750px" border="0" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td style="padding:30px 0px 15px;width:950px;text-align:center;color:rgb(102,102,102);font-family:thonburi,tahoma;font-size:13px">
				You received this email because you are. "Member companies" on site .<a style="color:rgb(102,102,102);font-family:Thonburi,Tahoma;font-size:13px;text-decoration:none" href="http://www.Maneki-job.com" target="_blank">Maneki-job.com</a>
			</td>
		</tr>
		<tr>
			<td>
				<table width="750" style="border:1px solid rgb(207,207,207)" bgcolor="#ffffff" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td valign="top" style="padding:15px 25px 0px">
							<a title="Go to www.Maneki-job.com" style="border:currentColor;text-decoration:none" href="http://www.maneki-job.com" target="_blank">
                            <img src="cid:header" alt="MANEKI-JOB opportunities .. A man .. A popular website Seekers one of Thailand. Leading intermediary in finding the best " width="849" height="275" border="0" style="border: solid 1px; border-radius:5px;"></a>
							</td>
						</tr>
						<tr>
							<td style="margin:0px;padding:25px 25px 0px;color:rgb(51,51,51);font-family:thonburi,tahoma;font-size:15px;font-weight:bold">
							Dear Members Maneki-job 
							</td>
						</tr>
						<tr>
							<td style="margin:0px;padding:15px 25px 0px;color:rgb(102,102,102);font-family:thonburi,tahoma;font-size:13px">
								
Welcome to the membership of the Service Maneki-job site the next time you use your email address or username below. Log in now.

							</td>
						</tr>
						<tr>
							<td style="font:bold 15px/normal thonburi,tahoma;margin:0px;padding:15px 25px 0px;color:rgb(51,51,51);font-size-adjust:none;font-stretch:normal">
								<table width="700" style="text-align:center" border="0" cellspacing="0" cellpadding="0">
									<tbody>
										<tr>
											<td>
												<table width="670" style="background:rgb(242,242,242);text-align:left" border="0" cellspacing="0" cellpadding="0">
													<tbody>
														<tr>
															<td style="padding:5px 0px 0px;width:10%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px"><strong>Username:</strong> </td>
                                                     <td style="padding:5px 0px 0px;width:90%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px">'.$prs_user.'</td>
														</tr>
														<tr>
															<td style="padding:5px 0px 0px;width:10%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px"><strong>Password:</strong> </td>
                                                     <td style="padding:5px 0px 0px;width:90%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px">'.strdecode("$prs_pass","$prs_user").'</td>

														</tr>
														<tr>
														  <td style="padding:5px 0px 0px;width:10%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px"><strong>Email:</strong></td>
														  <td style="padding:5px 0px 0px;width:90%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px"><a href="mailto:'.$cemail.'" style="padding:30px 0px 0px;color:rgb(111,203,243);font-family:Thonburi,Tahoma;font-size:13px;text-decoration:none" target="_blank">'.$cemail.'</a></td>
													  </tr>
														<tr>
														  <td style="padding:5px 0px 0px;width:10%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px">&nbsp;</td>
														  <td style="padding:5px 0px 0px;width:90%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px">&nbsp;</td>
													  </tr>
														<tr>
														  <td colspan="2" style="padding:5px 0px 0px;width:10%;color:rgb(51,51,51);font-family:Thonburi,Tahoma;font-size:13px">&nbsp;</td>
													  </tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							<a href="http://www.facebook.com/manekijob" target="_blank">
							<img src="cid:like-fanpage" alt="" width="181" height="103" border="0"/></a>
							</td>
						</tr>
						
						<tr>
							<td style="padding:30px 0px 0px;text-align:center;color:rgb(102,102,102);font-family:Thonburi,Tahoma;font-size:13px">If in doubt Please activate Maneki-job to advise Posting jobs with you.

</td>
						</tr>
                        <tr>
							<td style="padding:0px;text-align:center;color:rgb(102,102,102);font-family:Thonburi,Tahoma;font-size:13px">Phone number 02 260 3698 , 02 665 6170 or via email.<a style="padding:30px 0px 0px;color:rgb(111,203,243);font-family:Thonburi,Tahoma;font-size:13px;text-decoration:none" href="mailto:staff@maneki-job.com" target="_blank">staff@maneki-job.com</a></td>

						</tr>
						
						<tr>
							<td style="padding:20px 25px 5px;color:rgb(102,102,102);font-family:thonburi,tahoma;font-size:13px">Thank You</td>
						</tr>
						<tr>
							<td style="padding:0px 25px 50px;color:rgb(102,102,102);font-family:thonburi,tahoma;font-size:13px">Team Maneki-job</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		
		<tr>
			<td style="padding:25px 0px 0px;text-align:center;color:rgb(153,153,153);font-family:Thonburi,Tahoma;font-size:12px">Email this preparation and submission of team website administrator.  <a style="color:rgb(153,153,153);font-family:Thonburi,Tahoma;font-size:13px;text-decoration:none" href="http://www.Maneki-job.com" target="_blank">Maneki-job.com</a></td>

		</tr>
		<tr>
			<td style="padding:5px 0px 0px;text-align:center;color:rgb(153,153,153);font-family:Thonburi,Tahoma;font-size:12px">Copyright © 2557 the TDC International, Ltd. 75/35 Richmond office. class 12A. </td>
		</tr>
		<tr>
			<td style="padding:5px 0px 0px;text-align:center;color:rgb(153,153,153);font-family:Thonburi,Tahoma;font-size:12px">Soi Sukhumvit 26, Sukhumvit Rd. Klong Toey, Bangkok 10110 Tel.<a style="color:rgb(153,153,153);font-family:Thonburi,Tahoma;font-size:12px;text-decoration:none" href="tel:026164000" target="_blank">+02 260 3698 , 02 665 6170 </a>Fax. <a style="color:rgb(153,153,153);font-family:Thonburi,Tahoma;font-size:12px;text-decoration:none" href="tel:022403666" target="_blank">+662-240-3666</a></td>

		</tr>
		<tr>
			<td style="padding:5px 0px 30px;text-align:center;color:rgb(153,153,153);font-family:Thonburi,Tahoma;font-size:12px">Website<a style="color:rgb(111,203,243);font-family:Thonburi,Tahoma;font-size:12px;text-decoration:none" href="http://www.maneki-job.com" target="_blank">www.maneki-job.com</a></td>

		</tr>
	</tbody>
</table>
</td>
</tr>
</tbody>
</table>


</blockquote></div><br></div>
 </body>
 </html>';	 
 }

 //
 $mail =  new PHPMailer();
 $mail->IsSMTP();
 $mail->SMTPDebug = 2;
 $mail->IsHTML(true);
 $mail->CharSet = "UTF-8";
 $mail->SMTPAuth   = true;
 $mail->Host = "mail.jobmaneki.com";
 $mail->Username = "noreply@jobmaneki.com";
 $mail->Password = "noreply2015";
 //$mail->SetFrom("$cmail", "$cname");
 $mail->SetFrom("noreply@jobmaneki.com", "jobmaneki");
 $mail->Subject = "Username and password by jobmaneki.com";
 //$mail->AltBody = "อีเมลนี้ เป็นอีเมลแบบมีภาพ หากดูไม่ได้โปรดคลิกไปที่ http://domain.tld/";
 // แทรกรูปเข้าไปในเนื้อหาที่กำหนด cid: เอาไว้
 $mail->AddEmbeddedImage("images/maneki-fanpage.jpg", "header", "maneki-fanpage.jpg", "base64", "image/jpeg");
 //$mail->AddEmbeddedImage("images/header.jpg", "header", "header.jpg", "base64", "image/jpeg");
 $mail->AddEmbeddedImage("images/maneki-like-fanpage.jpg", "like-fanpage", "maneki-like-fanpage.jpg", "base64", "image/jpeg");
 //$mail->AddEmbeddedImage("images/art.jpg", "art", "art.jpg", "base64", "image/jpeg");
 //
 $mail->Body = $htmlbody;
 $mail->AddAddress("$cemail", "$prs_user");
 $mail->AddAddress("staff@jobmaneki.com", "staff-maneki");
 $mail->Send();
 //$mail->AddAddress("staff@maneki-job.com", "ชื่อผู้รับ2");
 //if ( $mail->Send() ) {
 //echo "<p>ส่งอีเมลสำเร็จ</p>";
 //} else {
// echo "<p>ส่งอีเมลไม่สำเร็จ โปรดดูรายละเอียด debug</p>";
// }

				  ?>
                <!--  <meta http-equiv="refresh" content="0;URL=success.php?lang=<?=$_COOKIE['lang'];?>&type=<?=$_COOKIE['type'];?>&message=<?=$message;?>" />-->
                <?php echo "success";?>

                  <?
				  }
			  else{
				  $message="ยูเซอร์เนม และ อีเมล์ ไม่ตรงกัน หรือ ไม่มีอยู่ในระบบ (กรุณาสมัครสมาชิค)";
				  ?>
			<!--	  <meta http-equiv="refresh" content="0;URL=error_404.php?lang=<?=$_COOKIE['lang'];?>&type=<?=$_COOKIE['type'];?>&message=<?=$message;?>" />-->
				  <?
				  }
			 }// $_SESSION[cuser2]=$cuser;$_SESSION[cpass2]=$cpass;
		 ?>
<? mysql_close($link);	 ?>
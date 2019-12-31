<?php 
	
	session_start();
	
												
	ini_set("session.gc_maxlifetime", "18000");
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "mem_structure.html"; 
	$url2 = "mem_inquiry.html"; 
	
	$tpl = new rFastTemplate("template");
	$tpl->define (array("main_tpl" => $url1, "detail_tpl" => $url2));
	
	mysql_query("use $db_name;");
	
	$memid = $_GET['id'];
	$pagid = $_GET['page'];
	$langcode = $_GET['lang'];
	
	// --- Global Template Section	
	include_once("./include/global_memvalue.php");
	
	$sql1 = "select * from flc_member where mem_id = '$memid';";
	$result1 = mysql_query($sql1);
	while ($dbarr1 = mysql_fetch_array($result1)) {
		
		if ($dbarr1['mem_status'] == 'd') {
			if ($_SESSION['vp'] != 'exe' && $_SESSION['vp'] != 'adm') {
				echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit();
			}
		}
		
		$memcomnameen = $dbarr1['mem_comname_en'];
		$memcomnamejp = $dbarr1['mem_comname_jp'];
		$memcomnamevn = $dbarr1['mem_comname_vn'];
		$memsubdescen = $dbarr1['mem_subdesc_en'];
		$memsubdescjp = $dbarr1['mem_subdesc_jp'];
		$memsubdescvn = $dbarr1['mem_subdesc_vn'];
		$memfooteren = $dbarr1['mem_footer_en'];
		$memfooterjp = $dbarr1['mem_footer_jp'];
		$memfootervn = $dbarr1['mem_footer_vn'];
		$memtemplate = $dbarr1['mem_template'];
		$memfolder = $dbarr1['mem_folder'];
		$memseocom = $dbarr1['mem_seocomdesc'];
		$memseokey = $dbarr1['mem_seokeyword'];
		$memstatus = $dbarr1['mem_status'];
	
	}
	
	
	$sql2 = "select * from flc_template_main where tpm_id = '$memtemplate';";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {
		$tpmcode = $dbarr2['tpm_name_file'];
	}
	if ($tpmcode == '') {
		$tpmcode = "red";
	}
	
	
	$sql3 = "select * from flc_page where mem_id = '$memid' and pag_type = 'prf';";
	$result3 = mysql_query($sql3);
	while ($dbarr3 = mysql_fetch_array($result3)) {
		$prfshowid = $dbarr3['pag_id'];
		$prfshowen = $dbarr3['pag_show_en'];
		$prfshowjp = $dbarr3['pag_show_jp'];
		$prfshowvn = $dbarr3['pag_show_vn'];
	}
	
	if ($langcode == 'en') {
		if ($prfshowen != 't') {
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit();
		}
	} elseif ($langcode == 'jp') {
		if ($prfshowjp != 't') {
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">";
			exit();
		}
	} elseif ($langcode == 'vn') {
		if ($prfshowvn != 't') {
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">";
			exit();
		}
	} else {
		echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">";
		exit();
	}
	
	
	$sql4 = "select * from flc_page where mem_id = '$memid' and pag_id = '$pagid';";
	$result4 = mysql_query($sql4);
	while ($dbarr4 = mysql_fetch_array($result4)) {
		
		$pagcheck = "t";
		
		if ($dbarr4['pag_status'] == 'd') {
			if ($_SESSION['vp'] != 'exe' && $_SESSION['vp'] != 'adm') {
				echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">";
				exit();
			}
		}
		
		if ($dbarr4['pag_type'] != 'inq') {
			echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">";
			exit();
		}
		
		if ($langcode == 'en' && $dbarr4['pag_show_en'] != 't') { 
			if ($prfshowen == 't') {
				echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_profile.php?id=".$memid."&page=".$prfshowid."&lang=en\">";
				exit();
			} else {
				echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">";
				exit();
			} 
		}
		
		if ($langcode == 'jp' && $dbarr4['pag_show_jp'] != 't') { 
			if ($prfshowjp == 't') {
				echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_profile.php?id=".$memid."&page=".$prfshowid."&lang=jp\">";
				exit();
			} else {
				echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">";
				exit(); } 
		}
		
		if ($langcode == 'vn' && $dbarr4['pag_show_vn'] != 't') { 
			if ($prfshowvn == 't') {
				echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_profile.php?id=".$memid."&page=".$prfshowid."&lang=vn\">"; exit();
			} else {
				echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php?id\">";
				exit();
			} 
		}
		
		if ($dbarr4['pag_show_en'] == 't' || $prfshowen == 't') {
			$langen = "<a href=\"mem_inquiry.php?id=".$memid."&page=".$pagid."&lang=en\"><img src=\"images/tpl_".$memlangpicen."\" title=\"English\" width=\"24\" height=\"24\" border=\"0\" /></a>";
		} else {
			$langen = "<img src=\"images/tpl_en_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
		}
		
		if ($dbarr4['pag_show_jp'] == 't' || $prfshowjp == 't') {
			$langjp = "<a href=\"mem_inquiry.php?id=".$memid."&page=".$pagid."&lang=jp\"><img src=\"images/tpl_".$memlangpicjp."\" title=\"日本語\" width=\"24\" height=\"24\" border=\"0\" /></a>";
		} else {
			$langjp = "<img src=\"images/tpl_jp_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
		}
		
		if ($dbarr4['pag_show_vn'] == 't' || $prfshowvn == 't') {
			$langvn = "<a href=\"mem_inquiry.php?id=".$memid."&page=".$pagid."&lang=vn\"><img src=\"images/tpl_".$memlangpicvn."\" title=\"Việt Nam\" width=\"24\" height=\"24\" border=\"0\" /></a>";
		} else {
			$langvn = "<img src=\"images/tpl_vn_00.png\" width=\"24\" height=\"24\" border=\"0\" />";
		}
		
		$pagpagetitleen = $dbarr4['pag_pagetitle_en'];
		$pagpagetitlejp = $dbarr4['pag_pagetitle_jp'];
		$pagpagetitlevn = $dbarr4['pag_pagetitle_vn'];
		$pagtitleen = $dbarr4['pag_title_en'];
		$pagtitlejp = $dbarr4['pag_title_jp'];
		$pagtitlevn = $dbarr4['pag_title_vn'];
		$pagtitlecolor = "#".$dbarr4['pag_title_color'];
		$pagdetailen = $dbarr4['pag_detail_en'];
		$pagdetailjp = $dbarr4['pag_detail_jp'];
		$pagdetailvn = $dbarr4['pag_detail_vn'];
		$pagimage = $dbarr4['pag_image'];
		$pagimagewidth = $dbarr4['pag_image_width'];
		$pagimagelink = $dbarr4['pag_image_link'];
		$pagimageside = $dbarr4['pag_image_side'];
		$pagmemo = $dbarr4['pag_memo'];

		if ($pagimageside == 'r') { $imgside = "colimg-defright"; $imgsidefull = "colimg-defright-full"; } else { $imgside = "colimg-defleft"; $imgsidefull = "colimg-defleft-full"; }
		
		if ($pagimage == 't') { 
			
			$imgpath = "home/".$memfolder."/".$memid."-".$pagid."-P.jpg";
			if ($pagimagewidth == 0) { $imgdms = getimagesize($imgpath); $imgwidth = $imgdms[0]; } else { $imgwidth = $pagimagewidth; }
			if ($imgwidth > 760) { $imgwidth = 760; }
			if ($imgwidth >= 755) { $imgclass = $imgsidefull; } else { $imgclass = $imgside; } 
			$pagimage = "<img src=\"".$imgpath."\" width=\"".$imgwidth."\" border=\"0\" class=\"".$imgclass."\" />"; 
			if ($pagimagelink == 't') { $pagimage = "<a href=\"".$imgpath."\" target=\"_blank\">".$pagimage."</a>"; }
		}
		
	}
	
	if ($pagcheck != 't') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_error.php\">"; exit(); }
	
	// language
	if ($langcode == 'en') { 
		$memsubdesc = $memsubdescen; 
		$memfooter = $memfooteren;
		$memcomname = $memcomnameen;
		$pagpagetitle = $pagpagetitleen;
		$pagtitle = $pagtitleen;
		$pagdetail = $pagdetailen;
		
	} 
	
	else if ($langcode == 'vn') { 
		$memsubdesc = $memsubdescvn; 
		$memfooter = $memfootervn;
		$memcomname = $memcomnamevn;
		$pagpagetitle = $pagpagetitlevn;
		$pagtitle = $pagtitlevn;
		$pagdetail = $pagdetailvn;
		
	} 
	
	else { 
		$memsubdesc = $memsubdescjp; 
		$memfooter = $memfooterjp;
		$memcomname = $memcomnamejp;
		$pagpagetitle = $pagpagetitlejp;
		$pagtitle = $pagtitlejp;
		$pagdetail = $pagdetailjp;
		
	} 
	
	$pagtitle = "<font color=\"".$pagtitlecolor."\"><h2 class=\"h2_title\">".subhtml($pagtitle)."</h2></font>";
	$pagdetail = $pagimage.$pagtitle.html($pagdetail);



// ======================================================================================
//Check Ip Spam==========================================================================


$_SESSION['Minfomation']="InputFrom";

//=======================================================================================
// RANDOM CAPTCHA
// ======================================================================================
	/*
	$randomcc = randomcaptcha2();
	$randomccmd5 = md5($randomcc);
	
	$cccreate = fopen("images/confirmcode/ccimage.php", "w");
	
	$cccode = "<?php
	header('Content-Type: image/png');
	\$rancode = str_split('$randomcc');
	\$ranbg = rand(1, 5); 
	\$dest = imagecreatefrompng('bg_'.\$ranbg.'.png');
	\$startpoint = \"1\".\$rancode[0].\$rancode[1];
	for (\$i=0;\$i<=3;\$i++) {
		\$ranno = rand(1, 2);
		\$src = imagecreatefrompng('no_'.\$ranno.'_'.\$rancode[\$i].'.png'); 
		imagecopy(\$dest, \$src, \$startpoint, 5, 0, 0, 20, 20); 
		\$startpoint = \$startpoint + 20;
	}
	imagepng(\$dest);
	imagedestroy(\$src);
	?>";
	
	fwrite($cccreate, $cccode);
	fclose($cccreate);
	
	$tpl->assign("##randomccmd5##", $randomccmd5);
	*/
// ======================================================================================
   
   if(isset($_POST['b_ok'])){
	   
	 $_POST['b_ok'];
	  //
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
	//Spam ip check
	$_SESSION['Minfomation'];
	//End Spam ip check
	if (substr_count($t_content,"</a>") != 0) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit(); 
	//echo "1";
	}
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
	//if ($t_subject = '1' && $t_content = '1') { //echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "4";
	 //} // 2013.07.23
	if(!isset($_SESSION['Minfomation'])) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit(); 
	//echo "5";
	} // 2013.07.23
	if($_SESSION['Minfomation']!='InputFrom') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; exit();
	//echo "6";
	 } // 2013.07.23
	// --------------------------
	
	// warning ip
	$arr_ip=explode(".",$get_ip);
	if(is_numeric($arr_ip[3])){
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

		$header = "Content-type: text/html; charset=utf-8"."\r\n"."From: Fact-Link <admin_vn@fact-link.com.vn>"; 
		
	//	mail($memcontactmail, $subject, $detail, $header);
	
	} else {  echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=2\">"; exit(); 
	}
	
	echo "<meta http-equiv = \"refresh\" content = \"0;URL = mem_inquiry_done.php?id=$h_memid&page=$h_pagid&lang=$h_langcode&code=1\">"; 
	//echo "7";
	exit();
	}
	  //
   
    }
//
	mysql_close($link);

//.............................................................................................................................	
	
	// Random security number
	
//	$random = random(0);
/*
function ranDomStr($length){
		$str2ran = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789*@#$%&'; //string ที่เป็นไปได้ที่จะใช้ในการ random ซึ่งสามารถเพิ่มลดได้ตามความต้องการ
		$str_result = "";  //สตริงว่างสำหรับจะรับค่าจากการ random
		while(strlen($str_result)<$length){  //วนลูปจนกว่าจะได้สตริงตามความยาวที่ต้องการ
			$str_result .= substr($str2ran,(rand()%strlen($str2ran)),1); //ต่อ string จาก substring ที่ได้จากการ random ตำแหน่ง ทีละ 1 ตัว 
																													//จนกว่าจะครบตรามความยาวที่ส่งมา
		}
		return($str_result);//ส่งค่ากลับ
	}
	$ran_str = ranDomStr(6); //สั่ง random string
	$ran_id = random2();
	$_SESSION["ran_id"] =$ran_id;
	//echo $myName;
	$str_ran=strendcode($ran_id,$ran_str);
	$tpl->assign("##ran_str##",$str_ran);
	*/
	
    $characters=6;
	$_GET['characters']=$characters;
    function generateCode($characters) {
    mb_internal_encoding('UTF-8');
    mb_regex_encoding('UTF-8');
    $possible = '1234567890zxcvbnmasdfghjkqwertyop';
    $count_mb = mb_strlen($possible);
    $code = '';
    $i = 0;
    while ($i < $characters) { 
        $random_position = mt_rand(0, ($count_mb-1));
            $code .= mb_substr($possible, $random_position, 1, 'UTF-8');
            $i++;
    }
    return $code;
   }
	$_SESSION["security_code"]= $code = generateCode($_GET['characters']);
	$randomccmd5 = md5($_SESSION["security_code"]);

	// Customize CSS For Special Company
	if ($memid == "00001109") {
		$memsubdesc = "<p style=\"margin: 0;padding-left: 25px;line-height: 18px;\">".$memsubdesc."</p>";
		$memcomname = "<span style=\"display: inline-block;width: 25px;\"></span>".$memcomname;
	}
	if (!empty($memPackage) && !empty($pagpagetitle)) {
		$metaTitle = $pagpagetitle;
	}
	
	$tpl->assign("##metaTitle##", $metaTitle);

	// ADD GOOGLE MAP
	$myMapX = "";
	$myMapY = "";
	if($pagmemo !== "" && !empty($pagmemo)) {
		$myMapArr = explode(",", $pagmemo);
		$myMapX = $myMapArr[0];
		$myMapY = $myMapArr[1];
		$myMapWidth = $myMapArr[2];
		$myMapHeight = $myMapArr[3];
		if (empty($myMapWidth)) {
			$myMapWidth = "300";
		}
		if (empty($myMapHeight)) {
			$myMapHeight = "300";
		}
		$mapLayout = "display: block; max-width:100%;";
	} else {
		$myMapWidth = "0";
		$myMapHeight = "0";
		$mapLayout = "";
	}
	$tpl->assign("##myLat##", $myMapX);
	$tpl->assign("##myLng##", $myMapY);
	$tpl->assign("##mapWidth##", $myMapWidth."px");
	$tpl->assign("##mapHeight##", $myMapHeight."px");
	$tpl->assign("##mapLayout##", $mapLayout);
	
	$tpl->assign("##randomccmd5##", $randomccmd5);
	//$tpl->assign("##rand##", include("pic_text.php"));
//	$confirmcode = $random[1].$random[2].$random[3].$random[4];
	 $PHP_SELF;
	$tpl->assign("##memid##", $memid);
	$tpl->assign("##pagid##", $pagid);
	$tpl->assign("##confirmcode##", $confirmcode);
	$tpl->assign("##randomnum##", $random[0]);
	$tpl->assign("##pagdetail##", $pagdetail);
	$tpl->assign("##pagpagetitle##", $pagpagetitle);
	$tpl->assign("##pagtitlecolor##", $pagtitlecolor);
	$tpl->assign("##memcomname##", $memcomname);
	$tpl->assign("##memsubdesc##", $memsubdesc);
	$tpl->assign("##memfooter##", $memfooter);
	$tpl->assign("##memseocom##", $memseocom);
	$tpl->assign("##memseokey##", $memseokey);
	$tpl->assign("##tpmcode##", $tpmcode);
	$tpl->assign("##langcode##", $langcode);
	$tpl->assign("##langen##", $langen);
	$tpl->assign("##langjp##", $langjp);
	$tpl->assign("##langvn##", $langvn);	
	
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();

?>
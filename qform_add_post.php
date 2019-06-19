<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$t_diresu = $_POST['t_diresu'];
	$t_emanmoc = $_POST['t_emanmoc'];
	$t_tcatnoc = $_POST['t_tcatnoc'];
	$t_liam = $_POST['t_liam'];
	$t_elibom = $_POST['t_elibom'];
	$t_let = $_POST['t_let'];
	$t_tnemmoc = $_POST['t_tnemmoc'];
	$q1_1 = $_POST['q1_1'];
	$q1_2 = $_POST['q1_2'];
	$q1_3 = $_POST['q1_3'];
	$q1_4 = $_POST['q1_4'];
	$q1_5 = $_POST['q1_5'];
	$q1_5_txt = $_POST['q1_5_txt'];
	$q2_1 = $_POST['q2_1'];
	$q2_2 = $_POST['q2_2'];
	$q2_3 = $_POST['q2_3'];
	$q2_4 = $_POST['q2_4'];
	$q2_5 = $_POST['q2_5'];
	$q2_5_txt = $_POST['q2_5_txt'];
	$q3_1 = $_POST['q3_1'];
	$q3_2 = $_POST['q3_2'];
	$q3_3 = $_POST['q3_3'];
	$q3_4 = $_POST['q3_4'];
	$q3_5 = $_POST['q3_5'];
	$q3_6 = $_POST['q3_6'];
	$q3_7 = $_POST['q3_7'];
	$q3_7_txt = $_POST['q3_7_txt'];
	$q4_1 = $_POST['q4_1'];
	$q4_2 = $_POST['q4_2'];
	$q4_3 = $_POST['q4_3'];
	$q4_4 = $_POST['q4_4'];
	$q4_5 = $_POST['q4_5'];
	$q4_6 = $_POST['q4_6'];
	$q4_7 = $_POST['q4_7'];
	$q4_8 = $_POST['q4_8'];
	$q4_8_txt = $_POST['q4_8_txt'];

	$q1 = ""; $q1_m = "<strong>Q1. ファクトリンクに関して機能を充実して欲しい物は何ですか？</strong><br />";
	$q2 = ""; $q2_m = "<strong>Q2. ファクトリンクはどのように利用しますか？</strong><br />";
	$q3 = ""; $q3_m = "<strong>Q3. ファクトリンクの使用頻度はどのくらいですか？</strong><br />";
	$q4 = ""; $q4_m = "<strong>Q4. ファクトリンク有料プランに関して</strong><br />";

	if ($q1_1 != '') { $q1 = $q1.$q1_1." | "; $q1_m = $q1_m.$q1_1."<br />"; }
	if ($q1_2 != '') { $q1 = $q1.$q1_2." | "; $q1_m = $q1_m.$q1_2."<br />"; }
	if ($q1_3 != '') { $q1 = $q1.$q1_3." | "; $q1_m = $q1_m.$q1_3."<br />"; }
	if ($q1_4 != '') { $q1 = $q1.$q1_4." | "; $q1_m = $q1_m.$q1_4."<br />"; }
	if ($q1_5 != '') { $q1 = $q1.$q1_5."#"; $q1_m = $q1_m.$q1_5."<br />"; }
	if ($q1_5_txt != '') { $q1 = $q1.$q1_5_txt; $q1_m = $q1_m.html($q1_5_txt)."<br />"; }

	if ($q2_1 != '') { $q2 = $q2.$q2_1." | "; $q2_m = $q2_m.$q2_1."<br />"; }
	if ($q2_2 != '') { $q2 = $q2.$q2_2." | "; $q2_m = $q2_m.$q2_2."<br />"; }
	if ($q2_3 != '') { $q2 = $q2.$q2_3." | "; $q2_m = $q2_m.$q2_3."<br />"; }
	if ($q2_4 != '') { $q2 = $q2.$q2_4." | "; $q2_m = $q2_m.$q2_4."<br />"; }
	if ($q2_5 != '') { $q2 = $q2.$q2_5."#"; $q2_m = $q2_m.$q2_5."<br />"; }
	if ($q2_5_txt != '') { $q2 = $q2.$q2_5_txt; $q2_m = $q2_m.html($q2_5_txt)."<br />"; }

	if ($q3_1 != '') { $q3 = $q3.$q3_1." | "; $q3_m = $q3_m.$q3_1."<br />"; }
	if ($q3_2 != '') { $q3 = $q3.$q3_2." | "; $q3_m = $q3_m.$q3_2."<br />"; }
	if ($q3_3 != '') { $q3 = $q3.$q3_3." | "; $q3_m = $q3_m.$q3_3."<br />"; }
	if ($q3_4 != '') { $q3 = $q3.$q3_4." | "; $q3_m = $q3_m.$q3_4."<br />"; }
	if ($q3_5 != '') { $q3 = $q3.$q3_5." | "; $q3_m = $q3_m.$q3_5."<br />"; }
	if ($q3_6 != '') { $q3 = $q3.$q3_6." | "; $q3_m = $q3_m.$q3_6."<br />"; }
	if ($q3_7 != '') { $q3 = $q3.$q3_7."#"; $q3_m = $q3_m.$q3_7."<br />"; }
	if ($q3_7_txt != '') { $q3 = $q3.$q3_7_txt; $q3_m = $q3_m.html($q3_7_txt)."<br />"; }

	if ($q4_1 != '') { $q4 = $q4.$q4_1." | "; $q4_m = $q4_m.$q4_1."<br />"; }
	if ($q4_2 != '') { $q4 = $q4.$q4_2." | "; $q4_m = $q4_m.$q4_2."<br />"; }
	if ($q4_3 != '') { $q4 = $q4.$q4_3." | "; $q4_m = $q4_m.$q4_3."<br />"; }
	if ($q4_4 != '') { $q4 = $q4.$q4_4." | "; $q4_m = $q4_m.$q4_4."<br />"; }
	if ($q4_5 != '') { $q4 = $q4.$q4_5." | "; $q4_m = $q4_m.$q4_5."<br />"; }
	if ($q4_6 != '') { $q4 = $q4.$q4_6." | "; $q4_m = $q4_m.$q4_6."<br />"; }
	if ($q4_7 != '') { $q4 = $q4.$q4_7." | "; $q4_m = $q4_m.$q4_7."<br />"; }
	if ($q4_8 != '') { $q4 = $q4.$q4_8."#"; $q4_m = $q4_m.$q4_8."<br />"; }
	if ($q4_8_txt != '') { $q4 = $q4.$q4_8_txt; $q4_m = $q4_m.html($q4_8_txt)."<br />"; }

	$currenttimestamp = date("Y-m-d H:i:s");

	$sql1 = "insert into flc_qform1 (qf1_user, qf1_comname, qf1_contact, qf1_mail, qf1_mobile, qf1_tel, qf1_comment, qf1_q1, qf1_q2, qf1_q3, qf1_q4, qf1_timestamp, qf1_ip)
					values ('$t_diresu', '$t_emanmoc', '$t_tcatnoc', '$t_liam', '$t_elibom', '$t_let', '$t_tnemmoc', '$q1', '$q2', '$q3', '$q4', 'currenttimestamp', '$getip');";
	$result1 = mysql_query($sql1);

	// --- Mail Section

	$subject = "ファクトリンク[パスワード & アンケート]依頼 Password Request & Questionair";
	$detail = "<html>
<body>
<table width=\"650\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">
  <tr>
    <td colspan=\"3\"><img src=\"http://www.fact-link.com/images/mail_01.jpg\" width=\"650\" height=\"75\" /></td>
  </tr>
  <tr>
    <td width=\"20\" background=\"http://www.fact-link.com/images/mail_02.jpg\">&nbsp;</td>
    <td width=\"610\"><p><font style=\"color: #CC0000; font-weight: bold; font-size: 18px;\">Password Request & Questionair</font><br />
      <br />
      <br />
    <font color=\"#000000\"><strong>ユーザーID / Username</strong></font><br />
    <font color=\"#000000\">".$t_diresu."</font><br />
	<font color=\"#000000\"><strong>会社名 / Company</strong></font><br />
	<font color=\"#000000\">".$t_emanmoc."</font><br />
	<font color=\"#000000\"><strong>担当者名 / Contact Name</strong></font><br />
	<font color=\"#000000\">".$t_tcatnoc."</font><br />
	<font color=\"#000000\"><strong>メールアドレス / E-mail</strong></font><br />
	<font color=\"#000000\">".$t_liam."</font><br />
	<font color=\"#000000\"><strong>携帯電話番号 / Mobile</strong></font><br />
    <font color=\"#000000\">".$t_elibom."</font><br />
    <font color=\"#000000\"><strong>電話番号 / Tel.</strong></font><br />
    <font color=\"#000000\">".$t_let."</font><br />
	<font color=\"#000000\"><strong>情報の変更箇所 / Comment</strong></font><br />
	<font color=\"#000000\">".html($t_tnemmoc)."</font><br />
	<br />
	<br />
	<font color=\"#000000\">".$q1_m."</font><br />
    <font color=\"#000000\">".$q2_m."</font><br />
	<font color=\"#000000\">".$q3_m."</font><br />
	<font color=\"#000000\">".$q4_m."</font><br />
    </p>
    </td>
    <td width=\"20\" background=\"http://www.fact-link.com/images/mail_03.jpg\">&nbsp;</td>
  </tr>
  <tr>
    <td colspan=\"3\"><img src=\"http://www.fact-link.com/images/mail_04.jpg\" width=\"650\" height=\"40\" /></td>
  </tr>
</table>
</body>
</html>";

		$header = "Content-type: text/html; charset=utf-8"."\r\n"."From: Fact-Link <info@fact-link.com.vn>";

		mail("factlink.noreply@gmail.com", $subject, $detail, $header);

		echo "<meta http-equiv = \"refresh\" content = \"0;URL = qform_done.php\">";

	exit();
?>

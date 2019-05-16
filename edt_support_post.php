<?php
	session_start();

	include_once("./include/global_config.php");
	include_once("./include/global_function.php");

	mysql_query("use $db_name;");
	// Escape special charactars
	$_POST = array_map('mysql_real_escape_string',$_POST);
	
	$h_memid = $_POST['h_memid'];
	$h_case = $_POST['h_case'];
	$t_subject = $_POST['t_subject'];
	$t_detail = $_POST['t_detail'];

	if ($_SESSION['vmd'] != $h_memid) { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=2\">"; exit(); }

	$sql1 = "insert into flc_mail (mem_id, mal_subj, mal_detail, mal_date, mal_time, mal_ip, mal_support, mal_case)
					values ('$h_memid', '$t_subject', '$t_detail', '$nowdate', '$nowtime', '$getip', 't', '$h_case');";
	$result1 = mysql_query($sql1);

	$sql2 = "select * from flc_member where mem_id = '$h_memid';";
	$result2 = mysql_query($sql2);
	while ($dbarr2 = mysql_fetch_array($result2)) {

		$memcomnameen = $dbarr2['mem_comname_en'];
		$memcontactnameen = $dbarr2['mem_contactname_en'];
		$memcontactmail = $dbarr2['mem_contactmail'];
	}

	// Mail section

	$subject = "[サポートリクエスト] Support Request";
	$detail = "<html>
<body>
<table width=\"650\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#FFFFFF\">
  <tr>
    <td colspan=\"3\"><img src=\"http://www.fact-link.com.vn/images/mail_01.jpg\" width=\"650\" height=\"75\" /></td>
  </tr>
  <tr>
    <td width=\"20\" background=\"http://www.fact-link.com.vn/images/mail_02.jpg\">&nbsp;</td>
    <td width=\"610\"><p><font style=\"color: #CC0000; font-weight: bold; font-size: 18px;\">サポートリクエスト / Support Request</font><br />
      <br />
        <br />
        <font color=\"#00000\"><strong>件名 / Subject</strong></font><br />
		<font color=\"#00000\">".$t_subject."</font><br /><br />
		<font color=\"#00000\"><strong>内容 / Detail</strong></font><br />
		<font color=\"#00000\">".html($t_detail)."</font><br />
        <br />
        <br />
        <font color=\"#000000\"><strong>差出人 / By</strong></font><br />
    <font color=\"#000000\">".$memcontactnameen."</font><br />
	<font color=\"#000000\"><strong>E-mail</strong></font><br />
	<font color=\"#000000\">".$memcontactmail."</font><br />
    <font color=\"#000000\"><strong>会社名 / Company Name</strong></font><br />
    <font color=\"#000000\">".$memcomnameen."</font><br />
	<font color=\"#000000\"><strong>会員ID / Member ID</strong></font><br />
	<font color=\"#000000\">".$h_memid."</font>
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

	mail("factlinkvn.noreply@gmail.com", $subject, $detail, $header);

	echo "<meta http-equiv = \"refresh\" content = \"0;URL = edt_support_sent.php\">";

	exit();
?>

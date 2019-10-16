<?php 
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	$url1 = "structure.html"; 
	$url2 = "touroku_done.html";
	$url3 = "ads_right.html";
	$url4 = "ads_left.html";
	$url5 = "ads_top.html";
	$pagecode = "reg";

	if ($_COOKIE['vlang'] == 'en') {
		$url6 = "menu_en.html";
	} elseif ($_COOKIE['vlang'] == 'vn') {
		$url6 = "menu_vn.html";
	} else {
		$url6 = "menu_jp.html";
	}
	
	$tpl = new rFastTemplate("template");
	$tpl->define(
			array(
			"main_tpl" => $url1,
			"detail_tpl" => $url2,
			"right_tpl" => $url3,
			"left_tpl" => $url4,
			"top_tpl" => $url5,
			"menu_tpl" => $url6
		)
	);
	
	mysql_query("use $db_name;");
	
	// --- Global Template Section	
	include_once("./include/global_value.php");
	
	// if ($_COOKIE['vlang'] == 'en') { $fintext = "<font color=\"#FF0000\"><strong>Register done.</strong></font></br>Please check your registered e-mail for registration information. If you not found any in Inbox, please check in your Junk Mail or contact us at (+84) 888 767 138."; }
	// else if ($_COOKIE['vlang'] == 'vn') { $fintext = "<font color=\"#FF0000\"><strong>Register done.</strong></font></br>Please check your registered e-mail for registration information. If you not found any in Inbox, please check in your Junk Mail or contact us at (+84) 888 767 138."; }
	// else { $fintext = "<font color=\"#FF0000\"><strong>登録済み。</strong></font></br>会員登録情報にご登録のE-Mailをご確認ください　受信ボックスに送信されていないようでしたらジャンクメールをご確認していただくか、または (+84) 888 767 138 までご連絡ください。"; }

	if ($_COOKIE['vlang'] == 'en') {
		$fintext = "<p align=\"center\"><font color=\"#FF0000\"><strong>Company information registration is completed.</strong></font></p><ol type=\"1\"><li>Please check your ID and Password sent to your registered e-mail. Please check your junk email if it doesn't seem to be sent to your inbox.</li><li>Login with the issued ID and password (login screen <a href=\"https://fact-link.com.vn\">https://fact-link.com.vn</a>), and create / edit your company page from the “Page Management” menu on the management screen. After the page is created, the page is published.</li></ol><p>If you have any questions regarding registration, please contact info@fact-link.com.vn.</p>";
	} elseif($_COOKIE['vlang'] == 'vn') {
		$fintext = "<p align=\"center\"><font color=\"#FF0000\"><strong>Bạn đã đăng ký thông tin công ty thành công</strong></font></p><ol type=\"1\"><li>Vui lòng kiểm tra ID và Mật khẩu của bạn được gửi đến e-mail đã đăng ký. Hoặc kiểm tra Hộp thư rác trong trường hợp không nhận được trong Hộp thư đến</li><li>Đăng nhập bằng ID và mật khẩu đã cấp (tại màn hình đăng nhập <a href=\"https://fact-link.com.vn\">https://fact-link.com.vn</a>) và tạo / chỉnh sửa trang công ty của bạn từ mục \"Quản lý Trang\" trên màn hình quản lý. Sau khi điền đầy đủ thông tin, trang Hồ sơ công ty bạn đã được tạo thành công.</li></ol><p>Nếu bạn có bất kỳ câu hỏi nào liên quan đến việc đăng ký, xin vui lòng liên hệ với info@fact-link.com.vn.</p>";
	} else {
		$fintext = "<p align=\"center\"><font color=\"#FF0000\"><strong>会社情報の登録が完了しました。</strong></font></p><ol type=\"1\"><li>IDとPasswordをご登録のE-Mailに送信いたしましたのでご確認ください。受信ボックスに送信されていないようでしたらジャンクメールをご確認ください。</li><li>発行されたIDとPasswordでログイン（ログイン画面　<a href=\"https://fact-link.com.vn\">https://fact-link.com.vn</a> ）をしていただき、管理画面の「ページ管理」メニューより貴社ページの作成・編集をお願いいたします。ページが作成された後、ページが公開されます。</li></ol><p>登録に関してご不明点がございましたら info@fact-link.com.vn までお問い合わせください。</p>";
	}
	
	$tpl->assign("##fintext##", $fintext);
	
	$tpl->parse ("##RIGHT_AREA##", "right_tpl");
	$tpl->parse ("##LEFT_AREA##", "left_tpl");
	$tpl->parse ("##TOP_AREA##", "top_tpl");
	$tpl->parse ("##MENU_AREA##", "menu_tpl");
	$tpl->parse ("##DETAIL_AREA##", "detail_tpl");
	$tpl->parse ("MAIN", "main_tpl");
	$tpl->FastPrint ();
	exit();
?>
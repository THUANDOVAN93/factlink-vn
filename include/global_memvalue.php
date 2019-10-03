<?php
	
	// language
	if ($langcode == 'en') { 
		$memlangpicjp = "jp_01.png"; $memlangpicvn = "vn_01.png"; $memlangpicen = "en_02.png";
		$titlemenu = "title_menu_en.jpg";
		$buttonsend = "button_send_en.jpg";
		
		$lb_comname = "Company Name";
		$lb_repname = "Representative Name";
		$lb_business = "Business Description";
		$lb_product = "Produce";
		$lb_url = "Website";
		$lb_establish = "Establish Date";
		$lb_capital = "Capital";
		$lb_parent = "Parent Company";
		$lb_share = "Shareholder";
		$lb_employee = "Employee";
		$lb_accdate = "Account Period";
		$lb_bank = "Bank";
		$lb_valcus = "Value Customer";
		
		$lb_company = "Company";
		$lb_department = "Department";
		$lb_contactname = "Your Name";
		$lb_address = "Address";
		$lb_tel = "TEL";
		$lb_fax = "FAX";
		$lb_email = "E-mail";
		$lb_subject = "Subject";
		$lb_content = "Your Inquiry";
		$lb_confirmcode = "Confirm Code";
		$lb_confirmcode_text = "Please fill 4 digits in this box to confirm submit.";
		
		$lb_error_disable = "Sorry, English do not available for this page.";
		
		$lb_button_send = "Send";

		$pro_contact = "Contact";
		$lb_keyword = "Keyword";
		$lb_search_dec = "Search for factories";
		$lb_sologan = "Vietnam Industrial Directory";
		$lb_back_top_page = "Back to Fact-Link top";
		$srcLogo = "logo_en.png";
		$contactFreeMember = "Send inquiry to this company";
	} 
	
	else if ($langcode == 'vn') { 
		$memlangpicjp = "jp_01.png"; $memlangpicvn = "vn_02.png"; $memlangpicen = "en_01.png";
		$titlemenu = "title_menu_vn.jpg";
		$buttonsend = "button_send_vn.jpg";
		
		$lb_comname = "Tên công ty";
		$lb_repname = "Tên người đại diện";
		$lb_business = "Mô tả kinh doanh";
		$lb_product = "Sản phẩm";
		$lb_url = "Trang web";
		$lb_establish = "Ngày thành lập";
		$lb_capital = "Vốn";
		$lb_parent = "Công ty mẹ";
		$lb_share = "Cổ đông chính";
		$lb_employee = "Nhân viên";
		$lb_accdate = "Quyết toán hàng năm";
		$lb_bank = "Ngân hàng giao dịch chính";
		$lb_valcus = "Khách hàng lớn";
		
		$lb_company = "Công ty";
		$lb_department = "Lĩnh vực";
		$lb_contactname = "Tên của bạn";
		$lb_address = "Địa chỉ";
		$lb_tel = "Số điện thoại";
		$lb_fax = "Số FAX";
		$lb_email = "Địa chỉ mail";
		$lb_subject = "Tiêu đề";
		$lb_content = "Nội dung";
		$lb_confirmcode = "Mã xác nhận";
		$lb_confirmcode_text = "Xin vui lòng điền vào 4 chữ số trong ô này để xác nhận.";
		
		$lb_error_disable = "Xin lỗi, không có tiếng việt cho trang này.";
		
		$lb_button_send = "Gửi";
		$pro_contact = "Liên hệ";
		$lb_keyword = "Từ khóa";
		$lb_search_dec = "Tìm kiếm theo nhà máy hoặc công ty";
		$lb_sologan = "Dành cho các doanh nghiệp Việt Nam";
		$lb_back_top_page = "Quay về trang chủ Fact-Link";
		$srcLogo = "logo_vn.png";
		$contactFreeMember = "Liên hệ với công ty này";
	} 
	
	else { 
		$memlangpicjp = "jp_02.png"; $memlangpicvn = "vn_01.png"; $memlangpicen = "en_01.png";
		$titlemenu = "title_menu_jp.jpg";
		
		$lb_comname = "会社名";
		$lb_repname = "代表者";
		$lb_business = "事業内容";
		$lb_product = "取扱品目";
		$lb_url = "ウェブサイト";
		$lb_establish = "創立日";
		$lb_capital = "資本金";
		$lb_parent = "親会社";
		$lb_share = "主要株主";
		$lb_employee = "従業員数";
		$lb_accdate = "決算期";
		$lb_bank = "取引銀行";
		$lb_valcus = "主要取引先";	
		
		$lb_company = "貴社名";
		$lb_department = "部署名";
		$lb_contactname = "お名前";
		$lb_address = "住所";
		$lb_tel = "TEL";
		$lb_fax = "FAX";
		$lb_email = "メールアドレス";
		$lb_subject = "件名";
		$lb_content = "お問い合わせ内容";
		$lb_confirmcode = "認証コード";
		$lb_confirmcode_text = "表示されている４ケタの数字を入力してください。";
		
		$lb_error_disable = "申し訳ございません　このページは日本語が利用できません。";
		
		$lb_button_send = "メール送信";
		$pro_contact = "問い合わせ";
		$lb_keyword = "キーワード";
		$lb_search_dec = "工場・企業を検索する";
		$lb_sologan = "ベトナムの製造業、工場検索ポータルサイト";
		$lb_back_top_page = "ファクトリンクTOP";
		$srcLogo = "logo_jp.png";
		$contactFreeMember = "この企業に問い合わせる";
		
	} 
	
	$tpl->assign("##memlangpicjp##", $memlangpicjp);
	$tpl->assign("##memlangpicvn##", $memlangpicvn);
	$tpl->assign("##memlangpicen##", $memlangpicen);
	$tpl->assign("##titlemenu##", $titlemenu);
	$tpl->assign("##lb_comname##", $lb_comname);
	$tpl->assign("##lb_repname##", $lb_repname);
	$tpl->assign("##lb_business##", $lb_business);
	$tpl->assign("##lb_product##", $lb_product);
	$tpl->assign("##lb_url##", $lb_url);
	$tpl->assign("##lb_establish##", $lb_establish);
	$tpl->assign("##lb_capital##", $lb_capital);
	$tpl->assign("##lb_parent##", $lb_parent);
	$tpl->assign("##lb_share##", $lb_share);
	$tpl->assign("##lb_employee##", $lb_employee);
	$tpl->assign("##lb_accdate##", $lb_accdate);
	$tpl->assign("##lb_bank##", $lb_bank);
	$tpl->assign("##lb_valcus##", $lb_valcus);
	$tpl->assign("##lb_company##", $lb_company);
	$tpl->assign("##lb_department##", $lb_department);
	$tpl->assign("##lb_contactname##", $lb_contactname);
	$tpl->assign("##lb_address##", $lb_address);
	$tpl->assign("##lb_tel##", $lb_tel);
	$tpl->assign("##lb_fax##", $lb_fax);
	$tpl->assign("##lb_email##", $lb_email);
	$tpl->assign("##lb_subject##", $lb_subject);
	$tpl->assign("##lb_content##", $lb_content);
	$tpl->assign("##lb_confirmcode##", $lb_confirmcode);
	$tpl->assign("##lb_confirmcode_text##", $lb_confirmcode_text);
	$tpl->assign("##lb_error_disable##", $lb_error_disable);
	$tpl->assign("##lb_button_send##", $lb_button_send);
	$tpl->assign("##tx_inqalert_1##", $tx_inqalert_1);
	$tpl->assign("##tx_inqalert_2##", $tx_inqalert_2);
	$tpl->assign("##pro_contact##", $pro_contact);
	$tpl->assign("##lb_keyword##", $lb_keyword);
	$tpl->assign("##lb_search_dec##", $lb_search_dec);
	$tpl->assign("##lb_sologan##", $lb_sologan);
	$tpl->assign("##lb_back_top_page##", $lb_back_top_page);
	$tpl->assign("##srcLogo##", $srcLogo);
	$tpl->assign("##contactFreeMember##", $contactFreeMember);

	// profile table
	$prfline = "<tr><td colspan=\"3\" valign=\"top\"><img src=\"images/line_h_02.png\" width=\"760\" height=\"10\" /></td></tr>";
	
	// member menu
	$sqlmemmenu = "select * from flc_page where mem_id = '$memid' and pag_status != 'd' order by pag_sort asc;";
	$resultmemmenu = mysql_query($sqlmemmenu);

	while ($dbarrmemmenu = mysql_fetch_array($resultmemmenu)) {
		
		$menupagen = subhtml($dbarrmemmenu['pag_name_en']);
		$menupagvn = subhtml($dbarrmemmenu['pag_name_vn']);
		$menupagjp = subhtml($dbarrmemmenu['pag_name_jp']);
		$menushowen = $dbarrmemmenu['pag_show_en'];
		$menushowvn = $dbarrmemmenu['pag_show_vn'];
		$menushowjp = $dbarrmemmenu['pag_show_jp'];
		$menupagid = $dbarrmemmenu['pag_id'];
		$menupagtype = $dbarrmemmenu['pag_type'];		
		
		if ($menupagtype == 'prf') {
			$menupaglink = "mem_profile.php?id=".$memid."&page=".$menupagid."&lang=".$langcode;
			$profilePageLink = $menupaglink;
		}
		else if ($menupagtype == 'hom') {
			$menupaglink = "mem_home.php?id=".$memid."&page=".$menupagid."&lang=".$langcode;
		}
		else if ($menupagtype == 'inq') {
			$menupaglink = "mem_inquiry.php?id=".$memid."&page=".$menupagid."&lang=".$langcode;
		}
		else if ($menupagtype == 'pst') {
			$menupaglink = "mem_present.php?id=".$memid."&page=".$menupagid."&lang=".$langcode;
		}
		else if ($menupagtype == 'pro') {
			$menupaglink = "mem_products.php?id=".$memid."&page=".$menupagid."&lang=".$langcode."&start=0";
		} 
		else {
			$menupaglink = "mem_content.php?id=".$memid."&page=".$menupagid."&lang=".$langcode;
		}
		
		$sqlmemmenu1 = "select * from flc_member where mem_id = '$memid';";
		$resultmemmenu1 = mysql_query($sqlmemmenu1);

		while ($dbarrmemmenu1 = mysql_fetch_array($resultmemmenu1)) {
			$menumemtemplate = $dbarrmemmenu1['mem_template'];
			$menumemcategory = explode(" ", $dbarrmemmenu1['mem_category']);
			$menumemcate = $menumemcategory[0];
			$memPackage = $dbarrmemmenu1['mem_package'];
		}

		$sqlmemmenu2 = "select * from flc_template_main where tpm_id = '$menumemtemplate';";
		$resultmemmenu2 = mysql_query($sqlmemmenu2);
		while ($dbarrmemmenu2 = mysql_fetch_array($resultmemmenu2)) { $menuclfid = $dbarrmemmenu2['clf_id']; }
		
		$sqlmemmenu3 = "select * from flc_color_font where clf_id = '$menuclfid';";
		$resultmemmenu3 = mysql_query($sqlmemmenu3);
		while ($dbarrmemmenu3 = mysql_fetch_array($resultmemmenu3)) { $menuclfcode = "#".$dbarrmemmenu3['clf_code']; }
		
		if ($langcode == 'en') { 
			if ($menupagen != '' && $menushowen != '') {
				if ($menupagid == $pagid) {
					$menulist = $menulist."<tr><td><div class=\"panelmenu\">".$menupagen."</div></td></tr>";
				} else {
					$menulist = $menulist."<tr><td><div class=\"panelmenu\"><a href=\"".$menupaglink."\">".$menupagen."</a></td></tr></div>"; 					
				}
			}
			
		} else if ($langcode == 'vn') { 
			if ($menupagvn != '' && $menushowvn != '') {
				if ($menupagid == $pagid) {
					$menulist = $menulist.
					"<tr><td><div class=\"panelmenu\">".$menupagvn."</div></td></tr>";
				} else {
					$menulist = $menulist.
					"<tr><td><div class=\"panelmenu\"><a href=\"".$menupaglink."\">".$menupagvn."</a></td></tr></div>";
				}
			}
			
		} else if ($langcode == 'jp') {
			if ($menupagjp != '' && $menushowjp != '') {
				if ($menupagid == $pagid) {
					$menulist = $menulist.
					"<tr><td><div class=\"panelmenu\">".$menupagjp."</div></td></tr>";
				} else {
					$menulist = $menulist.
					"<tr><td><div class=\"panelmenu\"><a href=\"".$menupaglink."\">".$menupagjp."</a></td></tr></div>"; 
					 
				}
			}
			
		}
		
	}
	
	$sqlmemmenu4 = "select * from flc_category where cat_id = '$menumemcate';"; 
	$resultmemmenu4 = mysql_query($sqlmemmenu4);
	while ($dbarrmemmenu4 = mysql_fetch_array($resultmemmenu4)) {
	
		$menucatpos = $dbarrmemmenu4['cat_pos'];
		$menucatunder = $dbarrmemmenu4['cat_under'];
		
		if ($langcode == 'en') { $menucatname = $dbarrmemmenu4['cat_name_en']; }
		else if ($langcode == 'vn') { $menucatname = $dbarrmemmenu4['cat_name_vn']; }
		else { $menucatname = $dbarrmemmenu4['cat_name_jp']; }
		
		if ($menucatpos == 's') { 
			$sqlmemmenu5 = "select * from flc_category where cat_id = '$menucatunder';"; 
			$resultmemmenu5 = mysql_query($sqlmemmenu5);
			while ($dbarrmemmenu5 = mysql_fetch_array($resultmemmenu5)) { 
				if ($langcode == 'en') { $menucatundername = $dbarrmemmenu5['cat_name_en']; }
				else if ($langcode == 'vn') { $menucatundername = $dbarrmemmenu5['cat_name_vn']; }
				else { $menucatundername = $dbarrmemmenu5['cat_name_jp']; }
			}
			$menucatname = $menucatundername."・".$menucatname;
		}
			
	}
	
	$sqlmemmenu5 = "select * from flc_page where pag_id = '$pagid';"; 
	$resultmemmenu5 = mysql_query($sqlmemmenu5);
	while ($dbarrmemmenu5 = mysql_fetch_array($resultmemmenu5)) { $menupagupdate = $dbarrmemmenu5['pag_update']; }
	
	$menupagupdate = explode(" ",$menupagupdate);
	$upd1 = explode("-",$menupagupdate[0]);
	
	if ($langcode == 'en') { 
		
		$menulastupdatetext = "LATEST UPDATE";
		$menulastupdate = $upd1[2]." ".mcvzerotosub($upd1[1])." ".$upd1[0];
		$menucatetext = "CATEGORY";
		$menufactlinktext = "Back to Fact-Link's Top Page";
		
	} else if ($langcode == 'vn') { 
		
		$menulastupdatetext = "LATEST UPDATE";
		$menulastupdate = $upd1[2]." ".mcvzerotosub($upd1[1])." ".$upd1[0];
		$menucatetext = "CATEGORY";
		$menufactlinktext = "Back to Fact-Link's Top Page";
		
	} else if ($langcode == 'jp') {
			
		$menulastupdatetext = "最終更新日";
		$menulastupdate = $upd1[0]."年".$upd1[1]."月".$upd1[2]."日";
		$menucatetext = "業種別";
		$menufactlinktext = "ファクトリンクTOPへ戻る";
		
	}
	
	$menulist = $menulist."
	
	<tr>
		<td>
			<div class=\"panelmenu\">
				<strong>".$menulastupdatetext."</strong>
				
				$menulastupdate
				
				<img src=\"images/line_side_08.png\" width=\"165\" height=\"10\" />
				
				<br/>
				
				<strong>$menucatetext</strong>
				
				<br/>
				
				<a href=\"search_category.php?id=".$menumemcate."&start=0\" target=\"_blank\">
				$menucatname
				</a>
				
				<img src=\"images/line_side_08.png\" width=\"165\" height=\"10\" /><br/>
				
				<a href=\"index.php\" target=\"_blank\">
				$menufactlinktext
				</a>
				
				<img src=\"images/line_side_08.png\" width=\"165\" height=\"10\" />
				
				
			</div>
		</td>
	</tr>
				
	";

	// ADS Banner Right For Free Member
	if ($memPackage == '') {
		if ($langcode == 'en') {
			$menulist = $menulist."<tr>
				<td class=\"pd-5\">
				<a href=\"https://factory-vn.com/\" target=\"_blank\">
				<img class=\"img-reposive br-5\" src=\"/images/ads/tdc-right-banner-en.png\">
				</a>
				</td>
				</tr>
				<tr>
				<td class=\"pd-5\">
				<a href=\"index.php?lang=en\" target=\"_blank\">
				<img class=\"img-reposive br-5\" src=\"/images/ads/factlink-right-banner-en.png\">
				</a>
				</td>
				</tr>";
		} elseif ($langcode == 'vn') {
			$menulist = $menulist."<tr>
				<td class=\"pd-5\">
				<a href=\"https://factory-vn.com/\" target=\"_blank\">
				<img class=\"img-reposive br-5\" src=\"/images/ads/tdc-right-banner-vn.png\">
				</a>
				</td>
				</tr>
				<tr>
				<td class=\"pd-5\">
				<a href=\"index.php?lang=vn\" target=\"_blank\">
				<img class=\"img-reposive br-5\" src=\"/images/ads/factlink-right-banner-vn.png\">
				</a>
				</td>
				</tr>";
		} else {
			$menulist = $menulist."<tr>
			<td class=\"pd-5\">
			<a href=\"https://www.tdc-vietnam.com/\" target=\"_blank\">
			<img class=\"img-reposive br-5\" src=\"/images/ads/tdc-right-banner-jp.png\">
			</a>
			</td>
			</tr>
			<tr>
			<td class=\"pd-5\">
			<a href=\"index.php?lang=jp\" target=\"_blank\">
			<img class=\"img-reposive br-5\" src=\"/images/ads/factlink-right-banner-jp.png\">
			</a>
			</td>
			</tr>";
		}
	}
	
	$tpl->assign("##menulist##", $menulist);

	// Temp Link Foooter
	if ($langcode == 'en') {
		$Linktext = "<p class=\"linkfooter\"><a href=\"http://www.fact-link.com/index.php?lang=th\" target=\"_blank\">Fact-Link Thailand is here</a></p>";
		$Linktext2 = "<p class=\"linkfooter\"><a href=\"http://indonesia.fact-link.com\" target=\"_blank\">Fact-Link Indonesia is here</a></p>";
		$Linktext3 = "<p class=\"linkfooter\"><a href=\"http://www.tdc-thai.com/\" target=\"_blank\">Thailand real estate information is here.</a></p>";
		$Linktext4 = "<p class=\"linkfooter\"><a href=\"https://fact-depot.com\" target=\"_blank\">Online purchasing service for MRO products in Vietnam</a></p>";
		$Linktext5 = "<p class=\"linkfooter\"><a href=\"http://www.tdc-vietnam.com\" target=\"_blank\">Vietnamese Factory information is here</a></p>";
	} elseif ($langcode == 'vn') {
		$Linktext = "<p class=\"linkfooter\"><a href=\"http://www.fact-link.com/index.php?lang=th\" target=\"_blank\">Fact-Link Thailand is here</a></p>";
		$Linktext2 = "<p class=\"linkfooter\"><a href=\"http://indonesia.fact-link.com\" target=\"_blank\">Fact-Link Indonesia is here</a></p>";
		$Linktext3 = "<p class=\"linkfooter\"><a href=\"http://www.tdc-thai.com/\" target=\"_blank\">Thailand real estate information is here.</a></p>";
		$Linktext4 = "<p class=\"linkfooter\"><a href=\"https://fact-depot.com\" target=\"_blank\">Chuyên thiết bị công nghiệp online tại Việt Nam</a></p>";
		$Linktext5 = "<p class=\"linkfooter\"><a href=\"http://www.tdc-vietnam.com\" target=\"_blank\">Thông tin nhà xưởng cho thuê tại Việt Nam</a></p>";
	} else {
		$Linktext = "<p class=\"linkfooter\"><a href=\"http://www.fact-link.com/index.php?lang=th\" target=\"_blank\">ファクトリンク タイはこちら</a></p>";
		$Linktext2 = "<p class=\"linkfooter\"><a href=\"http://indonesia.fact-link.com\" target=\"_blank\">ファクトリンク インドネシアはこちら</a></p>";
		$Linktext3 = "<p class=\"linkfooter\"><a href=\"http://www.tdc-thai.com/\" target=\"_blank\">タイの不動産情報はこちら</a></p>";
		$Linktext4 = "<p class=\"linkfooter\"><a href=\"https://fact-depot.com\" target=\"_blank\">ベトナムのオンライン工具通販はこちら</a></p>";
		$Linktext5 = "<p class=\"linkfooter\"><a href=\"http://www.tdc-vietnam.com\" target=\"_blank\">ベトナムの工場情報はこちら</a></p>";
	}
	
	if ($Linktext != '') {
		$LinkF = "<tr>
		<td valign=\"top\" class=\"grey_s\">".$Linktext."</td>
	  </tr>";
	} else { $LinkF = ""; }

	if ($Linktext2 != '') {
		$LinkF2 = "<tr>
		<td valign=\"top\" class=\"grey_s\">".$Linktext2."</td>
	  </tr>";
	} else { $LinkF2 = ""; }

	if ($Linktext3 != '') {
		$LinkF3 = "<tr>
		<td valign=\"top\" class=\"grey_s\">".$Linktext3."</td>
	  </tr>";
	} else { $LinkF3 = ""; }

	if ($Linktext4 != '') {
		$LinkF4 = "<tr>
		<td valign=\"top\" class=\"grey_s\">".$Linktext4."</td>
	  </tr>";
	} else { $LinkF4 = ""; }

	if ($Linktext5 != '') {
		$LinkF5 = "<tr>
		<td valign=\"top\" class=\"grey_s\">".$Linktext5."</td>
	  </tr>";
	} else { $LinkF5 = ""; }

	$tpl->assign("##LinkF##", $LinkF);
	$tpl->assign("##LinkF2##", $LinkF2);
	$tpl->assign("##LinkF3##", $LinkF3);
	$tpl->assign("##LinkF4##", $LinkF4);
	$tpl->assign("##LinkF5##", $LinkF5);
	if ($langcode == 'vn') {
		$footerInfo = "<p>CÔNG TY TNHH FACT-LINK MARKETPLACE</br>Địa chỉ: 602/43 Điện Biên Phủ, Phường 22, Quận Bình Thạnh, Thành phố Hồ Chí Minh</br>SĐT: 0888 767 138 - Email: info@fact-link.com.vn</br>Số GCNĐKDN (MST): 0313 560 828</br>Cấp ngày:  03/12/2015 bởi Sở Kế Hoạch và Đầu Tư TP. HCM</p>";
	} else {
		$footerInfo = "<p>FACT-LINK MARKETPLACE CO.,LTD</br>Address: 602/43 Dien Bien Phu, Ward 22, Binh Thanh District, Ho Chi Minh City.</br>Tel: 0888 767 138 - Email: info@fact-link.com.vn</br>Tax code: 0313 560 828</br>Date: 03/12/2015 by Ho Chi Minh City Department of Planning and Investment</p>";
	}
	$footerInfo .= "<p><a rel=\"nofollow\" target=\"_blank\" href=\"http://online.gov.vn/HomePage/WebsiteDisplay.aspx?DocId=50823\"><img alt=\"\" title=\"\" src=\"/image/authent.png\" /></a></p>";
	$tpl->assign("##FOOTER_INFO##", $footerInfo);

	if ($langcode == 'en') {
		$footerTerm = "<ul lang=\"en\">
							<li><a href=\"terms.php?term=1\">Operation regulation</a></li>
							<li><a href=\"terms.php?term=2\">Personal information's protecting policy</a></li>
							<li><a href=\"terms.php?term=3\">Resolving disputes, complaints</a></li>
						</ul>";
	} elseif ($langcode == 'vn') {
		$footerTerm = "<ul lang=\"en\">
							<li><a href=\"terms.php?term=1\">Quy chế hoạt động</a></li>
							<li><a href=\"terms.php?term=2\">Bảo vệ thông tin cá nhân</a></li>
							<li><a href=\"terms.php?term=3\">Giải quyết tranh chấp</a></li>
						</ul>";
	} else {
		$footerTerm = "<ul lang=\"en\">
							<li><a href=\"terms.php?term=1\">利用規約</a></li>
							<li><a href=\"terms.php?term=2\"> プライバシーポリシー</a></li>
							<li><a href=\"terms.php?term=3\">苦情等</a></li>
						</ul>";
	}
	$tpl->assign("##MenuFooterTerm_tpl##", $footerTerm);

	if (basename($_SERVER['PHP_SELF']) !== "mem_profile.php") {
		$tpl->assign("##FOOTER##", "");
	}
	// End footer

	// Build Breadcrumb
	$namePage = getNamePage($memid, $pagid, $langcode);
	$tpl->assign("##namePage##", $namePage);
	$tpl->assign("##profilePageLink##", $profilePageLink);
	$tpl->assign("##catName##", $menucatname);
	$linkCatBreadcrumb = "search_category.php?id=$menumemcate&start=0&lang=$langcode";
	$linkToppage = "index.php?lang=$langcode";
	$tpl->assign("##linkCatBreadcrumb##", $linkCatBreadcrumb);
	$tpl->assign("##linkToppage##", $linkToppage);
	// End Build bredcrumb

	// Hide On Paid Member
	if ($memPackage !== '') {
		$tpl->assign("##hidePaidMemberClass##", "none");
	} else {
		$tpl->assign("##hidePaidMemberClass##", "");
	}

	
?>
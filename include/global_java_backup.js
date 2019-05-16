function check_form(formname) {

	switch (formname) {
		
		case 'f_admmemedit' :
			if (document.formadmmemedit.t_comname_en.value=="") { alert ("Company Name [EN] is required."); document.formadmmemedit.t_comname_en.focus(); return false; }
			else if (document.formadmmemedit.t_memcat.value=="") { alert ("業種の要求が許可されました。\nCategory is required."); document.formadmmemedit.t_memcat.focus(); return false; }
			else if (document.formadmmemedit.t_comie.value=="") { alert ("Industrial Estate is required."); document.formadmmemedit.t_comie.focus(); return false; }
			else if (document.formadmmemedit.t_comaddress_en.value=="") { alert ("Address [EN] is required."); document.formadmmemedit.t_comaddress_en.focus(); return false; }
			else if (document.formadmmemedit.t_comprovince.value=="") { alert ("Province is required."); document.formadmmemedit.t_comprovince.focus(); return false; }
			else if (document.formadmmemedit.t_comzip.value=="") { alert ("Portal Code is required."); document.formadmmemedit.t_comzip.focus(); return false; }
			else if (document.formadmmemedit.t_comtel.value=="") { alert ("Tel. is required."); document.formadmmemedit.t_comtel.focus(); return false; }
			else if (document.formadmmemedit.t_contact_en.value=="") { alert ("Contact Name [EN] is required."); document.formadmmemedit.t_contact_en.focus(); return false; }
			else if (document.formadmmemedit.t_position_en.value=="") { alert ("Position Name [EN] is required."); document.formadmmemedit.t_position_en.focus(); return false; }
			else if (document.formadmmemedit.t_mail.value=="") { alert ("Contact E-mail is required."); document.formadmmemedit.t_mail.focus(); return false; }
			else if (document.formadmmemedit.t_tel.value=="") { alert ("Contact Tel. is required."); document.formadmmemedit.t_tel.focus(); return false; }
			break;
		case 'f_admmemcon' :
			if (document.formadmmemcon.t_memcat.value=="") { alert ("Category is required."); document.formadmmemcon.t_memcat.focus(); return false; }
			break;		
		
		case 'f_admbanadd' :
			if (document.formadmbanadd.t_name.value=="") { alert("Banner Name is required."); document.formadmbanadd.t_name.focus(); return false; }
			else if (document.formadmbanadd.t_pospage.value=="") { alert ("Position - Page is required."); document.formadmbanadd.t_pospage.focus(); return false; }
			else if (document.formadmbanadd.t_image_en.value=="") { alert ("Banner Image is required."); document.formadmbanadd.t_image_en.focus(); return false; }
			else if (document.formadmbanadd.t_width_en.value=="") { alert ("Width is required."); document.formadmbanadd.t_width_en.focus(); return false; }
			else if (document.formadmbanadd.t_height_en.value=="") { alert ("Height is required."); document.formadmbanadd.t_height_en.focus(); return false; }
			else if (document.formadmbanadd.t_image_jp.value=="") { alert ("Banner Image is required."); document.formadmbanadd.t_image_jp.focus(); return false; }
			else if (document.formadmbanadd.t_width_jp.value=="") { alert ("Width is required."); document.formadmbanadd.t_width_jp.focus(); return false; }
			else if (document.formadmbanadd.t_height_jp.value=="") { alert ("Height is required."); document.formadmbanadd.t_height_jp.focus(); return false; }
			else if (document.formadmbanadd.t_image_vn.value=="") { alert ("Banner Image is required."); document.formadmbanadd.t_image_vn.focus(); return false; }
			else if (document.formadmbanadd.t_width_vn.value=="") { alert ("Width is required."); document.formadmbanadd.t_width_vn.focus(); return false; }
			else if (document.formadmbanadd.t_height_vn.value=="") { alert ("Height is required."); document.formadmbanadd.t_height_vn.focus(); return false; }
			break;
		case 'f_admbanedt' :
			if (document.formadmbanedt.t_name.value=="") { alert("Banner Name is required."); document.formadmbanedt.t_name.focus(); return false; }
			else if (document.formadmbanedt.t_pospage.value=="") { alert ("Position - Page is required."); document.formadmbanedt.t_pospage.focus(); return false; }
			else if (document.formadmbanedt.t_width_en.value=="") { alert ("Width is required."); document.formadmbanedt.t_width_en.focus(); return false; }
			else if (document.formadmbanedt.t_height_en.value=="") { alert ("Height is required."); document.formadmbanedt.t_height_en.focus(); return false; }
			else if (document.formadmbanedt.t_width_jp.value=="") { alert ("Width is required."); document.formadmbanedt.t_width_jp.focus(); return false; }
			else if (document.formadmbanedt.t_height_jp.value=="") { alert ("Height is required."); document.formadmbanedt.t_height_jp.focus(); return false; }
			else if (document.formadmbanedt.t_width_vn.value=="") { alert ("Width is required."); document.formadmbanedt.t_width_vn.focus(); return false; }
			else if (document.formadmbanedt.t_height_vn.value=="") { alert ("Height is required."); document.formadmbanedt.t_height_vn.focus(); return false; }
			break;
		case 'f_admbuladd' :
			if (document.formadmbuladd.t_name.value=="") { alert("Bulletin Name is required."); document.formadmbuladd.t_name.focus(); return false; }
			else if (document.formadmbuladd.t_detail_en.value=="") { alert("Bulletin Text [EN] is required."); document.formadmbuladd.t_detail_en.focus(); return false; }
			else if (document.formadmbuladd.t_detail_jp.value=="") { alert("Bulletin Text [JP] is required."); document.formadmbuladd.t_detail_jp.focus(); return false; }
			else if (document.formadmbuladd.t_detail_vn.value=="") { alert("Bulletin Text [VN] is required."); document.formadmbuladd.t_detail_vn.focus(); return false; }
			else if (document.formadmbuladd.t_pospage.value=="") { alert ("Position - Page is required."); document.formadmbuladd.t_pospage.focus(); return false; }
			break;
		case 'f_admbacadd' :
			if (document.formadmbacadd.t_name.value=="") { alert("Banner Name is required."); document.formadmbacadd.t_name.focus(); return false; }
			else if (document.formadmbacadd.t_image.value=="") { alert ("Banner Image is required."); document.formadmbacadd.t_image.focus(); return false; }
			else if (document.formadmbacadd.t_width.value=="") { alert ("Width is required."); document.formadmbacadd.t_width.focus(); return false; }
			else if (document.formadmbacadd.t_height.value=="") { alert ("Height is required."); document.formadmbacadd.t_height.focus(); return false; }
			else if (document.formadmbacadd.t_cat.value=="") { alert ("Category is required."); document.formadmbacadd.t_cat.focus(); return false; }
			break;
		case 'f_admbacedt' :
			if (document.formadmbacedt.t_name.value=="") { alert("Banner Name is required."); document.formadmbacedt.t_name.focus(); return false; }
			else if (document.formadmbacedt.t_width.value=="") { alert ("Width is required."); document.formadmbacedt.t_width.focus(); return false; }
			else if (document.formadmbacedt.t_height.value=="") { alert ("Height is required."); document.formadmbacedt.t_height.focus(); return false; }
			else if (document.formadmbacedt.t_cat.value=="") { alert ("Category is required."); document.formadmbacedt.t_cat.focus(); return false; }
			break;
		case 'f_admbucadd' :
			if (document.formadmbucadd.t_name.value=="") { alert("Bulletin Name is required."); document.formadmbucadd.t_name.focus(); return false; }
			else if (document.formadmbucadd.t_detail_en.value=="") { alert("Bulletin Text [EN] is required."); document.formadmbucadd.t_detail_en.focus(); return false; }
			else if (document.formadmbucadd.t_detail_jp.value=="") { alert("Bulletin Text [JP] is required."); document.formadmbucadd.t_detail_jp.focus(); return false; }
			else if (document.formadmbucadd.t_detail_vn.value=="") { alert("Bulletin Text [VN] is required."); document.formadmbucadd.t_detail_vn.focus(); return false; }
			else if (document.formadmbucadd.t_image.value=="") { alert ("Bulletin Image is required."); document.formadmbucadd.t_image.focus(); return false; }
			else if (document.formadmbucadd.t_cat.value=="") { alert ("Category is required."); document.formadmbucadd.t_cat.focus(); return false; }
			break;
		case 'f_admbucedt' :
			if (document.formadmbucedt.t_name.value=="") { alert("Bulletin Name is required."); document.formadmbucedt.t_name.focus(); return false; }
			else if (document.formadmbucedt.t_detail_en.value=="") { alert("Bulletin Text [EN] is required."); document.formadmbucedt.t_detail_en.focus(); return false; }
			else if (document.formadmbucedt.t_detail_jp.value=="") { alert("Bulletin Text [JP] is required."); document.formadmbucedt.t_detail_jp.focus(); return false; }
			else if (document.formadmbucedt.t_detail_vn.value=="") { alert("Bulletin Text [VN] is required."); document.formadmbucedt.t_detail_vn.focus(); return false; }
			else if (document.formadmbucedt.t_cat.value=="") { alert ("Category is required."); document.formadmbucedt.t_cat.focus(); return false; }
			break;
		case 'f_admfeaadd' :
			if (document.formadmfeaadd.t_title_en.value=="") { alert("Title [EN] is required."); document.formadmfeaadd.t_title_en.focus(); return false; }
			else if (document.formadmfeaadd.t_title_jp.value=="") { alert ("Title [JP] is required."); document.formadmfeaadd.t_title_jp.focus(); return false; }
			else if (document.formadmfeaadd.t_title_vn.value=="") { alert ("Title [VN] is required."); document.formadmfeaadd.t_title_vn.focus(); return false; }
			else if (document.formadmfeaadd.t_detail_en.value=="") { alert("Detail [EN] is required."); document.formadmfeaadd.t_detail_en.focus(); return false; }
			else if (document.formadmfeaadd.t_detail_jp.value=="") { alert ("Detail [JP] is required."); document.formadmfeaadd.t_detail_jp.focus(); return false; }
			else if (document.formadmfeaadd.t_detail_vn.value=="") { alert ("Detail [VN] is required."); document.formadmfeaadd.t_detail_vn.focus(); return false; }
			break;
		case 'f_admuifadd' :
			if (document.formadmuifadd.t_name.value=="") { alert("Updated Info Name is required."); document.formadmuifadd.t_name.focus(); return false; }
			else if (document.formadmuifadd.t_detail_en.value=="") { alert("Detail [EN] is required."); document.formadmuifadd.t_detail_en.focus(); return false; }
			else if (document.formadmuifadd.t_detail_jp.value=="") { alert("Detail Text [JP] is required."); document.formadmuifadd.t_detail_jp.focus(); return false; }
			else if (document.formadmuifadd.t_detail_vn.value=="") { alert("Detail Text [VN] is required."); document.formadmuifadd.t_detail_vn.focus(); return false; }
			break;
		case 'f_admmagadd' :
			if (document.formadmmagadd.t_subject.value=="") { alert("Subject is required."); document.formadmmagadd.t_subject.focus(); return false; }
			else if (document.formadmmagadd.t_detail.value=="") { alert("Detail is required."); document.formadmmagadd.t_detail.focus(); return false; }
			break;
		case 'f_admintadd' :
			if (document.formadmintadd.t_name_en.value=="") { alert("Name [EN] is required."); document.formadmintadd.t_name_en.focus(); return false; }
			else if (document.formadmintadd.t_name_jp.value=="") { alert ("Name [JP] is required."); document.formadmintadd.t_name_jp.focus(); return false; }
			else if (document.formadmintadd.t_name_vn.value=="") { alert ("Name [VN] is required."); document.formadmintadd.t_name_vn.focus(); return false; }
			else if (document.formadmintadd.t_title_en.value=="") { alert("Title [EN] is required."); document.formadmintadd.t_title_en.focus(); return false; }
			else if (document.formadmintadd.t_title_jp.value=="") { alert ("Title [JP] is required."); document.formadmintadd.t_title_jp.focus(); return false; }
			else if (document.formadmintadd.t_title_vn.value=="") { alert ("Title [VN] is required."); document.formadmintadd.t_title_vn.focus(); return false; }
			else if (document.formadmintadd.t_detail_en.value=="") { alert("Detail [EN] is required."); document.formadmintadd.t_detail_en.focus(); return false; }
			else if (document.formadmintadd.t_detail_jp.value=="") { alert ("Detail [JP] is required."); document.formadmintadd.t_detail_jp.focus(); return false; }
			else if (document.formadmintadd.t_detail_vn.value=="") { alert ("Detail [VN] is required."); document.formadmintadd.t_detail_vn.focus(); return false; }
			else if (document.formadmintadd.t_link.value=="") { alert ("URL Link is required."); document.formadmintadd.t_link.focus(); return false; }
			break;
		case 'f_adminsadd' :
			if (document.formadminsadd.t_int1.value=="") { alert("Content Name 1 is required."); document.formadminsadd.t_int1.focus(); return false; }
			else if (document.formadminsadd.t_int2.value=="") { alert ("Content Name 2 is required."); document.formadminsadd.t_int2.focus(); return false; }
			else if (document.formadminsadd.t_int3.value=="") { alert ("Content Name 3 is required."); document.formadminsadd.t_int3.focus(); return false; }
			break;
		case 'f_admmemtpm' :
			if (document.formadmmemtpm.t_tpm.value=="") { alert("Main Template Style is required."); document.formadmmemtpm.t_tpm.focus(); return false; }
			break;
		case 'f_admnwsadd' :
			if (document.formadmnwsadd.t_nwg.value=="") { alert ("News Genre is required."); document.formadmnwsadd.t_nwg.focus(); return false; }
			else if (document.formadmnwsadd.t_nwe.value=="") { alert ("News Editor is required."); document.formadmnwsadd.t_nwe.focus(); return false; }
			else if (document.formadmnwsadd.t_title_en.value=="") { alert("Title [EN] is required."); document.formadmnwsadd.t_title_en.focus(); return false; }
			else if (document.formadmnwsadd.t_title_jp.value=="") { alert ("Title [JP] is required."); document.formadmnwsadd.t_title_jp.focus(); return false; }
			else if (document.formadmnwsadd.t_title_vn.value=="") { alert ("Title [VN] is required."); document.formadmnwsadd.t_title_vn.focus(); return false; }
			else if (document.formadmnwsadd.t_sum_en.value=="") { alert("Compend [EN] is required."); document.formadmnwsadd.t_sum_en.focus(); return false; }
			else if (document.formadmnwsadd.t_sum_jp.value=="") { alert ("Compend [JP] is required."); document.formadmnwsadd.t_sum_jp.focus(); return false; }
			else if (document.formadmnwsadd.t_sum_vn.value=="") { alert ("Compend [VN] is required."); document.formadmnwsadd.t_sum_vn.focus(); return false; }
			else if (document.formadmnwsadd.t_detail_en.value=="") { alert("Detail [EN] is required."); document.formadmnwsadd.t_detail_en.focus(); return false; }
			else if (document.formadmnwsadd.t_detail_jp.value=="") { alert ("Detail [JP] is required."); document.formadmnwsadd.t_detail_jp.focus(); return false; }
			else if (document.formadmnwsadd.t_detail_vn.value=="") { alert ("Detail [VN] is required."); document.formadmnwsadd.t_detail_vn.focus(); return false; }
			else if (document.formadmnwsadd.t_day.value=="") { alert ("News Date is required."); document.formadmnwsadd.t_day.focus(); return false; }
			else if (document.formadmnwsadd.t_month.value=="") { alert ("News Date is required."); document.formadmnwsadd.t_month.focus(); return false; }
			else if (document.formadmnwsadd.t_year.value=="") { alert ("News Date is required."); document.formadmnwsadd.t_year.focus(); return false; }
			break;
		case 'f_admnwgadd' :
			if (document.formadmnwgadd.t_name_en.value=="") { alert("Name [EN] is required."); document.formadmnwgadd.t_name_en.focus(); return false; }
			else if (document.formadmnwgadd.t_name_jp.value=="") { alert ("Name [JP] is required."); document.formadmnwgadd.t_name_jp.focus(); return false; }
			else if (document.formadmnwgadd.t_name_vn.value=="") { alert ("Name [VN] is required."); document.formadmnwgadd.t_name_vn.focus(); return false; }
			break;
		case 'f_admnweadd' :
			if (document.formadmnweadd.t_name_en.value=="") { alert("Name [EN] is required."); document.formadmnweadd.t_name_en.focus(); return false; }
			else if (document.formadmnweadd.t_name_jp.value=="") { alert ("Name [JP] is required."); document.formadmnweadd.t_name_jp.focus(); return false; }
			else if (document.formadmnweadd.t_name_vn.value=="") { alert ("Name [VN] is required."); document.formadmnweadd.t_name_vn.focus(); return false; }
			break;
		case 'f_admcatadd' :
			if (document.formadmcatadd.t_name_en.value=="") { alert("Name [EN] is required."); document.formadmcatadd.t_name_en.focus(); return false; }
			else if (document.formadmcatadd.t_name_jp.value=="") { alert ("Name [JP] is required."); document.formadmcatadd.t_name_jp.focus(); return false; }
			else if (document.formadmcatadd.t_name_vn.value=="") { alert ("Name [VN] is required."); document.formadmcatadd.t_name_vn.focus(); return false; }
			else if (document.formadmcatadd.t_pos.value=="s"&&document.formadmcatadd.t_under.value=="") { alert ("Please select Main Group."); document.formadmcatadd.t_under.focus(); return false; }
			break;
		case 'f_admprvadd' :
			if (document.formadmprvadd.t_name_en.value=="") { alert("Name [EN] is required."); document.formadmprvadd.t_name_en.focus(); return false; }
			else if (document.formadmprvadd.t_name_jp.value=="") { alert ("Name [JP] is required."); document.formadmprvadd.t_name_jp.focus(); return false; }
			else if (document.formadmprvadd.t_name_vn.value=="") { alert ("Name [VN] is required."); document.formadmprvadd.t_name_vn.focus(); return false; }
			break;
		case 'f_admineadd' :
			if (document.formadmineadd.t_name_en.value=="") { alert("Name [EN] is required."); document.formadmineadd.t_name_en.focus(); return false; }
			else if (document.formadmineadd.t_name_jp.value=="") { alert ("Name [JP] is required."); document.formadmineadd.t_name_jp.focus(); return false; }
			else if (document.formadmineadd.t_name_vn.value=="") { alert ("Name [VN] is required."); document.formadmineadd.t_name_vn.focus(); return false; }
			break;
		case 'f_admpckadd' :
			if (document.formadmpckadd.t_name_en.value=="") { alert("Name [EN] is required."); document.formadmpckadd.t_name_en.focus(); return false; }
			else if (document.formadmpckadd.t_day.value=="") { alert ("Day(s) is required."); document.formadmpckadd.t_day.focus(); return false; }
			else if (document.formadmpckadd.t_day.value=="0") { alert ("Day(s) value must more than 0."); document.formadmpckadd.t_day.focus(); return false; }
			break;
		case 'f_admtpmadd' :
			if (document.formadmtpmadd.t_name_en.value=="") { alert("Name [EN] is required."); document.formadmtpmadd.t_name_en.focus(); return false; }
			else if (document.formadmtpmadd.t_name_file.value=="") { alert ("File Name is required."); document.formadmtpmadd.t_name_file.focus(); return false; }
			else if (document.formadmtpmadd.t_clf.value=="") { alert ("Title Color is required."); document.formadmtpmadd.t_clf.focus(); return false; }
			else if (document.formadmtpmadd.t_tpk.value=="") { alert ("Panel Color is required."); document.formadmtpmadd.t_tpk.focus(); return false; }
			break;
		case 'f_admtpkadd' :
			if (document.formadmtpkadd.t_name_en.value=="") { alert("Name [EN] is required."); document.formadmtpkadd.t_name_en.focus(); return false; }
			else if (document.formadmtpkadd.t_name_file.value=="") { alert ("File Name is required."); document.formadmtpkadd.t_name_file.focus(); return false; }
			break;
		case 'f_admptcadd' :
			if (document.formadmptcadd.t_name_en.value=="") { alert("Name [EN] is required."); document.formadmptcadd.t_name_en.focus(); return false; }
			break;
		
		// --------------------------------------
		
		case 'f_edtprfadd' :
			if (document.formedtprfadd.t_pagname.value=="") { alert ("メニュー名の要求が許可されました。\nMenu Name is required."); document.formedtprfadd.t_pagname.focus(); return false; }
			else if (document.formedtprfadd.t_pagpagetitle.value=="") { alert ("タイトルバー名の要求が許可されました。\nTitle Bar Name is required."); document.formedtprfadd.t_pagpagetitle.focus(); return false; }
			else if (document.formedtprfadd.t_pagsort.value=="") { alert ("オーダーナンバーの要求が許可されました。\nOrder No. is required."); document.formedtprfadd.t_pagsort.focus(); return false; }
			else if (document.formedtprfadd.t_pagtitle.value=="") { alert ("ページの大見出しの要求が許可されました。\nTitle is required."); document.formedtprfadd.t_pagtitle.focus(); return false; }
			else if (document.formedtprfadd.t_comname.value=="") { alert ("会社名の要求が許可されました。\nCompany Name is required."); document.formedtprfadd.t_comname.focus(); return false; }
			/*else if (document.formedtprfadd.t_memsubdesc.value=="") { alert ("会社キャッチコピー の要求が許可されました。\nCompany Slogan is required."); document.formedtprfadd.t_memsubdesc.focus(); return false; }*/
			else if (document.formedtprfadd.t_pername.value=="") { alert ("代表者名の要求が許可されました。\nRepresentative Name is required."); document.formedtprfadd.t_pername.focus(); return false; }
			else if (document.formedtprfadd.t_posname.value=="") { alert ("役職の要求が許可されました。\nPosition is required."); document.formedtprfadd.t_posname.focus(); return false; }
			else if (document.formedtprfadd.t_business.value=="") { alert ("事業内容の要求が許可されました。\nBusiness Description is required."); document.formedtprfadd.t_business.focus(); return false; }
			else if (document.formedtprfadd.t_product.value=="") { alert ("取扱品目の要求が許可されました。\nProduce is required."); document.formedtprfadd.t_product.focus(); return false; }
			else if (document.formedtprfadd.t_comaddlab1.value=="") { alert ("住所（見出し） 1 の要求が許可されました。\nAddress Label 1 is required."); document.formedtprfadd.t_comaddlab1.focus(); return false; }
			else if (document.formedtprfadd.t_comadd1.value=="") { alert ("住所 1 の要求が許可されました。\nAddress 1 is required."); document.formedtprfadd.t_comadd1.focus(); return false; }
			else if (document.formedtprfadd.t_ine1.value=="") { alert ("住所（工業団地） 1 の要求が許可されました。\nIndustrial Estate 1 is required."); document.formedtprfadd.t_ine1.focus(); return false; }
			else if (document.formedtprfadd.t_prv1.value=="") { alert ("住所（県名） 1 の要求が許可されました。\nProvince 1 is required."); document.formedtprfadd.t_prv1.focus(); return false; }
			else if (document.formedtprfadd.t_zip1.value=="") { alert ("住所（郵便番号） 1 の要求が許可されました。\nPortal Code 1 is required."); document.formedtprfadd.t_zip1.focus(); return false; }
			else if (document.formedtprfadd.t_comtellab1.value=="") { alert ("電話（見出し） 1 の要求が許可されました。\nTel Label 1 is required."); document.formedtprfadd.t_comtellab1.focus(); return false; }
			else if (document.formedtprfadd.t_comtel1.value=="") { alert ("ご連絡先 TEL 1 の要求が許可されました。\nTel 1 is required."); document.formedtprfadd.t_comtel1.focus(); return false; }
			else if (document.formedtprfadd.t_footer.value=="") { alert ("下部欄外の帯名称の要求が許可されました。\nFooter is required."); document.formedtprfadd.t_footer.focus(); return false; }
			break;
		
		case 'f_edthomadd' :
			if (document.formedthomadd.t_pagname.value=="") { alert("メニュー名の要求が許可されました。\nMenu Name is required."); document.formedthomadd.t_pagname.focus(); return false; }
			else if (document.formedthomadd.t_pagpagetitle.value=="") { alert ("タイトルバー名の要求が許可されました。\nTitle Bar Name is required."); document.formedthomadd.t_pagpagetitle.focus(); return false; }
			else if (document.formedthomadd.t_pagsort.value=="") { alert ("オーダーナンバーの要求が許可されました。\nOrder No. is required."); document.formedthomadd.t_pagsort.focus(); return false; }
			else if (document.formedthomadd.t_pagtitle.value=="") { alert ("ページの大見出しの要求が許可されました。\nTitle is required."); document.formedthomadd.t_pagtitle.focus(); return false; }
			break;
		
		case 'f_edtinqadd' :
			if (document.formedtinqadd.t_pagname.value=="") { alert("メニュー名の要求が許可されました。\nMenu Name is required."); document.formedtinqadd.t_pagname.focus(); return false; }
			else if (document.formedtinqadd.t_pagpagetitle.value=="") { alert ("タイトルバー名の要求が許可されました。\nTitle Bar Name is required."); document.formedtinqadd.t_pagpagetitle.focus(); return false; }
			else if (document.formedtinqadd.t_pagsort.value=="") { alert ("オーダーナンバーの要求が許可されました。\nOrder No. is required."); document.formedtinqadd.t_pagsort.focus(); return false; }
			else if (document.formedtinqadd.t_pagtitle.value=="") { alert ("ページの大見出しの要求が許可されました。\nTitle is required."); document.formedtinqadd.t_pagtitle.focus(); return false; }
			break;
		
		case 'f_edtpstadd' :
			if (document.formedtpstadd.t_pagname.value=="") { alert("メニュー名の要求が許可されました。\nMenu Name is required."); document.formedtpstadd.t_pagname.focus(); return false; }
			else if (document.formedtpstadd.t_pagpagetitle.value=="") { alert ("タイトルバー名の要求が許可されました。\nTitle Bar Name is required."); document.formedtpstadd.t_pagpagetitle.focus(); return false; }
			else if (document.formedtpstadd.t_pagsort.value=="") { alert ("オーダーナンバーの要求が許可されました。\nOrder No. is required."); document.formedtpstadd.t_pagsort.focus(); return false; }
			else if (document.formedtpstadd.t_pagtitle.value=="") { alert ("ページの大見出しの要求が許可されました。\nTitle is required."); document.formedtpstadd.t_pagtitle.focus(); return false; }
			break;
		
		case 'f_edtboxadd' :
			if (document.formedtboxadd.t_boxsort.value=="") { alert ("オーダーナンバーの要求が許可されました。\nOrder No. is required."); document.formedtboxadd.t_boxsort.focus(); return false; }
			break;
		
		case 'f_edtconadd' :
			if (document.formedtconadd.t_pagname.value=="") { alert("メニュー名の要求が許可されました。\nMenu Name is required."); document.formedtvadd.t_pagname.focus(); return false; }
			else if (document.formedtconadd.t_pagpagetitle.value=="") { alert ("タイトルバー名の要求が許可されました。\nTitle Bar Name is required."); document.formedtconadd.t_pagpagetitle.focus(); return false; }
			else if (document.formedtconadd.t_pagsort.value=="") { alert ("オーダーナンバーの要求が許可されました。\nOrder No. is required."); document.formedtconadd.t_pagsort.focus(); return false; }
			else if (document.formedtconadd.t_pagtitle.value=="") { alert ("ページの大見出しの要求が許可されました。\nTitle is required."); document.formedtconadd.t_pagtitle.focus(); return false; }
			break;
		
		case 'f_edtcoladd' :
			if (document.formedtcoladd.t_consort.value=="") { alert("オーダーナンバーの要求が許可されました。\nOrder No. is required."); document.formedtcoladd.t_consort.focus(); return false; }
			else if (document.formedtcoladd.t_ptc.value=="") { alert ("デザイン選択の要求が許可されました。\nPattern is required."); document.formedtcoladd.t_ptc.focus(); return false; }
			else if (document.formedtcoladd.t_contitle.value=="") { alert ("ページの大見出しの要求が許可されました。\nTitle is required."); document.formedtcoladd.t_contitle.focus(); return false; }
			break;
			
		case 'f_edtpassedit' :
			if (document.formedtpassedit.t_password_old.value!=document.formedtpassedit.h_mempassword.value) { alert ("現在のパスワードは正しくありません。\nCurrent Password is incorrect."); document.formedtpassedit.t_password_old.focus(); return false; }
			else if (document.formedtpassedit.t_password.value=="") { alert ("新しいパスワードの要求が許可されました。\nNew Password is required."); document.formedtpassedit.t_password.focus(); return false; }
			else if (document.formedtpassedit.t_password_confirm.value!=document.formedtpassedit.t_password.value) { alert ("新しいパスワードの認証が正しくありません。\nConfirm New Password does not match."); document.formedtpassedit.t_password_confirm.focus(); return false; }
			break;			
		
		case 'f_edtmemedit' :
			
			var validRegExp = /^\w(\.?[\w-])*@\w(\.?[\w-])*\.[a-z]{2,6}$/i;
			var strEmail = document.formedtmemedit.t_mail.value;
			
			if (document.formedtmemedit.t_comname_en.value=="") { alert ("会社名の要求が許可されました。\nCompany Name [EN] is required."); document.formedtmemedit.t_comname_en.focus(); return false; }
			else if (document.formedtmemedit.t_memcat.value=="") { alert ("業種の要求が許可されました。\nCategory is required."); document.formedtmemedit.t_memcat.focus(); return false; }
			else if (document.formedtmemedit.t_comie.value=="") { alert ("工業団地の要求が許可されました。\nIndustrial Estate is required."); document.formedtmemedit.t_comie.focus(); return false; }
			else if (document.formedtmemedit.t_comaddress_en.value=="") { alert ("住所の要求が許可されました。\nAddress [EN] is required."); document.formedtmemedit.t_comaddress_en.focus(); return false; }
			else if (document.formedtmemedit.t_comprovince.value=="") { alert ("県名の要求が許可されました。\nProvince is required."); document.formedtmemedit.t_comprovince.focus(); return false; }
			else if (document.formedtmemedit.t_comzip.value=="") { alert ("郵便番号の要求が許可されました。\nPortal Code is required."); document.formedtmemedit.t_comzip.focus(); return false; }
			else if (document.formedtmemedit.t_comtel.value=="") { alert ("TEL の要求が許可されました。\nTel is required."); document.formedtmemedit.t_comtel.focus(); return false; }
			else if (document.formedtmemedit.t_contact_en.value=="") { alert ("担当者の要求が許可されました。\nContact Name [EN] is required."); document.formedtmemedit.t_contact_en.focus(); return false; }
			else if (document.formedtmemedit.t_position_en.value=="") { alert ("部署役職名の要求が許可されました。\nPosition Name [EN] is required."); document.formedtmemedit.t_position_en.focus(); return false; }
			else if (document.formedtmemedit.t_mail.value=="") { alert ("ご連絡先 E-MAIL の要求が許可されました。\nContact E-mail is required."); document.formedtmemedit.t_mail.focus(); return false; }
			else if (strEmail.search(validRegExp) == -1) { alert ("有効な E-mail を入力してください。\nPlease enter a valid E-mail."); document.formedtmemedit.t_mail.focus(); return false; }
			else if (document.formedtmemedit.t_tel.value=="") { alert ("ご連絡先 TEL の要求が許可されました。\nContact Tel is required."); document.formedtmemedit.t_tel.focus(); return false; }
			break;
		
		case 'f_edtmailadd' :
			
			var validRegExp = /^\w(\.?[\w-])*@\w(\.?[\w-])*\.[a-z]{2,6}$/i;
			var strEmail = document.formedtmailadd.t_mail.value;
			
			if (document.formedtmailadd.t_to.value=="") { alert ("宛名の要求が許可されました。\nName of Receiver is required."); document.formedtmailadd.t_to.focus(); return false; }
			else if (document.formedtmailadd.t_mail.value=="") { alert ("送信先 E-mail の要求が許可されました。\nDestination E-mail Address is required."); document.formedtmailadd.t_mail.focus(); return false; }
			else if (strEmail.search(validRegExp) == -1) { alert ("有効な E-mail を入力してください。\nPlease enter a valid E-mail."); document.formedtmailadd.t_mail.focus(); return false; }
			else if (document.formedtmailadd.t_subject.value=="") { alert ("題名の要求が許可されました。\nSubject is required."); document.formedtmailadd.t_subject.focus(); return false; }
			else if (document.formedtmailadd.t_detail.value=="") { alert ("本文の要求が許可されました。\nDetail is required."); document.formedtmailadd.t_detail.focus(); return false; }
			break;	
		
		case 'f_edtsupadd' :
			if (document.formedtsupadd.t_subject.value=="") { alert ("題名の要求が許可されました。\nSubject is required."); document.formedtsupadd.t_subject.focus(); return false; }
			else if (document.formedtsupadd.t_detail.value=="") { alert ("本文の要求が許可されました。\nDetail is required."); document.formedtsupadd.t_detail.focus(); return false; }
			break;	
			
		// --------------------------------------
		
		case 'f_memlogin' :
			if (document.formmemlogin.t_memuser.value=="") { alert("ユーザー名が空欄です。ユーザー名をご入力ください。\nUsername is required."); document.formmemlogin.t_memuser.focus(); return false; }
			else if (document.formmemlogin.t_mempass.value=="") { alert ("パスワードが空欄です。パスワードをご入力ください。\nPassword is required."); document.formmemlogin.t_mempass.focus(); return false; }
			break;
		
		case 'f_meminqadd' :
			
			var validRegExp = /^\w(\.?[\w-])*@\w(\.?[\w-])*\.[a-z]{2,6}$/i;
			var strEmail = document.formmeminqadd.t_mail.value;
			
       
			if (document.formmeminqadd.t_company.value=="") { alert("貴社名の要求が許可されました。\nCompany Name is required."); document.formmeminqadd.t_company.focus(); return false; }
			else if (document.formmeminqadd.t_department.value=="") { alert ("部署名の要求が許可されました。\nDepartment is required."); document.formmeminqadd.t_department.focus(); return false; }
			else if (document.formmeminqadd.t_name.value=="") { alert ("お名前の要求が許可されました。\nYour name is required."); document.formmeminqadd.t_name.focus(); return false; }
			else if (document.formmeminqadd.t_tel.value=="") { alert ("TEL の要求が許可されました。\nTEL is required."); document.formmeminqadd.t_tel.focus(); return false; }
			else if (document.formmeminqadd.t_mail.value=="") { alert ("E-mail の要求が許可されました。\nE-mail is required."); document.formmeminqadd.t_mail.focus(); return false; }
			else if (strEmail.search(validRegExp) == -1) { alert ("有効な E-mail を入力してください。\nPlease enter a valid E-mail."); document.formmeminqadd.t_mail.focus(); return false; }
			else if (document.formmeminqadd.t_subject.value=="") { alert ("件名の要求が許可されました。\nSubject is required."); document.formmeminqadd.t_subject.focus(); return false; }
			else if (document.formmeminqadd.t_content.value=="") { alert ("内容の要求が許可されました。\nContent is required."); document.formmeminqadd.t_content.focus(); return false; }
			else if (document.formmeminqadd.t_confirmvalue.value!=document.formmeminqadd.h_random.value) { alert ("認証コードが正しくありません。\nConfirmation code does not match."); document.formmeminqadd.t_confirm.focus(); return false; }
			break;
		
		case 'f_memadd' :
			
			var validRegExp = /^\w(\.?[\w-])*@\w(\.?[\w-])*\.[a-z]{2,6}$/i;
			var strEmail = document.formmemadd.t_liam.value;
			
			if (document.formmemadd.t_emanresu.value=="") { alert("ユーザー名の要求が許可されました。\nUsername is required."); document.formmemadd.t_emanresu.focus(); return false; }
			else if (document.formmemadd.t_emanhtap.value=="") { alert ("希望WEBアドレスの要求が許可されました。\nMember Path Name is required."); document.formmemadd.t_emanhtap.focus(); return false; }
			else if (document.formmemadd.t_emanmoc_en.value=="") { alert ("会社名の要求が許可されました。\nCompany Name [EN] is required."); document.formmemadd.t_emanmoc_en.focus(); return false; }
			else if (document.formmemadd.t_tacmem.value=="") { alert ("業種の要求が許可されました。\nCategory is required."); document.formmemadd.t_tacmem.focus(); return false; }
			else if (document.formmemadd.t_eimoc.value=="") { alert ("工業団地の要求が許可されました。\nIndustrial Estate is required."); document.formmemadd.t_eimoc.focus(); return false; }
			else if (document.formmemadd.t_sserddamoc_en.value=="") { alert ("住所の要求が許可されました。\nAddress [EN] is required."); document.formmemadd.t_sserddamoc_en.focus(); return false; }
			else if (document.formmemadd.t_ecnivorpmoc.value=="") { alert ("県名の要求が許可されました。\nProvince is required."); document.formmemadd.t_ecnivorpmoc.focus(); return false; }
			else if (document.formmemadd.t_pizmoc.value=="") { alert ("郵便番号の要求が許可されました。\nPortal Code is required."); document.formmemadd.t_pizmoc.focus(); return false; }
			else if (document.formmemadd.t_letmoc.value=="") { alert ("TEL の要求が許可されました。\nTel is required."); document.formmemadd.t_letmoc.focus(); return false; }
			else if (document.formmemadd.t_tcatnoc_en.value=="") { alert ("担当者の要求が許可されました。\nContact Name [EN] is required."); document.formmemadd.t_tcatnoc_en.focus(); return false; }
			else if (document.formmemadd.t_noitisop_en.value=="") { alert ("部署役職名の要求が許可されました。\nPosition Name [EN] is required."); document.formmemadd.t_noitisop_en.focus(); return false; }
			else if (document.formmemadd.t_liam.value=="") { alert ("ご連絡先 E-mail の要求が許可されました。\nContact E-mail is required."); document.formmemadd.t_liam.focus(); return false; }
			else if (strEmail.search(validRegExp) == -1) { alert ("有効な E-mail を入力してください。\nPlease enter a valid E-mail."); document.formmemadd.t_liam.focus(); return false; }
			else if (document.formmemadd.t_let.value=="") { alert ("ご連絡先 TEL の要求が許可されました。\nContact Tel is required."); document.formmemadd.t_let.focus(); return false; }
			else if (document.formmemadd.t_confirm.value!=document.formmemadd.h_random.value) { alert ("認証コードが正しくありません。\nConfirmation code does not match."); document.formmemadd.t_confirm.focus(); return false; }
			break;
		
		case 'f_memedit' :
			if (document.formmemedit.t_emanresu.value=="") { alert("ユーザー名の要求が許可されました。\nUsername is required."); document.formmemedit.t_emanresu.focus(); return false; }
			else if (document.formmemedit.t_emanhtap.value=="") { alert ("希望WEBアドレスの要求が許可されました。\nMember Path Name is required."); document.formmemedit.t_emanhtap.focus(); return false; }
			else if (document.formmemedit.t_confirm.value!=document.formmemedit.h_random.value) { alert ("認証コードが正しくありません。\nConfirmation code does not match."); document.formmemedit.t_confirm.focus(); return false; }
			break;
			
		case 'f_cttadd' :
			
			var validRegExp = /^\w(\.?[\w-])*@\w(\.?[\w-])*\.[a-z]{2,6}$/i;
			var strEmail = document.formcttadd.t_mail.value;
			
			if (document.formcttadd.t_company.value=="") { alert ("会社名の要求が許可されました。\nCompany Name is required."); document.formcttadd.t_company.focus(); return false; }
			else if (document.formcttadd.t_contact.value=="") { alert ("担当者の要求が許可されました。\nContact Name is required."); document.formcttadd.t_contact.focus(); return false; }
			else if (document.formcttadd.t_tel.value=="") { alert ("TEL の要求が許可されました。\nTel is required."); document.formcttadd.t_tel.focus(); return false; }
			else if (document.formcttadd.t_mail.value=="") { alert ("E-mail の要求が許可されました。\nE-mail is required."); document.formcttadd.t_mail.focus(); return false; }
			else if (strEmail.search(validRegExp) == -1) { alert ("有効な E-mail を入力してください。\nPlease enter a valid E-mail."); document.formcttadd.t_mail.focus(); return false; }
			else if (document.formcttadd.t_subject.value=="") { alert ("質問事項の要求が許可されました。\nSubject is required."); document.formcttadd.t_subject.focus(); return false; }
			else if (document.formcttadd.t_detail.value=="") { alert ("ご相談内容の要求が許可されました。\nDetail is required."); document.formcttadd.t_detail.focus(); return false; }
			else if (document.formcttadd.t_confirm.value!=document.formcttadd.h_random.value) { alert ("認証コードが正しくありません。\nConfirmation code does not match."); document.formcttadd.t_confirm.focus(); return false; }
			break;
			
		case 'f_qf1add' :
			
			var validRegExp = /^\w(\.?[\w-])*@\w(\.?[\w-])*\.[a-z]{2,6}$/i;
			var strEmail = document.formqf1add.t_liam.value;
			var qcheck = "";
			
			if(document.formqf1add.q4_1.checked==true) {qcheck = "t";}
			if(document.formqf1add.q4_2.checked==true) {qcheck = "t";}
			if(document.formqf1add.q4_3.checked==true) {qcheck = "t";}
			if(document.formqf1add.q4_4.checked==true) {qcheck = "t";}
			if(document.formqf1add.q4_5.checked==true) {qcheck = "t";}
			if(document.formqf1add.q4_6.checked==true) {qcheck = "t";}
			if(document.formqf1add.q4_7.checked==true) {qcheck = "t";}
			if(document.formqf1add.q4_8.checked==true) {qcheck = "t";}
			
			if (document.formqf1add.t_diresu.value=="") { alert ("ユーザーIDの要求が許可されました。\nUsername is required."); document.formqf1add.t_diresu.focus(); return false; }
			else if (document.formqf1add.t_emanmoc.value=="") { alert ("会社名の要求が許可されました。\nCompany Name is required."); document.formqf1add.t_emanmoc.focus(); return false; }
			else if (document.formqf1add.t_tcatnoc.value=="") { alert ("担当者名の要求が許可されました。\nContact Name is required."); document.formqf1add.t_tcatnoc.focus(); return false; }
			else if (document.formqf1add.t_liam.value=="") { alert ("E-mail の要求が許可されました。\nE-mail is required."); document.formqf1add.t_liam.focus(); return false; }
			else if (strEmail.search(validRegExp) == -1) { alert ("有効な E-mail を入力してください。\nPlease enter a valid E-mail."); document.formqf1add.t_liam.focus(); return false; }
			else if (document.formqf1add.t_elibom.value=="") { alert ("携帯電話番号の要求が許可されました。\nMobile is required."); document.formqf1add.t_elibom.focus(); return false; }
			else if (document.formqf1add.t_let.value=="") { alert ("TEL の要求が許可されました。\nTel is required."); document.formqf1add.t_let.focus(); return false; }
			else if (qcheck=="") { alert ("Q4 の要求が許可されました。\nQ4 is required."); document.formqf1add.q4_1.focus(); return false; }
			else if (document.formqf1add.t_confirm.value!=document.formqf1add.h_random.value) { alert ("認証コードが正しくありません。\nConfirmation code does not match."); document.formqf1add.t_confirm.focus(); return false; }
			break;
			
	}
	
}

function edittext(mess,check) {
	var check0;
	var allmessage;
	var tag = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[font color=#000000]','[/font]','[font color=#FF0000]','[/font]','[font color=#0000FF]','[/font]','[font color=#009900]','[/font]',
	'[font color=#CC9900]','[/font]','[font color=#FF9900]','[/font]','[font color=#FF00FF]','[/font]','[font color=#990099]','[/font]','[left]','[/left]','[center]','[/center]','[right]','[/right]',
	'[img]','[/img]','[youtube]','[/youtube]');	
	
	theselection = document.selection.createRange().text; 

	if(theselection.length >0){
		document.selection.createRange().text = tag[check] + theselection + tag[check+1];
		//document.newform.message.focus();
		return;
	}
}

function checkfield(value) {
	var invalids = new Array('!','@','#','$','%','^','&','*','~','<','>','/','?',';',':','|','+','-',',','=','_','[',']','{','}','\'','\"'); 
	for(i=0; i<invalids.length; i++) {
		if(value.indexOf(invalids[i]) >= 0 ) { alert ("Special Character founded."); return false; }
	}
}

function Prev() {history.back()}

function Next() {history.forward()}

function emailcheck (emailStr) {
	var checkTLD=1;
	var knownDomsPat=/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;
	var emailPat=/^(.+)@(.+)$/;
	var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
	var validChars="\[^\\s" + specialChars + "\]";
	var quotedUser="(\"[^\"]*\")";
	var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
	var atom=validChars + '+';
	var word="(" + atom + "|" + quotedUser + ")";
	var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
	var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");
	var matchArray=emailStr.match(emailPat);
	
	if (matchArray==null) {
		//alert("Email address seems incorrect (check @ and .'s)");
		return false;
	}
	
	var user=matchArray[1];
	var domain=matchArray[2];
	for (i=0; i<user.length; i++) {
	
		if (user.charCodeAt(i)>127) {
			//alert("Ths username contains invalid characters.");
			return false;
		}
	
	}
	
	for (i=0; i<domain.length; i++) {
		if (domain.charCodeAt(i)>127) {
			//alert("Ths domain name contains invalid characters.");
			return false;
		}
	}
	
	if (user.match(userPat)==null) {
		//alert("The username doesn't seem to be valid.");
		return false;
	}
	
	var IPArray=domain.match(ipDomainPat);
	if (IPArray!=null) {
		for (var i=1;i<=4;i++) {
			if (IPArray[i]>255) {
				//alert("Destination IP address is invalid!");
				return false;
			}
		}
	return true;
	}
	var atomPat=new RegExp("^" + atom + "$");
	var domArr=domain.split(".");
	var len=domArr.length;
	for (i=0;i<len;i++) {
		if (domArr[i].search(atomPat)==-1) {
			//alert("The domain name does not seem to be valid.");
			return false;
		}
	}
	if (checkTLD && domArr[domArr.length-1].length!=2 && domArr[domArr.length-1].search(knownDomsPat)==-1) {
		//alert("The address must end in a well-known domain or two letter " + "country.");
		return false;
	}
	if (len<2) {
		//alert("This address is missing a hostname!");
		return false;
	}
	return true;
}
//

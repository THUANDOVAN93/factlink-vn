<?php
// ----- page function -----

function pagecal($v_limit, $v_start, $v_sql, $v_link, $v_para) {

		$reccnt = 0;
		$recstart = 0;
		$limit = $v_limit;
		$start = $v_start;

		if ($v_para == '') { $para = "?"; } else { $para = "&"; } // $v_para must be first condition like "?variable=value"

		$sql = $v_sql;
		$result = mysql_query($sql);
		 while ($dbarr = mysql_fetch_array($result)) { $reccnt = $reccnt+1; }

		$pagecnt = $reccnt / $limit;
		$decimal = $reccnt % $limit;
		 if ($decimal > '0') { $pagecnt = (integer)$pagecnt + 1; }

		 for ($cnt=1;$cnt<=$pagecnt;$cnt++) {
			$pagemark = ($start / $limit) + 1;
			if ($pagemark == $cnt) { $bold1 = "<strong class=\"active-page\">"; $bold2 = "</strong>"; } else { $bold1 = ""; $bold2 = ""; }
			$page = $page." "." <a href=".$v_link.$v_para.$para."start=".$recstart.">".$bold1.$cnt.$bold2."</a>";
			$recstart  = $recstart + $limit;
		}

		return $page;

}

// ----- calendar function -----

function wdaychange($w) {

	if ($w == 0) {$wday = "Sun";}
	elseif ($w == 1) {$wday = "Mon";}
	elseif ($w == 2) {$wday = "Tue";}
	elseif ($w == 3) {$wday = "Wed";}
	elseif ($w == 4) {$wday = "Thu";}
	elseif ($w == 5) {$wday = "Fri";}
	elseif ($w == 6) {$wday = "Sat";}

	return $wday;

}

function mcvsubtonum($id) {

	if ($id == "Jan") {$name = 1;}
	elseif ($id == "Feb") {$name = 2;}
	elseif ($id == "Mar") {$name = 3;}
	elseif ($id == "Apr") {$name = 4;}
	elseif ($id == "May") {$name = 5;}
	elseif ($id == "Jun") {$name = 6;}
	elseif ($id == "Jul") {$name = 7;}
	elseif ($id == "Aug") {$name = 8;}
	elseif ($id == "Sep") {$name = 9;}
	elseif ($id == "Oct") {$name = 10;}
	elseif ($id == "Nov") {$name = 11;}
	elseif ($id == "Dec") {$name = 12;}

	return $name;

}

function mcvnumtosub ($id) {

	if ($id == 1) {$name = "Jan";}
	elseif ($id == 2) {$name = "Feb";}
	elseif ($id == 3) {$name = "Mar";}
	elseif ($id == 4) {$name = "Apr";}
	elseif ($id == 5) {$name = "May";}
	elseif ($id == 6) {$name = "Jun";}
	elseif ($id == 7) {$name = "Jul";}
	elseif ($id == 8) {$name = "Aug";}
	elseif ($id == 9) {$name = "Sep";}
	elseif ($id == 10) {$name = "Oct";}
	elseif ($id == 11) {$name = "Nov";}
	elseif ($id == 12) {$name = "Dec";}

	return $name;

}

function mcvnumtofull($id) {

	if ($id == 1) {$name = "January";}
	elseif ($id == 2) {$name = "February";}
	elseif ($id == 3) {$name = "March";}
	elseif ($id == 4) {$name = "April";}
	elseif ($id == 5) {$name = "May";}
	elseif ($id == 6) {$name = "June";}
	elseif ($id == 7) {$name = "July";}
	elseif ($id == 8) {$name = "August";}
	elseif ($id == 9) {$name = "September";}
	elseif ($id == 10) {$name = "October";}
	elseif ($id == 11) {$name = "November";}
	elseif ($id == 12) {$name = "December";}

	return $name;

}

function mcvzerotosub($id) {

	if ($id == '01') {$name = "Jan";}
	elseif ($id == '02') {$name = "Feb";}
	elseif ($id == '03') {$name = "Mar";}
	elseif ($id == '04') {$name = "Apr";}
	elseif ($id == '05') {$name = "May";}
	elseif ($id == '06') {$name = "Jun";}
	elseif ($id == '07') {$name = "Jul";}
	elseif ($id == '08') {$name = "Aug";}
	elseif ($id == '09') {$name = "Sep";}
	elseif ($id == '10') {$name = "Oct";}
	elseif ($id == '11') {$name = "Nov";}
	elseif ($id == '12') {$name = "Dec";}

	return $name;

}

function mcvsubtofull($m) {

	if ($m == "Jan") { $m = "January"; }
	elseif ($m == "Feb") { $m = "February"; }
	elseif ($m == "Mar") { $m = "March"; }
	elseif ($m == "Apr") { $m = "April"; }
	elseif ($m == "May") { $m = "May"; }
	elseif ($m == "Jun") { $m = "June"; }
	elseif ($m == "Jul") { $m = "July"; }
	elseif ($m == "Aug") { $m = "August"; }
	elseif ($m == "Sep") { $m = "September"; }
	elseif ($m == "Oct") { $m = "October"; }
	elseif ($m == "Nov") { $m = "November"; }
	elseif ($m == "Dec") { $m = "December"; }

	return $m;

}

function mcvsubtoth($m) {

	if ($m == "Jan") { $m = "มกราคม"; }
	elseif ($m == "Feb") { $m = "กุมภาพันธ์"; }
	elseif ($m == "Mar") { $m = "มีนาคม"; }
	elseif ($m == "Apr") { $m = "เมษายน"; }
	elseif ($m == "May") { $m = "พฤษภาคม"; }
	elseif ($m == "Jun") { $m = "มิถุนายน"; }
	elseif ($m == "Jul") { $m = "กรกฎาคม"; }
	elseif ($m == "Aug") { $m = "สิงหาคม"; }
	elseif ($m == "Sep") { $m = "กันยายน"; }
	elseif ($m == "Oct") { $m = "ตุลาคม"; }
	elseif ($m == "Nov") { $m = "พฤศจิกายน"; }
	elseif ($m == "Dec") { $m = "ธันวาคม"; }

	return $m;

}

function monthcal($m, $y) {

	$my = $y;
	$mn = $m;

		$set1 = array("1", "3", "5", "7", "8", "10", "12");
		for ($i=0;$i<=6;$i++) {
			if ($mn == $set1[$i]) { $mn = $mn."-31"; }
		}

		$set2 = array("4", "6", "9", "11");
		for ($i=0;$i<=3;$i++) {
			if ($mn == $set2[$i]) { $mn = $mn."-30"; }
		}

		$febvalue = $y % 4;
		if ($mn == 2 && $febvalue != 0) { $mn = $mn."-28"; }
		elseif ($mn == 2 && $febvalue == 0) { $mn = $mn."-29"; }

	$mn = $my."-".$mn;

	return $mn;

}

function expcal($d, $m, $y, $w, $len) {

	// this function used for the next ($len) day, except the start day. if need to include the start day, must -1 to ($len)
	// this function designed for turn-off ads status when ($atdate) = end date in db

	$thismonth = monthcal($m, $y);
	$mnowarr = explode("-", $thismonth);

	$mynow = $mnowarr[0];
	$mnow = $mnowarr[1];
	$mdnow = $mnowarr[2];

	$usenow = $mdnow - $d;
	if ($usenow <= $len) {

		$remain = $len - $usenow; //echo $remain."<br>";

		if ($remain != 0) {

			$yn = $y;
			$mn = $m;

			if ($remain == 1) { $case1 = 1; } else { $case1 = 0; } // case for remain=1 [bug of function]

			for ($i=$remain+$case1;$i!=1;$i++) {

				$mn = $mn + 1; if ($mn == 13) { $mn = 1; $yn = $yn + 1; }

				$nextmonth = monthcal($mn, $yn);
				$mnextarr = explode("-", $nextmonth);

				$mynext = $mnextarr[0];
				$mnext = $mnextarr[1];
				$mdnext = $mnextarr[2];

				if ($mdnext < $remain) { $remain = $remain - $mdnext; $i = $remain; }
				elseif ($mdnext >= $remain) { $i = 0; }

			}

		} else { $mynext = $y; $mnext = $m; $remain = $mdnow; }

	} else { $mynext = $y; $mnext = $m; $remain = $d + $len; }

	$end = $remain." ".$mnext." ".$mynext;

	return $end;

}

// ----- digit function -----

function deccal($value) {
	$pos = strpos($value, ".", 1);
	if ($pos != '') {
	$conv = explode(".", $value);
	$dec1 = substr($conv[1], 0, 1);
	$dec2 = substr($conv[1], 1, 1);
	$dec3 = substr($conv[1], 2, 1);
	if ($dec3 >= 5) { $dec2 = $dec2 + 1; }

		$value = $conv[0].".".$dec1.$dec2;
	}

	return $value;

}

function cutcomma($value) {

	$a = explode(".", $value);
	$value = $a[0];
	$b = explode(",", $value);
	$cnt = count($b);
	$newvalue = "";

	for ($i=0;$i<$cnt;$i++) { $newvalue = $newvalue.$b[$i]; }

	if ($a[1] != '0' || $a[1] != '00') { $newvalue = $newvalue.".".$a[1]; }

	return $newvalue;
}

function addcomma($value) {

	$cutvalue = explode(".", $value);
	$dotvalue = strlen($cutvalue[1]);
	if ($dotvalue == 1) { $cutvalue[1] = $cutvalue[1]."0"; }

	$cnt =strlen($cutvalue[0]);
	$vrev = strrev($cutvalue[0]);
	$newvalue = "";

	for ($i=0;$i<$cnt;$i++) {

		$section = substr($vrev, $i, 3);
		$newvalue = $newvalue.$section.",";
		$i = $i + 2;

	}

	$newvalue = strrev($newvalue);
	$newvalue = ltrim($newvalue, ",");


	if ($cutvalue[1] != '') { $newvalue = $newvalue.".".$cutvalue[1]; } else { $newvalue = $newvalue.".00"; }

	return $newvalue;
}

// ----- form function -----

function selectcheck($old, $value) {
	if ($old == $value) { $select = "selected"; }
	else { $select = ""; }
	return $select;
}

function selectday($day) {
	for ($i=1;$i<=31;$i++) {
		$sdayvalue = addzero2($i);
		$sdayname = addzero2($i);

		if ($day == $sdayvalue) { $sdayselected = "selected"; }
		else { $sdayselected = ""; }

		$sday = $sday."<option value=\"".$sdayvalue."\"".$sdayselected.">".$sdayname."</option>";
	}
	return $sday;
}

function selectmonth($month) {
	for ($i=1;$i<=12;$i++) {
		$smonthvalue = mcvnumtosub($i);
		$smonthname = mcvnumtofull($i);

		if ($month == $smonthvalue) { $smonthselected = "selected"; }
		else { $smonthselected = ""; }

		$smonth = $smonth."<option value=\"".$smonthvalue."\"".$smonthselected.">".$smonthname."</option>";
	}
	return $smonth;
}

// ----- table function -----

function twistcolor($cnt) {
	$value = $cnt % 2;
	if ($value != 0) { $twist = "#FFFFFF"; } else { $twist = "#EEEEEE"; }
	return $twist;
}

// ----- text format function -----

function addzero5($id) {
	if ($id < 10) {$zero = "0000";}
	elseif ($id < 100) {$zero = "000";}
	elseif ($id < 1000) {$zero = "00";}
	elseif ($id < 10000) {$zero = "0";}
	$id = $zero.$id;
	return $id;
}

function addzero3($id) {
	if ($id < 10) {$zero = "00";}
	elseif ($id < 100) {$zero = "0";}
	$id = $zero.$id;
	return $id;
}

function addzero2($id) {
	if (strlen($id) < 2) {$zero = "0";}
	else {$zero = "";}
	$id = $zero.$id;
	return $id;
}

function imagetype($type) {
	if ($type == 'application/x-shockwave-flash') { $type = "swf"; }
	else if ($type == 'image/pjpeg') { $type = "jpg"; }
	else if ($type == 'image/jpeg') { $type = "jpg"; }
	else if ($type == 'image/gif') { $type = "gif"; }
	else { $type = "jpg"; }
	return $type;
}
function imagetype2($type) {

	$img=explode(".",$type);

	return $img[1];
}

function html($str) {
	if ($str != "") {

		// $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');//htmlspecialchars($str);
		// $str = strip_tags($str);
		//$str = nl2br($str);

		/*  */
		if(version_compare(PHP_VERSION,'5.3','>')) {
			// $str = @eregi_replace(chr(13)," <br>\r\n", $str );
			// $str = @eregi_replace("(^|[>[:space:]\n])([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])([<\n[:space:]]|$)"," <a href=\"\\2://\\3\\4\" target=\"_blank\"><u>\\2://\\3\\4</u></a> ", $str );
		} else {
			// $str = eregi_replace(chr(13)," <br>\r\n", $str );
			// $str = eregi_replace("(^|[>[:space:]\n])([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])([<\n[:space:]]|$)"," <a href=\"\\2://\\3\\4\" target=\"_blank\"><u>\\2://\\3\\4</u></a> ", $str );
		}

		$str = str_replace ( "[a]", "<a href=\"", $str ) ;
		$str = str_replace ( "[/a]", "</a>", $str ) ;
		$str = str_replace ( "[center]", "<div align=\"center\">", $str ) ;
		$str = str_replace ( "[/center]", "</div>", $str ) ;
		$str = str_replace ( "[right]", "<div align=\"right\">", $str ) ;
		$str = str_replace ( "[/right]", "</div>", $str ) ;
		$str = str_replace ( "[br]", "<br>\r\n", $str ) ;
		$str = str_replace ( "[b]", "<b>", $str ) ;
		$str = str_replace ( "[/b]", "</b>", $str ) ;
		$str = str_replace ( "[i]", "<i>", $str ) ;
		$str = str_replace ( "[/i]", "</i>", $str ) ;
		$str = str_replace ( "[u]", "<u>", $str ) ;
		$str = str_replace ( "[/u]", "</u>", $str ) ;
		$str = str_replace ( "[img]", "<img src=\"", $str ) ;
		$str = str_replace ( "[/img]", "\" border=\"0\">", $str ) ;
		$str = str_replace ( "[alt]", "\" alt=\"", $str ) ;
		$str = str_replace ( "[float l]", "\" class=\"colimg-defleft", $str ) ;
		$str = str_replace ( "[float r]", "\" class=\"colimg-defright", $str ) ;
		$str = str_replace ( "[notarget]", "\">", $str ) ;
		$str = str_replace ( "[blank]", "\" target=\"_blank\">", $str ) ;
		$str = str_replace ( "[anchor]", "<a id=\"", $str ) ;
		$str = str_replace ( "[/anchor]", "\"></a>", $str ) ;
		$str = str_replace ( "[h1]", "<h1 class=\"h1_title\">", $str ) ;
		$str = str_replace ( "[/h1]", "</h1>", $str ) ;
		$str = str_replace ( "[h2]", "<h2 class=\"h2_title\">", $str ) ;
		$str = str_replace ( "[/h2]", "</h2>", $str ) ;
		$str = str_replace ( "[h3]", "<h3 class=\"h3_title\">", $str ) ;
		$str = str_replace ( "[/h3]", "</h3>", $str ) ;
		$str = str_replace ( "[font +1]", "<font size=\"+1\">", $str ) ;
		$str = str_replace ( "[font +2]", "<font size=\"+2\">", $str ) ;
		$str = str_replace ( "[font +3]", "<font size=\"+3\">", $str ) ;
		$str = str_replace ( "[font +4]", "<font size=\"+4\">", $str ) ;
		$str = str_replace ( "[font black]", "<font color=\"#000000\">", $str ) ; //black
		$str = str_replace ( "[font grey]", "<font color=\"#999999\">", $str ) ; //grey
		$str = str_replace ( "[font red]", "<font color=\"#FF0000\">", $str ) ; //red
		$str = str_replace ( "[font blue]", "<font color=\"#0000FF\">", $str ) ; //blue
		$str = str_replace ( "[font darkgreen]", "<font color=\"#009900\">", $str ) ; //darkgreen
		$str = str_replace ( "[font darkyellow]", "<font color=\"#CC9900\">", $str ) ; //darkyellow
		$str = str_replace ( "[font orange]", "<font color=\"#FF9900\">", $str ) ; //orange
		$str = str_replace ( "[font pink]", "<font color=\"#FF00FF\">", $str ) ; //pink
		$str = str_replace ( "[font violet]", "<font color=\"#990099\">", $str ) ; //violet
		$str = str_replace ( "[/font]", "</font>", $str ) ;
		

		return $str;
	}
	else return " ";
}

function convertURL2HTML($string) {
	
	/* OLD VERSION */
	// $regex = '/(http[s]{0,1}\:\/\/\S{4,})\s{0,}/ims';
	// $write = '<a href="$1" target="_blank">$1</a>';
	// $string = preg_replace($regex, $write, $string);
	// return $string;
	
	$search = '$(\s|^)(https?://[a-z0-9_./?=&-]+)(?![^<>]*>)$ims';
	$modify = ' <a href="$2" target="_blank">$2</a>';
	$string = preg_replace($search, $modify, $string);
	return $string;
	
	
	
	
}

function subhtml($str) {
	if ($str != "") {
		
		// $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
		// $str = htmlspecialchars($str);
		// $str = strip_tags($str);
		
		// $str = eregi_replace(chr(13)," <br> ", $str );
		// $str = eregi_replace("(^|[>[:space:]\n])([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])([<\n[:space:]]|$)"," <a href=\"\\2://\\3\\4\" target=\"_blank\"><u>\\2://\\3\\4</u></a> ", $str );
		// $str = str_replace ( "[br]", "\r\n<br />", $str ) ;
		
		$str = str_replace ( "[b]", "<b>", $str ) ;
		$str = str_replace ( "[/b]", "</b>", $str ) ;
		$str = str_replace ( "[i]", "<i>", $str ) ;
		$str = str_replace ( "[/i]", "</i>", $str ) ;
		$str = str_replace ( "[u]", "<u>", $str ) ;
		$str = str_replace ( "[/u]", "</u>", $str ) ;
		$str = str_replace ( "[a]", "<a href=\"", $str ) ;
		$str = str_replace ( "[/a]", "</a>", $str ) ;
		$str = str_replace ( "[notarget]", "\">", $str ) ;
		$str = str_replace ( "[br]", "<br>\r\n", $str ) ;
		$str = str_replace ( "[blank]", "\" target=\"_blank\">", $str ) ;
		
		
		$str = convertURL2HTML($str);
		
		
		
		return $str;
	}
	else return " ";
}

function charscheck($text) {

	$chars = str_split("abcdefghijklmnopqrstuvwxyz1234567890-_"); // for PHP5 only
	$charscnt = count($chars);
	$text = str_split($text); // for PHP5 only
	$textcnt = count($text);
	$textcheckcnt = 0;

	for ($i=0; $i<$textcnt; $i++) {
		for ($a=0; $a<$charscnt; $a++) {
			if ($text[$i] == $chars[$a]) { $textcheckcnt = $textcheckcnt + 1; }
		}
	}

	if ($textcheckcnt == $textcnt) {
		$textcheck = "t";
	} else {
		$textcheck = "f";
	}

	return $textcheck;

}

function sortnumcheck($text) {

	$text = ltrim($text, "0");

	$chars = str_split("1234567890"); // for PHP5 only
	$charscnt = count($chars);
	$text = str_split($text); // for PHP5 only
	$textcnt = count($text);
	$textcheckcnt = 0;

	for ($i=0; $i<$textcnt; $i++) {
		for ($a=0; $a<$charscnt; $a++) {
			if ($text[$i] == $chars[$a]) { $textcheckcnt = $textcheckcnt + 1; }
		}
	}

	if ($textcheckcnt == $textcnt) { $textcheck = "t"; } else { $textcheck = "f"; }
	return $textcheck;
}

// ----- other function -----

function random($no) {
	$num = array();
	$num[0] = "";

	for ($i=1;$i<=4;$i++) {
		$random = rand(0, 9);
		$num[0] = $num[0].$random;
		$num[$i] = "<img src=\"images/num_".$random.".jpg\" width=\"20\" height=\"20\" /> ";
	}

	return $num;
}


function randompass($no) {
	$length = 8;
	$chars = "abcdefghijklmnopqrstuvwxyz1234567890";

    $chars_length = (strlen($chars) - 1);
    $randpass = $chars{ rand(0, $chars_length) };
    for ($i = 1; $i < $length; $i = strlen($randpass)) {
        $r = $chars{rand(0, $chars_length)};
        if ($r != $randpass{$i - 1}) $randpass .=  $r;
    }

    return $randpass;
}

function checkfreemem($memid) {
	$sqlmempackage = "select * from flc_member where mem_id = '$memid';";
	$resultmempackage = mysql_query($sqlmempackage);
	while ($dbarrmempackage = mysql_fetch_array($resultmempackage)) { $mempackage = $dbarrmempackage['mem_package']; }

    return $mempackage;
}


function randomcaptcha2() {
	$num = "";

	for ($i=1;$i<=4;$i++) {
		$random = rand(0, 9);
		$num = $num.$random;
	}

	return $num;
}

function randompass2() {
	$length = 8;
	$chars = "abcdefghijklmnopqrstuvwxyz1234567890";

    $chars_length = (strlen($chars) - 1);
    $randpass = $chars{ rand(0, $chars_length) };
    for ($i = 1; $i < $length; $i = strlen($randpass)) {
        $r = $chars{rand(0, $chars_length)};
        if ($r != $randpass{$i - 1}) $randpass .=  $r;
    }

    return $randpass;
}

function lclangswitch($lang, $langlocal) {

	if ($lang == 'lc') { $lang = $langlocal; }
	return $lang;

}
//Password encryption function.==========================================================
function random2() {
	$length = 12;
	$chars = "1234567890";

    $chars_length = (strlen($chars) - 1);
    $randpass = $chars{ rand(0, $chars_length) };
    for ($i = 1; $i < $length; $i = strlen($randpass)) {
        $r = $chars{rand(0, $chars_length)};
        if ($r != $randpass{$i - 1}) $randpass .=  $r;
    }

    return $randpass;
}

function strendcode($user,$pass){
 $str_len=strlen($user);
 $total_str =  (int ) ($str_len  /  2 );
 $arr_str = str_split($user, $total_str);
 $count_arr=count($arr_str);
 for($i=0;$i<=$count_arr;$i++){
 	$end_pass=base64_encode($pass);
	 }
 		return $end_pass;
}
function strdecode($str,$pass){

 $str_len=strlen($pass);
 $total_str =  (int ) ($str_len  /  2 );
 $arr_str = str_split($pass, $total_str);
 $count_arr=count($arr_str);
 for($i=0;$i<=$count_arr;$i++){
 	$end_str=base64_decode($str);
	 }
 		return $end_str;
}
//END Password encryption function.==================================================

//Validate ReCaptcha function.==========================================================
function validateReCaptcha($secretKey, $captchaResponse, $ipClient)
{
	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captchaResponse."&remoteip=".$ipClient);
	$responseKeys = json_decode($response, true);
	if (intval($responseKeys["success"]) !== 1) {
		return false;
	}
	return true;
}
//Validate ReCaptcha function.==========================================================

//Get Name Page function.==========================================================
function getNamePage($memId, $pageId, $lang)
{
	$sqlGetName = "select pag_name_en, pag_name_jp, pag_name_vn from flc_page where mem_id = '$memId' and pag_id = '$pageId';";
	$rsGetName = mysql_query($sqlGetName);
	while ($nameItem = mysql_fetch_array($rsGetName)) {
		if($lang == 'en') {
			$pageName = $nameItem['pag_name_en'];
		} elseif($lang == 'vn') {
			$pageName = $nameItem['pag_name_vn'];
		} else {
			$pageName = $nameItem['pag_name_jp'];
		}
	}
	return $pageName;
}
//Get Name Page function.==========================================================

//Detect File Extension function.==========================================================
function getFileExtend($file, $allowed = array())
{
	$extFile = pathinfo($file['name'], PATHINFO_EXTENSION);

	if (empty($allowed)) {
		return $extFile;
	}
	
	if (!in_array($extFile, $allowed)) {
		return false;
	}

	return $extFile;
}

//Detect File Extension function.==========================================================

//Render National Templatte function.==========================================================

function getNationalTemplate($lang) {

	switch ($lang) {

		case 'jp':
			$bgColor = "#FFFFFF";
			$nationalName = "Japan";
			$nationalShortcut = "jp";
			break;

		case 'vn':
			$bgColor = "#CC0000";
			$nationalName = "Vietnam";
			$nationalShortcut = "vn";
			break;

		case 'kr':
			$bgColor = "#FFFFFF";
			$nationalName = "Korean";
			$nationalShortcut = "kr";
			break;

		case 'tw':
			$bgColor = "#fe0000";
			$nationalName = "Taiwan";
			$nationalShortcut = "tw";
			break;

		case 'hk':
			$bgColor = "#de2910";
			$nationalName = "Hongkong";
			$nationalShortcut = "hk";
			break;

		case 'sg':
			$bgColor = "#e11014";
			$nationalName = "Singapore";
			$nationalShortcut = "sg";
			break;

		case 'cn':
			$bgColor = "#de2910";
			$nationalName = "China";
			$nationalShortcut = "cn";
			break;

		default:
			$bgColor = "#004F94";
			$nationalName = "Other Nation";
			$nationalShortcut = "oo";
			break;
	}

	$elementNationalHtml = "<td width=\"22\" bordercolor=\"#999999\" bgcolor=\"".$bgColor."\" style=\"border-style:solid; border-width:1px;\"><img src=\"images/bg_nation_".$nationalShortcut.".jpg\" title=\"".$nationalName."\" /></td>";

	return $elementNationalHtml;
}

//Render National Templatte function.==========================================================


?>

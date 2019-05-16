<?php
if (strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot')){ $bot='Google';}
else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Yandex')){$bot='Yandex';}
else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Mediapartners-Google')){$bot='Mediapartners-Google (Adsense)';}
else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Slurp')){$bot='Hot Bot search';}
else if (strstr($_SERVER['HTTP_USER_AGENT'], 'WebCrawler')){$bot='WebCrawler search';}
else if (strstr($_SERVER['HTTP_USER_AGENT'], 'ZyBorg')){$bot='Wisenut search';}
else if (strstr($_SERVER['HTTP_USER_AGENT'], 'scooter')){$bot='AltaVista';}  
else if (strstr($_SERVER['HTTP_USER_AGENT'], 'StackRambler')){$bot='Rambler';}  
else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Aport')){$bot='Aport';}  
else if (strstr($_SERVER['HTTP_USER_AGENT'], 'lycos')){$bot='Lycos';}  
else if (strstr($_SERVER['HTTP_USER_AGENT'], 'WebAlta')){$bot='WebAlta';}
else if (strstr($_SERVER['HTTP_USER_AGENT'], 'yahoo')){$bot='Yahoo';}
else if (strstr($_SERVER['HTTP_USER_AGENT'], 'msnbot')){$bot='msnbot/1.0';}
else if (strstr($_SERVER['HTTP_USER_AGENT'], 'ia_archiver')){$bot='Alexa search engine';}
else if (strstr($_SERVER['HTTP_USER_AGENT'], 'FAST')){$bot='AllTheWeb';}
 
if($bot !=""){
	$tdiff = 3600 * 0; // เปลี่ยนจาก 0 เป็น 7 ถ้า Server นอก (GMT) หรือเพิ่มลดได้ตามแต่ Time Zone อยู่ที่ได (GMT -12 ถึง GMT +13)
	$file = "bots.txt";
	$day = date("d/m/Y",time() + $tdiff);
	$time = date("H:i:s",time() + $tdiff);
	$ip = $_SERVER['REMOTE_ADDR'];
	$fh = fopen($file, "w");
	fwrite($fh, "$day|$time|$bot|$ip");
	fclose($fh);
}


$month[1] =  defined('_F_Month_1')?_F_Month_1:'_F_Month_1';
$month[2] =  defined('_F_Month_2')?_F_Month_2:'_F_Month_2';
$month[3] =  defined('_F_Month_3')?_F_Month_3:'_F_Month_3';
$month[4] =  defined('_F_Month_4')?_F_Month_4:'_F_Month_4';
$month[5] =  defined('_F_Month_5')?_F_Month_5:'_F_Month_5';
$month[6] =  defined('_F_Month_6')?_F_Month_6:'_F_Month_6';
$month[7] =  defined('_F_Month_7')?_F_Month_7:'_F_Month_7';
$month[8] =  defined('_F_Month_8')?_F_Month_8:'_F_Month_8';
$month[9] =  defined('_F_Month_9')?_F_Month_9:'_F_Month_9';
$month[10] = defined('_F_Month_10')?_F_Month_10:'_F_Month_10';
$month[11] = defined('_F_Month_11')?_F_Month_11:'_F_Month_11';
$month[12] = defined('_F_Month_12')?_F_Month_12:'_F_Month_12';

$file = "bots.txt";
if(file_exists($file)) {
	$fh = fopen($file, 'r+');
	$s = filesize($file);
	if($s == 0) {
		$out = "<strong>"._BOT_NOACCESS."</strong>";
	}else{
		$contents = fread($fh, $s);
		fclose($fh);
		
		$info = explode("|",$contents);
		$day = explode("/",$info[0]);
		$m = number_format($day[1]);
		$tm = explode(":",$info[1]);
		$agent = $info[2];
		$ip = $info[3];

		/* Fix missing Notice error missing assumed to string */
		if(!defined('_BOT_ACCESS')) {define('_BOT_ACCESS','_BOT_ACCESS');}
		if(!defined('_BOT_TODAY')) {define('_BOT_TODAY','_BOT_TODAY');}
		if(!defined('_BOT_TODAYS')) {define('_BOT_TODAYS','_BOT_TODAYS');}
		if(!defined('_BOT_TIMES')) {define('_BOT_TIMES','_BOT_TIMES');}
		if(!defined('_BOT_TIMESN')) {define('_BOT_TIMESN','_BOT_TIMESN');}
		
		
		$out = "<strong>"._BOT_ACCESS." ".$agent ." (".$ip.") ";
		
		if(date('d',time()) == $day[0]){
			$out .= _BOT_TODAY;
		}else{
			$out .=" "._BOT_TODAYS." ".$day[0]." ".$month[$m]." ". ($day[2]+543);
		}
		$out .= " "._BOT_TIMES." ". $tm[0]. ".".$tm[1]." "._BOT_TIMESN."</strong>";
		
	}
	//$out;
}
?>
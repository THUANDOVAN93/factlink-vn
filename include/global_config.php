<?php

clearstatcache();
//echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.html\" />";
$db_name = "factlink_beta";


/* Use @ to silence "Deprecated" error */
$link = @mysql_connect("localhost", "factlink_db", "01354101") or die("Error connect to database."); 

/*$db_name="factlinkvn_db";
$link = mysql_connect("localhost", "root", "12345") or die("Error connect to database."); 
*/
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8"); 

// global value
$nowdate = date("d M Y");
$nowtime = date("H").":".date("i");
$nowmonth = date("n");
$nowwday = date("w");

$getremote = gethostbyaddr($_SERVER['REMOTE_ADDR']); 
$getremote = str_replace(".","-",$getremote); 
$findip = explode("-",$getremote);
$getip = $findip[1].".".$findip[2].".".$findip[3].".".$findip[4]; 

// get ip
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $get_ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $get_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $get_ip = $_SERVER['REMOTE_ADDR'];
}
 
//

if ($_COOKIE['vlang'] == '') { $expire = time()+60*60*24*7; setcookie("vlang", "jp", $expire); }

$timelength = time() - (60*60); // 60 min.

$qtyFeaProduct = 8;

/* reCaptcha Config */
$captchaSiteKey = "6Ld0qZIUAAAAADzcBE7QzHfMUVtPp625QUpDSxP7";
$captchaSecretKey = "6Ld0qZIUAAAAAJ37AJSr1vUeceJYOeiV8TG5AaHL";
$fileExtAllowed = ["jpg", "png", "gif", "mp4"];
$langCodeAllowed = ["en", "vn", "jp"];
$nationalOptionAllowed = array(
	'jp' => 'Japan',
	'vn' => 'Vietnam',
	'kr' => 'Korea',
	'tw' => 'Taiwan',
	'hk' => 'Hongkong',
	'sg' => 'Singapore',
	'cn' => 'China',
	'oo' => 'Other Nation'
);

?>

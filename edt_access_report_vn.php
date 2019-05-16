<?php
	session_start();
	if($_SERVER['DOCUMENT_ROOT']=='C:/xampp/htdocs') {
		//$id='00000721';
	} else {
		ini_set("session.gc_maxlifetime", "18000");
		session_start();
		
		if ($_SESSION['vmd'] == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=1\">"; exit(); }
		 $id=$_SESSION['vmd']; 
		
				include("./include/global_config.php");
				include("./include/global_function.php");//or die("don't include function");
				
				mysql_query("use $db_name;")or die(mysql_error());
				
				$checkpackage = checkfreemem($id);
				if ($checkpackage == '') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = error.php?code=5\">"; exit(); }
				
	}
	
	
	if(isset($_POST["d"])) {
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=access_report.csv");
		
		echo chr(255).chr(254);
		echo mb_convert_encoding(urldecode($_POST["d"]),'UTF-16LE','UTF-8');
		exit; 
	}
	
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ja" />
	<meta name="robots" content="noindex" />
	<link rel="canonical" href="edt_access_report_vn.php" />
	
    <title><?php echo $title; ?></title>
</head>

	<body><!--<iframe src="edt_access_report_vn_3.php?id=<?//=$id;?>" width="1000" height="900" frameborder="1" ></iframe> -->
	<br>
<iframe src="http://www.fact-link.com/edt_access_report_vn_2.php?id=<?=$id;?>" width="1000" height="900" frameborder="0" ></iframe>
   
	</body>
</html>
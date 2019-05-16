<?php
session_start();

/*
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
	*/
	$id=$_GET['id'];
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
	<link rel="canonical" href="http://www.fact-link.com/edt_access_report_vn_2.php" />
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		
		google.setOnLoadCallback(
			drawChart
		);
		
		function drawChart() {
			var data = google.visualization.arrayToDataTable(
<?php 

	$ad=array(array('日付', 'ページビュー')); 
	$weeks=array('日','月','火','水','木','金','土');
	$ago=isset($_GET['m']) && preg_match('/[123]/',$_GET['m']) ? $_GET['m'] : 0;
	list($year,$month)=explode("-",date("Y-m",time()));
	if($month-$ago>0) {
		$month-=$ago;
	} else {
		$year-=1;
		$month=$month+12-$ago;
	}
	
	$f=sprintf('%04d-%02d-%02d',$year,$month,1);
	$t=sprintf('%04d-%02d-%02d',$year,$month,date("t",strtotime($year.'-'.$month)));
	$title='アクセスレポート('.$f.'から'.$t.'まで)';
	
	define('ga_email','factlink.noreply@gmail.com');
	define('ga_password','F159@Fvdt');
	define('ga_profile_id','38284324');
	require_once('./include/gapi.class.php');
	$ga = new gapi(ga_email,ga_password);//$ga = new gapi(ga_email,ga_password);
	$ga->requestReportData(ga_profile_id,array('date'),array('pageviews','visits'),
	'date', $filter='ga:pagePath=~id='.$id, $start_date=$f, $end_date=$t, $start_index=1, $max_results=100); 
	$o="日	ページビュー数\n"; 
	foreach($ga->getResults() as $v){
		$d=strtotime($v->getDate());
		$w=date("w",$d);
		$ad[]=array(date("Y/n/j (D)",$d),$v->getPageviews());
		
		$o.=date("Y年n月j日",$d).$weeks[$w].'曜日'."\t".$v->getPageViews()."\n";
		
	} 
	echo json_encode($ad);
?>
			);

			var options = {
				width: 950,
				height: 550,
				chartArea: {width: '75%', height: '80%', left: 80, top: 10}
			};

			var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		}
	</script>
    <title><?php echo $title; ?></title>
</head>

	<body>
    <div>
    	<a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?id=<?=$_SESSION["id"]?>">最新（今月）</a>
        |
    	<a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?id=$id&m=1">1ヶ月前</a>
        |
    	<a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?id=$id&m=2">2ヶ月前</a>
        |
    	<a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?id=$id&m=3">3ヶ月前</a>
    </div>
    <h3 style="margin-left:80px;"><?php echo $title; ?></h3>
    
    
	<div id="chart_div"></div>
	<form action="http://www.fact-link.com.vn/edt_access_report_vn_2.php?id=<?=$id;?>" method="POST">
		<input type="hidden" name="d" value="<?php echo urlencode($o); ?>" />
		<input type="submit" value="エクセル(CSV)でダウンロード">
	</form>
  
	</body>
</html>
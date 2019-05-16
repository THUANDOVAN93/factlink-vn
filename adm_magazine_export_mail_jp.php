<?php
    ini_set("session.gc_maxlifetime", "18000");
	set_time_limit(10000);
	session_start();
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
    include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	
	mysql_query("use $db_name;");
	$ntl=$_GET['ntl'];
	
    $sql2 = "select * from flc_member where mem_status = '' and mem_mailop_mag = '1' AND mem_national =  'jp' AND mem_contactmail<>'' ;";
	$sql3 = "select * from flc_member where mem_status = '' and mem_mailop_mag = '1' AND mem_national =  'jp' AND mem_oth_contactmail<>'' ;";  
	// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	 
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".date("Y-m-d").'-'.date("H:s:i").'_jp'.".xls");   
	
	$query = mysql_query($sql2);
   $i=0;
	while ($result = mysql_fetch_array($query)) {
	$i++; 
	$summail[]= (explode(",",$result['mem_contactmail']));
   }
   
   $query3 = mysql_query($sql3);
   $i=0;
   
	while ($result3 = mysql_fetch_array($query3)) {
	$i++; 
	
	$summail3[]= (explode(",",$result3['mem_oth_contactmail']));
	
   }

 echo"<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td>No.</td>
    <td>Mail</td>
  </tr>";
foreach ($summail as $names ) {
$n++;
if($names[0]!=''){
echo"<tr>
    <td>$n</td>
    <td>$names[0]</td>
  </tr>";
  }
}

$h=$n;
foreach ($summail3 as $names3 ) {

//if($names3!=''){
	for($i=0;$i<=count($summail3[0]);$i++){
	$h++;
if($names3[$i]!=''){
echo"<tr>
    <td>".$h."</td>
    <td>".$names3[$i]."</td>
  </tr>";
}
  
  }
  
}
echo "</table>";



?>
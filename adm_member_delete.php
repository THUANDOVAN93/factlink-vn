<?php 
	
	ini_set("session.gc_maxlifetime", "18000");
	session_start();
	
	if ($_SESSION['vp'] != 'exe') { echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_login.html\">"; exit(); }
	
	include_once("./include/class.rFastTemplate.php");
	include_once("./include/global_config.php");
	include_once("./include/global_function.php");
	 
	$memid=$_GET['id'];
	$start=$_GET['start'];
	$tpl = new rFastTemplate("template");
	
	$sql="SELECT mem_folder FROM flc_member WHERE mem_id='$memid'";
	$query=mysql_db_query($db_name,$sql);
	while($fect=mysql_fetch_array($query)){$mem_folder=$fect['mem_folder'];}
	$dir = "./home/$mem_folder";
	//$dir = "./images/antz";// test

	// Open a directory, and read its contents
	

	// Open a known directory, and proceed to read its contents
	if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
             "filename: $file ";//: filetype: "."<br>";// . filetype($dir . $file) . "\n";
			unlink("$dir/$file");
        }
        closedir($dh);
    }
	}else{ echo "Can't open dir";}
	if($file==''){
		rmdir("$dir");
	 /*  $ftphost = ftp_connect("123.30.129.231")or die("ftp_connect");
	   $ftplogin = ftp_login($ftphost, "factlink", "01354101")or die("ftp_login"); 
		
		ftp_rmdir($ftphost, "./public_html/home/$mem_folder");//or die("ftp_mkdir"); // *** NEED CHECK PATH
		//ftp_chmod($ftphost, 0777, "public_html/home/$t_emanhtap");
		
		ftp_close($ftphost);//home/factlink/public_html
*/
	}
	else{ echo "Can't delete dir";}
	$sql1="DELETE FROM flc_member WHERE mem_id = '$memid';";
	mysql_db_query($db_name,$sql1);
	
	$sql2="SELECT * FROM flc_banner WHERE mem_id='$memid'";
	$query2=mysql_db_query($db_name,$sql2);
	while($fect2=mysql_fetch_array($query2)){$fect2['mem_id'];$mem_folder=$fect2['mem_folder'];}
	if($fect2['mem_id']!=''){
	$sql="DELETE FROM flc_banner WHERE mem_id = '$memid';";
	mysql_db_query($db_name,$sql);
		}
    
	// Open a known directory, and proceed to read its contents
	$dir2 = "./images/banner";//
	if (is_dir($dir2)) {
    if ($dh2 = opendir($dir2)) {
        while (($file = readdir($dh2)) !== false) {
             "filename: $file ";//: filetype: "."<br>";// . filetype($dir . $file) . "\n";
			
			$file2=explode(".",$file);
			$file3=explode("_",$file2[0]);
			$flen=strlen($file3[0]);
			
			if($flen==8 & $file3[0]==$memid){ 
			//echo $file;echo"<br>"; 
			unlink("$dir2/$file");
			
			}
			else if($flen > 8 & $file3[0] = 'C'.$memid ){
				//$ex='C'.'00000008.'file_type 
			//echo $file; echo "<br>";
			unlink("$dir2/$file");
			}
        }
        closedir($dh2);
    }
	}else{ echo "Can't open dir";}
	
	
	$sql3="SELECT * FROM flc_banner_cate WHERE mem_id='$memid'";
	$query3=mysql_db_query($db_name,$sql3);
	while($fect3=mysql_fetch_array($query3)){$fect3['mem_id'];}
	if($fect3['mem_id']!=''){
	$sql="DELETE FROM flc_banner_cate WHERE mem_id = '$memid';";
	mysql_db_query($db_name,$sql);
		}
		
	$sql4="SELECT * FROM flc_bulletin WHERE mem_id='$memid'";
	$query4=mysql_db_query($db_name,$sql4);
	while($fect4=mysql_fetch_array($query4)){$fect4['mem_id'];}
	if($fect4['mem_id']!=''){
	$sql="DELETE FROM flc_bulletin WHERE mem_id = '$memid';";
	mysql_db_query($db_name,$sql);
		}
	
	$sql5="SELECT * FROM flc_bulletin_cate WHERE mem_id='$memid'";
	$query5=mysql_db_query($db_name,$sql5);
	while($fect5=mysql_fetch_array($query5)){$fect5['mem_id'];}
	if($fect5['mem_id']!=''){
	$sql="DELETE FROM flc_bulletin_cate WHERE mem_id = '$memid';";
	mysql_db_query($db_name,$sql);
		}
		
	$sql6="SELECT * FROM flc_content WHERE mem_id='$memid'";
	$query6=mysql_db_query($db_name,$sql6);
	while($fect6=mysql_fetch_array($query6)){$fect6['mem_id'];}
	if($fect6['mem_id']!=''){
	$sql="DELETE FROM flc_content WHERE mem_id = '$memid';";
	mysql_db_query($db_name,$sql);
		}
	
	$sql7="SELECT * FROM flc_feature WHERE mem_id='$memid'";
	$query7=mysql_db_query($db_name,$sql7);
	while($fect7=mysql_fetch_array($query7)){$fect7['mem_id'];}
	if($fect7['mem_id']!=''){
	$sql="DELETE FROM flc_feature WHERE mem_id = '$memid';";
	mysql_db_query($db_name,$sql);
		}
		
	$sql8="SELECT * FROM flc_home WHERE mem_id='$memid'";
	$query8=mysql_db_query($db_name,$sql8);
	while($fect8=mysql_fetch_array($query8)){$fect8['mem_id'];}
	if($fect8['mem_id']!=''){
	$sql="DELETE FROM flc_home WHERE mem_id = '$memid';";
	mysql_db_query($db_name,$sql);
		}
		
	$sql9="SELECT * FROM flc_introduce WHERE mem_id='$memid'";
	$query9=mysql_db_query($db_name,$sql9);
	while($fect9=mysql_fetch_array($query9)){$fect9['mem_id'];}
	if($fect9['mem_id']!=''){
	$sql="DELETE FROM flc_introduce WHERE mem_id = '$memid';";
	mysql_db_query($db_name,$sql);
		}
		
	$sql10="SELECT * FROM flc_mail WHERE mem_id='$memid'";
	$query10=mysql_db_query($db_name,$sql10);
	while($fect10=mysql_fetch_array($query10)){$fect10['mem_id'];}
	if($fect10['mem_id']!=''){
	$sql="DELETE FROM flc_mail WHERE mem_id = '$memid';";
	mysql_db_query($db_name,$sql);
		}
		
	$sql11="SELECT * FROM flc_page WHERE mem_id='$memid'";
	$query11=mysql_db_query($db_name,$sql11);
	while($fect11=mysql_fetch_array($query11)){$fect11['mem_id'];}
	if($fect11['mem_id']!=''){
	$sql="DELETE FROM flc_page WHERE mem_id = '$memid';";
	mysql_db_query($db_name,$sql);
		}
		
	$sql12="SELECT * FROM flc_present WHERE mem_id='$memid'";
	$query12=mysql_db_query($db_name,$sql12);
	while($fect12=mysql_fetch_array($query12)){$fect12['mem_id'];}
	if($fect12['mem_id']!=''){
	$sql="DELETE FROM flc_present WHERE mem_id = '$memid';";
	mysql_db_query($db_name,$sql);
		}
		
	$sql13="SELECT * FROM flc_present_box WHERE mem_id='$memid'";
	$query13=mysql_db_query($db_name,$sql13);
	while($fect13=mysql_fetch_array($query13)){$fect13['mem_id'];}
	if($fect13['mem_id']!=''){
	$sql="DELETE FROM flc_present_box WHERE mem_id = '$memid';";
	mysql_db_query($db_name,$sql);
		}
		
	$sql14="SELECT * FROM flc_uselog WHERE usl_userid='$memid'";
	$query14=mysql_db_query($db_name,$sql13);
	while($fect14=mysql_fetch_array($query14)){$fect14['mem_id'];}
	if($fect14['mem_id']!=''){
	$sql="DELETE FROM flc_uselog WHERE usl_userid = '$memid';";
	mysql_db_query($db_name,$sql);
		}	
	echo "<meta http-equiv = \"refresh\" content = \"0;URL = adm_member_del.php?start=$start\">";
		
	exit();	
?>
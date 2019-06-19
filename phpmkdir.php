<?
$ftphost = ftp_connect("123.30.129.231");
			$ftplogin = ftp_login($ftphost, "factlink", "01354101")or die("don't connect ftp");
				
			ftp_mkdir($ftphost, "public_html/home/01ex_sample")or die("don't create floder");  
			ftp_chmod($ftphost, 0777, "public_html/home/01ex_sample")or die("don't chmod"); 
				
			ftp_close($ftphost);
?>
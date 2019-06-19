<?php
   session_start();
   
   include_once("./include/global_function.php");
	$str_id=$_SESSION['ran_id'];
	$str=$_GET['str'];
	$str2= strdecode($str,$str_id);
	$font = "angsab.ttf"; //ไฟล์ font ที่จะใช้
	if(!isset($str)){
		echo"<meta http-equiv=\"refresh\" content=\"0;URL=http://www.google.com\" />";

		}else{
	$image = imagecreate(100,30);	//สร้างภาพโดยการกำหนดขนาด ยาว(แกน x), กว้าง(แกน y)
	$bg = imagecolorallocate($image,200,220,220); //กำหนดสีพื้น (ภาพ,Red,Green,Blue)
	
	$black = imagecolorallocate($image, 0, 0, 0); //กำหดนค่าสีของสีดำซึ่งจะใช้เป็นสีของตัวอักษร
	
	imagettftext($image,28,0,2,25,$black,$font,$str2);  //นำตัวอักษรจากฟอร์มมาวาดเป็นรูป
	
	header("Content-type:image/png");	//กำหนดชนิดของภาพตอนแสดงผลผ่าน browser
	imagepng($image);   //แสดงผลภาพที่สร้าง
	imagedestroy($image); //เมื่อ browser ดึงไปแสดงแล้วก็คืนค่าหน่วยคืนค่าหน่วยความจำให้กับระบบ <br>
	//***การใช้หน่วยความจำอย่างประหยัดสำคัญมากในการเขียนโปรแกรม***
		}

?>
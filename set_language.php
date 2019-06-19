<?php
	session_start(); 
	
	$lang = $_GET['lang'];
	$expire = time()+60*60*24*7;
	setcookie("vlang", $lang, $expire);
	
?>
<script language="JavaScript">history.back()</script>
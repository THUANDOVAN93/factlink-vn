<?php
	session_start(); 
	
	//var_dump($_SERVER);die();
	$lang = $_GET['lang'];
	$langOrigin = $_COOKIE['vlang'];
	$expire = time()+60*60*24*7;
	setcookie("vlang", $lang, $expire);
	setcookie("lang-origin", $langOrigin, $expire);
	//header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
<!-- <script language="JavaScript">history.back()</script> -->
<!-- <script language="JavaScript">window.location = document.referrer + '?langset=true';</script> -->

<?php
	echo '<form id="myForm" action="'.$_SERVER['HTTP_REFERER'].'" method="get"></form>';
    // foreach ($_POST as $a => $b) {
    //     echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
    // }
?>
</form>
<script type="text/javascript">
    document.getElementById('myForm').submit();
</script>
<?

//mail('admin@fact-link.com', 'test', 'detail', 'admin@fact-link.com <admin>')or die("fdfdfdf");
$chk=mail('admin@fact-link.com', 'test', 'detail', 'admin@fact-link.com <admin>');

if($chk){ echo "error";}else{echo "success";}


?>
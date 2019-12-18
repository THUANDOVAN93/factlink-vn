<?php
ini_set("session.gc_maxlifetime", "18000");
session_start();

require_once __DIR__.'/../vendor/autoload.php';
	
if ($_SESSION['vp'] != 'exe') {
	echo "<meta http-equiv = \"refresh\" content = \"0;URL = ../adm_login.html\">";
	exit();
}

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../View/templates');
//$twig = new \Twig\Environment($loader);
$twig = new \Twig\Environment($loader);


$template = $twig->load('index.html');

echo $template->render([
	'title' => 'FACT-LINK SEO MANAGEMENT',
	'action' => 'ACTION',
	'result' => 'RESULT',
	'buttonActionContent' => 'Create Sitemap',
	'buttonActionHandler' => 'GenSitemapAction.php',
	'linkGoogleConsole' => 'https://www.fact-link.com.vn/assets/sitemap.xml'
]);

?>
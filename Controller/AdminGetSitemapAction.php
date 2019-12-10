<?php
$attachment_location = $_SERVER["DOCUMENT_ROOT"] . "/assets/sitemap.xml";
if (file_exists($attachment_location)) {

    header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
    header("Cache-Control: public"); // needed for internet explorer
    header("Content-Type: application/xml");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Length:".filesize($attachment_location));
    header("Content-Disposition: attachment; filename=sitemap.xml");
    readfile($attachment_location);
    die();        
} else {
    die("Error: File not found.");
} 
?>
<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();
$routes->add('admin_seo', new Route('/seo', [
    '_controller' => 'AppBundle:Admin:index',
]));

return $routes;
?>
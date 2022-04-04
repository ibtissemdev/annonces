<?php

use Router\Router;

require '../vendor/autoload.php';

$router = new Router($_GET['url']);

$router->get ('/','BlogController@index');
$router->get ('/posts/:id','BlogControlller@show');

$router->run();




?>
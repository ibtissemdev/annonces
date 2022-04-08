<?php 

use Router\Router; 

require '../vendor/autoload.php'; 

define ('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
define ('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);
define('DB_NAME', 'projet4');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', '');


$router = new Router($_GET['url']);
$router->get('/posts', 'App\Controllers\AnnonceController@accueil');
$router->get('/', 'App\Controllers\AnnonceController@index');
$router->get('/posts/:id', 'App\Controllers\AnnonceController@show'); 
$router->get('/posts/delete/:id', 'App\Controllers\AnnonceController@sup'); 
$router->get('/posts', 'App\Controllers\AnnonceController@form'); 


$router->run();

?>
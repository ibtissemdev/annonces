<?php 

use Router\Router; 

require '../vendor/autoload.php'; //Chargement automatique des class
require_once 'config.php'; //paramètres de connexion à la BDD

$router = new Router($_GET['url']);

        //      $path        namespace              $action
$router->get('/', 'App\Controllers\AnnonceController@index');
$router->post('/', 'App\Controllers\AnnonceController@search');
$router->get('/annonces/:id', 'App\Controllers\AnnonceController@show'); 

$router->get('/annonces/delete/:id', 'App\Controllers\AnnonceController@sup');
$router->get('/formulaire', 'App\Controllers\AnnonceController@form'); 
       //post  Envoie de données     
$router->post('/formulaire', 'App\Controllers\AnnonceController@create'); 
        //get Récupération des données
$router->get('/formulaire/:id', 'App\Controllers\AnnonceController@edit');
$router->post('/formulaire/:id', 'App\Controllers\AnnonceController@updateMail');
//Lien depuis l'e-mail 
$router->get('/valid/:slug', 'App\Controllers\AnnonceController@valid');
$router->post('/valid/:id', 'App\Controllers\AnnonceController@valid');
$router->get('/formulairemail/:slug', 'App\Controllers\AnnonceController@formUpdate');
$router->post('/formulairemail/:slug', 'App\Controllers\AnnonceController@updateMail');
// $router->get('/annonces/:page', 'App\Controllers\AnnonceController@pagination');
$router->get('/annonces', 'App\Controllers\AnnonceController@search');
$router->get('/genpdf', 'App\Controllers\AnnonceController@genPdf');

//Vérifie si notre route match
$router->run();

?>
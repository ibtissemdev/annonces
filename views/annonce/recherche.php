<?php 

use App\Models\Annonce;

$annonces = new Annonce($this->getDb());



// print_r($_GET);
$id_categorie= explode('/', filter_var($_GET['url']), FILTER_SANITIZE_URL);
// print_r($id_categorie[1]);

 $result=$annonces->recherche($id_categorie[1]);



$encoder= json_encode($result) ;
// echo json_encode($result,JSON_FORCE_OBJECT);

error_log(print_r($encoder,1));


?>
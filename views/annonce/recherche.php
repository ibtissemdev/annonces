<?php 

use App\Models\Annonce;

$annonces = new Annonce($this->getDb());



// print_r($_GET);
$id_categorie= explode('/', filter_var($_GET['url']), FILTER_SANITIZE_URL);
// print_r($id_categorie[1]);

 $result=$annonces->recherche($id_categorie[1]);

 error_log("REsult : ".print_r($result,1));


$encoder=json_encode($result,JSON_UNESCAPED_UNICODE);
$encoder=str_replace("\/","/",$encoder);

echo $encoder ;
// echo json_encode($result,JSON_FORCE_OBJECT);

 error_log("Enoder : ".print_r($encoder,1));


?>
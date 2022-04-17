<?php
echo 'salut';
use Dompdf\Dompdf;

require_once '../includes/dompdf/autoload.inc.php';

$dompdf= new Dompdf();

$dompdf->loadHtml("Brouette");//je veux du html
$dompdf->render();//Pour générer le pdf (rendu en mémoire)
$dompdf->stream();//Envoie du pdf en tant que fichier à télécharger
?>

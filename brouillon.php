<h1><?= $params['annonce']->nom ?></h1>

<p><?= $params['annonce']->description ?></p>
<p><?php print_r($params['listeChemin'][1]->chemin);

?></p>

<div id="slider">
  
        <img src="<?= $params['annonce']->chemin ?>" alt="photo1" id="slide">
   
        <div id="precedent" onclick="ChangeSlide(-1)"><</div>
        <div id="suivant" onclick="ChangeSlide(1)">></div>
</div>
<a href="/annonces/"><button class="boutton">Retour</button></a>
<?php

 $listePhoto=[];
foreach($params['listeChemin'] as $photo) {
    $listePhoto[]= $photo->chemin;
  
//  print_r($listePhoto)   ;

} 
$listePhoto=implode('" , "',$listePhoto );

$listePhoto.='"';
$listePhoto= substr_replace($listePhoto, '"', 0, 0); 
//print_r($listePhoto);
?>


<script>

    
    var slidePhoto = new Array(<?=$listePhoto?>);

var slide = new Array("<?=  $params['annonce']->photo1 ?>", "<?= $params['annonce']->photo2 ?>", "<?= $params['annonce']->photo3 ?>", "<?= $params['annonce']->photo4 ?>","<?= $params['annonce']->photo5 ?>" );

var numero = 0;

function ChangeSlide(sens) {
    numero = numero + sens;
    if (numero < 0)
        numero =slide.length - 1;
    if (numero >slide.length - 1)
        numero = 0;
    document.getElementById("slider").src =slide[numero];
}
setInterval("ChangeSlide(1)", 3000);
</script>

<!--<a href="/annonces/annonces/delete/<?= $params['annonce']->id ?>" ><button class="btn btn-secondary">Supprimer</button></a>
<a href="/annonces/formulaire/<?= $params['annonce']->id ?>" ><button class="btn btn-secondary">Modifier</button></a> ->

    [2] => 2022-03-10 12_47_27-.png
    [3] => 2022-04-05 11_46_14-.png



<?php
        $photo = new Photo($this->getDb());

        //On récupère la liste des photos à supprimer dans la table photos
        $result = $photo->findAllChemin();
        // error_log(print_r($result, 1));

        //On leur supprime le path pour ne laisser que le nom du fichier photo et on les stocke dans un tableau
        $photoAsupprimer = [];
        foreach ($result as $photoPourSup) {
            $photoPourSup = str_replace(self::PATH_IMG_ABSOLUTE, "", $photoPourSup->chemin);

            $photoAsupprimer[] = $photoPourSup;
        }

        // error_log(print_r($photoAsupprimer, 1));
        //On parcour le dossier image et on stocke chaque fichier image dans un tableau
        $dir = "images/";
        $dossier = opendir($dir);
        $fichierImage = [];
        while ($fichier = readdir($dossier)) {
            if ($fichier != '.' && $fichier != '..') {
                // error_log(print_r($fichier, 1));
                $fichierImage[] = $fichier;
            }
        }

        $imagesAsupprimer = array_diff($fichierImage,$photoAsupprimer);

        foreach ( $imagesAsupprimer as $aSupprimer) {
            
                    // error_log(print_r("fichier dans table photo : " . $aSupprimer, 1));
                    // error_log(print_r("fichier dans dossier image : " . $fich, 1));
                    unlink("images/".$aSupprimer);
        //  error_log(print_r("images dans dossier image supprimées",1));
            }
            closedir($dossier);

?>


    
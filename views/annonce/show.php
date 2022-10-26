<h1> <?= ucfirst($params['annonce']->nom )?></h1>
<?php 
// print_r($params['listeChemin']);
$tableau=[];
foreach($params['listeChemin'] as $photo) {

$tableau[]=$photo->chemin;

}


$tableau= implode('","',$tableau);

?></p>

<div id="slider">
  
        <img src="<?= $params['annonce']->chemin ?>" alt="photo1" id="slide">
        <div id="precedent" onclick="ChangeSlide(-1)"><</div>
        <div id="suivant" onclick="ChangeSlide(1)">></div>
</div>




<h2>Catégorie : <?=$params['annonce']->nom_categorie?></h2>
<h3>Date de création : <?=date("d/m/Y",strtotime($params['annonce']->date_creation))?></h3> 


<div class="description"><h3> Descritpion : </h3><p><?= $params['annonce']->description ?></p></div>
<p>

<a href="/annonces/"><button class="boutton">Retour</button></a>

<script>
var slide =new Array("<?=$tableau?>");
var numero = 0;

function ChangeSlide(sens) {
    numero = numero + sens;
    if (numero < 0)
        numero = slide.length - 1;
    if (numero > slide.length - 1)
        numero = 0;
    document.getElementById("slide").src = slide[numero];
}
setInterval("ChangeSlide(1)", 3000);
</script>
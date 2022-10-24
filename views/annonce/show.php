<h1><?= $params['annonce']->nom ?></h1>

<p> Descritpion : <?= $params['annonce']->description ?></p>
<p><?php 
// print_r($params['listeChemin']);
$tableau=[];
foreach($params['listeChemin'] as $photo) {

$tableau[]=$photo->chemin;

}


$tableau= implode('","',$tableau);

print_r($tableau);
?></p>

<div id="slider">
  
        <img src="<?= $params['annonce']->chemin ?>" alt="photo1" id="slide">
        <div id="precedent" onclick="ChangeSlide(-1)"><</div>
        <div id="suivant" onclick="ChangeSlide(1)">></div>
</div>
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




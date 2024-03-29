<?php
// print_r($params['listeChemin']);
$tableau = [];
foreach ($params['listeChemin'] as $photo) {

    $tableau[] = $photo->chemin;
}


$tableau = implode('","', $tableau);

?>
<div class="afficher">
    <h1> <?= ucfirst($params['annonce']->nom) ?></h1>

    <div id="slider">

        <img src="<?= $params['annonce']->chemin ?>" alt="photo" id="slide">
        <div id="precedent" onclick="ChangeSlide(-1)"> < </div>
                <div id="suivant" onclick="ChangeSlide(1)">></div>
    </div>

        <div class="description">
            <h3> Descritpion : </h3>
            <p><?= $params['annonce']->description ?></p>
        </div>

        <div class="infos">
            <h2 class="cat">Catégorie : <?= $params['annonce']->nom_categorie ?></h2>
            <h4 class="date">Créée le : <?= date("d/m/Y", strtotime($params['annonce']->date_creation)) ?></h4>
        </div>
   

</div>
<a href="/annonces/"><button class="boutton">Retour</button></a>

<script>
    var slide = new Array("<?= $tableau ?>");
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
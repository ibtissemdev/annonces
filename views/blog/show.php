<h1><?= $params['annonce']->nom ?></h1>
<p><?= $params['annonce']->description ?></p>

<img src="../public/images/<?=$params['annonce']->photo1?>" alt="photo1">
<img src="../public/images/<?=$params['annonce']->photo2?>" alt="photo1">
<img src="../public/images/<?=$params['annonce']->photo3?>" alt="photo1">
<img src="../public/images/<?=$params['annonce']->photo4?>" alt="photo1">
<img src="../public/images/<?=$params['annonce']->photo5?>" alt="photo1">

<a href="/annonces/" ><button class="btn btn-secondary">Retour</button></a>
<a href="/annonces/annonces/delete/<?= $params['annonce']->id ?>" ><button class="btn btn-secondary">Supprimer</button></a>
<a href="/annonces/formulaire/<?= $params['annonce']->id ?>" ><button class="btn btn-secondary">Modifier</button></a>

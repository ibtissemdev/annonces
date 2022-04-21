<h1><?= $params['annonce']->nom ?></h1>
<p><?= $params['annonce']->description ?></p>

<img src="<?=$params['annonce']->photo1?>" alt="photo1">
<img src="<?=$params['annonce']->photo2?>" alt="photo2">
<img src="<?=$params['annonce']->photo3?>" alt="photo3">
<img src="<?=$params['annonce']->photo4?>" alt="photo4">
<img src="<?=$params['annonce']->photo5?>" alt="photo5">

<a href="/annonces/" ><button class="btn btn-secondary">Retour</button></a>

<!--<a href="/annonces/annonces/delete/<?= $params['annonce']->id ?>" ><button class="btn btn-secondary">Supprimer</button></a>
<a href="/annonces/formulaire/<?= $params['annonce']->id ?>" ><button class="btn btn-secondary">Modifier</button></a> ->



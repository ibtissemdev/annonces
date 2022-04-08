<h1><?= $params['annonce']->nom ?></h1>
<p><?= $params['annonce']->description ?></p>
<a href="/annonces/" ><button class="btn btn-secondary">Retour</button></a>
<a href="/annonces/posts/delete/<?= $params['annonce']->id ?>" ><button class="btn btn-secondary">Supprimer</button></a>

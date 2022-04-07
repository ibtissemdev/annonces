<h1>Les dernières annonces</h1>

<?php foreach ($params['annonces'] as $annonce) : ?>

    <div class="card">

        <div class="card-body mb-3">
            <h2> <?= $annonce->nom // on récupère en objet?></h2>
            <p><?= $annonce->categorie // on récupère en objet?></p>
            <small><?= $annonce->nom // on récupère en objet?></small>
      <a href="/posts/<?=$annonce->id?>"><button class='btn btn-primary'>Lire plus</button></a>
        </div>

    </div>

<?php endforeach ?>
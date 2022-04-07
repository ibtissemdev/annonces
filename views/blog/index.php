<h1>Les dernières annonces</h1>

<?php foreach ($params['annonces'] as $annonce) : ?>

    <div class="card">

        <div class="card-body">
            <h2> <?= $annonce->nom // on récupère en objet
                    ?></h2>
        </div>

    </div>

<?php endforeach ?>
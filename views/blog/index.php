<h1>Les dernières annonces</h1>

<?php foreach ($params['annonces'] as $annonce) : ?>

    <div class="card">

        <div class="card-body mb-3">
            <h2> <?= $annonce->nom // on récupère en objet?></h2>
            <p><?= $annonce->categorie // on récupère en objet?></p>
            <span> <?= '<img src= "./public/images/' . $annonce->photo1 . '" alt="photo annonce">'; // on récupère en objet?></span>
            <span> <?= '<img src= "./public/images/' . $annonce->photo2 . '" alt="photo annonce">'; // on récupère en objet?></span>
            <span> <?= '<img src= "./public/images/' . $annonce->photo3 . '" alt="photo annonce">'; // on récupère en objet?></span>
            <span> <?= '<img src= "./public/images/' . $annonce->photo4 . '" alt="photo annonce">'; // on récupère en objet?></span>
            <span> <?= '<img src= "./public/images/' . $annonce->photo5 . '" alt="photo annonce">'; // on récupère en objet?></span>
    <a href="/annonces/annonces/<?=$annonce->id?>"><button class='btn btn-primary'>Lire plus</button></a>
    </div>

    </div>

<?php endforeach ?>

<a href="/annonces/formulaire"><button class='btn btn-primary'>Ajouter</button></a>
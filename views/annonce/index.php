<?php

use App\Models\Categorie;

$count = (int)  $this->db->getPDO()->query('SELECT COUNT(id)FROM annonces ')->fetch(PDO::FETCH_NUM)[0];


//Si l'utilisateur a tardé à valider l'annonce ce message s'affichera en le redirigeant sur la page d'accueil
if (isset($_GET['cookie'])) {
  echo "<strong> Le délai d'une heure est écoulé, votre annonce n'a pas été publié recommencez votre saisie </strong><br>";
}

 ?>

<a href="/annonces/formulaire"><button class='boutton'>Ajouter une annnonce</button></a>
<div class="recherche">
<form action="" method="post">
  <label for="recherche">Recherche</label>
  <select name="recherche" id="recherche">
  <option value= "" disabled selected hidden>Catégorie</option>
    <?php
                        $categorie = new Categorie($this->getDb());
                        $liste = $categorie->findAllCategorie();
                        // print_r($liste);

                        foreach ($liste as $cat) {

                            // print_r($cat->nom_categorie);
                            // print_r($cat->id_categorie);

                        ?>
                            <option value="<?= $cat->id_categorie ?>"><?= $cat->nom_categorie ?></option>

                        <?php } ?>
  </select>
  <button class="boutton" type="search">Envoyer</button>
</form>
</div>

<h1>Les dernières annonces</h1>

<header><?= $count ?> Enregistrements au total</header>


<div class="liste">

  <?php
  if (!isset($params['resultat'])) {

    foreach ($params['annonces'] as $annonce) :
      //foreach ($result as $annonce) :
  ?>


      <div class="annonce">
        <span>
          <div class="nom">
            <h2>Non : <?= $annonce->nom // on récupère en objet
                  ?></h2>
            <p>Catégorie : <?= $annonce->nom_categorie // on récupère en objet
                ?></p>
          </div>
          <img src="<?= $annonce->chemin ?>" alt="photo annonce">

          <a href="/annonces/annonces/<?= $annonce->id ?>"><button class='plus'>Lire plus</button></a>
        </span>

      </div>


    <?php endforeach;  ?>
</div>

<?php
  } else {


    foreach ($params['resultat'] as $annonce) :
      //foreach ($result as $annonce) :
?>


  <div class="annonce">
    <span>
      <div class="nom">
        <h2> <?= $annonce->nom; // on récupère en objet
     
              ?></h2>
        <p><?= $annonce->nom_categorie // on récupère en objet
            ?></p>
      </div>
      <img src="<?= $annonce->chemin ?>" alt="photo annonce">

      <a href="/annonces/annonces/<?= $annonce->id ?>"><button class='plus'>Lire plus</button></a>
    </span>

  </div>


<?php endforeach;
  } ?>
</div>
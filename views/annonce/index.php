

<?php


use App\Models\Categorie;

$count = (int)  $this->db->getPDO()->query('SELECT COUNT(id)FROM annonces ')->fetch(PDO::FETCH_NUM)[0];


//Si l'utilisateur a tardé à valider l'annonce ce message s'affichera en le redirigeant sur la page d'accueil
if (isset($_GET['cookie'])) {
  echo "<strong> Le délai d'une heure est écoulé, votre annonce n'a pas été publié recommencez votre saisie </strong><br>";
  
}


?>

<a href="/annonces/formulaire"><button class='boutton ajouter'>Ajouter une annnonce</button></a>


<form action="" method="post" class="formRecherche">
  <div class="recherche">
    <fieldset>
      <legend>Recherche</legend>
      <select name="recherche"  id="recherche" >
        <option value="" disabled selected hidden>Catégorie

        </option><?php
                  $categorie = new Categorie($this->getDb());
                  $liste = $categorie->findAllCategorie();
                  // print_r($liste);

                  foreach ($liste as $cat) {

                    // print_r($cat->nom_categorie);
                    // print_r($cat->id_categorie);

                  ?>
          <option  value="<?= $cat->id_categorie ?>"><?= $cat->nom_categorie ?></option>

        <?php } ?>
      </select>
      <button type="search" >Envoyer</button>
    </fieldset>

  </div>
</form>


<h1>Les dernières annonces</h1>

  <?php
  if (!isset($params['resultat'])) {

    ?>
<p><?= $count ?> Enregistrements au total</p>

<div class="liste" id="liste">
<?php
    foreach ($params['annonces'] as $annonce) : ?>

      <div class="annonce">
        <span>
          <div class="nom">
            <h2> <?= $annonce->nom // on récupère en objet?></h2>
            <h3>Catégorie : <?= $annonce->nom_categorie // on récupère en objet?></h3>
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


<?php endforeach; ?>
<a href="/annonces/"><button class="boutton">Retour</button></a>
<?php
  } ?>
  
</div>


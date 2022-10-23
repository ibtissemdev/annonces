<?php //session_start(); 

use App\Models\Categorie;
use App\Models\Photo;

?>

<h1> <?= (isset($params['annonce']->id) && !empty($params['annonce']->id)) ? "Modifier " : "Ajouter" ?> une annonce</h1>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="public\css\style.css" rel="stylesheet">
    <title>Corner Shop</title>
</head>

<body>

    <?php $idtmp = rand(10000, 99999);
    setcookie("idTmp", $idtmp, time() + 3600 );  /* expire dans 1 heure */
    ?>
    <container>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="partie1">
                <input type="hidden" name="id" value="<?php if (isset($params['annonce']->id)) {
                                                            echo  $params['annonce']->id;
                                                        } ?>">
                <input type="hidden" name="idTmp" value="<?= $idtmp ?>">
                <fieldset>
                    <legend>Informations annonces</legend>
                    <label for="lieux">Où </label>
                    <select name="ville" id="ville" required>
                        <?= (isset($params['annonce']->id)) ?  "<option>" . $params['annonce']->ville . "</option>" : "<option disabled selected hidden>Ville</option>"; ?>
                        <option value="Chambery">Chambéry</option>
                        <option value="Grenoble">Grenoble</option>
                        <option value="Annecy">Annecy</option>
                        <option value="Lyon">Lyon</option>
                    </select>
                    <?php
                    if((isset($params['annonce']->id))) {
                        $categorie = new Categorie($this->getDb());
                        $nomCategorie = $categorie->findCategorieById($params['annonce']->categorie_id);
                        // error_log(print_r($nomCategorie,1));
                    }
                 
                    ?>

                    <label for="categorie">Quoi </label>
                    <select name="categorie" id="" required>

                        <?= (isset($params['annonce']->id)) ?  "<option value=".$nomCategorie->id_categorie.">". $nomCategorie->nom_categorie . "</option>" : "<option disabled selected hidden>Catégorie</option>";
                        ?>
                        <?php
                        $categorie = new Categorie($this->getDb());
                        $liste = $categorie->findAllCategorie();
                        // print_r($liste);
                        foreach ($liste as $cat) {
                        //     print_r($cat->nom_categorie);
                        // error_log(print_r('numéro de l/id catégorie : '.$cat->id_categorie,1))    ;
                        ?>
                            <option value="<?= $cat->id_categorie ?>"><?= $cat->nom_categorie ?></option>

                        <?php } ?>
                    </select>

                    <label for="titre">Titre : </label>
                    <input type="text" value="<?php
                                                if (isset($params['annonce']->id)) {
                                                    echo  $params['annonce']->nom;
                                                } ?>" id="titre" name="nom" maxlength="20" pattern="^[A-Za-zéèê '-]+$" required placeholder="Ex : Une superbe voiture">

                    <label for="prix">Prix : </label>
                    <input type="number" value="<?php
                                                if (isset($params['annonce']->id)) {
                                                    echo  $params['annonce']->prix;
                                                } ?>" id="wifi" name="prix" required placeholder="Ex : Un prix correct">

                    <label for="description">Desciption : </label>
                    <input type="text" id="parking" maxlength="250" value="<?php
                                                            if (isset($params['annonce']->id)) {
                                                                echo  $params['annonce']->description;
                                                            } ?>" name="description" pattern="^[A-Za-zéèê '-]+$" required placeholder="Ex : Détails sur le produit">

            </div>
            </fieldset>
            <div class="partie2">
                <fieldset>
                    <legend>Photos</legend>
                 
                    <label for="file">Ajouter photo </label>
                        <?php
                                                  if (isset($params['annonce']->id)) {
                                                        $photo= new Photo($this->getDb());
                                                        $listePhoto=$photo->findCheminsById($params['annonce']->id);

                                                        foreach ($listePhoto as $photo) {
                                                            echo '<img src= "' . $photo->chemin . '" alt="photo hébergement">';
                                                        }
                                                        echo "Veuillez insérer vos photos à nouveau".'<br>';
                                                      
                                                    } ?>

                    <input type="file" name="file[]" multiple>

                    <?php
                    if (!isset($params['annonce']->id)) { ?>
                        <div>
                            <label for="email">Entrer votre email:</label>
                            <input type="email" id="email" value=" " maxlength="30" pattern="^[A-Za-z0-9]+@{1}[A-Za-z]+\.{1}[A-Za-z]{2,}$" name="mail" id="mail" placeholder="Entrer le mail" required>

                        </div>
                    <?php } ?>
                </fieldset>

                <div id="submit">
                    <input type="submit" name="envoyer" value="<?php
                                                                if (isset($params['annonce']->id)) {
                                                                    echo  'Modifier une annonce';
                                                                } else {
                                                                    echo 'Ajouter une annonce';
                                                                } ?>">
                </div>

                <input type="reset">
            </div>
        </form>
        <a href="/annonces/"><button class="btn btn-secondary">Retour</button></a>

    </container>
<?php //session_start(); 

use App\Models\Categorie;
$categorie = new Categorie($this->getDb());
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="http://localhost/public/css/style.css" rel="stylesheet">
    <title>Corner Shop</title>
</head>

<body>


    <container>

        <h1>Récapitulatif de votre annonce </h1>

        <?php if ($_POST) {
            error_log("formulairemail.php avec POST");  ?>

            <span>Ville : <?= $_POST['ville'] ?> <p></p></span>
            <span>Catégorie : <?=$categorie->findCategorieById($_POST['categorie'])->nom_categorie;
          ?></span><br>
            <span>Nom : <?= $_POST['nom'] ?></span><br>
            <span>Prix : <?= $_POST['prix'] ?> €</span><br>
            <span>Description : <?= $_POST['description'] ?></span><br>

           

            <?php
            $nbrPhoto = count($_FILES['file']['name']);
            error_log($nbrPhoto);


            for ($i = 0; $i < $nbrPhoto; $i++) {
                error_log($i);
            ?>

              <!--  <span><img src="http://localhost/annonces/public/images/<?= ($_FILES['file']) ? $_FILES['file']['name'][$i] : "image vide" ?>"></span><br> -->


            <?php }
        } else if (empty($_POST)) {

            error_log("formulairemail.php SANS POST");

            $tmp = str_replace("formulairemail/", "", $_GET['url']);

            //Décode l'ensemble des données récupérées dans l'url
            $slugcrypter_modif = base64_decode($tmp);
            $donnees = explode("/", $slugcrypter_modif);
            ?>

            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idTmp" value="<?= $donnees[0] ?>">
                <div class="formulaire">
                <div class="partie1">
                    <fieldset name="information-modifier">
                        <legend>Informations annonces</legend>
                        <label for="ville">Où </label>
                        <select name="ville" id="ville"  required>
                            <option value="<?= $donnees[1] ?>"><?= $donnees[1] ?></option>
                            <option value="Chambery">Chambéry</option>
                            <option value="Grenoble">Grenoble</option>
                            <option value="Annecy">Annecy</option>
                            <option value="Lyon">Lyon</option>
                        </select>

                        <label for="categorie">Quoi </label>
                        <select name="categorie" id="" required>
                            <option value="<?= $donnees[2] ?>"><?= $donnees[2] ?></option>
                            <?php
                    
                            $liste = $categorie->findAllCategorie();
                            // print_r($liste);

                            foreach ($liste as $cat) {

                                // print_r($cat->nom_categorie);
                                // print_r($cat->id_categorie);

                            ?>
                                <option value="<?= $cat->id_categorie ?>"><?= $cat->nom_categorie ?></option>

                            <?php } ?>

                        </select>

                        <div>
                            <label for="logement">Titre : </label>
                            <input type="text" value="<?= $donnees[3] ?>" id="titre" name="nom" maxlength="20" pattern="^[A-Za-zéèê '-]+$" required placeholder="Ex : Une superbe voiture">
                        </div>

                        <div>
                            <label for="prix">Prix : </label>
                            <input type="number" value="<?= $donnees[4] ?>" id="wifi" name="prix" required placeholder="Ex : Un prix correct">
                        </div>
                        <div>
                            <label for="description">Desciption : </label>
                        <textarea id="parking" maxlength="300" rows="5" cols="26" value="<?= $donnees[5] ?>" name="description" maxlength="250" pattern="^[A-Za-zéèê0-9 '-]+$" required placeholder="Ex : Détails sur le produit"></textarea>
                        </div>

                    </fieldset>
                </div>

                <div class="partie2">
                    <fieldset name="photo-modifier">
                        <legend>Photos</legend>
                        <label for="file"> Photos chargés :</label>

                        <?php

                        // error_log(print_r($donnees),1)   ;
                        $nbrPhotos = count($donnees) - 2;
                        $j = 0;
                        for ($i = 7; $i < $nbrPhotos; $i++) {
                            $j++;
                        ?><div>
                            <?php echo 'Photo ' . $j . '<img src= "' . 'http://localhost/annonces/public/images/' . $donnees[$i] . '" alt="photo hébergement">' . '<hr>';
                        }   ?>
                            <span>Veuillez recharger toutes vos photos sinon elles seront supprimées</span>
                            <input type="file" name="file[]" multiple>
                            </div>

                            <div>

                                <input type="hidden" id="mail" value="<?= $donnees[6] ?>" name="mail">
                            </div>
                          
                    </fieldset>
              
                    <div id="submit" name="modifier">
                    <input type="reset">
                        <button type="submit" class="boutton" name="modifier">Modifier</button><br>

                    </div>

                

                </div>
                </div>
            </form>
            <a href="/annonces/"><button class="boutton">Retour</button></a>

        <?php 
        }


        if ($_POST) {

            // error_log("formulairemail.php AVEC POST avant envoie du mail");
            //  error_log(print_r($_FILES,1));
            $nbrPhoto = count($_FILES['file']['name']);
            $photo = "";
            for ($i = 0; $i < $nbrPhoto; $i++) {
                // error_log(print_r("liste des photos : " .$_FILES['file']['name'][$i],1));
                $photo .= $_FILES['file']['name'][$i];
                $photo .= '/';
            }
            // error_log(print_r("liste des photos : " .$photo,1));

            $slug = $_POST['idTmp'] . '/' . $_POST['ville'] . '/' . $_POST['categorie'] . '/' . $_POST['nom'] . '/' . $_POST['prix'] . '/' . $_POST['description'] . '/' . $_POST['mail'] . '/' . $photo . '/';

            $slugEncode_valid = base64_encode($slug . "valid");
            $slugEncode_update = base64_encode($slug . "update");?>


<p>Si votre annonce vous convient, vous pouvez la valider : </p><br>
            <button type="submit" name="envoyer"><a href="http://localhost/annonces/valid/<?= $slugEncode_valid ?>">Valider</a></button><br>
 <p>Si vous souhaiter la modifier, vous pouvez le faire en suivant ce lien</p>  <br>         
            <button type="submit" name="envoyer"><a href="http://localhost/annonces/formulairemail/<?= $slugEncode_update ?>">Modifier</a></button><br>
            <p>Vous pouvez tout annuler, en cliquant sur le bouton retour</p>  <br> 
            <a href="http://localhost/annonces/"><button class="btn btn-secondary">Retour</button></a>

        <?php    } ?>


     
    </container>
</body>

</html>
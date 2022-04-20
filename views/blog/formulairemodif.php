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
<span>Ville : <?= $_POST['ville'] ?> </span><br>
<span>Catégorie : <?= $_POST['categorie'] ?></span><br>
<span>Nom: <?= $_POST['nom']?></span><br>
<span>Prix : <?= $_POST['prix']?></span><br>
<span>Desciption : <?=$_POST['description']?></span><br>

<container>
    <h4>modifier </h4>
    <form action=""  method="post" enctype="multipart/form-data">
    <input type="hidden" name="idTmp" value="<?= $idtmp ?>">
             <label for="logement">Où  </label>
            <select name="ville" id="ville" >
        <?=$donnees[1]?>
                <option value="Chambery">Chambéry</option>
                <option value="Grenoble">Grenoble</option>
                <option value="Annecy">Annecy</option>
                <option value="Lyon">Lyon</option>
            </select>

            <label for="categorie">Quoi </label>
            <select name="categorie" id="pet-select">
          <?=$donnees[2]?>"
                <option value="immobilier">Immobilier</option>
                <option value="vehicule">Vehicules</option>
                <option value="loisirs">Loisirs</option>
                <option value="meubles">Meubles</option>
                <option value="telephonie">Téléphonie</option>
                <option value="mode">Mode</option>
  	            <option value="emplois">Emplois</option>
  	            <option value="multimedia">Multimédia</option>
            </select>

    <div>
    <label for="logement">Titre : </label>
    <input type="text" value="<?=$donnees[3]?>" id="logement" name="nom" required placeholder = "Ex : Une superbe voiture">
    </div>
    
    <div>
    <label for="prix">Prix : </label>
    <input type="number" value="<?=$donnees[4]?>" id="wifi" name="prix" required placeholder = "Ex : Un prix correct">
    </div>
    <div>
    <label for="description">Desciption : </label>
    <input type="text" id="parking" value="<?=$donnees[5]?>" name="description" required placeholder = "Ex : Détails sur le produit">
    </div>
    <div>
   
    <?php 
    $test='photo';
for ($i=1 ; $i<=5 ; $i++) {

    $test='photo'.$i;
    ?>
     <label for="file">Ajouter photo <?=$i ?></label>
   <input type="file" name="<?=$test?>">

<?php } ?>
    
    <div>
            <label for="email">Entrer votre email:</label>
            <input type="email" id="email" value=" " size="30" name="mail" id="mail" placeholder="Entrer le mail" required>

            </div>

    <div id="submit">
    <input type="submit" name="envoyer" value="">
    </div>

    <input type="reset">
    </form>
</container>
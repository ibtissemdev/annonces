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
   
    <h4>Créez votre annonce </h4>
<?php if($_POST) { ?>


    <span>Ville : <?=$_POST['ville']?></span><br>
    <span>Catégorie :<?=$_POST['categorie']?></span><br>
    <span>Nom : <?=$_POST['nom']?></span><br>
    <span>Prix : <?=$_POST['prix']?></span><br>
    <span>Description : <?=$_POST['description']?></span><br>

    <span><img src="http://localhost/annonces/public/images/<?=($_FILES['photo1']) ? $_FILES['photo1'] ['name']: $donnees[6] ?>"></span><br>
<span><img src="http://localhost/annonces/public/images/<?=($_FILES['photo2']) ? $_FILES['photo2']['name']: "image vide" ?>"></span><br>
<span><img src="http://localhost/annonces/public/images/<?=($_FILES['photo3']) ? $_FILES['photo3']['name'] : "image vide" ?>"></span><br>
<span><img src="http://localhost/annonces/public/images/<?=($_FILES['photo4']) ? $_FILES['photo4']['name'] : "image vide" ?>"></span><br>
<span><img src="http://localhost/annonces/public/images/<?=($_FILES['photo5']) ? $_FILES['photo5']['name'] : "image vide" ?>"></span><br>

<?php } else if (empty($_POST)){ ?>

<form action=""  method="post" enctype="multipart/form-data">
    <input type="hidden" name="idTmp" value="<?= $idtmp ?>">
             <label for="logement">Où  </label>
            <select name="ville" id="ville" >
            <option value=""><?=$donnees[1]?></option>
                <option value="Chambery">Chambéry</option>
                <option value="Grenoble">Grenoble</option>
                <option value="Annecy">Annecy</option>
                <option value="Lyon">Lyon</option>
            </select>

            <label for="categorie">Quoi </label>
            <select name="categorie" id="pet-select">
            <option value=""><?=$donnees[2]?></option>
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
    

    <div id="submit">
    <button  type="submit" name="envoyer"><a  href="http://localhost/annonces/valid/<?=$donnees[0]?>">Modifier</a></button><br>
   
    </div>

    <input type="reset">
    </form>
    <?php } ?>
    
<?php $slug=$_POST['idTmp'].'/'.$_POST['ville'].'/'.$_POST['categorie'].'/'.$_POST['nom'].'/'.$_POST['prix'].'/'.$_POST['description'].'/'.$_POST['mail'].'/'.$_FILES['photo1']['name'].'/'.$_FILES['photo2']['name'].'/'.$_FILES['photo3']['name'].'/'.$_FILES['photo4']['name'].'/'.$_FILES['photo5']['name'].'/';

$slugcrypter_valid=base64_encode($slug."valid");
$slugcrypter_update=base64_encode($slug."update");

?>
   <button  type="submit" name="envoyer"><a  href="http://localhost/annonces/valid/<?=$slugcrypter_valid?>">Valider</a></button><br>
   <button  type="submit" name="envoyer"><a  href="http://localhost/annonces/valid/<?=$slugcrypter_update?>">Modifier</a></button><br>
   </form>
</container>
</body>

</html>
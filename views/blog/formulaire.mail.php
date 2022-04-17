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
 <p></p>

 <span>Ville : <?= $_POST['ville'] ?> </span><br>
<span>Catégorie : <?= $_POST['categorie'] ?></span><br>
<span>Nom: <?= $_POST['nom']?></span><br>
<span>Prix : <?= $_POST['prix']?></span><br>
<span>Desciption : <?=$_POST['description']?></span><br>



    <?php error_log(print_r($_POST['idTmp'],1)) ?><br>
   <button  type="submit" name="envoyer"><a  href="http://localhost/annonces/valid/<?= $_POST['idTmp']?>">Valider</a></button><br>
   <button  type="submit" name="envoyer"><a  href="http://localhost/annonces/valid/<?= $_POST['idTmp']?>">Modifier</a></button><br>


 
</container>

</html>
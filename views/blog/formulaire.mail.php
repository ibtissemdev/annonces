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
    <?php require '../index.html' ;
    ?>
    <h4>Créez votre annonce </h4>
 <p></p>

 <span>Ville : <?= $_POST['ville'] ?> </span><br>
<span>Catégorie : <?= $_POST['categorie'] ?></span><br>
<span>Nom: <?= $_POST['nom']?></span><br>
<span>Prix : <?= $_POST['prix']?></span><br>
<span>Desciption : <?=$_POST['description']?></span><br>
<span><img src="http://localhost/annonces/public/images/<?=($_FILES['photo1']) ? $_FILES['photo1'] ['name']: "image vide" ?>"></span><br>
<span><img src="http://localhost/annonces/public/images/<?=($_FILES['photo2']) ? $_FILES['photo2']['name']: "image vide" ?>"></span><br>
<span><img src="http://localhost/annonces/public/images/<?=($_FILES['photo3']) ? $_FILES['photo3']['name'] : "image vide" ?>"></span><br>
<span><img src="http://localhost/annonces/public/images/<?=($_FILES['photo4']) ? $_FILES['photo4']['name'] : "image vide" ?>"></span><br>
<span><img src="http://localhost/annonces/public/images/<?=($_FILES['photo5']) ? $_FILES['photo5']['name'] : "image vide" ?>"></span><br>

<?php var_dump($_FILES) ;?>


    <?php error_log(print_r($_POST['idTmp'],1)) ?><br>
<?php $slug=$_POST['idTmp'].'/'.$_POST['ville'].'/'.$_POST['categorie'].'/'.$_POST['nom'].'/'.$_POST['prix'].'/'.$_POST['description'].'/'.$_POST['mail'].'/'.$_FILES['photo1']['name'].'/'.$_FILES['photo2']['name'].'/'.$_FILES['photo3']['name'].'/'.$_FILES['photo4']['name'].'/'.$_FILES['photo5']['name'];
// $ivlen=openssl_cipher_iv_length($cipher="AES-256-CBC");
// $iv=openssl_random_pseudo_bytes($ivlen);
var_dump($slug) ;
$slugcrypter=base64_encode($slug);
?>

   <button  type="submit" name="envoyer"><a  href="http://localhost/annonces/valid/<?=$slugcrypter?>">Valider</a></button><br>
   <button  type="submit" name="envoyer"><a  href="http://localhost/annonces/valid/<?= $_POST['idTmp']?>">Modifier</a></button><br>


 
</container>

</html>
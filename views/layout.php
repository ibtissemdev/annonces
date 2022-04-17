<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La bonne place !</title>
    <link rel="stylesheet" href="<?= SCRIPTS . 'css' .DIRECTORY_SEPARATOR . 'style.css'?>">
</head>
<body>
<nav class="">
  
  <a class="logo" href="/">La bonne place</a>

  <form action="recherche.php" method="post">
  <label for="recherche">Recherche</label>
<input type="search" name="search" >
<button name="envoyer">Envoyer</button>
</form>
</nav>

    <div class="container">
            <?= $content ?>
    </div>
    







</body>
</html>
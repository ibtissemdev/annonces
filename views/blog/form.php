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
    <nav>
        <img src="assets\logo_bg_removed.png" alt="logo du site"> 
        <input id="searchbar" onkeyup="search_animal()" type="text"
        name="search" placeholder="Je recherche..."> 
    </nav>

<container>
    <h4>Créez votre annonce </h4>
    <form action=""  method="post" enctype="multipart/form-data">
             <label for="logement">Où  </label>
            <select name="ville" id="ville" > Ville
            <option value= "" disabled selected hidden>Ville</option>
                <option value="Chambery">Chambéry</option>
                <option value="Grenoble">Grenoble</option>
                <option value="Annecy">Annecy</option>
                <option value="Lyon">Lyon</option>
            </select>
            <label for="categorie">Quoi </label>
            <select name="categorie" id="pet-select">
            <option value= "" disabled selected hidden>Catégorie</option>
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
    <input type="text" id="logement" name="nom" required placeholder = "Ex : Une superbe voiture">
    </div>
    
    <div>
    <label for="prix">Prix : </label>
    <input type="number" id="wifi" name="prix" required placeholder = "Ex : Un prix correct">
    </div>
    <div>
    <label for="description">Desciption : </label>
    <input type="text" id="parking" name="description" required placeholder = "Ex : Détails sur le produit">
    </div>
    <div>
    <label for="file">Ajouter 5 photos : </label>
    <input type="file" name="file[]" multiple>

    <div>
            <label for="email">Entrer votre email:</label>
            <input type="email" id="email" size="30" name="mail" id="mail" placeholder="Entrer le mail" required>

            </div>

    <div id="submit">
    <input type="submit" name="envoyer" value="Créer Annonce">
    </div>

    <input type="reset">
    </form>
</container>
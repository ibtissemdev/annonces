<?php 


use App\Models\Annonce;
//Récupérer le nombre d'enregistrements
$count=new Annonce($this->getDb());;
$count =  $this->db->getPDO()->prepare("SELECT count(Id) as cpt  FROM annonces");
$count->setFetchMode(PDO::FETCH_ASSOC);
$count->execute();
$tcount = $count->fetchAll();

//Si l'utilisateur a tardé à valider l'annonce ce message s'affichera en le redirigeant sur la page d'accueil
if(isset($_GET['cookie'])) { echo "Le délais d'une heure est écoulé, recommencez votre saisie";} 

?>

<h1>Les dernières annonces</h1>

<header><?= $tcount[0]["cpt"]; ?> Enregistrements au total</header>

  <a href="/annonces/formulaire"><button class='btn btn-primary'>Ajouter</button></a>
<div class="liste">
<?php foreach ($params['annonces'] as $annonce) : ?>

 
<div class="annonce">
        <span><div class="nom"><h2> <?= $annonce->nom // on récupère en objet?></h2>
            <p><?= $annonce->categorie // on récupère en objet?></p></div>
             <img src="<?=$annonce->photo1?>" alt="photo annonce"> 

<?php echo $annonce->photo1  ?>
    <a href="/annonces/annonces/<?=$annonce->id?>"><button class='plus'>Lire plus</button></a></span>

    </div>
 

<?php endforeach ?>
</div>

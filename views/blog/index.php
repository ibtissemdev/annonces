<?php 
//Récupérer le nombre d'enregistrements

use App\Models\Annonce;

$count=new Annonce($this->getDb());;
$count =  $this->db->getPDO()->prepare("SELECT count(Id) as cpt  FROM annonces");
$count->setFetchMode(PDO::FETCH_ASSOC);
$count->execute();
$tcount = $count->fetchAll();

//Pagination 
@$page = $_GET["page"];
if (empty($page)) $page = 1;
$nbr_elements_par_page =3;

$nbr_de_pages = ceil($tcount[0]["cpt"] / $nbr_elements_par_page);
$debut = ($page - 1) * $nbr_elements_par_page;

$sth =  $this->db->getPDO()->prepare("SELECT * FROM annonces LIMIT $debut, $nbr_elements_par_page");
$sth->execute();
$resultat = $sth->fetchAll(PDO::FETCH_ASSOC);

?>


<h1>Les dernières annonces</h1>

<header><?= $tcount[0]["cpt"]; ?> Enregistrements au total</header>

<div class="pagination">
  <?php
 
    $precedent=$page-1;
    if ($page>1){
      echo"<a href='?page=$precedent'>Précédent</a>&nbsp";
  
}else {
  echo "<a>précédent</a>&nbsp";
}

  for ($i = 1; $i <=$nbr_de_pages; $i++) {
    if ($page != $i) {

      echo "<a href='?page=$i'>$i</a>&nbsp";
    } else {
      echo "<a>$i</a>&nbsp";
     
    }
  }
 
  $suivant=$page+1;
  if ($suivant<=$nbr_de_pages){
    echo "<a href='?page=$suivant'>Suivant</a>&nbsp";
  } else {
    echo "<a>Suivant</a>&nbsp";
  }
 
  ?>
  <a href="/annonces/formulaire"><button class='btn btn-primary'>Ajouter</button></a>
<div class="liste">
<?php foreach ($params['annonces'] as $annonce) : ?>

 
<div class="annonce">
        <span><div class="nom"><h2> <?= $annonce->nom // on récupère en objet?></h2>
            <p><?= $annonce->categorie // on récupère en objet?></p></div>
             <img src="<?=$annonce->photo1?>" alt="photo annonce"> 


    <a href="/annonces/annonces/<?=$annonce->id?>"><button class='plus'>Lire plus</button></a></span>

    </div>
 

<?php endforeach ?>
</div>

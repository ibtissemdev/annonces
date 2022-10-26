<?php

namespace App\Models;

use Database\DbConnection;
use stdClass;

//Classe qui ne sera jamais instensiée 
abstract class Model
{
  protected $db;
  protected $table;


  public function __construct(DbConnection $db)
  {
    $this->db = $db;
  }

  public function findAll(): array
  {
    $sql = $this->db->getPDO()->query("SELECT annonces.id, description, prix, ville, nom_categorie,annonces.categorie_id, chemin, annonces.nom FROM {$this->table} 
    LEFT JOIN categorie ON annonces.categorie_id=categorie.id_categorie
    LEFT JOIN liaison_photo ON liaison_photo.annonce_id=annonces.id 
    LEFT JOIN photos ON photos.id_photo=liaison_photo.photo_id
    GROUP BY annonces.id
 
    ");
    return $sql->fetchAll();
  }

  public function findAllCategorie(): array
  {
    $sql = $this->db->getPDO()->query("SELECT nom_categorie, id_categorie FROM {$this->table} ");
    return $sql->fetchAll();
  }

  public function findCategorieById(int $id): stdClass //Classe standard prédéfinie
  {
    $sql = $this->db->getPDO()->query("SELECT nom_categorie, id_categorie FROM {$this->table} WHERE id_categorie=$id");
    $sql->execute();
    return $sql->fetch();
  }



  public function findById(int $id): stdClass //Classe standard prédéfinie
  {
    $sql = $this->db->getPDO()->prepare("SELECT description,annonces.id, prix, ville, nom_categorie, chemin, annonces.nom, annonces.categorie_id FROM {$this->table} 
    LEFT JOIN categorie ON annonces.categorie_id=categorie.id_categorie
    LEFT JOIN liaison_photo ON liaison_photo.annonce_id=annonces.id 
    LEFT JOIN photos ON photos.id_photo=liaison_photo.photo_id WHERE annonces.id=?");

    $sql->execute([$id]);
    return $sql->fetch();
  }


  public function findAllChemin(): array
  {
    $sql = $this->db->getPDO()->query("SELECT chemin FROM {$this->table} ");
    return $sql->fetchAll();
  }


  public function findCheminsById(int $id): array //Classe standard prédéfinie
  {
    $sql = $this->db->getPDO()->prepare("SELECT chemin, id_photo FROM {$this->table} 
    LEFT JOIN liaison_photo ON liaison_photo.photo_id=photos.id_photo
    LEFT JOIN annonces ON annonces.id=liaison_photo.annonce_id WHERE annonces.id=?");

    $sql->execute([$id]);
    return $sql->fetchall();
  }


  public function delete($id_annonce, $id)
  {
    $sth = $this->db->getPDO()->prepare("DELETE FROM {$this->table} WHERE $id_annonce=$id");
    $sth->execute();
  }
  private function valid_donnees($donnees)
  {
    $donnees = trim($donnees); //Supprime les espaces en début et fin de chaîne
    $donnees = stripslashes($donnees); //Supprime les antislashs d'une chaîne
    $donnees = htmlspecialchars($donnees);//Convertit les caractères spéciaux en entités HTML
    $donnees = strip_tags($donnees);//Supprime les balises HTML et PHP d'une chaîne

    return $donnees;
  }


  public function insert(Model $data)
  {

    $keys = [];
    $champs = [];
    $values = [];

    foreach ($data as $key => $value) {
      if ($value != null && $key != 'table' && $key != 'db') {//Pour ne pas prendre les propriété table et 
        $keys[] = $key;
        $champs[] = '?';
        $valueFiltre = $this->valid_donnees($value);
        $values[] = $valueFiltre;
      }
    }
    $keys = implode(",", $keys);
    $champs = implode(",", $champs);
    $sth = $this->db->getPDO()->prepare("INSERT INTO {$this->table} ($keys) VALUES ($champs)");
    $sth->execute($values);
    $result = $this->db->getPDO()->lastInsertId();
    return $result;
  }

  public function update($id, Model $data)
  {
    $keys = [];
    $values = [];

    foreach ($data as $key => $value) {
      if ($value != null && $key != 'table' && $key != 'db') {
        $keys[] = "$key = ?";
        $valueFiltre = $this->valid_donnees($value);
        $values[] = $valueFiltre;
      }
    }
    $values[] = $id;
    $keys = implode(",", $keys);
     
error_log(print_r($values,1));
    $sth = $this->db->getPDO()->prepare("UPDATE $this->table SET $keys WHERE id = ?");
    $sth->execute($values);
  
  }

  public function recherche($recherche)
  {
    $sql = "SELECT COUNT(annonces.id), description,annonces.id, prix, ville, nom_categorie, chemin, annonces.nom FROM {$this->table} 
    LEFT JOIN categorie ON annonces.categorie_id=categorie.id_categorie
    LEFT JOIN liaison_photo ON liaison_photo.annonce_id=annonces.id 
    LEFT JOIN photos ON photos.id_photo=liaison_photo.photo_id
    WHERE categorie.id_categorie LIKE '%$recherche%'
    GROUP BY annonces.id
    HAVING COUNT(annonces.id)";

    $sth = $this->db->getPDO()->prepare($sql);
    $sth->execute();
    $resultat = $sth->fetchall();

    return $resultat;
  }
}

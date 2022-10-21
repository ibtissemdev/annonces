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
    $sql = $this->db->getPDO()->query("SELECT COUNT(annonces.id), description,annonces.id, prix, ville, nom_categorie, chemin, annonces.nom FROM {$this->table} LEFT JOIN categorie ON annonces.categorie_id=categorie.id_categorie
    LEFT JOIN liaison_photo ON liaison_photo.annonce_id=annonces.id 
    LEFT JOIN photos ON photos.id_photo=liaison_photo.photo_id
    GROUP BY annonces.id
    HAVING COUNT(annonces.id)
    ");
    return $sql->fetchAll();
  }

  public function findById(int $id): stdClass //Classe standard prédéfinie
  {

    $sql = $this->db->getPDO()->prepare("SELECT description,annonces.id, prix, ville, nom_categorie, chemin, annonces.nom FROM {$this->table} 
    LEFT JOIN categorie ON annonces.categorie_id=categorie.id_categorie
    LEFT JOIN liaison_photo ON liaison_photo.annonce_id=annonces.id 
    LEFT JOIN photos ON photos.id_photo=liaison_photo.photo_id WHERE annonces.id=?");

    $sql->execute([$id]);
    return $sql->fetch();
  }
  public function findCheminsById(int $id): array //Classe standard prédéfinie
  {
    $sql = $this->db->getPDO()->prepare("SELECT chemin FROM {$this->table} 
    LEFT JOIN liaison_photo ON liaison_photo.photo_id=photos.id_photo
    LEFT JOIN annonces ON annonces.id=liaison_photo.annonce_id WHERE annonces.id=?");

    $sql->execute([$id]);
    return $sql->fetchall();
  }


  public function delete($id)
  {
    $sth = $this->db->getPDO()->prepare("DELETE FROM {$this->table} WHERE Id=$id");
    $sth->execute();
  }
  private function valid_donnees($donnees)
  {
    $donnees = trim($donnees);
    $donnees = stripslashes($donnees);
    $donnees = htmlspecialchars($donnees);
    $donnees = strip_tags($donnees);

    return $donnees;
  }


  public function insert(Model $data)
  {

    $keys = [];
    $champs = [];
    $values = [];

    foreach ($data as $key => $value) {
      if ($value != null && $key != 'table' && $key != 'db') {
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
    $sth = $this->db->getPDO()->prepare("UPDATE $this->table SET $keys WHERE id = ?");
    $sth->execute($values);
  }

  public function recherche($recherche)
  {
    $sql = "SELECT * FROM {$this->table} WHERE categorie LIKE '%$recherche%'";
    $sth = $this->db->getPDO()->prepare($sql);
    $sth->execute();
    $resultat = $sth->fetchall();

    return $resultat;
  }
}

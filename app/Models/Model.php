<?php 

namespace App\Models;

use Database\DbConnection;
use stdClass;

//Classe qui ne sera jamais instensiée 
abstract class Model{
 protected $db;
 protected $table;

 public function __construct(DbConnection $db)
 {
     $this->db = $db;
 }

 public function findAll() : array{

    $sql= $this->db->getPDO()->query("SELECT * FROM {$this->table} ORDER BY nom DESC");
    return $sql->fetchAll(); 

 }

 public function findById(int $id) :stdClass //Classe standard prédéfinie
 {

    $sql= $this->db->getPDO()->prepare("SELECT * FROM {$this->table} WHERE id=?");
    $sql-> execute([$id]);
    return $sql ->fetch(); 

 }

}

?>
<?php 

namespace App\Models;

use Database\DbConnection;
use stdClass;

//Classe qui ne sera jamais instensiée 
abstract class Model{
 protected $db;
 protected $table;
 protected $nom;

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

 public function delete($id)
 {
   $sth = $this->db->getPDO()->prepare("DELETE FROM {$this->table} WHERE Id=$id");
   $sth->execute();

 }

 public function insert(Model $data)
 {
   $keys=[];
     $champs=[];
     $values=[];
     
   foreach ($data as $key => $value) {
     if($value != null && $key!= 'table' && $key!='pdo') {
     $keys[] = $key;
     $champs[] = '?';
     $values[] = $value;
   }
 }
   $keys = implode(",", $keys);
   $champs = implode(",", $champs);
   $sth = $this->pdo->prepare("INSERT INTO {$this->table} ($keys) VALUES ($champs)");
   $sth->execute($values);
 }

 public function upload () {
   //Boucle qui permet d'uploader plusieurs images
   // print_r($_FILES);
   if(isset($_POST['envoyer'])){
       $countfiles = count($_FILES['file']['name']);
       for($i=0;$i<$countfiles;$i++){
           $filename = $_FILES['file']['name'][$i];
           $this->nom[$i+1]=$filename;

               move_uploaded_file($_FILES['file']['tmp_name'][$i],'images/'.$filename);}
   }

   var_dump($this->nom[1]);
   echo '<hr>';
   //var_dump($nom);
   echo '<hr>';
}

 public function update($id,$data){
   $keys=[];
   $values=[];
   
 foreach ($data as $key => $value) {
   if($value != null && $key!= 'table' && $key!='pdo') {
   $keys[] = "$key = ?";
   $values[] = $value;
 }
}
 $values[]=$id;
 $keys = implode(",", $keys);
 $sth = $this->pdo->prepare("UPDATE $this->table SET $keys WHERE Id = ?");
 $sth->execute($values);
}

}

?>
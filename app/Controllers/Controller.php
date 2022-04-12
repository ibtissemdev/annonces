<?php

namespace App\Controllers;

use Database\DbConnection;
//Classe abstraite : classe qui ne sera jamais instancié
abstract class  Controller{

    protected $db; 

    public function __construct(DbConnection  $db)
    {
        $this->db= $db;
    }

    protected function getDb() {

        return $this->db;
    }
    
    protected function view(string $path, array $params = null)
    {
        ob_start();
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        require VIEWS . $path . '.php';
        $content = ob_get_clean();
        require VIEWS . 'layout.php';
    }

}


?>
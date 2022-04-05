<?php

namespace App\Controllers;

use Database\DbConnection;

class BlogController extends Controller {

    public function index()
    {
        return $this->view('blog.index');
    }

    public function show(int $id)
    {
        $db = new DbConnection('projet4', 'localhost', 'root', '');
        $db->getPDO();
        $sql= $db->getPDO()->query('SELECT * FROM annonces');
        $annonces=$sql->fetchAll(); 
        var_dump($annonces); 
 
        return $this->view('blog.show', compact('id'));
        
    }
}













?>
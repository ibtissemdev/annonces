<?php

namespace App\Controllers;


class BlogController extends Controller {

    public function accueil(){
        return $this->view('blog.accueil');
    }

    public function index()
    {
       $stmt= $this->db->getPDO()->query('SELECT * FROM annonces ORDER BY nom DESC');
       $annonces=$stmt->fetchAll(); 
    return $this->view('blog.index', compact('annonces'));//permet d'envoyer un tableau qui contient nos données qui aura la clée annonces
    }

    public function show(int $id)
    {
   
        return $this->view('blog.show', compact('id'));
        
    }
}













?>
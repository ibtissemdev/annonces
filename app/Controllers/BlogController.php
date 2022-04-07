<?php

namespace App\Controllers;


class BlogController extends Controller {

    public function accueil(){
        return $this->view('blog.accueil');
    }

    public function index()
    {
       $sql= $this->db->getPDO()->query('SELECT * FROM annonces ORDER BY nom DESC');
       $annonces=$sql->fetchAll(); 
    return $this->view('blog.index', compact('annonces'));//permet d'envoyer un tableau qui contient nos données qui aura la clée annonces
    }

    public function show(int $id)
    {
        $sql= $this->db->getPDO()->prepare('SELECT * FROM annonces WHERE id=?');
        $sql-> execute([$id]);
        $annonce= $sql ->fetch() ; 
        return $this->view('blog.show', compact('annonce'));
        
    }
}













?>
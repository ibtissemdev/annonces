<?php

namespace App\Controllers;

use App\Models\Annonce;

class AnnonceController extends Controller {

    public function accueil(){
        return $this->view('blog.accueil');
    }

    public function index()
    {
        $annonce= new Annonce ($this->getDb());
        $annonces= $annonce->findAll();

      
    return $this->view('blog.index', compact('annonces'));//permet d'envoyer un tableau qui contient nos données qui aura la clée annonces
    }

    public function show(int $id)
    {
        $annonce= new Annonce ($this->getDb());
        $annonce= $annonce->findById($id);

        return $this->view('blog.show', compact('annonce'));
        
    }
}













?>
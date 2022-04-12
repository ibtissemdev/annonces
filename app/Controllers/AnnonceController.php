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

    public function sup(int $id) {
        $annonce=new Annonce ($this->getDb());
        $annonce->delete($id);

     header('Location: /annonces/ ');
        }

    public function form(){
        $annonce=new Annonce ($this->getDb());
        return $this->view('blog.formulaire', compact('annonce')); 
        /*if (!empty($_POST)) {
            $newAnnonce=$annonce->setCategorie($_POST['categorie'])
            ->setNom($_POST['nom'])
            ->setDescription($_POST['description'])
            ->setPrix($_POST['prix'])
            ->setVille($_POST['ville']);

            
            if (isset($_GET['id'])) {
              $annonce->update($_GET['id'],$newAnnonce);
              } else {
                $annonce->insert($newAnnonce);
              }
              header('Location:index.php');
            }*/

    
    }   
    }















?>
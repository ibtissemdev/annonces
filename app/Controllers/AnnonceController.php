<?php

namespace App\Controllers;

use App\Models\Annonce;
use App\Models\Mail;
class AnnonceController extends Controller {

  
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
    }   
    
    public function edit(int $id){
        $annonce=(new Annonce ($this->getDb()))->findById($id);
    return $this->view('blog.formulaire', compact('annonce')); 
    }   
    
    public function create(){
        $annonce=new Annonce ($this->getDb());
        $mail=new Mail ($this->getDb());
        if (!empty($_POST)) {
            $countfiles = count($_FILES['file']['name']);
            for($i=0;$i<$countfiles;$i++){
                $filename = $_FILES['file']['name'][$i];
                $photo[$i+1]=$filename;
     
                    move_uploaded_file($_FILES['file']['tmp_name'][$i],'images/'.$filename);}

            $newAnnonce=$annonce->setCategorie($_POST['categorie'])
            ->setNom($_POST['nom'])
            ->setDescription($_POST['description'])
            ->setPrix($_POST['prix'])
            ->setVille($_POST['ville'])->setphoto1($_FILES['file']['name'][0])
            ->setphoto2($_FILES['file']['name'][1])
            ->setphoto3($_FILES['file']['name'][2])
            ->setphoto4($_FILES['file']['name'][3])
            ->setphoto5($_FILES['file']['name'][4]);
       
                //Boucle qui permet d'uploader plusieurs images
                // print_r($_FILES)

            $newMail=$mail->setMail($_POST['mail']);
            if (isset($_GET['id'])) {
            $annonce->update($_GET['id'],$newAnnonce);
            } else {
                $annonce->insert($newAnnonce);
                $mail->insert($newMail);
              }
            
              header('Location: /annonces/');
            }
    }

}













?>
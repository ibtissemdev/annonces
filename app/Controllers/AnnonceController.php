<?php

namespace App\Controllers;

use App\Models\Annonce;
use App\Models\Mail;

session_start();
class AnnonceController extends Controller
{
    public function index()
    {
        $annonce = new Annonce($this->getDb());
        $annonces = $annonce->findAll();
        return $this->view('blog.index', compact('annonces')); //permet d'envoyer un tableau qui contient nos données qui aura la clée annonces
    }

    public function genPdf()
    {
        $annonce = new Annonce($this->getDb());
        return $this->view('blog.genpdf'); //permet d'envoyer un tableau qui contient nos données qui aura la clée annonces
    }

    public function show(int $id)
    {
        $annonce = new Annonce($this->getDb());
        $annonce = $annonce->findById($id);
        return $this->view('blog.show', compact('annonce'));
    }

    public function sup(int $id)
    {
        $annonce = new Annonce($this->getDb());
        $annonce->delete($id);

        header('Location: /annonces/ ');
    }

    public function form()
    {
        $annonce = new Annonce($this->getDb());
        return $this->view('blog.formulaire', compact('annonce'));
    }

    public function edit(int $id)
    {
        $annonce = (new Annonce($this->getDb()))->findById($id);
        return $this->view('blog.formulaire', compact('annonce'));
    }

    public function valid()
    {   
        echo "<pre>",print_r($_SESSION),"</pre>"; 
        error_log("Valid " . print_r($_SESSION,1));
        $annonce = new Annonce($this->getDb());
        $mail = new Mail($this->getDb());
        error_log(print_r($_GET['url'], 1));
        $tmp = explode("/", $_GET['url']);
        $idtmp = $tmp[1];
        print_r($idtmp);

       // echo "<pre> fonction valid",print_r($_SESSION),"</pre>"; 
     
        if (!empty($idtmp)) {
            //error_log(print_r($_POST,1));
            $newAnnonce = $annonce->setCategorie($_SESSION['categorie'])
                ->setNom($_SESSION['nom'])
                ->setDescription($_SESSION['description'])
                ->setPrix($_SESSION['prix'])
                ->setVille($_SESSION['ville'])
                ->setphoto1($_SESSION['photo1'])
                ->setphoto2($_SESSION['photo2'])
                ->setphoto3($_SESSION['photo3'])
                ->setphoto4($_SESSION['photo4'])
                ->setphoto5($_SESSION['photo5']);
            $result = $annonce->insert($newAnnonce);
            $mail->setMail($_POST['mail'])->setId_annonce($result);
            $to = $_POST['mail'];
            $subject = 'Annonce ajoutée';
            $message = 'Votre annonce a bien été ajouté';
            $headers = "From: ibtissem.khir@gmail.com";
            mail($to, $subject, $message, $headers);
        } else {
            echo 'aucune donnée reçue';
        }
    }

    
    public function create()
    {
        $annonce = new Annonce($this->getDb());
        $mail = new Mail($this->getDb());
        // var_dump($_POST);
        //var_dump($_SESSION);

        //CONDITION SI $_POST N'EST PAS VIDE ALORS ON RECUPERE LES DONNEES
        if (!empty($_POST)) {
            //UPLOAD D'IMAGE
            $countfiles = count($_FILES['file']['name']);
            for ($i = 0; $i < $countfiles; $i++) {
                $filename = $_FILES['file']['name'][$i];
                $photo[$i + 1] = $filename;
                move_uploaded_file($_FILES['file']['tmp_name'][$i], './images/' . $filename);
            }
            //ON DEFFINIE LES SETTERS
            $newAnnonce = $annonce->setCategorie($_POST['categorie'])
                ->setNom($_POST['nom'])
                ->setDescription($_POST['description'])
                ->setPrix($_POST['prix'])
                ->setVille($_POST['ville'])
                ->setphoto1($_FILES['file']['name'][0])
                ->setphoto2($_FILES['file']['name'][1])
                ->setphoto3($_FILES['file']['name'][2])
                ->setphoto4($_FILES['file']['name'][3])
                ->setphoto5($_FILES['file']['name'][4]);
         
            // error_log("newAnnonce" . print_r($newAnnonce, 1));
            //ON STOCKE LES DONNES DU FORMULAIRES DANS LE $_SESSION
            //$_SESSION[] = $photo;
            $_SESSION = $newAnnonce;
        
           //error_log("SESSION ".print_r($_SESSION,1));
            //$_SESSION=[$_FILES['file']['name'][0]];
         
            //CONDITION POUR VERIFIER SI ON A UN ID ALORS ON APPELLE LA FONCTION UPDATE
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $countfiles = count($_FILES['file']['name']);
                for ($i = 0; $i < $countfiles; $i++) {
                    $filename = $_FILES['file']['name'][$i];
                    $photo[$i + 1] = $filename;
                    move_uploaded_file($_FILES['file']['tmp_name'][$i], './images/' . $filename);
                }
               // echo "<pre>", print_r($_POST), "</pre>";
               // die();
                $annonce->update($_POST['id'], $newAnnonce);

                //ENVOIE DU MAIL APRES AVOIR REMPLI LES CHAMPS DU FORMULAIRE
            } else if (isset($_POST['envoyer']) && !empty($_POST['mail'])) {

                $mail = $_POST['mail'];
                print_r($mail);

                $to = $mail;
                $subject = "Validation annonce";
                ob_start();
                require '../views/blog/formulaire.mail.php';
                // Pour revenir à la ligne tous les 70 caractères environ
                $message = ob_get_clean();
                $message = wordwrap($message, 70, "\r\n");
                // Le destinataire : 
                $headers[] = "From: ibtissem.khir@gmail.com";
                $headers[] = 'MIME-Version: 1.0';
                $headers[] = 'Content-type: text/html; charset=utf-8';
                if (mail($to, $subject, $message, implode("\r\n", $headers))) {
                    echo 'Votre message a bien été envoyé';
                    echo "<pre>",print_r($_SESSION),"</pre>"; 
                } else {
                    echo 'Votre message n\'a pas pu être envoyé';
                }

                // print_r($result);
                //    $result= $annonce->insert($newAnnonce);
                //    $newMail=$mail->setMail($_POST['mail'])->setId_annonce($result);
                //         $mail->insert($newMail);

            }
        }

        //header('Location: /annonces/');
    }

}


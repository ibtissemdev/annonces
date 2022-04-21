<?php

namespace App\Controllers;

use App\Models\Annonce;
use App\Models\Mail;


class AnnonceController extends Controller
{//lien absolu pour l'image
    public const PATH_IMG_ABSOLUTE="http://localhost/annonces/public/images/";

    public function image(){

        return $this->view('blog.formulaire.mail.php' );
    }

    public function index()
    {
        $annonce = new Annonce($this->getDb());
        $annonces = $annonce->findAll();
        return $this->view('blog.index', compact('annonces')); //permet d'envoyer un tableau qui contient nos données qui aura la clée annonces
    }

    public function genPdf()
    {
        $annonce = new Annonce($this->getDb());
        $annonces = $annonce->findAll();
        return $this->view('blog.genpdf', compact('annonces') ); //permet d'envoyer un tableau qui contient nos données qui aura la clée annonces
        
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

    public function formUpdate()
    {   $annonce = new Annonce($this->getDb());
        return $this->view('blog.formulairemodif',compact('annonce'));
    }
    public function edit(int $id)
    {
        $annonce = (new Annonce($this->getDb()))->findById($id);
        return $this->view('blog.formulaire', compact('annonce'));
    }

    public function valid()
    {   
        // session_start();
        $annonce = new Annonce($this->getDb());
        $mail = new Mail($this->getDb());
        $tmp=str_replace("valid/","", $_GET['url']);

   //Decrypte l'ensemble des données récupérées dans l'url
   $slugcrypter_valid=base64_decode($tmp);
        $donnees = explode("/",$slugcrypter_valid);



    if ($donnees[12]=="valid") {
        
    //element constituants les donnees                              0 => idTmp       
        if (!empty($donnees[0])&&($_COOKIE['idTmp']==$donnees[0])) {
            $newAnnonce = $annonce
                ->setVille($donnees[1])                             //1=>ville   
                ->setCategorie($donnees[2])                         //2=>categorie
                ->setNom($donnees[3])                               //3=>nom
                ->setPrix($donnees[4])                              //4=>prix
                ->setDescription($donnees[5])                       //5=>description
                ->setphoto1(self::PATH_IMG_ABSOLUTE.$donnees[7])    //7=>photo1
                ->setphoto2(self::PATH_IMG_ABSOLUTE.$donnees[8])    //8=>photo8
                ->setphoto3(self::PATH_IMG_ABSOLUTE.$donnees[9])    //9=>photo9
                ->setphoto4(self::PATH_IMG_ABSOLUTE.$donnees[10])   //10=>photo10
                ->setphoto5(self::PATH_IMG_ABSOLUTE.$donnees[11]);  //11=>photo11

            $result = $annonce->insert($newAnnonce);

//Insertion de l'e-mail avec l'id_annonce
            $newMail=$mail->setMail($donnees[6])->setId_annonce($result);
            $mail->insert($newMail);

 //Envoie du deuxième e-mail           
            $to = $donnees[6];
            $subject = "Validation annonce";
            ob_start();
            require '../views/blog/mail.sup.php';
            $message = ob_get_clean();
            $message = wordwrap($message, 70, "\r\n");
            // Le destinataire : 
            $headers[] = "From: ibtissem.khiri@gmail.com";
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=utf-8';
            if (mail($to, $subject, $message, implode("\r\n", $headers))) {
                echo 'Votre message a bien été envoyé';

            } else {
                echo 'Votre message n\'a pas pu être envoyé';
            }
            
//Destruction de la session idTmp
           unset($_COOKIE['idTmp']);
           unset($_COOKIE["PHPSESSID"]);
           setcookie ("idTmp",NULL, 0); 
            if(isset($_COOKIE)){

                var_dump($_COOKIE);
            } else {
                echo 'le cookie est détruit';
            }

        } else {
            echo 'aucune donnée reçue';
        }
    } else {
       require '../views/blog/formulairemail.php';

        $slugcrypter_update=base64_decode($tmp);
        $donnees = explode("/",$slugcrypter_update);
        //element constituants les donnees                              0 => idTmp       
        if (!empty($donnees[0])&&($_COOKIE['idTmp']==$donnees[0])) {
            $newAnnonce = $annonce
                ->setVille($donnees[1])                             //1=>ville   
                ->setCategorie($donnees[2])                         //2=>categorie
                ->setNom($donnees[3])                               //3=>nom
                ->setPrix($donnees[4])                              //4=>prix
                ->setDescription($donnees[5])                       //5=>description
                ->setphoto1($donnees[7])    //7=>photo1
                ->setphoto2($donnees[8])    //8=>photo8
                ->setphoto3($donnees[9])    //9=>photo9
                ->setphoto4($donnees[10])   //10=>photo10
                ->setphoto5($donnees[11]);  //11=>photo11

            $result = $annonce->insert($newAnnonce);

//Insertion de l'e-mail avec l'id_annonce
            $newMail=$mail->setMail($donnees[6])->setId_annonce($result);
            $mail->insert($newMail);


    }}}
    
    public function create()
    {
        $annonce = new Annonce($this->getDb());
        $mail = new Mail($this->getDb());
        //CONDITION SI $_POST N'EST PAS VIDE ALORS ON RECUPERE LES DONNEES
        if (!empty($_POST)) {
            for ($i =1; $i <= 5; $i++) {
                $filename = $_FILES["photo$i"]['name'];
                $photo[$i + 1] = $filename;
                move_uploaded_file($_FILES["photo$i"]['tmp_name'], './images/' . $filename);
            }
            //ON DEFFINIE LES SETTERS
            $newAnnonce = $annonce->setCategorie($_POST['categorie'])
                ->setNom($_POST['nom'])
                ->setDescription($_POST['description'])
                ->setPrix($_POST['prix'])
                ->setVille($_POST['ville'])
                ->setphoto1($_FILES['photo1']['name'])
                ->setphoto2($_FILES['photo2']['name'])
                ->setphoto3($_FILES['photo3']['name'])
                ->setphoto4($_FILES['photo4']['name'])
                ->setphoto5($_FILES['photo5']['name']);
         
            //CONDITION POUR VERIFIER SI ON A UN ID ALORS ON APPELLE LA FONCTION UPDATE
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                for ($i =1; $i <= 5; $i++) {
                    $filename = $_FILES["photo$i"]['name'];
                    $photo[$i + 1] = $filename;
                    move_uploaded_file($_FILES["photo$i"]['tmp_name'], './images/' . $filename);
                }

                $annonce->update($_POST['id'], $newAnnonce);

                //ENVOIE DU MAIL APRES AVOIR REMPLI LES CHAMPS DU FORMULAIRE
            } else if (isset($_POST['envoyer']) && !empty($_POST['mail'])) {

                $mail = $_POST['mail'];
                print_r($mail);
                $to = $mail;
                $subject = "Vérification annonce";
                ob_start();
                require '../views/blog/formulairemail.php';
                $message = ob_get_clean();
                $message = wordwrap($message, 70, "\r\n");
                // Le destinataire : 
                $headers[] = "From: ibtissem.khiri@gmail.com";
                $headers[] = 'MIME-Version: 1.0';
                $headers[] = 'Content-type: text/html; charset=utf-8';
                if (mail($to, $subject, $message, implode("\r\n", $headers))) {
                    echo 'Votre message a bien été envoyé';
                } else {
                    echo 'Votre message n\'a pas pu être envoyé';
                }

            }
        }

        //header('Location: /annonces/');
    }

}


<?php

namespace App\Controllers;

use App\Models\Annonce;
use App\Models\Mail;


class AnnonceController extends Controller
{
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

    public function edit(int $id)
    {
        $annonce = (new Annonce($this->getDb()))->findById($id);
        return $this->view('blog.formulaire', compact('annonce'));
    }

    public function valid()
    {   session_start();
        // echo "<pre>",print_r($_SESSION),"</pre>"; 
        // error_log("Valid " . print_r($_SESSION,1));
        $annonce = new Annonce($this->getDb());
        $mail = new Mail($this->getDb());
        error_log(print_r($_GET['url'], 1));
$tmp=$_GET['url'];

$tmp=str_replace("valid/","", $tmp);
var_dump($tmp);
    //     $tmp = explode("/", $_GET['url']);

    //     $slugreconstitue="";
    //    for ($i=1; $i<=count($tmp); $i++) {
    //        $slugreconstitue.=$tmp[$i];

    //    }

//        $ivlen=openssl_cipher_iv_length($cipher="AES-256-CBC");
// $iv=openssl_random_pseudo_bytes($ivlen);
// $slugcrypter=openssl_encrypt($slug,"AES-256-CBC","unmotdepassecomplique",$options=OPENSSL_RAW_DATA,$iv);

       $slugdecryte=base64_decode($tmp);
        //print_r($slugdecryte);
         $donnees = explode("/",$slugdecryte);
         var_dump($donnees);
  
        if (!empty($donnees[0])&&($_SESSION['idTmp']==$donnees[0])) {
            //error_log(print_r($_POST,1));

            $newAnnonce = $annonce->setCategorie($donnees[2])
                ->setNom($donnees[3])
                ->setDescription($donnees[5])
                ->setPrix($donnees[4])
                ->setVille($donnees[1])
                ->setphoto1(self::PATH_IMG_ABSOLUTE.$donnees[7])
                ->setphoto2(self::PATH_IMG_ABSOLUTE.$donnees[8])
                ->setphoto3(self::PATH_IMG_ABSOLUTE.$donnees[9])
                ->setphoto4(self::PATH_IMG_ABSOLUTE.$donnees[10])
                ->setphoto5(self::PATH_IMG_ABSOLUTE.$donnees[11]);
            $result = $annonce->insert($newAnnonce);

            $newMail=$mail->setMail($donnees[6])->setId_annonce($result);
            $mail->insert($newMail);
            $to = $donnees[6];
            $subject = 'Annonce ajoutée';
            $message = 'Votre annonce a bien été ajouté';
            $headers = "From: ibtissem.khir@gmail.com";
            mail($to, $subject, $message, $headers);
            unset($_SESSION['idTmp']);
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
            //$countfiles = count($_FILES['file']['name']);
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
         
            // error_log("newAnnonce" . print_r($newAnnonce, 1));
            //ON STOCKE LES DONNES DU FORMULAIRES DANS LE $_SESSION
            //$_SESSION[] = $photo;
      
        
           //error_log("SESSION ".print_r($_SESSION,1));
            //$_SESSION=[$_FILES['file']['name'][0]];
         
            //CONDITION POUR VERIFIER SI ON A UN ID ALORS ON APPELLE LA FONCTION UPDATE
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                for ($i =1; $i <= 5; $i++) {
                    $filename = $_FILES["photo$i"]['name'];
                    $photo[$i + 1] = $filename;
                    move_uploaded_file($_FILES["photo$i"]['tmp_name'], './images/' . $filename);
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


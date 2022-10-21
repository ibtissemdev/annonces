<?php

namespace App\Controllers;

use App\Models\Annonce;
use App\Models\Mail;
use App\Models\Photo;


class AnnonceController extends Controller
{ //lien absolu pour l'image
    public const PATH_IMG_ABSOLUTE = "http://localhost/annonces/public/images/";



    public function index()
    { //Affiche la page d'accueil avec toutes les annonces
        $annonce = new Annonce($this->getDb());
        $annonces = $annonce->findAll();

        return $this->view('blog.index', compact('annonces')); //permet d'envoyer un tableau qui contient nos données qui aura la clée annonces
    }

    public function genPdf()
    { //Affiche la page qui génère le pdf
        // $annonce = new Annonce($this->getDb());
        // $annonces = $annonce->findAll();
        return $this->view('blog.genpdf'); //permet d'envoyer un tableau qui contient nos données qui aura la clée annonces

    }

    public function show(int $id)
    { // Affiche une page de manière dynamique selon l'Id de l'annonce
        $annonce = new Annonce($this->getDb());
        $annonce = $annonce->findById($id);

    $photo= new Photo($this->getDb());
    $listeChemin=$photo->findCheminsById($id);
        return $this->view('blog.show', compact('annonce','listeChemin'));
    }

    public function search()
    { //Barre de recherche selon la catégorie de l'annonce
        $annonce = new Annonce($this->getDb());
        if (isset($_POST['recherche'])) {

            $recherche = $_POST['recherche'];
            $resultat = $annonce->recherche($recherche);
            return $this->view('blog.index', compact('resultat'));
        } else {
            $annonces = $annonce->findAll();
        }
        return $this->view('blog.index', compact('annonces'));
    }

    public function sup(int $id)
    { //Fonction qui supprime selon l'Id
        $annonce = new Annonce($this->getDb());
        $annonce->delete($id);

        header('Location: /annonces/ ');
    }

    public function form()
    { //Affiche le premier formulaire vide (après avoir cliqué sur ajouter)
        $annonce = new Annonce($this->getDb());
        return $this->view('blog.formulaire', compact('annonce'));
    }

    public function formUpdate()
    { //Afficher le formulaire depuis le lien du mail pour modifier l'annonce qui n'est pas encore dans la base de donnée
        $annonce = new Annonce($this->getDb());
        return $this->view('blog.formulairemail', compact('annonce'));
    }
    public function edit(int $id)
    { //Affiche le formulaire prérempli
        $annonce = (new Annonce($this->getDb()))->findById($id);
        return $this->view('blog.formulaire', compact('annonce'));
    }

    public function create()
    { //Formulaire en cliquant sur ajouter dans la page d'accueil
        $annonce = new Annonce($this->getDb());
        $mail = new Mail($this->getDb());

        //CONDITION SI $_POST N'EST PAS VIDE ALORS ON RECUPERE LES DONNEES
        if (!empty($_POST)) {
            //Update des images
            $valid_ext = array("gif", "jpg", "png", "jpeg", "webp", "jfif");
            $maxSize = 2000000;
            for ($i = 1; $i <= 5; $i++) {

                $filename = $_FILES["photo$i"]['name'];
                $location = './images/' . $filename;
                $file_extension = pathinfo($location, PATHINFO_EXTENSION);
                $file_extension = strtolower($file_extension);

                if (in_array($file_extension, $valid_ext)) {
                    if ($_FILES["photo$i"]['size'] < $maxSize) {

                        $photo[$i + 1] = $filename;
                        error_log(print_r($_FILES["photo$i"]['size'], 1));
                        move_uploaded_file($_FILES["photo$i"]['tmp_name'], $location);
                    } else {
                        error_log('taille trop grande : ' . $i);
                        error_log(print_r($_FILES["photo$i"]['size'], 1));
                    }
                } else {
                    error_log('extension non valide');
                }
            }



            // move_uploaded_file($_FILES["photo$i"]['tmp_name'], './images/' . $filename);

            //ON DEFFINIE LES SETTERS
            $newAnnonce = $annonce->setCategorie($_POST['categorie'])
                ->setNom($_POST['nom'])
                ->setDescription($_POST['description'])
                ->setPrix($_POST['prix'])
                ->setVille($_POST['ville'])
                // ->setphoto1($_FILES['photo1']['name'])
                // ->setphoto2($_FILES['photo2']['name'])
                // ->setphoto3($_FILES['photo3']['name'])
                // ->setphoto4($_FILES['photo4']['name'])
                // ->setphoto5($_FILES['photo5']['name']);
                ->setCategorie_id($_POST['categorie']);


            //CONDITION POUR VERIFIER SI ON A UN ID ALORS ON APPELLE LA FONCTION UPDATE
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                //Upload des images qui vont remplacer celles d'origine
                for ($i = 1; $i <= 5; $i++) {
                    $filename = $_FILES["photo$i"]['name'];
                    $photo[$i + 1] = $filename;
                    move_uploaded_file($_FILES["photo$i"]['tmp_name'], './images/' . $filename);
                }

                $annonce->update($_POST['id'], $newAnnonce);

                //ENVOIE DU MAIL APRES AVOIR REMPLI LES CHAMPS ET ENVOYE LE FORMULAIRE
            } else if (isset($_POST['envoyer']) && !empty($_POST['mail'])) {

                $mail = $_POST['mail'];
                // print_r($mail);
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
                if (mail($to, $subject, $message, implode("\r\n", $headers)) == true) {
                    echo 'Vous allez recevoir un e-mail à l\'adresse indiquée pour valider ou modifier votre annonce <a href="/annonces/"><button class="btn btn-secondary">Retour</button></a>';
                } else {
                    echo 'Une erreur est survenue <a href="/annonces/"><button class="btn btn-secondary">Retour</button></a>';
                }
            }
        }

        //header('Location: /annonces/');
    }



    public function valid()
    { // Fonction appelée après que l'utilisateur aie cliqué sur le lien valider dans l'e-mail
        $annonce = new Annonce($this->getDb());
        $mail = new Mail($this->getDb());
        $photo = new Photo($this->getDb());

        //On supprime le mot valid dans l'Url
        $tmp = str_replace("valid/", "", $_GET['url']);
        //Decrypte l'ensemble des données récupérées dans l'url
        $slugcrypter_valid = base64_decode($tmp);
        //on retourne un tableau avec toutes les données qui étaient séparées par un "/"
        $donnees = explode("/", $slugcrypter_valid);

        error_log(print_r(end($donnees), 1));

        //On vérifie que le dernier élément de la chaîne est le mot "valid" => pour valider l'annonce
        if (end($donnees) == "valid") {
            //element constituants les donnees récupérés dans l'Url       0 => idTmp       
            if (!empty($donnees[0]) && ($_COOKIE['idTmp'] == $donnees[0])) {
                $newAnnonce = $annonce
                    ->setVille($donnees[1])                             //1=>ville   
                    ->setCategorie($donnees[2])                         //2=>categorie
                    ->setNom($donnees[3])                               //3=>nom
                    ->setPrix($donnees[4])                              //4=>prix
                    ->setDescription($donnees[5])                       //5=>description
                    // lien de la photo en absolu
                    ->setphoto1(self::PATH_IMG_ABSOLUTE . $donnees[7])    //7=>photo1
                    ->setphoto2(self::PATH_IMG_ABSOLUTE . $donnees[8])    //8=>photo8
                    ->setphoto3(self::PATH_IMG_ABSOLUTE . $donnees[9])    //9=>photo9
                    ->setphoto4(self::PATH_IMG_ABSOLUTE . $donnees[10])   //10=>photo10
                    ->setphoto5(self::PATH_IMG_ABSOLUTE . $donnees[11])  //11=>photo11
                    ->setCategorie_id($donnees[2]);                     //2=>categorie_id

                //Insère l'annonce une fois que l'utilisateur a valider avec l'e-mail
                $result = $annonce->insert($newAnnonce);
                //print_r($newAnnonce);
                //Insertion de l'e-mail dans la table mail avec l'id_annonce
                $newMail = $mail->setMail($donnees[6])->setId_annonce($result);

                // Insertion des photos dans la table photo
                for ($i = 7; $i < 12; $i++) {
                    $newPoto = $photo->setChemin(self::PATH_IMG_ABSOLUTE . $donnees[$i]);
                    $photo->insert($newPoto);
                    $idPhoto = $this->db->getPDO()->lastInsertId();

                    echo "<pre>", print_r($idPhoto, 1), "</pre>";
                    echo "<pre>", print_r($result, 1), "</pre>";

                    $sth = "INSERT INTO liaison_photo (photo_id,annonce_id) VALUES ($idPhoto,$result)";
                    $this->db->getPDO()->exec($sth);
                }



                $mail->insert($newMail);

                //Envoie du deuxième e-mail qui permet d'afficher/modifier/supprimer l'annonce qui vient d'être rentrée dans la bdd          
                $to = $donnees[6];
                $subject = "Votre annonce a été validé";
                ob_start();
                require '../views/blog/mail.sup.php';
                $message = ob_get_clean();
                $message = wordwrap($message, 70, "\r\n");
                // Le destinataire : 
                $headers[] = "From: ibtissem.khiri@gmail.com";
                $headers[] = 'MIME-Version: 1.0';
                $headers[] = 'Content-type: text/html; charset=utf-8';
                if (mail($to, $subject, $message, implode("\r\n", $headers))) {
                    echo 'Votre annonce a été ajouté avec succés, vous allez recevoir un e-mail à l\'adresse indiquée. <a href="/annonces/"><button class="btn btn-secondary">Retour</button></a>';
                } else {
                    echo 'Votre message n\'a pas pu être envoyé';
                }

                //Destruction de la session idTmp
                unset($_COOKIE['idTmp']);
                unset($_COOKIE["PHPSESSID"]);
                setcookie("idTmp", NULL, 0);
                if (isset($_COOKIE)) {

                    var_dump($_COOKIE);
                } else {
                    echo 'le cookie est détruit';
                }
            } else {
                echo 'Le temps imparti est écoulé';
                header('Location: /annonces/?cookie=ecoule');
            }
        }
    }


    public function updateMail()
    {

        error_log("Controller updateMail");
        $annonce = new Annonce($this->getDb());
        $mail = new Mail($this->getDb());
        $photo = new Photo($this->getDb());

        //CONDITION SI $_POST N'EST PAS VIDE ALORS ON RECUPERE LES DONNEES
        if ($_POST && ($_COOKIE['idTmp'] == $_POST['idTmp'])) {
            $nbrPhoto = count($_FILES);


            for ($i = 0; $i <= $nbrPhoto; $i++) {
                $filename = $_FILES["file"]['name'][$i];
                //  $photo[$i + 1] = $filename;
                move_uploaded_file($_FILES["file"]['tmp_name'][$i], './images/' . $filename);
            }
            //ON DEFFINIE LES SETTERS
            $newAnnonce = $annonce->setCategorie($_POST['categorie'])
                ->setNom($_POST['nom'])
                ->setDescription($_POST['description'])
                ->setPrix($_POST['prix'])
                ->setVille($_POST['ville'])
                ->setphoto1(self::PATH_IMG_ABSOLUTE . $_FILES['file']['name'])
                ->setphoto2(self::PATH_IMG_ABSOLUTE . $_FILES['file']['name'])
                ->setphoto3(self::PATH_IMG_ABSOLUTE . $_FILES['file']['name'])
                ->setphoto4(self::PATH_IMG_ABSOLUTE . $_FILES['file']['name'])
                ->setphoto5(self::PATH_IMG_ABSOLUTE . $_FILES['file']['name'])
                ->setCategorie_id($_POST['categorie']);

            //CONDITION POUR VERIFIER SI ON A UN ID ALORS ON APPELLE LA FONCTION UPDATE
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                for ($i = 1; $i <= 5; $i++) {
                    $filename = $_FILES["photo$i"]['name'];
                    $photo[$i + 1] = $filename;
                    move_uploaded_file($_FILES["photo$i"]['tmp_name'], './images/' . $filename);
                }

                $annonce->update($_POST['id'], $newAnnonce);
            } else {

                $result = $annonce->insert($newAnnonce);
                //Insertion de l'e-mail avec l'id_annonce
                $newMail = $mail->setMail($_POST['mail'])
                    ->setId_annonce($result);
                $mail->insert($newMail);



                // Insertion des photos dans la table photo
                $nbrPhoto = count($_FILES);
error_log(print_r($_FILES,1));
                for ($i = 0; $i <= $nbrPhoto; $i++) {
                    $newPoto = $photo->setChemin(self::PATH_IMG_ABSOLUTE . $_FILES['file']['name'][$i]);


                    $photo->insert($newPoto);
                    $idPhoto = $this->db->getPDO()->lastInsertId();

                    echo "<pre>", print_r($idPhoto, 1), "</pre>";
                    echo "<pre>", print_r($result, 1), "</pre>";

                    $sth = "INSERT INTO liaison_photo (photo_id,annonce_id) VALUES ($idPhoto,$result)";
                    $this->db->getPDO()->exec($sth);
                }


                $to = $_POST['mail'];
                $subject = "Votre annonce a été validé";
                ob_start();
                require '../views/blog/mail.sup.php';
                $message = ob_get_clean();
                $message = wordwrap($message, 70, "\r\n");
                // Le destinataire : 
                $headers[] = "From: ibtissem.khiri@gmail.com";
                $headers[] = 'MIME-Version: 1.0';
                $headers[] = 'Content-type: text/html; charset=utf-8';

                error_log($message);

                if (mail($to, $subject, $message, implode("\r\n", $headers))) {
                    error_log($_POST['mail']);
                    echo 'Votre annonce a été ajouté avec succés, vous allez recevoir un e-mail à l\'adresse indiquée. <a href="/annonces/"><button class="btn btn-secondary">Retour</button></a>';
                } else {
                    error_log("erreur");
                    echo 'Votre message n\'a pas pu être envoyé';
                }
            }
        }
    }
}

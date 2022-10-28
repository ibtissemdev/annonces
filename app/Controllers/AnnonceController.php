<?php

namespace App\Controllers;

use App\Models\Annonce;
use App\Models\Mail;
use App\Models\Photo;
use PDO;


class AnnonceController extends Controller
{ //lien absolu pour l'image
    public const PATH_IMG_ABSOLUTE = "http://localhost/annonces/public/images/";



    public function index()
    { //Affiche la page d'accueil avec toutes les annonces

        $annonce = new Annonce($this->getDb());
        $annonces = $annonce->findAll();

        return $this->view('annonce.index', compact('annonces')); //permet d'envoyer un tableau qui contient nos données qui aura la clée annonces
    }

    public function genPdf()
    { //Affiche la page qui génère le pdf
        // $annonce = new Annonce($this->getDb());
        // $annonces = $annonce->findAll();
        return $this->view('annonce.genpdf'); //permet d'envoyer un tableau qui contient nos données qui aura la clée annonces

    }

    // public function recherche()
    // { //Affiche la page qui récupère la recherhe
    //     // $annonce = new Annonce($this->getDb());
    //     // $annonces = $annonce->findAll();
    //     return $this->view('annonce.recherche'); //permet d'envoyer un tableau qui contient nos données qui aura la clée annonces

    // }

    public function show(int $id)
    { // Affiche une page de manière dynamique selon l'Id de l'annonce
        $annonce = new Annonce($this->getDb());
        $annonce = $annonce->findById($id);

        $photo = new Photo($this->getDb());
        $listeChemin = $photo->findCheminsById($id);
        return $this->view('annonce.show', compact('annonce', 'listeChemin'));
    }

    public function search()
    { //Barre de recherche selon la catégorie de l'annonce
        $annonce = new Annonce($this->getDb());
        if (isset($_POST['recherche'])) {

            $recherche = $_POST['recherche'];
            $resultat = $annonce->recherche($recherche);
           
            return $this->view('annonce.index', compact('resultat'));
        } else {
            $annonces = $annonce->findAll();
        }
        return $this->view('annonce.index', compact('annonces'));
    }

    public function sup(int $id)
    { //Fonction qui supprime l'annonce, l'utilisateur, les liaison et les photos selon selon l'Id de l'annonce
        $annonce = new Annonce($this->getDb());
        $mail = new Mail($this->getDb());
        $photo = new Photo($this->getDb());

        //On récupère la liste des photos à supprimer dans la table photos
        $result = $photo->findCheminsById($id);
        // error_log(print_r($result, 1));

        //On leur supprime le path pour ne laisser que le nom du fichier photo et on les stocke dans un tableau
        $photoAsupprimer = [];
        foreach ($result as $photoPourSup) {
            $photoPourSup = str_replace(self::PATH_IMG_ABSOLUTE, "", $photoPourSup->chemin);

            $photoAsupprimer[] = $photoPourSup;
        }

        // error_log(print_r($photoAsupprimer, 1));
        //On parcour le dossier image et on stocke chaque fichier image dans un tableau
        $dir = "images/";
        $dossier = opendir($dir);
        $fichierImage = [];
        while ($fichier = readdir($dossier)) {
            if ($fichier != '.' && $fichier != '..') {
                // error_log(print_r($fichier, 1));
                $fichierImage[] = $fichier;
            }
        }
        foreach ($photoAsupprimer as $aSupprimer) {
            foreach ($fichierImage as $fich) {
                if ($aSupprimer == $fich) {
                    // error_log(print_r("fichier dans table photo : " . $aSupprimer, 1));
                    // error_log(print_r("fichier dans dossier image : " . $fich, 1));
                    unlink("images/" . $fich);
                }
            }
        }

        closedir($dossier);

        foreach ($result as $photoSup) {
            $photo->delete('id_photo', $photoSup->id_photo);
        }
        //    error_log(print_r('photos supprimées',1));

        $annonce->delete("id", $id); //Supression annonce
        $mail->delete("id_annonce", $id); // Suppression email de l'utilisateur qui a créé l'annonce

        //Suppression des liaisons qui correspondent à l'annonce
        $sth = $this->db->getPDO()->prepare("DELETE FROM liaison_photo WHERE annonce_id=$id");
        $sth->execute();

        header('Location: /annonces/ ');
    }

    public function form()
    { //Affiche le premier formulaire vide (après avoir cliqué sur ajouter)
        $annonce = new Annonce($this->getDb());
        return $this->view('annonce.formulaire', compact('annonce'));
    }

    public function formUpdate()
    { //Afficher le formulaire depuis le lien du mail pour modifier l'annonce qui n'est pas encore dans la base de donnée
        $annonce = new Annonce($this->getDb());
        return $this->view('annonce.formulairemail', compact('annonce'));
    }

    public function edit(int $id)
    { //Affiche le formulaire prérempli
        $annonce = (new Annonce($this->getDb()))->findById($id);
        return $this->view('annonce.formulaire', compact('annonce'));
    }

    public function create()
    { //Formulaire en cliquant sur ajouter dans la page d'accueil

        //CONDITION SI $_POST N'EST PAS VIDE ALORS ON RECUPERE LES DONNEES
        if (!empty($_POST)) {
            //Update des images
            $valid_ext = array("gif", "jpg", "png", "jpeg", "webp", "jfif");
            $maxSize = 5000000;
            $nbrPhoto = count($_FILES["file"]['name']);
            // error_log(print_r($_FILES["file"]['name'], 1));

            for ($i = 0; $i <= $nbrPhoto; $i++) {
                $filename = $_FILES["file"]['name'][$i];
                $location = './images/' . $filename;
                $file_extension = pathinfo($location, PATHINFO_EXTENSION);
                $file_extension = strtolower($file_extension);

                if (in_array($file_extension, $valid_ext)) {
                    if ($_FILES["file"]['size'][$i] < $maxSize) {
                        // error_log(print_r($_FILES["file"]['size'][$i], 1));
                    } else {
                        echo 'taille trop grande ! ';
                    }
                } else {
                    echo 'extension non valide ! ';
                }
                move_uploaded_file($_FILES["file"]['tmp_name'][$i], $location);
            }


            //     //ENVOIE DU MAIL APRES AVOIR REMPLI LES CHAMPS ET ENVOYE LE FORMULAIRE
            // } else 
            if (isset($_POST['envoyer']) && !empty($_POST['mail'])) {

                $mail = $_POST['mail'];
                // print_r($mail);
                $to = $mail;
                $subject = "Vérification annonce";
                ob_start();
                require '../views/annonce/formulairemail.php';
                $message = ob_get_clean();
                $message = wordwrap($message, 70, "\r\n");
                // Le destinataire : 
                $headers[] = "From: ibtissem.khiri@gmail.com";
                $headers[] = 'MIME-Version: 1.0';
                $headers[] = 'Content-type: text/html; charset=utf-8';
                if (mail($to, $subject, $message, implode("\r\n", $headers)) == true) {
                    echo 'Vous allez recevoir un e-mail à l\'adresse indiquée pour valider ou modifier votre annonce <a href="/annonces/"><button class="btn btn-secondary">Retour</button></a>';
                } else {
                    // echo 'Une erreur est survenue <a href="/annonces/"><button class="btn btn-secondary">Retour</button></a>';
                    header('Location: /annonces/ ');
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
        //Decode l'ensemble des données récupérées dans l'url
        $slugEncode_valid = base64_decode($tmp);
        //on retourne un tableau avec toutes les données qui étaient séparées par un "/"
        $donnees = explode("/", $slugEncode_valid);

        // error_log(print_r(end($donnees), 1));

        //On vérifie que le dernier élément de la chaîne est le mot "valid" => pour valider l'annonce
        if (end($donnees) == "valid") {
            //element constituants les donnees récupérés dans l'Url       0 => idTmp       
            if (!empty($donnees[0]) && ($_COOKIE['idTmp'] == $donnees[0])) {
                $newAnnonce = $annonce
                    ->setVille($donnees[1])                             //1=>ville
                    ->setCategorie_id($donnees[2])                      //2=>id_categorie
                    ->setNom($donnees[3])                               //3=>nom
                    ->setPrix($donnees[4])                              //4=>prix
                    ->setDescription($donnees[5]);                      //5=>description

                //Insère l'annonce une fois que l'utilisateur a valider avec l'e-mail
                $result = $annonce->insert($newAnnonce);
                //print_r($newAnnonce);

                //Insertion de l'e-mail dans la table mail avec l'id_annonce
                $newMail = $mail->setMail($donnees[6])->setId_annonce($result);
                $mail->insert($newMail);

                $compteur = count($donnees) - 2;
                // error_log(print_r("nombre de données : " . count($donnees), 1));
                // Insertion des photos dans la table photo
                for ($i = 7; $i < $compteur; $i++) {
                    $newPoto = $photo->setChemin(self::PATH_IMG_ABSOLUTE . $donnees[$i]);
                    $photo->insert($newPoto);
                    $idPhoto = $this->db->getPDO()->lastInsertId();
                    // echo "<pre>", print_r($idPhoto, 1), "</pre>";

                    $sth = "INSERT INTO liaison_photo (photo_id,annonce_id) VALUES ($idPhoto,$result)";
                    $this->db->getPDO()->exec($sth);
                }


                //Envoie du deuxième e-mail qui permet d'afficher/modifier/supprimer l'annonce qui vient d'être rentrée dans la bdd          
                $to = $donnees[6];
                $subject = "Votre annonce a été validé";
                ob_start();
                require '../views/annonce/mail.sup.php';
                $message = ob_get_clean();
                $message = wordwrap($message, 70, "\r\n");
                // Le destinataire : 
                $headers[] = "From: ibtissem.khiri@gmail.com";
                $headers[] = 'MIME-Version: 1.0';
                $headers[] = 'Content-type: text/html; charset=utf-8';
                if (mail($to, $subject, $message, implode("\r\n", $headers))) {
                    echo 'Votre annonce a été ajouté avec succés, vous allez recevoir un e-mail à l\'adresse indiquée. <a href="/annonces/"><button class="btn btn-secondary">Retour</button></a>';
                } else {
                    // echo 'Votre message n\'a pas pu être envoyé';
                    header('Location: /annonces/ ');
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

                $photo = new Photo($this->getDb());
                //On récupère la liste des photos à supprimer dans la table photos
                $result = $photo->findAllChemin();

                //On leur supprime le path pour ne laisser que le nom du fichier et on les stocke dans un tableau
                $photoAsupprimer = [];
                foreach ($result as $photoPourSup) {
                    $photoPourSup = str_replace(self::PATH_IMG_ABSOLUTE, "", $photoPourSup->chemin);
                    $photoAsupprimer[] = $photoPourSup;
                }
                //  error_log(print_r($photoAsupprimer, 1));
                //On parcourt le dossier images/ et on stocke chaque fichier image dans un tableau
                $dir = "images/";
                $dossier = opendir($dir);
                $fichierImage = [];
                while ($fichier = readdir($dossier)) {
                    if ($fichier != '.' && $fichier != '..') {
                        // error_log(print_r($fichier, 1));
                        $fichierImage[] = $fichier;
                    }
                }
                //Je récupère un tableau avec la liste des images qui ne  se trouvent pas dans l'un des deux tableaux
                $imagesAsupprimer = array_diff($fichierImage, $photoAsupprimer);

                foreach ($imagesAsupprimer as $aSupprimer) {
                    // error_log(print_r("fichier dans table photo : " . $aSupprimer, 1));
                    unlink("images/" . $aSupprimer);
                    // error_log(print_r("images dans dossier image supprimées", 1));
                }
                closedir($dossier);


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
        //ON DEFFINIE LES SETTERS


        $valid_ext = array("gif", "jpg", "png", "jpeg", "webp", "jfif");
        $maxSize = 5000000;

        //CONDITION SI $_POST N'EST PAS VIDE ALORS ON RECUPERE LES DONNEES
        if ($_POST && ($_COOKIE['idTmp'] == $_POST['idTmp']) && empty($_POST['id'])) {

            $newAnnonce = $annonce->setNom($_POST['nom'])
                ->setDescription($_POST['description'])
                ->setPrix($_POST['prix'])
                ->setVille($_POST['ville'])
                ->setCategorie_id($_POST['categorie']);
            $nbrPhoto = count($_FILES["file"]['name']);
            // error_log(print_r($_FILES["file"]['name'], 1));

            for ($i = 0; $i <= $nbrPhoto; $i++) {
                $filename = $_FILES["file"]['name'][$i];
                $location = './images/' . $filename;
                $file_extension = pathinfo($location, PATHINFO_EXTENSION);
                $file_extension = strtolower($file_extension);

                if (in_array($file_extension, $valid_ext)) {
                    if ($_FILES["file"]['size'][$i] < $maxSize) {
                        // error_log(print_r($_FILES["file"]['size'][$i], 1));
                    } else {
                        echo 'taille trop grande ! ';
                    }
                } else {
                    echo 'extension non valide ! ';
                }
                move_uploaded_file($_FILES["file"]['tmp_name'][$i], $location);
            }

            $result = $annonce->insert($newAnnonce);
            //Insertion de l'e-mail avec l'id_annonce
            $newMail = $mail->setMail($_POST['mail'])
                ->setId_annonce($result);
            $mail->insert($newMail);

            // Insertion des photos dans la table photo
            $nbrPhoto = count($_FILES["file"]['name']);
            // error_log(print_r($_FILES, 1));
            for ($i = 0; $i <= $nbrPhoto; $i++) {

                $newPoto = $photo->setChemin(self::PATH_IMG_ABSOLUTE . $_FILES['file']['name'][$i]);
                $photo->insert($newPoto);
                $idPhoto = $this->db->getPDO()->lastInsertId();
                // echo "<pre>", print_r($idPhoto, 1), "</pre>";
                // echo "<pre>", print_r($result, 1), "</pre>";
                $sth = "INSERT INTO liaison_photo (photo_id,annonce_id) VALUES ($idPhoto,$result)";
                $this->db->getPDO()->exec($sth);
            }

            $to = $_POST['mail'];
            $subject = "Votre annonce a été validé";
            ob_start();
            require '../views/annonce/mail.sup.php';
            $message = ob_get_clean();
            $message = wordwrap($message, 70, "\r\n");
            // Le destinataire : 
            $headers[] = "From: ibtissem.khiri@gmail.com";
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=utf-8';

            if (mail($to, $subject, $message, implode("\r\n", $headers))) {
                error_log($_POST['mail']);
                echo 'Votre annonce a été ajouté avec succés, vous allez recevoir un e-mail à l\'adresse indiquée. <a href="/annonces/"><button class="btn btn-secondary">Retour</button></a>';
            } else {
                error_log("Votre message n\'a pas pu être envoyé");
                echo 'Votre message n\'a pas pu être envoyé';
            }
        }

        //CONDITION POUR VERIFIER SI ON A UN ID ALORS ON APPELLE LA METHOD UPDATE
        if (isset($_POST['id']) && !empty($_POST['id'])) {


            $idAnnonce = $_POST['id'];
            $newAnnonce = $annonce->setNom($_POST['nom'])
                ->setDescription($_POST['description'])
                ->setPrix($_POST['prix'])
                ->setVille($_POST['ville'])
                ->setCategorie_id($_POST['categorie']);

            //On récupère la liste des photos à supprimer dans la table photos
            $result = $photo->findCheminsById($idAnnonce);
            // error_log(print_r($result, 1));

            foreach ($result as $photoSup) {
                $photo->delete('id_photo', $photoSup->id_photo); //On les supprime
            }

            //Suppression des liaisons qui correspondent à l'annonce
            $sth = $this->db->getPDO()->prepare("DELETE FROM liaison_photo WHERE annonce_id=$idAnnonce");
            $sth->execute();
            error_log(print_r($newAnnonce, 1));
            //Modification de l'annonce dans la table annonce
            $annonce->update($idAnnonce, $newAnnonce);


            //Upload des images 
            $nbrPhoto = count($_FILES["file"]['name']);
            // error_log(print_r($_FILES["file"]['name'], 1));

            for ($i = 0; $i < $nbrPhoto; $i++) {
                $filename = $_FILES["file"]['name'][$i];
                $location = './images/' . $filename;
                $file_extension = pathinfo($location, PATHINFO_EXTENSION);
                $file_extension = strtolower($file_extension);

                if (in_array($file_extension, $valid_ext)) {
                    if ($_FILES["file"]['size'][$i] < $maxSize) {
                        // error_log(print_r($_FILES["file"]['size'][$i], 1));
                    } else {
                        echo 'taille trop grande ! ';
                    }
                } else {
                    echo 'extension non valide ! ';
                }
                move_uploaded_file($_FILES["file"]['tmp_name'][$i], $location);
            }

            //Insértion des chemins des photos dans la table photo et les liaisons dans la table liaison
            for ($i = 0; $i < $nbrPhoto; $i++) {

                $filename = $_FILES["file"]['name'][$i];
                //  error_log(print_r($filename, 1));
                $newPoto = $photo->setChemin(self::PATH_IMG_ABSOLUTE . $filename);
                $photo->insert($newPoto);
                $idPhoto = $this->db->getPDO()->lastInsertId();

                $sth = "INSERT INTO liaison_photo (photo_id,annonce_id) VALUES ($idPhoto,$idAnnonce)";
                $this->db->getPDO()->exec($sth);
            }

            header('Location: /annonces/ ');
        }
    }
}

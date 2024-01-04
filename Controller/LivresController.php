<?php

class LivresController{

    private $livreManager;

    public function __construct() {
        require_once "Models/LivreManager.php";
        $this->livreManager = new LivreManager;
        $this->livreManager->chargementLivres();
    }

    public function afficherLivres(){
        $livres = $this->livreManager->getLivres();
        require "Views/livres.view.php";
    }

    public function afficherLivre($id){
        $livre = $this->livreManager->getLivreById($id);
        require "Views/afficherLivre.view.php";
    }

    public function ajoutLivre(){
        require "Views/ajoutLivre.view.php";
    }

    public function ajoutLivreValidation(){
        $file = $_FILES["image"];
        $repertoire = "public/images/";
        $nomImageAjoutee = $this->ajoutImage($file, $repertoire);

        $this->livreManager->ajoutLivreBD($_POST['titre'], $_POST['nbPages'], $nomImageAjoutee);
        header('Location: '.URL."livres");
    }

    private function ajoutImage($file, $dir){
        if(!isset($file['name']) || empty($file['name']))
            throw new Exception("Vous devez indiquer une image");
        if(!file_exists($dir)) mkdir($dir,0777);
        
        $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
        do {
            $random = rand(0,99999);
            $target_file = $dir.$random."_".$file['name'];
        } while (file_exists($target_file));
        
        if(!getimagesize($file["tmp_name"]))
            throw new Exception("Le fichier n'est pas une image");
        if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif")
            throw new Exception("L'extension du fichier n'est pas reconnu");
        if($file['size'] > 500000)
            throw new Exception("Le fichier est trop gros");
        if(!move_uploaded_file($file['tmp_name'], $target_file))
            throw new Exception("l'ajout de l'image n'a pas fonctionné");
        else return ($random."_".$file['name']);
    }

    public function suppressionLivre($id){
        $nomImage = $this->livreManager->getLivreById($id)->getImage();
        $target_file = "public/images/".$nomImage;
        if(file_exists($target_file)) unlink($target_file);
        $this->livreManager->suppressionLivreBD($id);
        header('Location: '.URL."livres");
    }

    public function modifierLivre($id){
        $livre = $this->livreManager->getLivreById($id);
        require "Views/modifierLivre.view.php";
    }

    public function modifierLivreValidation(){
        $imageActuelle = $this->livreManager->getLivreById($_POST["identifiant"])->getImage();
        $file = $_FILES['image'];
        if ($file['size'] > 0) {
            unlink("public/images/".$imageActuelle);
            $repertoire = "public/images/";
            $nomImageAjoutee = $this->ajoutImage($file, $repertoire);
        } else {
            $nomImageAjoutee = $imageActuelle;
        }
        $this->livreManager->modifLivreBD($_POST['identifiant'], $_POST['titre'], $_POST['nbPages'], $nomImageAjoutee);
        header('Location: '.URL."livres");
    }
}
<?php

require_once "Model.class.php";
require_once "Livre.class.php";

class LivreManager extends BDConnexion{
    private $livres;

    public function ajoutLivre($livre){
        $this->livres[] = $livre;
    }

    public function getLivres(){
        return $this->livres;
    }

    public function chargementLivres(){
        $req = $this->getBDD()->prepare('SELECT * FROM livres');
        $req->execute();
        $mesLivres = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();

        foreach($mesLivres as $value){
            $book = new Livre($value['idLivre'], $value['titre'], $value['nbPages'], $value['image']);
            $this->ajoutLivre($book);
        }
    }

    public function getLivreById($id){
        for ($i=0; $i < count($this->livres); $i++) {
            if ($this->livres[$i]->getId() == $id) {
                return $this->livres[$i];
            }
        }
    }

    public function ajoutLivreBD($titre, $nbPages, $image){
        $req = "INSERT INTO livres(titre, nbPages, image) VALUES (:titre, :nbPages, :image)";

        $stmt = $this->getBDD()->prepare($req);
        $stmt->bindValue(":titre", $titre, PDO::PARAM_STR);
        $stmt->bindValue(":nbPages", $nbPages, PDO::PARAM_INT);
        $stmt->bindValue(":image", $image, PDO::PARAM_STR);
        
        $resultat = $stmt->execute();
        $stmt->closeCursor();

        if($resultat > 0){
            $livre = new Livre($this->getBDD()->lastInsertId(), $titre, $nbPages, $image);
            $this->ajoutLivre($livre);
        }
    }

    public function suppressionLivreBD($id){
        $req = "DELETE FROM livres WHERE idLivre = :idLivre";
        $stmt = $this->getBDD()->prepare($req);
        $stmt->bindValue(":idLivre", $id, PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();

        if($resultat > 0){
            $livre = $this->getLivreById($id);
            unset($livre);
        }
    }

    public function modifLivreBD($id, $titre, $nbPages, $image) {
        $req = "UPDATE livres SET titre = :titre, nbPages = :nbPages, image = :image WHERE idLivre = :idLivre";
        $stmt = $this->getBDD()->prepare($req);
        $stmt->bindValue(":idLivre", $id, PDO::PARAM_INT);
        $stmt->bindValue(":titre", $titre, PDO::PARAM_STR);
        $stmt->bindValue(":nbPages", $nbPages, PDO::PARAM_INT);
        $stmt->bindValue(":image", $image, PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();

        if($resultat > 0){
            $this->getLivreById($id)->setTitre($titre);
            $this->getLivreById($id)->setNbPages($nbPages);
            $this->getLivreById($id)->setImage($image);
        }
    }

}
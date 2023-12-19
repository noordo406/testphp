<?php

class Livre {

    public function __construct(private $idLivre, private $titre, private $nbPages, private $image)
    {
    }

    public function getId()               {return $this->idLivre;}
    public function getTitre()            {return $this->titre;}
    public function getNbPages()          {return $this->nbPages;}
    public function getImage()            {return $this->image;}

    public function setId($id)            {$this->idLivre = $id;}
    public function setTitre($titre)      {$this->titre = $titre;}
    public function setNbPages($nbPages)  {$this->nbPages = $nbPages;}
    public function setImage($image)      {$this->image = $image;}

    
}
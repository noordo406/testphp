<?php

define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once "Controller/LivresController.php";
$livreController = new LivresController;

try {
    if (empty($_GET['page'])) {
        require "Views/accueil.view.php";
    } else {
        $url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);
        switch ($url[0]) {
            case "accueil":
                require "Views/accueil.view.php";
                break;
            case "livres":
                if (empty($url[1])) {
                    $livreController->afficherLivres();
                } else if ($url[1] === "l") {
                    echo $livreController->afficherLivre(intval($url[2]));
                } else if ($url[1] === "a") {
                    echo $livreController->ajoutLivre();
                } else if ($url[1] === "m") {
                    echo "modification d'un livre";
                } else if ($url[1] === "s") {
                    echo "suppression d'un livre";
                } else if ($url[1] === "av") {
                    echo $livreController->ajoutLivreValidation();
                }else {
                    throw new Exception("La page n'existe pas");
                }
                break;
            default:
                throw new Exception("La page n'existe pas");
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

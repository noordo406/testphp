<?php ob_start() ?>

<form method="POST" action="<?= URL ?>livres/mv" enctype="multipart/form-data">
    <label for="titre">Titre :</label><br>
    <input type="text" id="titre" name="titre" value="<?= $livre->getTitre();?>"><br>
    <label for="nbPages">Nombre de pages :</label><br>
    <input type="number" id="nbPages" name="nbPages" value="<?= $livre->getNbPages();?>"><br><br>
    <label for="image">Image :</label><br>
    <img src="<?=URL?>public/images/<?= $livre->getImage();?>" alt="" class="imgpreview"><br>
    <input type="file" id="image" name="image"><br><br>
    <input type="hidden" name="identifiant" value="<?= $livre->getId(); ?>">
    <input type="submit" value="Valider">
</form>


<?php
$titre = "Modification du livre \"".$livre->getTitre()."\"";
$content = ob_get_clean();
require "template.php";
?>
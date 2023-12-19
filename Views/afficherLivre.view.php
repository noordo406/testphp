<?php ob_start()?>

<table>
    <tr>
        <th>Image</th>
        <th>Titre</th>
        <th>Nombre de pages</th>
    </tr>
    <tr>
        <td><img src="<?= URL ?>public/images/<?=$livre->getImage(); ?>" alt=""></td>
        <td><?= $livre->getTitre(); ?></td>
        <td><?= $livre->getNbPages(); ?></td>
    </tr>
</table>

<?php
$titre = "Affichage d'un livre";
$content = ob_get_clean();
require "template.php";
?>
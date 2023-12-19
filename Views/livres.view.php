<?php ob_start()?>

<table>
    <tr>
        <th>Image</th>
        <th>Titre</th>
        <th>Nombre de pages</th>
        <th>Actions</th>
    </tr>
    <?php
    for ($i = 0; $i < count($livres); $i++) : ?>
        <tr>
            <td><img src="<?=URL?>public/images/<?= $livres[$i]->getImage(); ?>" alt=""></td>
            <td><a href="<?=URL?>livres/l/<?= $livres[$i]->getId();?>"><?= $livres[$i]->getTitre(); ?></a></td>
            <td><?= $livres[$i]->getNbPages(); ?></td>
            <td>
                <!-- Divisez la colonne "Actions" en deux sous-colonnes -->
                <button>Modifier</button>
                <button>Supprimer</button>
            </td>
        </tr>
    <?php endfor; ?>
</table>
<a href="<?= URL ?>livres/a"><button class="ajouter">Ajouter</button></a>


<?php
$titre = "Les livres de la bibliothèque";
$content = ob_get_clean();
require "template.php";
?>
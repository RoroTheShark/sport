<?php ob_start(); ?>
        <a href="index.php?domain=sport&action=list&type=equipments&all=<?= $all == 1 ? 0 : 1 ?>"><?= $all == 1 ? "Avec juste le matériel utilisé" : "Avec tout le matériel" ?></a>
        <table class="materiels">
            <thead>
	            <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Marque</th>
                    <th>Défaut</th>
                    <th>Valeur</th>
                    <th>Date d'achat</th>
                    <th>Lien</th>
                    <th>Commentaire</th>
                    <th>Sports</th>
                    <th>Nombre séances</th>
                    <th>Distance</th>
                    <th>Temps</th>
                    <th>Action</th>
	            </tr>
            </thead>
            <tbody>
<?php
    $idEquipmentSubTypePrec = 0;
    foreach($equipments as $equipment) {
        if($equipment->getEquipmentSubType()->getId() != $idEquipmentSubTypePrec) {
?>
                <tr class="categorie">
                    <th colspan="13" align="center"><?= $equipment->getEquipmentSubType()->getEquipmentType()->getName() ?> / <?= $equipment->getEquipmentSubType()->getName() ?></th>
                </tr>
<?php
    }
?>
                <tr class="value">
                    <td><?= $equipment->getId() ?></td>
                    <td><?= $equipment->getName() ?></td>
                    <td><?= $equipment->getBrand()->getName() ?></td>
                    <td><?= $equipment->isDefault() ? "Oui" : "Non" ?></td>
                    <td><?= $equipment->getValue() ?>€</td>
                    <td><?= $equipment->getDatePurchase() ? $equipment->getDatePurchase()->format("d/m/Y") : "" ?></td>
                    <td><?php if($equipment->getLink()) { ?><a href="<?= $equipment->getLink() ?>" target="_blank">Lien</a><?php } ?></td>
                    <td><?= $equipment->getComment() ?></td>
                    <td><?= implode(", ",array_map(function($s){return $s->getName();},$equipment->getSports())) ?></td>
                    <td><?= $equipment->getWorkoutsNumber() ?></td>
                    <td><?= $equipment->getWorkoutsSumDistance() ?></td>
                    <td><?= $equipment->getWorkoutsSumTime() ?></td>
                    <td><a href="index.php?domain=sport&action=form&type=equipment&idEquipment=<?= $equipment->getId() ?>">Modifier</a></td>
                </tr>
<?php
        $idEquipmentSubTypePrec = $equipment->getEquipmentSubType()->getId();
    }
?>
            	<tr>
            		<td colspan="4">
            			<a href="index.php?domain=sport&action=form&type=equipment&idEquipment=0">Ajouter un équipement</a>
            		</td>
            	</tr>
            </tbody>
        </table>
<?php $content = ob_get_clean(); ?>

<?php $title = 'Liste des équipements'; ?>
<?php require('layout.php') ?>
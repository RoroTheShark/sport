<?php ob_start(); ?>
        <table border="1">
            <thead>
	            <tr>
	                <th>Nom</th>
	                <th>Monts</th>
	                <th>Routes</th>
	                <th>Nombre passages</th>
	                <th>Action</th>
	            </tr>
            </thead>
            <tbody>
            <?php foreach($countries as $country) { ?>
                <tr>
                    <td rowspan="<?= 1+$country->getNumberMounts()+$country->getNumberRoads(); ?>"><?= $country->getName() ?></td>
                    <td colspan="3">
                        <?= $country->getMountsRoadsWorkoutsSumNumber() ?> / <a href="index.php?domain=sport&action=form&type=country&origin=mounts&idCountry=<?= $country->getId() ?>">Modifier</a> / <a href="index.php?domain=sport&action=form&type=mount&idCountry=<?= $country->getId() ?>&idMount=0">Ajouter un mont</a>
                    </td>
                </tr>
                <?php foreach($country->getMounts() as $mount) { ?>
	                <tr>
	                    <td rowspan="<?= 1+count($mount->getRoads()) ?>"><?= $mount->getName() ?></td>
	                    <td colspan="2">
	                    	<?= $mount->getRoadsWorkoutsSumNumber() ?> / <a href="index.php?domain=sport&action=form&type=mount&idCountry=<?= $country->getId() ?>&idMount=<?= $mount->getId() ?>">Modifier</a> / <a href="index.php?domain=sport&action=form&type=road&idMount=<?= $mount->getId() ?>&idRoad=0">Ajouter une route</a>
	                    </td>
	                </tr>
	                <?php foreach($mount->getRoads() as $road) { ?>
	                <tr>
	                    <td><?= $road->getName() ?></td>
	                    <td><?= $road->getWorkoutsSumNumber() ?></td>
	                    <td>
	                        <a href="index.php?domain=sport&action=form&type=road&idMount=<?= $mount->getId() ?>&idRoad=<?= $road->getId() ?>">Modifier</a>
	                    </td>
	                </tr>
	                <?php } ?>
                <?php } ?>
            <?php } ?>
            	<tr>
            		<td colspan="4">
            			<a href="index.php?domain=sport&action=form&type=country&origin=mounts&idCountry=0">Ajouter un pays</a>
            		</td>
            	</tr>
            </tbody>
        </table>
<?php $content = ob_get_clean(); ?>

<?php $title = 'Liste des monts'; ?>
<?php require('layout.php') ?>
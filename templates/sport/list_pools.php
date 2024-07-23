<?php ob_start(); ?>
        <table border="1">
            <thead>
	            <tr>
	                <th>Nom</th>
	                <th>Ville</th>
	                <th>Pays</th>
	                <th>Nombre</th>
	                <th>Action</th>
	            </tr>
            </thead>
            <tbody>
            <?php foreach($countries as $country) { ?>
                <tr>
                    <td rowspan="<?= 1+$country->getNumberCities()+$country->getNumberPools(); ?>"><?= $country->getName() ?></td>
                    <td colspan="3">
                        <?= $country->getCitiesPoolsWorkoutsSumNumber() ?> / <a href="index.php?domain=sport&action=form&type=country&origin=pools&idCountry=<?= $country->getId() ?>">Modifier</a> / <a href="index.php?domain=sport&action=form&type=city&idCountry=<?= $country->getId() ?>&idCity=0">Ajouter une ville</a>
                    </td>
                </tr>
                <?php foreach($country->getCities() as $city) { ?>
	                <tr>
	                    <td rowspan="<?= 1+count($city->getPools()) ?>"><?= $city->getName() ?></td>
	                    <td colspan="2">
	                    	<?= $city->getPoolsWorkoutsSumNumber() ?> / <a href="index.php?domain=sport&action=form&type=city&idCountry=<?= $country->getId() ?>&idCity=<?= $city->getId() ?>">Modifier</a> / <a href="index.php?domain=sport&action=form&type=pool&idCity=<?= $city->getId() ?>&idPool=0">Ajouter une piscine</a>
	                    </td>
	                </tr>
	                <?php foreach($city->getPools() as $pool) { ?>
	                <tr>
	                    <td><?= $pool->getName() ?></td>
	                    <td><?= $pool->getWorkoutsNumber() ?></td>
	                    <td>
	                        <a href="index.php?domain=sport&action=form&type=pool&idCity=<?= $city->getId() ?>&idPool=<?= $pool->getId() ?>">Modifier</a>
	                    </td>
	                </tr>
	                <?php } ?>
                <?php } ?>
            <?php } ?>
            	<tr>
            		<td colspan="4">
            			<a href="index.php?domain=sport&action=form&type=country&origin=pools&idCountry=0">Ajouter un pays</a>
            		</td>
            	</tr>
            </tbody>
        </table>
<?php $content = ob_get_clean(); ?>

<?php $title = 'Liste des piscines'; ?>
<?php require('layout.php') ?>
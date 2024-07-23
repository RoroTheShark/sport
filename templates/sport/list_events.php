<?php ob_start(); ?>
        <table border="1">
            <thead>
	            <tr>
					<th>Id</th>
					<th>Nom</th>
					<th>Date début</th>
					<th>Date fin</th>
					<th>Action</th>
	            </tr>
            </thead>
            <tbody>
            <?php foreach($events as $event) { ?>
                <tr>
                    <td><?= $event->getId() ?></td>
                    <td><?= $event->getName() ?></td>
                    <td><?= $event->getDateStart()->format("d/m/Y") ?></td>
                    <td><?= $event->getDateEnd()->format("d/m/Y") ?></td>
                    <td><a href="index.php?domain=sport&action=form&type=event&idEvent=<?= $event->getId() ?>">Modifier</a></td>
                </tr>
            <?php } ?>
            	<tr>
            		<td colspan="4">
            			<a href="index.php?domain=sport&action=form&type=event&idEvent=0">Ajouter un évènement</a>
            		</td>
            	</tr>
            </tbody>
        </table>
<?php $content = ob_get_clean(); ?>

<?php $title = 'Liste des évènements'; ?>
<?php require('layout.php') ?>
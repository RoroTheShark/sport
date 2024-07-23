<?php ob_start(); ?>
        <table border="1">
            <thead>
	            <tr>
					<th>Id</th>
					<th>Nom</th>
					<th>Action</th>
	            </tr>
            </thead>
            <tbody>
            <?php foreach($partners as $partner) { ?>
                <tr>
                    <td><?= $partner->getId() ?></td>
                    <td><?= $partner->getName() ?></td>
                    <td><a href="index.php?domain=sport&action=form&type=partner&idPartner=<?= $partner->getId() ?>">Modifier</a></td>
                </tr>
            <?php } ?>
            	<tr>
            		<td colspan="4">
            			<a href="index.php?domain=sport&action=form&type=partner&idPartner=0">Ajouter un partenaire</a>
            		</td>
            	</tr>
            </tbody>
        </table>
<?php $content = ob_get_clean(); ?>

<?php $title = 'Liste des partenaires'; ?>
<?php require('layout.php') ?>
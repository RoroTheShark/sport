<?php ob_start(); ?>
		<form action="index.php?domain=sport" method="POST">
			<div>
				<span>Nom : </span>
				<span><input type="text" name="name" id="name" value="<?= $brand->getName() ?>" /></span>
			</div>
			<input type="hidden" name="action" value="save" />
			<input type="hidden" name="type" value="brand" />
			<input type="hidden" name="idEquipment" value="<?= $idEquipment ?>" />
			<input type="hidden" name="id" value="<?= $brand->getId() ?>" />
			<input type="submit" value="Valider" class="submit" />
		</form>
		<div>
			<a href="index.php?domain=sport&action=form&type=equipment&idEquipment=<?= $idEquipment ?>">Retour au formulaire d'équipement</a>
		</div>
<?php $content = ob_get_clean(); ?>

<?php $title = 'Formulaire de marque'; ?>
<?php require('layout.php') ?>
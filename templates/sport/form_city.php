<?php ob_start(); ?>
		<form action="index.php?domain=sport" method="POST">
			<div>
				<span>Nom : </span>
				<span><input type="text" name="name" id="name" value="<?= $city->getName() ?>" /></span>
			</div>
			<input type="hidden" name="action" value="save" />
			<input type="hidden" name="type" value="city" />
			<input type="hidden" name="idCountry" value="<?= $city->getCountry()->getId() ?>" />
			<input type="hidden" name="id" value="<?= $city->getId() ?>" />
			<input type="submit" value="Valider" class="submit" />
		</form>
		<div>
			<a href="index.php?domain=sport&action=list&type=pools">Retour à la liste des piscines</a>
		</div>
<?php $content = ob_get_clean(); ?>

<?php $title = 'Formulaire de ville'; ?>
<?php require('layout.php') ?>
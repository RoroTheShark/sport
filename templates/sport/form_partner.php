<?php ob_start(); ?>
		<form action="index.php?domain=sport" method="POST">
			<div>
				<span>Nom : </span>
				<span><input type="text" name="name" id="name" value="<?= $partner->getName() ?>" /></span>
			</div>
			<input type="hidden" name="action" value="save" />
			<input type="hidden" name="type" value="partner" />
			<input type="hidden" name="id" value="<?= $partner->getId() ?>" />
			<input type="submit" value="Valider" class="submit" />
		</form>
		<div>
			<a href="index.php?domain=sport&action=list&type=partners">Retour à la liste des partenaires</a>
		</div>
<?php $content = ob_get_clean(); ?>

<?php $title = 'Formulaire d\'évènement'; ?>
<?php require('layout.php') ?>
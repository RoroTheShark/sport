<?php ob_start(); ?>
		<form action="index.php?domain=sport" method="POST">
			<div>
				<span>Nom : </span>
				<span><input type="text" name="name" id="name" value="<?= $road->getName() ?>" /></span>
			</div>
			<input type="hidden" name="action" value="save" />
			<input type="hidden" name="type" value="road" />
			<input type="hidden" name="idMount" value="<?= $road->getMount()->getId() ?>" />
			<input type="hidden" name="id" value="<?= $road->getId() ?>" />
			<input type="submit" value="Valider" class="submit" />
		</form>
		<div>
			<a href="index.php?domain=sport&action=list&type=mounts">Retour à la liste des monts et cols</a>
		</div>
<?php $content = ob_get_clean(); ?>

<?php $title = 'Formulaire de route'; ?>
<?php require('layout.php') ?>
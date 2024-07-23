<?php ob_start(); ?>
		<form action="index.php?domain=sport" method="POST">
			<div>
				<span>Nom : </span>
				<span><input type="text" name="name" id="name" value="<?= $pool->getName() ?>" /></span>
			</div>
			<input type="hidden" name="action" value="save" />
			<input type="hidden" name="type" value="pool" />
			<input type="hidden" name="idCity" value="<?= $pool->getCity()->getId() ?>" />
			<input type="hidden" name="id" value="<?= $pool->getId() ?>" />
			<input type="submit" value="Valider" class="submit" />
		</form>
		<div>
			<a href="index.php?domain=sport&action=list&type=pools">Retour à la liste des monts et cols</a>
		</div>
<?php $content = ob_get_clean(); ?>

<?php $title = 'Formulaire de piscine'; ?>
<?php require('layout.php') ?>
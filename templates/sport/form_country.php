<?php ob_start(); ?>
		<form action="index.php?domain=sport" method="POST">
			<div>
				<span>Nom : </span>
				<span><input type="text" name="name" id="name" value="<?= $country->getName() ?>" /></span>
			</div>
			<input type="hidden" name="action" value="save" />
			<input type="hidden" name="type" value="country" />
			<input type="hidden" name="origin" value="<?= $origin; ?>" />
			<input type="hidden" name="id" value="<?= $country->getId() ?>" />
			<input type="submit" value="Valider" class="submit" />
		</form>
		<div>
	<?php if($origin == 'mounts') { ?>
			<a href="index.php?domain=sport&action=list&type=mounts">Retour à la liste des monts et cols</a>
	<?php } else if($origin == 'pools') { ?>
			<a href="index.php?domain=sport&action=list&type=pools">Retour à la liste des piscines</a>
	<?php } else { ?>
			<a href="index.php?domain=sport">Retour à l'accueil</a>
	<?php } ?>
		</div>
<?php $content = ob_get_clean(); ?>

<?php $title = 'Formulaire de pays'; ?>
<?php require('layout.php') ?>
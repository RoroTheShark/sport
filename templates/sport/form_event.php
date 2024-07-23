<?php ob_start(); ?>
		<form action="index.php?domain=sport" method="POST">
			<div>
				<span>Nom : </span>
				<span><input type="text" name="name" id="name" value="<?= $event->getName() ?>" /></span>
			</div>
			<div>
				<span>Date début : </span>
				<span><input type="date" name="dateStart" id="dateStart" value="<?php echo $event->getDateStart()->format("Y-m-d"); ?>" /></span>
			</div>
			<div>
				<span>Date fin : </span>
				<span><input type="date" name="dateEnd" id="dateEnd" value="<?php echo $event->getDateEnd()->format("Y-m-d"); ?>" /></span>
			</div>
			<input type="hidden" name="action" value="save" />
			<input type="hidden" name="type" value="event" />
			<input type="hidden" name="id" value="<?= $event->getId() ?>" />
			<input type="submit" value="Valider" class="submit" />
		</form>
		<div>
			<a href="index.php?domain=sport&action=list&type=events">Retour à la liste des évènements</a>
		</div>
<?php $content = ob_get_clean(); ?>

<?php $title = 'Formulaire d\'évènement'; ?>
<?php require('layout.php') ?>
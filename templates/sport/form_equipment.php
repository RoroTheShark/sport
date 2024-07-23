<?php ob_start(); ?>
		<form action="index.php?domain=sport" method="POST">
			<div>
				<span>Sous type équipement : </span>
				<span>
					<select name="idEquipmentSubType">
						<option value="0"></option>
<?php
	foreach($equipmentSubTypes as $equipmentSubType) {
		$selected = $equipment->getEquipmentSubType() && $equipment->getEquipmentSubType()->getId() == $equipmentSubType->getId() ? " selected" : "";
?>
						<option value="<?= $equipmentSubType->getId() ?>"<?= $selected ?>><?= $equipmentSubType->getEquipmentType()->getName() ?> / <?= $equipmentSubType->getName() ?></option>
<?php } ?>
					</select>
				</span>
			</div>
			<div>
				<span>Nom : </span>
				<span><input type="text" name="name" id="name" value="<?= $equipment->getName() ?>" /></span>
			</div>
			<div>
				<span>Marque : </span>
				<span>
					<select name="idBrand">
						<option value="0"></option>
<?php
	foreach($brands as $brand) {
		$selected = $equipment->getBrand() && $equipment->getBrand()->getId() == $brand->getId() ? " selected" : "";
?>
						<option value="<?= $brand->getId() ?>"<?= $selected ?>><?= $brand->getName() ?></option>
<?php } ?>
					</select>
				</span>
				<span><a href="index.php?domain=sport&action=form&type=brand&idEquipment=<?= $equipment->getId() ?>">Ajouter une marque</a></span>
			</div>
			<div id="sport">
				<span>Sport : </span>
				<span>
<?php
	foreach($sports as $sport) {
		$checked = $equipment->asSport($sport) ? " checked" : "";
?>
						<input type="checkbox" name="sports[]" id="sport-<?= $sport->getId() ?>" value="<?= $sport->getId() ?>"<?= $checked ?>/><label for="sport-<?= $sport->getId() ?>"><?= $sport->getName() ?></label>
<?php } ?>
				</span>
			</div>
			<div>
				<span>Défaut : </span>
				<span><input type="radio" name="default" id="defautOui" value="1"<?= $equipment->isDefault() ? " checked" : "" ?> /><label for="defautOui">Oui</label><input type="radio" name="default" id="defautNon" value="0"<?= $equipment->isDefault() ? "" : "checked" ?> /><label for="defautNon">Non</label></span>
			</div>
			<div>
				<span>Valeur : </span>
				<span><input type="text" name="value" id="value" value="<?= $equipment->getValue() ?>" /> €</span>
			</div>
			<div>
				<span>Date achat : </span>
				<span><input type="date" name="datePurchase" id="datePurchase" value="<?= $equipment->getDatePurchase() ? $equipment->getDatePurchase()->format("Y-m-d") : "" ?>" /></span>
			</div>
			<div>
				<span>Lien : </span>
				<span><input type="text" name="link" id="link" value="<?= $equipment->getLink(); ?>" /></span>
			</div>
			<div>
				<span>Commentaire : </span>
				<span><textarea name="comment"><?= $equipment->getComment(); ?></textarea></span>
			</div>
      <div>
        <span>Utilisé : </span>
        <span><input type="checkbox" name="used"<?= $equipment->isUsed() ? " checked" : "" ?> /></span>
      </div>
			<input type="hidden" name="action" value="save" />
			<input type="hidden" name="type" value="equipment" />
			<input type="hidden" name="id" value="<?= $equipment->getId() ?>" />
			<input type="submit" value="Valider" class="submit" />
		</form>
		<div>
			<a href="index.php?domain=sport&action=list&type=equipments">Retour à la liste des équipements</a>
		</div>
<?php $content = ob_get_clean(); ?>

<?php $title = 'Formulaire d\'équipement'; ?>
<?php require('layout.php') ?>
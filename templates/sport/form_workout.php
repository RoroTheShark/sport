<?php ob_start(); ?>
		<form action="index.php?domain=sport" method="POST" onSubmit="Javascript: return verifForm();">
			<div>
				<span>Date : </span>
				<span><input type="date" name="date" id="date" value="<?php echo $workout->getDate()->format("Y-m-d"); ?>" /></span>
			</div>
			<div>
				<span>Sport : </span>
				<span>
					<select name="sport" id="sport" onChange="Javascript: changeSport();">
<?php
	foreach($sports as $sport) {
		$selected = ($workout->getEnvironment() && $workout->getEnvironment()->getSport()->getId() == $sport->getId()) || (!$workout->getEnvironment() && $sport->getId() == 1) ? " selected" : "";
?>
						<option value="<?= $sport->getId() ?>"<?= $selected ?>><?= $sport->getName() ?></option>
<?php } ?>
					</select>
				</span>
			</div>
			<div id="environment">
				<span>Environnement : </span>
				<span>
<?php
	foreach($environments as $environment) {
		$checked = ($workout->getEnvironment() && $workout->getEnvironment()->getId() == $environment->getId()) ? " checked" : "";
?>
					<input type="radio" name="idEnvironment" id="idEnvironment-<?= $environment->getId() ?>" value="<?= $environment->getId() ?>" data-sport="<?= $environment->getSport()->getId() ?>"<?= $checked ?>/><label for="idEnvironment-<?= $environment->getId() ?>"><?= $environment->getName() ?></label>
<?php } ?>
				</span>
			</div>
			<div id="divPays">
				<span>Pays : </span>
				<span>
<?php
	foreach($countries as $country) {
		$checked = ($workout->getPool() && $workout->getPool()->getCity()->getCountry()->getId() == $country->getId()) ? " checked" : "";
?>
				<input type="radio" name="country" id="country-<?= $country->getId() ?>" value="<?= $country->getId() ?>" onclick="changePays();"<?= $checked ?> /><label for="country-<?= $country->getId() ?>"><?= $country->getName() ?></label>
<?php } ?>
				</span>
			</div>
			<div id="divVille">
				<span>Ville : </span>
				<span>
<?php
	foreach($cities as $city) {
		$checked = ($workout->getPool() && $workout->getPool()->getCity()->getId() == $city->getId()) ? " checked" : "";
?>
					<input type="radio" name="city" id="city-<?= $city->getId() ?>" value="<?= $city->getId() ?>" data-pays="<?= $city->getCountry()->getId() ?>" onclick="changeVille();"<?= $checked ?> /><label for="city-<?= $city->getId() ?>" ><?= $city->getName() ?></label>
<?php } ?>
				</span>
			</div>
			<div id="divPiscine">
				<span>Piscine : </span>
				<span>
<?php
	foreach($pools as $pool) {
		$checked = ($workout->getPool() && $workout->getPool()->getId() == $pool->getId()) ? " checked" : "";
?>
					<input type="radio" name="idPool" id="idPool-<?= $pool->getId() ?>" value="<?= $pool->getId() ?>" data-ville="<?= $pool->getCity()->getId() ?>"<?= $checked ?> /><label for="idPool-<?= $pool->getId() ?>" ><?= $pool->getName() ?></label>
<?php } ?>
				</span>
			</div>
			<div>
				<span>Entra&icirc;nement / Comp&eacute;tition : </span>
				<span>
					<select name="idCompetTrain" id="idCompetTrain">
<?php
	foreach($competTrains as $competTrain) {
		$selected = ($workout->getCompetTrain() && $workout->getCompetTrain()->getId() == $competTrain->getId()) || $competTrain->getId() == 1 ? " selected" : "";
?>
						<option value="<?= $competTrain->getId() ?>"<?= $selected ?>><?= $competTrain->getName() ?></option>
<?php } ?>
					</select>
				</span>
			</div>
			<div id="divDistance">
				<span>Distance : </span>
				<span><input type="text" name="distance" id="distance" value="<?= $workout->getDistance() ?>" /> m</span>
			</div>
			<div id="divDenivele">
				<span>Dénivelé : </span>
				<span><input type="text" name="elevation" id="elevation" value="<?= $workout->getElevation() ?>" /> m</span>
			</div>
			<div>
				<span>Temps : </span>
				<span><input type="text" name="time" id="time" placeholder="00:00:00" value="<?= $workout->getTimeFormated("form") ?>"/></span>
			</div>
			<div>
				<span>Moment : </span>
				<span>
					<select name="idMoment" id="idMoment">
<?php
	foreach($moments as $moment) {
		$selected = ($workout->getMoment() && $workout->getMoment()->getId() == $moment->getId()) || $moment->getId() == 1 ? " selected" : "";
?>
						<option value="<?= $moment->getId() ?>"<?= $selected ?>><?= $moment->getName() ?></option>
<?php } ?>
					</select>
				</span>
			</div>
			<div id="intensites">
				<span>Intensit&eacute: </span>
				<span>
<?php
	foreach($intensities as $intensity) {
		$checked = ($workout->getIntensity() && $workout->getIntensity()->getId() == $intensity->getId()) ? " checked" : "";
?>
						<input type="radio" name="idIntensity" id="idIntensity-<?= $intensity->getId() ?>" value="<?= $intensity->getId() ?>"<?= $checked ?> /><label for="idIntensity-<?= $intensity->getId() ?>"><?= $intensity->getValue() ?></label>
<?php } ?>
				</span>
			</div>
			<div id="partenaires">
				<span>Avec qui : </span>
				<span>
<?php
	foreach($partners as $partner) {
		$checked = $workout->asPartner($partner) ? " checked" : "";
?>
					<input type="checkbox" name="partners[]" id="partners-<?= $partner->getId() ?>" value="<?= $partner->getId() ?>"<?= $checked ?> /><label for="partners-<?= $partner->getId() ?>"><?= $partner->getName() ?></label>
<?php } ?>
				</span>
			</div>
			<div>
				<span>Commentaire : </span>
				<span><textarea name="comment"><?= $workout->getComment() ?></textarea></span>
			</div>
			<div>
				<span>Entraînement : </span>
				<span><textarea name="training"><?= $workout->getTraining() ?></textarea></span>
			</div>
			<div id="materiels">
<?php foreach($equipmentTypes as $equipmentType) { ?>
				<div><h3><?= $equipmentType->getName() ?></h3></div>
	<?php foreach($equipmentType->getEquipmentSubTypes() as $equipmentSubType) { ?>
				<div><h4><?= $equipmentSubType->getName() ?></h4></div>
		<?php
			foreach($equipmentSubType->getEquipments() as $equipment) {
				$checked = $workout->asEquipment($equipment) || (empty($workout->getEquipments()) && $equipment->isDefault()) ? 1 : 0;
		?>
				<input type="checkbox" name="equipments[]" id="equipments-<?= $equipment->getId() ?>" value="<?= $equipment->getId() ?>" data-sport="<?= $equipment->getSportsIdString() ?>" data-checked="<?= $checked ?>" /><label for="equipments-<?= $equipment->getId() ?>" data-sport="<?= $equipment->getSportsIdString() ?>"><?= $equipment->getName() ?></label>
		<?php } ?>
	<?php } ?>
<?php } ?>
			</div>
			<div>
				<span>ID Strava : </span>
				<span><input type="text" name="idStrava" id="idStrava" value="<?= $workout->getIdStrava() ?>"/></span>
				<span>ID Decathlon : </span>
				<span><input type="text" name="idDecathlon" id="idDecathlon" value="<?= $workout->getIdDecathlon() ?>"/></span>
			</div>
			<div>
				<table border="1" id="tabMonts" style="display: ;">
		            <thead>
			            <tr>
			                <th>Nom</th>
			                <th>Monts</th>
			                <th>Routes</th>
			                <th>Nombre</th>
			            </tr>
		            </thead>
		            <tbody>
<?php foreach($countriesMounts as $country) { ?>
						<tr>
							<td rowspan="<?= $country->getNumberRoads() ?>"><?= $country->getName() ?></td>
	<?php
		foreach($country->getMounts() as $idMount => $mount) {
			if($idMount > 0) {
	?>
						<tr>
	<?php } ?>
							<td rowspan="<?= count($mount->getRoads()) ?>"><?= $mount->getName() ?></td>
		<?php
			foreach($mount->getRoads() as $idRoad => $road) {
				$number = $workout->getWorkoutRoadNumbers($road);
				if($idRoad > 0) {
		?>
						<tr>
		<?php } ?>
							<td><?= $road->getName() ?></td>
							<td><input type="number" name="nb_route_<?= $road->getId() ?>" min="0" value="<?= $number ?>"/></td>
						</tr>
		<?php } ?>
						</tr>
	<?php } ?>
						</tr>
<?php } ?>
		            </tbody>
		        </table>
		    </div>
		    <div>
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="type" value="workout" />
				<input type="hidden" name="id" value="<?= $workout->getId() ?>" />
				<input type="submit" value="Valider" class="submit" />
			</div>
		</form>
		<div class="msgErreur" id="msgErreur" style="display: none;"></div>
		<div>
			<a href="index.php?domain=sport">Retour à l'accueil</a>
		</div>
<?php $content = ob_get_clean(); ?>

<?php ob_start(); ?>
	<script type="text/Javascript">
		function verifForm() {
			var cptErr = 0;
			var tabErr = new Array();
			if(document.getElementById("date").value == "") {
				cptErr++;
				tabErr.push("date");
			}
			var sport = document.getElementById("sport").value;
			if(sport == "") {
				cptErr++;
				tabErr.push("sport");
			}
			var inputs = document.getElementById("environment").getElementsByTagName("input");
			var cptSousSports = 0;
			for(var i = 0; i < inputs.length; i++) {
				if(inputs[i].checked) {
					cptSousSports++;
				}
			}
			if(cptSousSports == 0) {
				cptErr++;
				tabErr.push("environnement");
			}
			if(document.getElementById("idCompetTrain").value == "") {
				cptErr++;
				tabErr.push("Entraînement/Compétition");
			}
			if(document.getElementById("time").value == "") {
				cptErr++;
				tabErr.push("temps");
			}
			if(sport == "10" || sport == "3" || sport == "11" || sport == "1" || sport == "2") {
				if(document.getElementById("distance").value == "") {
					cptErr++;
					tabErr.push("distance");
				}
				var inputsCountry = document.getElementById("divPays").getElementsByTagName("input");
				var cptCountries = 0;
				for(var i = 0; i < inputsCountry.length; i++) {
					if(inputsCountry[i].checked) {
						cptCountries++;
					}
				}
			}
			if(sport == "1") {
				if(cptCountries == 0) {
					cptErr++;
					tabErr.push("pays");
				}
				var inputsCity = document.getElementById("divVille").getElementsByTagName("input");
				var cptCities = 0;
				for(var i = 0; i < inputsCity.length; i++) {
					if(inputsCity[i].checked) {
						cptCities++;
					}
				}
				if(cptCities == 0) {
					cptErr++;
					tabErr.push("ville");
				}
				var inputsPool = document.getElementById("divPiscine").getElementsByTagName("input");
				var cptPools = 0;
				for(var i = 0; i < inputsPool.length; i++) {
					if(inputsPool[i].checked) {
						cptPools++;
					}
				}
				if(cptPools == 0) {
					cptErr++;
					tabErr.push("piscine");
				}
			}
			if(sport == "10" || sport == "3" || sport == "11" || sport == "2") {
				if(document.getElementById("elevation").value == "") {
					cptErr++;
					tabErr.push("denivele");
				}
			}
			if(document.getElementById("idMoment").value == "") {
				cptErr++;
				tabErr.push("moment");
			}
			var inputs = document.getElementById("intensites").getElementsByTagName("input");
			var cptIntens = 0;
			for(var i = 0; i < inputs.length; i++) {
				if(inputs[i].checked) {
					cptIntens++;
				}
			}
			if(cptIntens == 0) {
				cptErr++;
				tabErr.push("intensité");
			}

			console.log(cptErr);
			if(cptErr > 0) {
				document.getElementById("msgErreur").style.display = "";
				document.getElementById("msgErreur").innerHTML = "Vous devez remplir "+tabErr.join(", ");
				return false;
			}
		}
		function changeSport() {
			var idSport = document.getElementById("sport").value;
			var inputs = document.getElementById("environment").getElementsByTagName("input");
			var labels = document.getElementById("environment").getElementsByTagName("label");
			for(var i = 0; i < inputs.length; i++) {
				if(inputs[i].getAttribute("data-sport") == idSport) {
					inputs[i].style.display = "";
					labels[i].style.display = "";
				} else {
					inputs[i].checked = false;
					inputs[i].style.display = "none";
					labels[i].style.display = "none";
				}
			}
			var inputsMateriel = document.getElementById("materiels").getElementsByTagName("input");
			var labelsMateriel = document.getElementById("materiels").getElementsByTagName("label");
			for(var i = 0; i < inputsMateriel.length; i++) {
				if(inputsMateriel[i].getAttribute("data-sport").split(",").includes(idSport) == true) {
					inputsMateriel[i].style.display = "";
					labelsMateriel[i].style.display = "";
					inputsMateriel[i].checked = inputsMateriel[i].dataset.checked == 1 ? true : false;
				} else {
					inputsMateriel[i].style.display = "none";
					labelsMateriel[i].style.display = "none";
					inputsMateriel[i].checked = false;
				}
			}
			if(idSport == "1") {
				document.getElementById("divPays").style.display = "";
				document.getElementById("divVille").style.display = "";
				document.getElementById("divPiscine").style.display = "";
			} else {
				document.getElementById("divPays").style.display = "none";
				document.getElementById("divVille").style.display = "none";
				document.getElementById("divPiscine").style.display = "none";
			}
			if(idSport == "2") {
				document.getElementById("tabMonts").style.display = "";
			} else {
				document.getElementById("tabMonts").style.display = "none";
			}
			if(idSport == "1" || idSport == "2" || idSport == "3" || idSport == "10" || idSport == "11") {
				document.getElementById("divDistance").style.display = "";
			} else {
				document.getElementById("divDistance").style.display = "none";
			}
			if(idSport == "2" || idSport == "3" || idSport == "10" || idSport == "11") {
				document.getElementById("divDenivele").style.display = "";
			} else {
				document.getElementById("divDenivele").style.display = "none";
			}
			
		}
		function changePays() {
			var idPays = 0;
			var inputsPays = document.getElementById("divPays").getElementsByTagName("input");
			for(var i = 0; i < inputsPays.length; i++) {
				idPays = inputsPays[i].checked ? inputsPays[i].value : idPays;
			}

			var inputsVille = document.getElementById("divVille").getElementsByTagName("input");
			var labelsVille = document.getElementById("divVille").getElementsByTagName("label");
			for(var i = 0; i < inputsVille.length; i++) {
				if(inputsVille[i].getAttribute("data-pays") == idPays) {
					inputsVille[i].style.display = "";
					labelsVille[i].style.display = "";
				} else {
					inputsVille[i].checked = false;
					inputsVille[i].style.display = "none";
					labelsVille[i].style.display = "none";
				}
			}
			changeVille();
		}
		function changeVille() {
			var idVille = 0;
			var inputsVilles = document.getElementById("divVille").getElementsByTagName("input");
			for(var i = 0; i < inputsVilles.length; i++) {
				idVille = inputsVilles[i].checked ? inputsVilles[i].value : idVille;
			}

			var inputsPiscine = document.getElementById("divPiscine").getElementsByTagName("input");
			var labelsPiscine = document.getElementById("divPiscine").getElementsByTagName("label");
			for(var i = 0; i < inputsPiscine.length; i++) {
				if(inputsPiscine[i].getAttribute("data-ville") == idVille) {
					inputsPiscine[i].style.display = "";
					labelsPiscine[i].style.display = "";
				} else {
					inputsPiscine[i].checked = "";
					inputsPiscine[i].style.display = "none";
					labelsPiscine[i].style.display = "none";
				}
			}
		}
		changeSport();
		changePays();
	</script>
<?php $javascript = ob_get_clean(); ?>

<?php $title = 'Formulaire de séance'; ?>
<?php require('layout.php') ?>
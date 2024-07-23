<?php require('functions_formatting.php') ?>
<?php ob_start(); ?>
        <form action="index.php?domain=sport&action=list&type=workout" method="GET">
            <div>
                <span>Date entre <input type="date" name="fDateStart" id="fDateStart" value="<?= $fDateStart; ?>" /> et <input type="date" name="fDateEnd" id="fDateEnd" value="<?= $fDateEnd; ?>" /></span>
            </div>
            <div>
                <span>Sport : </span>
                <span>
                    <select name="fSport" id="fSport" onChange="Javascript: selectSport();">
                        <option value=""></option>
<?php
    foreach($sports as $sport) {
        $selected = $sport->getId() == $fSport ? " selected" : "";
?>
                        <option value="<?= $sport->getId() ?>"<?= $selected ?>><?= $sport->getName() ?></option>
<?php } ?>
                    </select>
                </span>
            </div>
            <div>
                <span>Environnement : </span>
                <span>
                    <select name="fEnvironment" id="fEnvironment">
                        <option value=""></option>
<?php
    foreach($environments as $environment) {
        $selected = $environment->getId() == $fEnvironment ? " selected" : "";
?>
                        <option value="<?= $environment->getId() ?>" data-sport="<?= $environment->getSport()->getId() ?>"<?= $selected ?>><?= $environment->getName() ?></option>
<?php } ?>
                    </select>
                </span>
            </div>
            <div>
                <span>Distance entre <input type="text" name="fDistanceStart" id="fDistanceStart" value="<?= $fDistanceStart; ?>" />m et <input type="text" name="fDistanceEnd" id="fDistanceEnd" value="<?= $fDistanceEnd; ?>" />m</span>
            </div>
            <div>
                <span>Temps entre <input type="text" name="fTimeStart" id="fTimeStart" value="<?= $fTimeStart; ?>" placeholder="hh:mm:ss" /> et <input type="text" name="fTimeEnd" id="fTimeEnd" value="<?= $fTimeEnd; ?>" placeholder="hh:mm:ss" /></span>
            </div>
            <div>
                <span>Partenaire : </span>
                <span>
                    <select name="fPartner" id="fPartner">
                        <option value=""></option>
<?php
    foreach($partners as $partner) {
        $selected = $partner->getId() == $fPartner ? " selected" : "";
?>
                        <option value="<?= $partner->getId() ?>"<?= $selected ?>><?= $partner->getName() ?></option>
<?php } ?>
                    </select>
                </span>
            </div>
            <div>
                <input type="hidden" name="domain" value="sport" />
                <input type="hidden" name="action" value="list" />
                <input type="hidden" name="type" value="workouts" />
                <input type="submit" value="Valider" />
                <a href="index.php?domain=sport&action=list&type=workouts">Ré-initialiser</a>
            </div>
        </form>
        <table class="liste">
            <tr>
                <th>Date</th>
                <th>Sport / sous sport</th>
                <th>Type</th>
                <th>Temps</th>
                <th>Distance</th>
                <th>Dénivelé</th>
                <th>Vitesse / allure</th>
                <th>Distance + dénivelé</th>
                <th>Vitesse / allure + dénivelé</th>
                <th>Intensité</th>
                <th>Partenaire(s)</th>
                <th>Action</th>
            </tr>
            <tr class="trTotal">
                <td><?= count($workouts); ?></td>
                <td></td>
                <td></td>
                <td><?= $sumDatas->getSumTime(); ?></td>
                <td><?= $sumDatas->getSumDistance(" km"); ?></td>
                <td><?= $sumDatas->getSumElevation(); ?></td>
            </tr>
<?php foreach($workouts as $workout) { ?>
            <tr>
                <td><?= $workout->getDate()->format("d/m/Y") ?></td>
                <td><?= $workout->getEnvironment()->getSport()->getName() ?> / <?= $workout->getEnvironment()->getName() ?></td>
                <td><?= $workout->getCompetTrain()->getName() ?></td>
                <td><?= $workout->getTimeFormated() ?></td>
                <td><?= $workout->getDistanceFormated() ?></td>
                <td><?= $workout->getElevationFormated() ?></td>
                <td><?= $workout->getSpeedFormated() ?></td>
                <td><?= $workout->getDistanceAndElevationFormated() ?></td>
                <td><?= $workout->getSpeedDistanceAndElevationFormated() ?></td>
                <td><?= $workout->getIntensity()->getValue() ?>/6</td>
                <td><?= implode(", ",array_map(function($p) {return $p->getName();},$workout->getPartners())) ?></td>
                <td>
    <?php if($workout->getTraining() != "") { ?>
                    <a href="Javascript: ouvreFermeEntrainement(<?= $workout->getId() ?>);">Entrainement</a> / 
    <?php } ?>
                    <a href="index.php?domain=sport&action=form&type=workout&idWorkout=<?= $workout->getId() ?>">Modifier</a>
                </td>
            </tr>
            <tr class="commentaire">
                <td align="center" colspan="12">
                    <?= str_replace("\n","<br />", $workout->getComment() ? $workout->getComment() : "") ?>
                </td>
            </tr>
            <tr class="entrainement">
                <td align="center" colspan="12">
                    <div id="divEntrainement-<?= $workout->getId() ?>" class="divEntrainement" style="display: none;">
                        <div><?= str_replace("\n","<br />", $workout->getTraining() ? $workout->getTraining() : "") ?></div>
                    </div>
                </td>
            </tr>
            <tr class="materiels">
                <td align="center"><?= $workout->getIdStrava() != "" ? "<a href='https://www.strava.com/activities/".$workout->getIdStrava()."' target='_blank'>Strava</a>" : ""; ?></td>
                <td align="center" colspan="11"><?= $workout->getListEquipments(2) ?></td>
            </tr>
            <tr class="habits">
                <td align="center"><?= $workout->getIdDecathlon() != "" ? "<a href='https://www.decathloncoach.com/fr-fr/portal/activities/".$workout->getIdDecathlon()."' target='_blank'>Decathlon</a>" : ""; ?></td>
                <td align="center" colspan="11"><?= implode(", ",array_map(function($e) {return $e->getName();},array_filter($workout->getEquipments(), function($e) {return $e->getEquipmentSubType()->getEquipmentType()->getId() == 1;}))) ?></td>
            </tr>
<?php } ?>
        	<tr>
        		<td colspan="4">
        			<a href="index.php?domain=sport&action=form&type=partner&idPartner=0">Ajouter un partenaire</a>
        		</td>
        	</tr>
        </table>
<?php $content = ob_get_clean(); ?>

<?php ob_start(); ?>
    <script type="text/Javascript">
        function selectSport(init = false) {
            var idSport = document.getElementById("fSport").value;
            var sousSport = document.getElementById("fEnvironment");
            if(!init)
                sousSport[0].selected = true;
            for(var i = 1; i < sousSport.length; i++) {
                if(sousSport[i].dataset.sport == idSport) {
                    sousSport[i].style.display = "";
                } else {
                    sousSport[i].style.display = "none";
                }
            }
        }
        selectSport(true);
        function ouvreFermeEntrainement(id) {
            if(document.getElementById('divEntrainement-'+id).style.display == "") {
                document.getElementById('divEntrainement-'+id).style.display = "none";
            } else {
                document.getElementById('divEntrainement-'+id).style.display = "";
            }
        }
    </script>
<?php $javascript = ob_get_clean(); ?>

<?php $title = 'Liste des séances'; ?>
<?php require('layout.php') ?>
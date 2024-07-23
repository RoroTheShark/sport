<?php ob_start(); ?>
        <div>
            <p><a href="index.php?domain=sport&action=list&type=stats&vue=<?= $vue == "year" ? "season" : "year" ?>">Voir &agrave; <?= $vue == "year" ? "la saison" : "l'année" ?></a></p>

            <select id="selectedPeriod" onChange="Javascript: changeSelect();">
<?php
    foreach($listChoices as $row) {
        $selected = $selectedPeriod == $row['value'] ? " selected" : "";
?>

                <option value=<?= $row['value'] ?><?= $selected ?>><?= $row['name'] ?></option>
<?php } ?>
            </select>
            <p>Explication : </p>
            <table>
                <tr>
                    <td class="exemple">
                        <b>Total</b><br />Moyenne<br />Maximum
                    </td>
                </tr>
            </table>
        </div>
        <table border="0" cellspacing="0">
            <tr>
                <th></th>
                <th class="bDroite"></th>
<?php
    foreach($sportsPeriod as $sport) {
        //$colspan = 3+count($tabSousSports[$row['id']])*3;
        $colspan = 3+count($sport->getEnvironments())*3;
?>
                <th colspan="<?= $colspan ?>" class="titre bBas bDroite"><?= $sport->getName() ?></th>
<?php } ?>
                <th colspan='3' rowspan="2" class='titre bBas bDroite'>Total</th>
            </tr>
            <tr>
                <th class="bBas"></th>
                <th class="bBas bDroite"></th>
<?php foreach($sportsPeriod as $sport) { ?>
    <?php foreach($sport->getEnvironments() as $environment) { ?>
                <th colspan="3" class="titre bBas bDroitePetit"><?= $environment->getName() ?></th>
    <?php } ?>
                <th colspan='3' class="titre bBas bDroite">Total</th>
<?php } ?>
            </tr>
<?php foreach($months as $month) { ?>
            <tr>
                <th class='bBas bDroitePetit titre'><?= $month->getName() ?></th>
                <td class='bBas bDroite' nowrap><?= $statsPartners['months'][$month->getId()] ?></td>
    <?php foreach($sportsPeriod as $sport) { ?>
        <?php foreach($sport->getEnvironments() as $environment) { ?>
                <td align='right' class='distance'>
                    <b><?= $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['actual']->getSumDistance() ?></b><br />
                    <i><?= $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['previous']->getSumDistance() ?></i><br /><br />
                    <?= $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['actual']->getMoyDistance() ?><br />
                    <i><?= $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['previous']->getMoyDistance() ?></i><br /><br />
                    <?= $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['actual']->getMaxDistance() ?><br />
                    <i><?= $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['previous']->getMaxDistance() ?></i>
                </td>
                <td align='right' class='temps'>
                    <b><?= $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['actual']->getSumTime() ?></b><br />
                    <i><?= $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['previous']->getSumTime() ?></i><br /><br />
                    <?= $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['actual']->getMoyTime() ?><br />
                    <i><?= $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['previous']->getMoyTime() ?></i><br /><br />
                    <?= $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['actual']->getMaxTime() ?><br />
                    <i><?= $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['previous']->getMaxTime() ?></i>
                </td>
                <td align='right' class='seances'>
                    <b><?= $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['actual']->getNumWorkouts() ?></b><br />
                    <i><?= $arrayResults['months'][$month->getId()]['environments'][$environment->getId()]['previous']->getNumWorkouts() ?></i>
                </td>
        <?php } ?>
                <td align='right' class='totalDistance'>
                    <b><?= $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['actual']->getSumDistance() ?></b><br />
                    <i><?= $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['previous']->getSumDistance() ?></i><br /><br />
                    <?= $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['actual']->getMoyDistance() ?><br />
                    <i><?= $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['previous']->getMoyDistance() ?></i><br /><br />
                    <?= $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['actual']->getMaxDistance() ?><br />
                    <i><?= $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['previous']->getMaxDistance() ?></i>
                </td>
                <td align='right' class='totalTemps'>
                    <b><?= $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['actual']->getSumTime() ?></b><br />
                    <i><?= $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['previous']->getSumTime() ?></i><br /><br />
                    <?= $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['actual']->getMoyTime() ?><br />
                    <i><?= $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['previous']->getMoyTime() ?></i><br /><br />
                    <?= $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['actual']->getMaxTime() ?><br />
                    <i><?= $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['previous']->getMaxTime() ?></i>
                </td>
                <td align='right' class='totalSeances'>
                    <b><?= $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['actual']->getNumWorkouts() ?></b><br />
                    <i><?= $arrayResults['months'][$month->getId()]['sports'][$sport->getId()]['previous']->getNumWorkouts() ?></i>
                </td>
    <?php   } ?>
                <td align='right' class='totalDistance'>
                    <b><?= $arrayResults['months'][$month->getId()]['total']['actual']->getSumDistance() ?></b><br />
                    <i><?= $arrayResults['months'][$month->getId()]['total']['previous']->getSumDistance() ?></i><br /><br />
                    <?= $arrayResults['months'][$month->getId()]['total']['actual']->getMoyDistance() ?><br />
                    <i><?= $arrayResults['months'][$month->getId()]['total']['previous']->getMoyDistance() ?></i><br /><br />
                    <?= $arrayResults['months'][$month->getId()]['total']['actual']->getMaxDistance() ?><br />
                    <i><?= $arrayResults['months'][$month->getId()]['total']['previous']->getMaxDistance() ?></i>
                </td>
                <td align='right' class='totalTemps'>
                    <b><?= $arrayResults['months'][$month->getId()]['total']['actual']->getSumTime() ?></b><br />
                    <i><?= $arrayResults['months'][$month->getId()]['total']['previous']->getSumTime() ?></i><br /><br />
                    <?= $arrayResults['months'][$month->getId()]['total']['actual']->getMoyTime() ?><br />
                    <i><?= $arrayResults['months'][$month->getId()]['total']['previous']->getMoyTime() ?></i><br /><br />
                    <?= $arrayResults['months'][$month->getId()]['total']['actual']->getMaxTime() ?><br />
                    <i><?= $arrayResults['months'][$month->getId()]['total']['previous']->getMaxTime() ?></i>
                </td>
                <td align='right' class='totalSeances'>
                    <b><?= $arrayResults['months'][$month->getId()]['total']['actual']->getNumWorkouts() ?></b><br />
                    <i><?= $arrayResults['months'][$month->getId()]['total']['previous']->getNumWorkouts() ?></i>
                </td>
            </tr>
<?php } ?>
            <tr>
                <th class='gauche' colspan="2">Total</th>
<?php foreach($sportsPeriod as $sport) { ?>
    <?php foreach($sport->getEnvironments() as $environment) { ?>
                <td align='right' class='distance'>
                    <b><?= $arrayResults['environments'][$environment->getId()]['actual']->getSumDistance() ?></b><br />
                    <i><?= $arrayResults['environments'][$environment->getId()]['previous']->getSumDistance() ?></i><br /><br />
                    <?= $arrayResults['environments'][$environment->getId()]['actual']->getMoyDistance() ?><br />
                    <i><?= $arrayResults['environments'][$environment->getId()]['previous']->getMoyDistance() ?></i><br /><br />
                    <?= $arrayResults['environments'][$environment->getId()]['actual']->getMaxDistance() ?><br />
                    <i><?= $arrayResults['environments'][$environment->getId()]['previous']->getMaxDistance() ?></i>
                </td>
                <td align='right' class='temps'>
                    <b><?= $arrayResults['environments'][$environment->getId()]['actual']->getSumTime() ?></b><br />
                    <i><?= $arrayResults['environments'][$environment->getId()]['previous']->getSumTime() ?></i><br /><br />
                    <?= $arrayResults['environments'][$environment->getId()]['actual']->getMoyTime() ?><br />
                    <i><?= $arrayResults['environments'][$environment->getId()]['previous']->getMoyTime() ?></i><br /><br />
                    <?= $arrayResults['environments'][$environment->getId()]['actual']->getMaxTime() ?><br />
                    <i><?= $arrayResults['environments'][$environment->getId()]['previous']->getMaxTime() ?></i>
                </td>
                <td align='right' class='seances'>
                    <b><?= $arrayResults['environments'][$environment->getId()]['actual']->getNumWorkouts() ?></b><br />
                    <i><?= $arrayResults['environments'][$environment->getId()]['previous']->getNumWorkouts() ?></i>
                </td>
    <?php } ?>
                <td align='right' class='totalDistance'>
                    <b><?= $arrayResults['sports'][$sport->getId()]['actual']->getSumDistance() ?></b><br />
                    <i><?= $arrayResults['sports'][$sport->getId()]['previous']->getSumDistance() ?></i><br /><br />
                    <?= $arrayResults['sports'][$sport->getId()]['actual']->getMoyDistance() ?><br />
                    <i><?= $arrayResults['sports'][$sport->getId()]['previous']->getMoyDistance() ?></i><br /><br />
                    <?= $arrayResults['sports'][$sport->getId()]['actual']->getMaxDistance() ?><br />
                    <i><?= $arrayResults['sports'][$sport->getId()]['previous']->getMaxDistance() ?></i>
                </td>
                <td align='right' class='totalTemps'>
                    <b><?= $arrayResults['sports'][$sport->getId()]['actual']->getSumTime() ?></b><br />
                    <i><?= $arrayResults['sports'][$sport->getId()]['previous']->getSumTime() ?></i><br /><br />
                    <?= $arrayResults['sports'][$sport->getId()]['actual']->getMoyTime() ?><br />
                    <i><?= $arrayResults['sports'][$sport->getId()]['previous']->getMoyTime() ?></i><br /><br />
                    <?= $arrayResults['sports'][$sport->getId()]['actual']->getMaxTime() ?><br />
                    <i><?= $arrayResults['sports'][$sport->getId()]['previous']->getMaxTime() ?></i>
                </td>
                <td align='right' class='totalSeances'>
                    <b><?= $arrayResults['sports'][$sport->getId()]['actual']->getNumWorkouts() ?></b><br />
                    <i><?= $arrayResults['sports'][$sport->getId()]['previous']->getNumWorkouts() ?></i>
                </td>
<?php   } ?>
                <td align='right' class='totalDistance'>
                    <b><?= $arrayResults['total']['actual']->getSumDistance() ?></b><br />
                    <i><?= $arrayResults['total']['previous']->getSumDistance() ?></i><br /><br />
                    <?= $arrayResults['total']['actual']->getMoyDistance() ?><br />
                    <i><?= $arrayResults['total']['previous']->getMoyDistance() ?></i><br /><br />
                    <?= $arrayResults['total']['actual']->getMaxDistance() ?><br />
                    <i><?= $arrayResults['total']['previous']->getMaxDistance() ?></i>
                </td>
                <td align='right' class='totalTemps'>
                    <b><?= $arrayResults['total']['actual']->getSumTime() ?></b><br />
                    <i><?= $arrayResults['total']['previous']->getSumTime() ?></i><br /><br />
                    <?= $arrayResults['total']['actual']->getMoyTime() ?><br />
                    <i><?= $arrayResults['total']['previous']->getMoyTime() ?></i><br /><br />
                    <?= $arrayResults['total']['actual']->getMaxTime() ?><br />
                    <i><?= $arrayResults['total']['previous']->getMaxTime() ?></i>
                </td>
                <td align='right' class='totalSeances'>
                    <b><?= $arrayResults['total']['actual']->getNumWorkouts() ?></b><br />
                    <i><?= $arrayResults['total']['previous']->getNumWorkouts() ?></i>
                </td>
            </tr>
        </table>
        <div style="display: flex; flex-direction: row;">
            <div style="flex: auto;text-align: center;">
                <h4>Partenaires</h4>
                <table>
                    <tr>
                        <th>Nom</th>
                        <th>Nombre de séances / %</th>
                        <th>Temps / %</th>
                    </tr>
<?php foreach($statsPartners['partners'] as $nomPartner => $statParner) { ?>
                        <tr>
                            <td><?= $nomPartner ?></td>
                            <td><?= $statParner->getNumWorkouts() ?> = <?= round($statParner->getNumWorkouts()/$arrayResults['total']['actual']->getNumWorkouts()*100,2) ?>%</td>
                            <td><?= $statParner->getSumTime() ?> = <?= round($statParner->getOriginalSumTime()/$arrayResults['total']['actual']->getOriginalSumTime()*100,2) ?>%</td>
                        </tr>
<?php } ?>
                </table>
            </div>
            <div style="flex: auto;text-align: center;">
                <h4>Monts</h4>
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
                $number = isset($statsRoads[$road->getId()]) ? $statsRoads[$road->getId()] : "";
                if($idRoad > 0) {
        ?>
                        <tr>
        <?php } ?>
                            <td><?= $road->getName() ?></td>
                            <td><?= $number ?></td>
                        </tr>
        <?php } ?>
                        </tr>
    <?php } ?>
                        </tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
            <div style="flex: auto;text-align: center;">
                <h4>Piscines</h4>
                <table border="1" id="tabPiscines" style="display: ;">
                    <thead>
                    <tr>
                        <th>Pays</th>
                        <th>Villes</th>
                        <th>Piscines</th>
                        <th>Pour entraînement</th>
                        <th>Pour compétition (et échauff/récup)</th>
                    </tr>
                    </thead>
                    <tbody>
<?php foreach($countriesCities as $country) { ?>
                        <tr>
                            <td rowspan="<?= $country->getNumberPools() ?>"><?= $country->getName() ?></td>
    <?php
        foreach($country->getCities() as $idCity => $city) {
            if($idCity > 0) {
    ?>
                        <tr>
    <?php } ?>
                            <td rowspan="<?= count($city->getPools()) ?>"><?= $city->getName() ?></td>
        <?php
            foreach($city->getPools() as $idPool => $pool) {
                $training = "";
                $competition = "";
                if(isset($statsPools[$pool->getId()])) {
                    $training = $statsPools[$pool->getId()]['number1'] > 0 ? $statsPools[$pool->getId()]['number1'] : "";
                    $competition = $statsPools[$pool->getId()]['number2'] > 0 ? $statsPools[$pool->getId()]['number2'] : "";
                    $competition .= $statsPools[$pool->getId()]['number3'] > 0 ? "(".$statsPools[$pool->getId()]['number3'].")" : "";
                }
                if($idPool > 0) {
        ?>
                        <tr>
        <?php } ?>
                            <td><?= $pool->getName() ?></td>
                            <td><?= $training ?></td>
                            <td><?= $competition ?></td>
                        </tr>
        <?php } ?>
                        </tr>
    <?php } ?>
                        </tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
<?php $content = ob_get_clean(); ?>

<?php ob_start(); ?>
    <script type="text/Javascript">
        function changeSelect() {
            var idChoix = document.getElementById("selectedPeriod").value;
            location.href = "index.php?domain=sport&action=list&type=stats&vue=<?= $vue ?>&selectedPeriod="+idChoix;
        }
    </script>
<?php $javascript = ob_get_clean(); ?>

<?php $title = 'Liste des partenaires'; ?>
<?php require('layout.php') ?>
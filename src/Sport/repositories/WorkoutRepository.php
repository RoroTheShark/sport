<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/CompetTrain.php');
require_once('src/Sport/entities/Environment.php');
require_once('src/Sport/entities/Equipment.php');
require_once('src/Sport/entities/EquipmentSubType.php');
require_once('src/Sport/entities/EquipmentType.php');
require_once('src/Sport/entities/Intensity.php');
require_once('src/Sport/entities/Month.php');
require_once('src/Sport/entities/Partner.php');
require_once('src/Sport/entities/Pool.php');
require_once('src/Sport/entities/Road.php');
require_once('src/Sport/entities/Season.php');
require_once('src/Sport/entities/Sport.php');
require_once('src/Sport/entities/Workout.php');
require_once('src/Sport/entities/WorkoutCycle.php');
require_once('src/Sport/entities/WorkoutRoad.php');
require_once('src/Sport/entities/WorkoutRunWalk.php');
require_once('src/Sport/entities/WorkoutSwimming.php');

require_once('src/Sport/repositories/DayRepository.php');
require_once('src/Sport/repositories/MonthRepository.php');
require_once('src/Sport/repositories/PoolRepository.php');
require_once('src/Sport/repositories/SeasonRepository.php');

require_once('src/Sport/traits/Distance.php');

use Sport\Entity\CompetTrain;
use Sport\Entity\Environment;
use Sport\Entity\Equipment;
use Sport\Entity\EquipmentSubType;
use Sport\Entity\EquipmentType;
use Sport\Entity\Intensity;
use Sport\Entity\Month;
use Sport\Entity\Partner;
use Sport\Entity\Pool;
use Sport\Entity\Road;
use Sport\Entity\Season;
use Sport\Entity\Sport;
use Sport\Entity\Workout;
use Sport\Entity\WorkoutCycle;
use Sport\Entity\WorkoutRoad;
use Sport\Entity\WorkoutRunWalk;
use Sport\Entity\WorkoutSwimming;

use Sport\Repository\DayRepository;
use Sport\Repository\MonthRepository;
use Sport\Repository\PoolRepository;
use Sport\Repository\SeasonRepository;

use Sport\Trait\Distance;

class WorkoutRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById($idWorkout): Workout
    {
        $requeteWorkout = "SELECT se.id, se.date_seance, sp.id AS id_sport, sp.nom AS nom_sport, env.id AS id_environment, env.nom AS name_environment, se.temps, se.distance, se.denivele, ce.id AS id_ce, ce.nom AS competition_entrainement, i.id AS id_intensite, i.valeur AS valeur_intensite, se.id_strava, se.id_decathlon, se.commentaire, se.entrainement, se.id_piscine, mamasotyma.equipements, sesepa.partenaires, sesero.routes";
        $requeteWorkout .= " FROM s_sports sp, s_environnements env, s_ce ce, s_intensites i, s_seances se LEFT JOIN s_seances_materiels sm ON (se.id = sm.id_seance)";
        $requeteWorkout .= " LEFT JOIN (SELECT sm.id_seance, GROUP_CONCAT(CONCAT(ma.id,'-',ma.nom,'-',masoty.id,'-',maty.id) SEPARATOR ', ') AS equipements FROM s_seances_materiels sm, s_materiels ma, s_materiels_sous_types masoty, s_materiels_types maty WHERE sm.id_materiel = ma.id AND ma.id_sous_type = masoty.id AND masoty.id_type = maty.id GROUP BY sm.id_seance) mamasotyma ON (se.id = mamasotyma.id_seance)";
        $requeteWorkout .= " LEFT JOIN (SELECT sepa.id_seance, GROUP_CONCAT(CONCAT(pa.id,'-',pa.nom) SEPARATOR ', ') AS partenaires FROM s_partenaires pa, s_seances_partenaires sepa WHERE pa.id = sepa.id_partenaire GROUP BY sepa.id_seance) sesepa ON (se.id = sesepa.id_seance)";
        $requeteWorkout .= " LEFT JOIN (SELECT sero.id_seance, GROUP_CONCAT(CONCAT(ro.id,'-',ro.nom,'-',sero.nombre) SEPARATOR ', ') AS routes FROM s_routes ro, s_seances_routes sero WHERE ro.id = sero.id_route GROUP BY sero.id_seance) sesero ON (se.id = sesero.id_seance)";
        $requeteWorkout .= " WHERE env.id_sport = sp.id AND se.id_environnement = env.id AND se.id_ce = ce.id AND se.id_intensite = i.id AND se.id = :idWorkout";
        $requeteWorkout .= " GROUP BY se.id, se.date_seance, sp.id, sp.nom, env.nom, se.temps, se.distance, se.denivele, ce.nom, i.valeur, se.id_strava, se.id_decathlon, se.commentaire, se.entrainement;";

        $resultWorkout = $this->dbMysql->select_one($requeteWorkout, ['idWorkout' => $idWorkout]);

        $workout = new Workout();
        if($resultWorkout) {
            if($resultWorkout['id_sport'] == 1) {
                $workout = new WorkoutSwimming();
                $poolRepository = new PoolRepository();
                $workout->setPool($poolRepository->findOneById($resultWorkout['id_piscine']));
                $workout->setDistance($resultWorkout['distance']);
            } else if($resultWorkout['id_sport'] == 2) {
                $workout = new WorkoutCycle();
                $workout->setDistance($resultWorkout['distance']);
                $workout->setElevation($resultWorkout['denivele']);
            } else if($resultWorkout['id_sport'] == 3 || $resultWorkout['id_sport'] == 10 || $resultWorkout['id_sport'] == 11) {
                $workout = new WorkoutRunWalk();
                $workout->setDistance($resultWorkout['distance']);
                $workout->setElevation($resultWorkout['denivele']);
            }

            $workout->setId($resultWorkout['id']);
            $sport = new Sport();
            $sport->setId($resultWorkout['id_sport']);
            $sport->setName($resultWorkout['nom_sport']);

            $environment = new Environment();
            $environment->setId($resultWorkout['id_environment']);
            $environment->setName($resultWorkout['name_environment']);
            $environment->setSport($sport);
            $workout->setEnvironment($environment);

            $competTrain = new CompetTrain();
            $competTrain->setId($resultWorkout['id_ce']);
            $competTrain->setName($resultWorkout['competition_entrainement']);
            $workout->setCompetTrain($competTrain);

            $workout->setDate($resultWorkout['date_seance']);

            $workout->setTime($resultWorkout['temps']);

            $intensity = new Intensity();
            $intensity->setId($resultWorkout['id_intensite']);
            $intensity->setValue($resultWorkout['valeur_intensite']);
            $workout->setIntensity($intensity);

            $workout->setIdStrava($resultWorkout['id_strava']);
            $workout->setIdDecathlon($resultWorkout['id_decathlon']);
            $workout->setComment($resultWorkout['commentaire']);
            $workout->setTraining($resultWorkout['entrainement']);

            $arrayPartners = [];
            if($resultWorkout['partenaires'] != "") {
                $tabPartners = explode(", ", $resultWorkout['partenaires']);
                foreach($tabPartners as $partnerR) {
                    $values = explode("-", $partnerR);
                    $partner = new Partner();
                    $partner->setId(intval($values[0]));
                    $partner->setName($values[1]);
                    array_push($arrayPartners, $partner);
                }
            }
            $workout->setPartners($arrayPartners);

            // Ici, on ne prends que les ID car pour la liste des séances, on va filter par l'ID du type équipement
            $arrayEquipments = [];
            if($resultWorkout['equipements'] != "") {
                $tabEquipments = explode(", ", $resultWorkout['equipements']);
                foreach($tabEquipments as $equipmentR) {
                    $values = explode("-", $equipmentR);
                    
                    $equipmentType = new EquipmentType();
                    $equipmentType->setId(intval($values[3]));

                    $equipmentSubType = new EquipmentSubType();
                    $equipmentSubType->setId(intval($values[2]));
                    $equipmentSubType->setEquipmentType($equipmentType);

                    $equipment = new Equipment();
                    $equipment->setId(intval($values[0]));
                    $equipment->setName($values[1]);
                    $equipment->setEquipmentSubType($equipmentSubType);
                    array_push($arrayEquipments, $equipment);
                }
            }

            $arrayWorkoutsRoads = [];
            if($resultWorkout['routes'] != "") {
                $tabRoads = explode(", ", $resultWorkout['routes']);
                foreach($tabRoads as $roadR) {
                    $values = explode("-", $roadR);
                    $workoutRoad = new WorkoutRoad();

                    $road = new Road();
                    $road->setId(intval($values[0]));
                    $road->setName($values[1]);

                    $workoutRoad->setRoad($road);
                    $workoutRoad->setNumber(intval($values[2]));
                    $workoutRoad->setWorkout($workout);

                    array_push($arrayWorkoutsRoads, $workoutRoad);
                }
            }
            $workout->setWorkoutsRoads($arrayWorkoutsRoads);

            $workout->setEquipments($arrayEquipments);
        }
        

        return $workout;
    }

    public function findSeveralBy(string $fDateStart, string $fDateEnd, int $fSport, int $fEnvironment, float $fDistanceStart, float $fDistanceEnd, string $fTimeStart, string $fTimeEnd, int $fPartner): array
    {
        $requeteAddWhere = "";
        $requeteParams = [];
        if($fDateStart != "") {
            $requeteAddWhere .= " AND se.date_seance >= :fDateStart";
            $requeteParams["fDateStart"] = $fDateStart;
        }
        if($fDateEnd != "") {
            $requeteAddWhere .= " AND se.date_seance <= :fDateEnd";
            $requeteParams["fDateEnd"] = $fDateEnd;
        }
        if($fSport != 0) {
            $requeteAddWhere .= " AND env.id_sport = :fSport";
            $requeteParams["fSport"] = $fSport;
        }
        if($fEnvironment != 0) {
            $requeteAddWhere .= " AND se.id_environnement = :fEnvironment";
            $requeteParams["fEnvironment"] = $fEnvironment;
        }
        if($fDistanceStart != 0) {
            $requeteAddWhere .= " AND se.distance >= :fDistanceStart";
            $requeteParams["fDistanceStart"] = $fDistanceStart;
        }
        if($fDistanceEnd != 0) {
            $requeteAddWhere .= " AND se.distance <= :fDistanceEnd";
            $requeteParams["fDistanceEnd"] = $fDistanceEnd;
        }
        if($fTimeStart != 0) {
            $requeteAddWhere .= " AND se.temps >= :fTimeStart";
            $requeteParams["fTimeStart"] = $fTimeStart;
        }
        if($fTimeEnd != 0) {
            $requeteAddWhere .= " AND se.temps <= :fTimeEnd";
            $requeteParams["fTimeEnd"] = $fTimeEnd;
        }
        if($fPartner != 0) {
            $requeteAddWhere .= " AND se.id IN (SELECT id_seance FROM seances_partenaires WHERE id_partenaire = :fPartner)";
            $requeteParams["fPartner"] = $fPartner;
        }
        if($requeteAddWhere == "") {
            $classicDateStart = date('Y-m-d', strtotime('-1 year'));
            $requeteAddWhere .= " AND se.date_seance > :classicDateStart";
            $requeteParams["classicDateStart"] = $classicDateStart;
        }

        $requeteWorkouts = "SELECT se.id, se.date_seance, sp.id AS id_sport, sp.nom AS nom_sport, env.id AS id_environment, env.nom AS name_environment, se.temps, se.distance, se.denivele, ce.id AS id_ce, ce.nom AS competition_entrainement, i.id AS id_intensite, i.valeur AS valeur_intensite, se.id_strava, se.id_decathlon, se.commentaire, se.entrainement, mamasotyma.equipements, sesepa.partenaires";
        $requeteWorkouts .= " FROM s_sports sp, s_environnements env, s_ce ce, s_intensites i, s_seances se LEFT JOIN s_seances_materiels sm ON (se.id = sm.id_seance)";
        $requeteWorkouts .= " LEFT JOIN (SELECT sm.id_seance, GROUP_CONCAT(CONCAT(ma.id,'-',ma.nom,'-',masoty.id,'-',maty.id) SEPARATOR ', ') AS equipements FROM s_seances_materiels sm, s_materiels ma, s_materiels_sous_types masoty, s_materiels_types maty WHERE sm.id_materiel = ma.id AND ma.id_sous_type = masoty.id AND masoty.id_type = maty.id GROUP BY sm.id_seance) mamasotyma ON (se.id = mamasotyma.id_seance)";
        $requeteWorkouts .= " LEFT JOIN (SELECT sepa.id_seance, GROUP_CONCAT(CONCAT(pa.id,'-',pa.nom) SEPARATOR ', ') AS partenaires FROM s_partenaires pa, s_seances_partenaires sepa WHERE pa.id = sepa.id_partenaire GROUP BY sepa.id_seance) sesepa ON (se.id = sesepa.id_seance)";
        $requeteWorkouts .= " WHERE env.id_sport = sp.id AND se.id_environnement = env.id AND se.id_ce = ce.id AND se.id_intensite = i.id";
        $requeteWorkouts .= $requeteAddWhere;
        $requeteWorkouts .= " GROUP BY se.id, se.date_seance, sp.id, sp.nom, env.nom, se.temps, se.distance, se.denivele, ce.nom, i.valeur, se.id_strava, se.id_decathlon, se.commentaire, se.entrainement";
        $requeteWorkouts .= " ORDER BY se.date_seance DESC, se.id_moment DESC;";
        //echo $requeteWorkouts;
        $resultsWorkouts = $this->dbMysql->select($requeteWorkouts, $requeteParams);

        $arrayResults = [];
        foreach($resultsWorkouts as $workoutR) {
            $workout = new Workout();
            if($workoutR['id_sport'] == 1) {
                $workout = new WorkoutSwimming();
                //$poolRepository = new PoolRepository();
                //$workout->setPool($poolRepository->findOneById($workoutR['id_piscine']));
                $workout->setDistance($workoutR['distance']);
            } else if($workoutR['id_sport'] == 2) {
                $workout = new WorkoutCycle();
                $workout->setDistance($workoutR['distance']);
                $workout->setElevation($workoutR['denivele']);
            } else if($workoutR['id_sport'] == 3 || $workoutR['id_sport'] == 11) {
                $workout = new WorkoutRunWalk();
                $workout->setDistance($workoutR['distance']);
                $workout->setElevation($workoutR['denivele']);
            }

            $workout->setId($workoutR['id']);
            $sport = new Sport();
            $sport->setId($workoutR['id_sport']);
            $sport->setName($workoutR['nom_sport']);

            $environment = new Environment();
            $environment->setId($workoutR['id_environment']);
            $environment->setName($workoutR['name_environment']);
            $environment->setSport($sport);
            $workout->setEnvironment($environment);

            $competTrain = new CompetTrain();
            $competTrain->setId($workoutR['id_ce']);
            $competTrain->setName($workoutR['competition_entrainement']);
            $workout->setCompetTrain($competTrain);

            $workout->setDate($workoutR['date_seance']);

            $workout->setTime($workoutR['temps']);

            $intensity = new Intensity();
            $intensity->setId($workoutR['id_intensite']);
            $intensity->setValue($workoutR['valeur_intensite']);
            $workout->setIntensity($intensity);

            $workout->setIdStrava($workoutR['id_strava']);
            $workout->setIdDecathlon($workoutR['id_decathlon']);
            $workout->setComment($workoutR['commentaire']);
            $workout->setTraining($workoutR['entrainement']);

            $arrayPartners = [];
            if($workoutR['partenaires'] != "") {
                $tabPartners = explode(", ", $workoutR['partenaires']);
                foreach($tabPartners as $partnerR) {
                    $values = explode("-", $partnerR);
                    $partner = new Partner();
                    $partner->setId(intval($values[0]));
                    $partner->setName($values[1]);
                    array_push($arrayPartners, $partner);
                }
            }
            $workout->setPartners($arrayPartners);

            // Ici, on ne prends que les ID car pour la liste des séances, on va filter par l'ID du type équipement
            $arrayEquipments = [];
            if($workoutR['equipements'] != "") {
                $tabEquipments = explode(", ", $workoutR['equipements']);
                foreach($tabEquipments as $equipmentR) {
                    $values = explode("-", $equipmentR);
                    
                    $equipmentType = new EquipmentType();
                    $equipmentType->setId(intval($values[3]));

                    $equipmentSubType = new EquipmentSubType();
                    $equipmentSubType->setId(intval($values[2]));
                    $equipmentSubType->setEquipmentType($equipmentType);

                    $equipment = new Equipment();
                    $equipment->setId(intval($values[0]));
                    $equipment->setName($values[1]);
                    $equipment->setEquipmentSubType($equipmentSubType);
                    array_push($arrayEquipments, $equipment);
                }
            }
            $workout->setEquipments($arrayEquipments);

            array_push($arrayResults, $workout);
        }
        
        return $arrayResults;
    }

    // Je ne souhaite pas surcharger ici, car ce n'est appelé que dans la liste des piscine, on n'a juste besoin du nombre de séances
    public function findSeveralByPool(Pool $pool): array
    {
        $requeteWorkouts = "SELECT se.id";
        $requeteWorkouts .= " FROM s_seances se";
        $requeteWorkouts .= " WHERE se.id_piscine = :idPool;";
        $resultsWorkouts = $this->dbMysql->select($requeteWorkouts, ['idPool' => $pool->getId()]);

        $arrayResults = [];
        foreach($resultsWorkouts as $workoutR) {
            $workout = new Workout();
            $workout->setId($workoutR['id']);

            array_push($arrayResults, $workout);
        }
        
        return $arrayResults;
    }

    // Je ne souhaite pas surcharger ici, car ce n'est appelé que dans la liste des piscine, on n'a juste besoin de la distance, temps et dénivelé
    public function findSeveralByEquipment(Equipment $equipment): array
    {
        $requeteWorkouts = "SELECT se.id, se.distance, se.temps, se.denivele, sp.id AS id_sport";
        $requeteWorkouts .= " FROM s_sports sp, s_environnements env, s_seances se, s_seances_materiels sm";
        $requeteWorkouts .= " WHERE env.id_sport = sp.id AND se.id_environnement = env.id AND se.id = sm.id_seance AND sm.id_materiel = :idEquipment;";
        $resultsWorkouts = $this->dbMysql->select($requeteWorkouts, ['idEquipment' => $equipment->getId()]);

        $arrayResults = [];
        foreach($resultsWorkouts as $workoutR) {
            $workout = new Workout();
            if($workoutR['id_sport'] == 1) {
                $workout = new WorkoutSwimming();
                $workout->setDistance($workoutR['distance']);
            } else if($workoutR['id_sport'] == 2) {
                $workout = new WorkoutCycle();
                $workout->setDistance($workoutR['distance']);
                $workout->setElevation($workoutR['denivele']);
            } else if($workoutR['id_sport'] == 3 || $workoutR['id_sport'] == 11) {
                $workout = new WorkoutRunWalk();
                $workout->setDistance($workoutR['distance']);
                $workout->setElevation($workoutR['denivele']);
            }
            $workout->setId($workoutR['id']);
            $workout->setTime($workoutR['temps']);

            array_push($arrayResults, $workout);
        }
        
        return $arrayResults;
    }

    public function findAll(): array
    {
        $requeteWorkouts = "SELECT id, id_environnement, date_seance, temps, distance FROM s_seances ORDER BY date_seance ASC;";
        $resultsWorkouts = $this->dbMysql->select($requeteWorkouts);

        $arrayResults = [];
        foreach($resultsWorkouts as $workoutR) {
            $workout = new Workout();
            $workout->setId($workoutR['id']);
            $environmentRepository = new EnvironmentRepository();
            $workout->setEnvironment($environmentRepository->findOneById($workoutR['id_environnement']));
            $workout->setDate($workoutR['date_seance']);
            $workout->setTime($workoutR['temps']);
            $workout->setDistance($workoutR['distance']);
            array_push($arrayResults, $workout);
        }
        
        return $arrayResults;
    }

    public function findStatsByDates(string $dateStart, string $dateEnd): array
    {
        $requeteStatsWorkouts = "SELECT env.id_sport, se.id_environnement, se.id_mois, SUM(se.distance) AS sum_distance, MAX(se.distance) AS max_distance, SUM(se.temps) AS sum_temps, MAX(se.temps) AS max_temps, COUNT(*) AS num_seances";
        $requeteStatsWorkouts .= " FROM s_seances se, s_environnements env";
        $requeteStatsWorkouts .= " WHERE se.id_environnement = env.id AND se.date_seance BETWEEN :dateStart AND :dateEnd";
        $requeteStatsWorkouts .= " GROUP BY env.id_sport, se.id_environnement, se.id_mois;";
        //echo $requeteStatsWorkouts," / ", $dateStart;
        $resultsStatsWorkouts = $this->dbMysql->select($requeteStatsWorkouts, ['dateStart' => $dateStart, 'dateEnd' => $dateEnd]);

        $arrayResults = [];
        foreach($resultsStatsWorkouts as $workoutStat) {
            if(!isset($arrayResults[$workoutStat['id_mois']])) {
                $arrayResults[$workoutStat['id_mois']] = [];
            }
            if(!isset($arrayResults[$workoutStat['id_mois']][$workoutStat['id_environnement']])) {
                $arrayResults[$workoutStat['id_mois']][$workoutStat['id_environnement']] = ['sumDistance' => 0, 'maxDistance' => 0, 'sumTime' => 0, 'maxTime' => 0, 'numWorkouts' => 0];
            }
            $arrayResults[$workoutStat['id_mois']][$workoutStat['id_environnement']]['sumDistance'] += $workoutStat['sum_distance'];
            $arrayResults[$workoutStat['id_mois']][$workoutStat['id_environnement']]['maxDistance'] += $workoutStat['max_distance'];
            $arrayResults[$workoutStat['id_mois']][$workoutStat['id_environnement']]['sumTime'] += $workoutStat['sum_temps'];
            $arrayResults[$workoutStat['id_mois']][$workoutStat['id_environnement']]['maxTime'] += $workoutStat['max_temps'];
            $arrayResults[$workoutStat['id_mois']][$workoutStat['id_environnement']]['numWorkouts'] += $workoutStat['num_seances'];
        }
        
        return $arrayResults;
    }

    public function findAllYears(): array
    {
        $requeteYears = "SELECT YEAR(date_seance) AS annee FROM s_seances GROUP BY YEAR(date_seance) ORDER BY YEAR(date_seance);";
        $resultsYears = $this->dbMysql->select($requeteYears);

        $arrayResults = [];
        foreach($resultsYears as $year) {
            array_push($arrayResults, ['value' => $year['annee'], 'name' => $year['annee']]);
        }
        
        return $arrayResults;
    }

    public function save(): void
    {
        $idWorkout = 0;

        $dayDate = date("l", strtotime($_POST['date']));
        $idMonth = date("n", strtotime($_POST['date']));
        $yearDate = date("Y", strtotime($_POST['date']));
        $dayRepository = new DayRepository();
        $day = $dayRepository->findOneByNameEnglish($dayDate);

        $lastYearSeason = (date("m", strtotime($_POST['date'])) < 9) ? $yearDate : $yearDate+1;
        $seasonRepository = new SeasonRepository();
        if(!$season = $seasonRepository->findOneByLastYear($lastYearSeason)) {
            $season = $seasonRepository->save($lastYearSeason-1, $lastYearSeason);
        }

        $idPool = isset($_POST['idPool']) ? $_POST['idPool'] : null;

        $workout = new Workout();
        $workout->setTime($_POST['time']);

        if($_POST['id'] == 0) {
            $requeteInsertWorkout = "INSERT INTO s_seances (id_environnement, id_ce, date_seance, id_mois, id_jour, id_moment, id_saison, distance, denivele, temps, id_intensite, id_strava, id_decathlon, commentaire, entrainement, id_piscine) VALUES (:idEnvironment, :idCompetTrain, :dateWorkout, :idMonth, :idDay, :idMoment, :idSeason, :distance, :elevation, :timeWorkout, :idIntensity, :idStrava, :idDecathlon, :comment, :training, :idPool);";
            $resultInsertWorkout = $this->dbMysql->InsertDeleteUpdate($requeteInsertWorkout, ['idEnvironment' => $_POST['idEnvironment'], 'idCompetTrain' => $_POST['idCompetTrain'], 'dateWorkout' => $_POST['date'], 'idMonth' => $idMonth, 'idDay' => $day->getId(), 'idMoment' => $_POST['idMoment'], 'idSeason' => $season->getId(), 'distance' => $_POST['distance'], 'elevation' => $_POST['elevation'], 'timeWorkout' => $workout->getTime(), 'idIntensity' => $_POST['idIntensity'], 'idStrava' => $_POST['idStrava'], 'idDecathlon' => $_POST['idDecathlon'], 'comment' => $_POST['comment'], 'training' => $_POST['training'], 'idPool' => $idPool]);
            $idWorkout = $this->dbMysql->lastInsertId();
        } else {
            $requeteUpdateWorkout = "UPDATE s_seances SET id_environnement = :idEnvironment, id_ce = :idCompetTrain, date_seance = :dateWorkout, id_mois = :idMonth, id_jour = :idDay, id_moment = :idMoment, id_saison = :idSeason, distance = :distance, denivele = :elevation, temps = :timeWorkout, id_intensite = :idIntensity, id_strava = :idStrava, id_decathlon = :idDecathlon, commentaire = :comment, entrainement = :training, id_piscine = :idPool WHERE id = :idWorkout;";
            $resultUpdateWorkout = $this->dbMysql->InsertDeleteUpdate($requeteUpdateWorkout, ['idEnvironment' => $_POST['idEnvironment'], 'idCompetTrain' => $_POST['idCompetTrain'], 'dateWorkout' => $_POST['date'], 'idMonth' => $idMonth, 'idDay' => $day->getId(), 'idMoment' => $_POST['idMoment'], 'idSeason' => $season->getId(), 'distance' => $_POST['distance'], 'elevation' => $_POST['elevation'], 'timeWorkout' => $workout->getTime(), 'idIntensity' => $_POST['idIntensity'], 'idStrava' => $_POST['idStrava'], 'idDecathlon' => $_POST['idDecathlon'], 'comment' => $_POST['comment'], 'training' => $_POST['training'], 'idPool' => $idPool, 'idWorkout' => $_POST['id']]);
            $idWorkout = $_POST['id'];
        }

        $requetePartners = "SELECT id FROM s_partenaires ORDER BY id;";
        $resultsPartners = $this->dbMysql->select($requetePartners);
        foreach($resultsPartners as $partner) {
            $requeteVerif = "SELECT id FROM s_seances_partenaires WHERE id_seance = :idWorkout AND id_partenaire = :idPartner;";
            $resultVerif = $this->dbMysql->select_one($requeteVerif, ['idWorkout' => $idWorkout, 'idPartner' => $partner['id']]);

            $requeteWorkoutPartner = "";
            if(isset($_POST['partners']) && in_array($partner['id'], $_POST['partners']) && !$resultVerif) {
                $requeteWorkoutPartner = "INSERT INTO s_seances_partenaires (id_seance, id_partenaire) VALUES (:idWorkout, :idPartner);";
            } else if((!isset($_POST['partners']) || !in_array($partner['id'], $_POST['partners'])) && $resultVerif) {
                $requeteWorkoutPartner = "DELETE FROM s_seances_partenaires WHERE id_seance = :idWorkout AND id_partenaire = :idPartner;";
            }
            if($requeteWorkoutPartner != "")
                $resultPartner = $this->dbMysql->InsertDeleteUpdate($requeteWorkoutPartner, ['idWorkout' => $idWorkout, 'idPartner' => $partner['id']]);
        }

        $requeteEquipments = "SELECT id FROM s_materiels ORDER BY id;";
        $resultsEquipments = $this->dbMysql->select($requeteEquipments);
        foreach($resultsEquipments as $equipment) {
            $requeteVerif = "SELECT id FROM s_seances_materiels WHERE id_seance = :idWorkout AND id_materiel = :idEquipment;";
            $resultVerif = $this->dbMysql->select_one($requeteVerif, ['idWorkout' => $idWorkout, 'idEquipment' => $equipment['id']]);

            $requeteWorkoutEquipment = "";
            if(isset($_POST['equipments']) && in_array($equipment['id'], $_POST['equipments']) && !$resultVerif) {
                $requeteWorkoutEquipment = "INSERT INTO s_seances_materiels (id_seance, id_materiel) VALUES (:idWorkout, :idEquipment);";
            } else if((!isset($_POST['equipments']) || !in_array($equipment['id'], $_POST['equipments'])) && $resultVerif) {
                $requeteWorkoutEquipment = "DELETE FROM s_seances_materiels WHERE id_seance = :idWorkout AND id_materiel = :idEquipment;";
            }
            if($requeteWorkoutEquipment != "")
                $resultEquipment = $this->dbMysql->InsertDeleteUpdate($requeteWorkoutEquipment, ['idWorkout' => $idWorkout, 'idEquipment' => $equipment['id']]);
        }

        $requeteRoads = "SELECT id FROM s_routes ORDER BY id;";
        $resultsRoads = $this->dbMysql->select($requeteRoads);
        foreach($resultsRoads as $road) {
            $requeteVerif = "SELECT id FROM s_seances_routes WHERE id_seance = :idWorkout AND id_route = :idRoad;";
            $resultVerif = $this->dbMysql->select_one($requeteVerif, ['idWorkout' => $idWorkout, 'idRoad' => $road['id']]);

            if(isset($_POST['nb_route_'.$road['id']]) && $_POST['nb_route_'.$road['id']] > 0 && !$resultVerif) {
                $requeteWorkoutRoad = "INSERT INTO s_seances_routes (id_seance, id_route, nombre) VALUES (:idWorkout, :idRoad, :number);";
                $resultWorkoutRoad = $this->dbMysql->InsertDeleteUpdate($requeteWorkoutRoad, ['idWorkout' => $idWorkout, 'idRoad' => $road['id'], 'number' => $_POST['nb_route_'.$road['id']]]);
            } else if($resultVerif) {
                if(!isset($_POST['nb_route_'.$road['id']]) || $_POST['nb_route_'.$road['id']] == 0) {
                    $requeteWorkoutRoad = "DELETE FROM s_seances_routes WHERE id_seance = :idWorkout AND id_route = :idRoad;";
                    $resultWorkoutRoad = $this->dbMysql->InsertDeleteUpdate($requeteWorkoutRoad, ['idWorkout' => $idWorkout, 'idRoad' => $road['id']]);
                } else {
                    $requeteWorkoutRoad = "UPDATE s_seances_routes SET nombre = :number WHERE id_seance = :idWorkout AND id_route = :idRoad;";
                    $resultWorkoutRoad = $this->dbMysql->InsertDeleteUpdate($requeteWorkoutRoad, ['idWorkout' => $idWorkout, 'idRoad' => $road['id'], 'number' => $_POST['nb_route_'.$road['id']]]);
                }
            }
        }
    }
}
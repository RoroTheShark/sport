<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/Mount.php');
require_once('src/Sport/entities/Road.php');
require_once('src/Sport/entities/Season.php');
require_once('src/Sport/entities/WorkoutRoad.php');
require_once('src/Sport/repositories/MountRepository.php');

use Sport\Entity\Mount;
use Sport\Entity\Road;
use Sport\Entity\Season;
use Sport\Entity\WorkoutRoad;
use Sport\Repository\MountRepository;

class RoadRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById($idRoad): ?Road
    {
        $requeteRoad = "SELECT id, nom, id_mont FROM s_routes WHERE id = :idRoad;";
        $resultRoad = $this->dbMysql->select_one($requeteRoad, ['idRoad' => $idRoad]);

        $road = new Road();
        if($resultRoad) {
            $road->setId($resultRoad['id']);
            $road->setName($resultRoad['nom']);
            $mountRepository = new MountRepository();
            $road->setMount($mountRepository->findOneById($resultRoad['id_mont']));
        }
        return $road;
    }

    public function findSeveralByMount(Mount $mount): array
    {
        $requeteRoads = "SELECT r.id, r.nom, sesero.routes";
        $requeteRoads .= " FROM s_routes r";
        $requeteRoads .= " LEFT JOIN (SELECT sero.id_route, GROUP_CONCAT(CONCAT(ro.id,'-',ro.nom,'-',sero.nombre) SEPARATOR ', ') AS routes FROM s_routes ro, s_seances_routes sero WHERE ro.id = sero.id_route GROUP BY sero.id_route) sesero ON (r.id = sesero.id_route)";
        $requeteRoads .= " WHERE r.id_mont = :idMount";
        $requeteRoads .= " ORDER BY r.nom ASC;";
        $resultsRoads = $this->dbMysql->select($requeteRoads, ['idMount' => $mount->getId()]);

        $arrayResults = [];
        foreach($resultsRoads as $roadR) {
            $road = new Road();
            $road->setId($roadR['id']);
            $road->setName($roadR['nom']);
            $road->setMount($mount);

            $arrayWorkoutsRoads = [];
            if($roadR['routes'] != "") {
                $tabRoads = explode(", ", $roadR['routes']);
                foreach($tabRoads as $roadR) {
                    $values = explode("-", $roadR);
                    $workoutRoad = new WorkoutRoad();

                    $road = new Road();
                    $road->setId(intval($values[0]));
                    $road->setName($values[1]);

                    $workoutRoad->setRoad($road);
                    $workoutRoad->setNumber(intval($values[2]));

                    array_push($arrayWorkoutsRoads, $workoutRoad);
                }
            }
            $road->setWorkoutsRoads($arrayWorkoutsRoads);

            array_push($arrayResults, $road);
        }
        
        return $arrayResults;
    }

    public function findStatsByDates(string $dateStart, string $dateEnd): array
    {
        $requeteStatsRoads = "SELECT ro.id AS id_route, SUM(sesero.nombre) AS nombre";
        $requeteStatsRoads .= " FROM s_routes ro LEFT JOIN";
        $requeteStatsRoads .= "    (SELECT sero.id, sero.id_route, sero.nombre FROM s_seances se, s_seances_routes sero WHERE se.id = sero.id_seance AND se.date_seance BETWEEN :dateStart AND :dateEnd) sesero ON (ro.id = sesero.id_route)";
        $requeteStatsRoads .= " GROUP BY ro.id";
        $requeteStatsRoads .= " ORDER BY ro.id;";
        $resultsStatsRoads = $this->dbMysql->select($requeteStatsRoads, ['dateStart' => $dateStart, 'dateEnd' => $dateEnd]);

        $arrayResults = [];
        foreach($resultsStatsRoads as $statsRoad) {
            $arrayResults[$statsRoad['id_route']] = $statsRoad['nombre'];
        }
        
        return $arrayResults;
    }

    public function save(): void
    {
        if($_POST['id'] == 0) {
            $requeteInsertRoad = "INSERT INTO s_routes (nom, id_mont) VALUES (:name, :idMount);";
            $resultInsertRoad = $this->dbMysql->InsertDeleteUpdate($requeteInsertRoad, ['name' => $_POST['name'], 'idMount' => $_POST['idMount']]);
        } else {
            $requeteUpdateRoad = "UPDATE s_routes SET nom = :name WHERE id = :idRoad;";
            $resultUpdateRoad = $this->dbMysql->InsertDeleteUpdate($requeteUpdateRoad, ['name' => $_POST['name'], 'idRoad' => $_POST['id']]);
        }
    }
}
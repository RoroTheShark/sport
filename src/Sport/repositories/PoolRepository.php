<?php

namespace Sport\Repository;

require_once('db.class.php');

require_once('src/Sport/entities/City.php');
require_once('src/Sport/entities/Pool.php');
require_once('src/Sport/entities/Season.php');

require_once('src/Sport/repositories/CityRepository.php');
require_once('src/Sport/repositories/WorkoutRepository.php');

use Sport\Entity\City;
use Sport\Entity\Pool;
use Sport\Entity\Season;

use Sport\Repository\CityRepository;
use Sport\Repository\WorkoutRepository;

class PoolRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById($idPool): ?Pool
    {
        $requetePool = "SELECT id, nom, id_ville FROM s_piscines WHERE id = :idPool;";
        $resultPool = $this->dbMysql->select_one($requetePool, ['idPool' => $idPool]);

        $pool = new Pool();
        if($resultPool) {
            $pool->setId($resultPool['id']);
            $pool->setName($resultPool['nom']);
            $cityRepository = new CityRepository();
            $pool->setCity($cityRepository->findOneById($resultPool['id_ville']));
        }
        return $pool;
    }

    public function findSeveralByCity(City $city): array
    {
        $requetePools = "SELECT id, nom FROM s_piscines WHERE id_ville = :idCity ORDER BY nom ASC;";
        $resultsPools = $this->dbMysql->select($requetePools, ['idCity' => $city->getId()]);

        $arrayResults = [];
        foreach($resultsPools as $poolR) {
            $pool = new Pool();
            $pool->setId($poolR['id']);
            $pool->setName($poolR['nom']);
            $pool->setCity($city);
            $workoutRepository = new WorkoutRepository();
            $pool->setWorkouts($workoutRepository->findSeveralByPool($pool));
            array_push($arrayResults, $pool);
        }
        
        return $arrayResults;
    }

    public function findAll(): array
    {
        $requetePools = "SELECT p.id AS id_piscine, p.nom, v.id AS id_ville FROM s_piscines p, s_villes v WHERE p.id_ville = v.id ORDER BY p.nom ASC;";
        $resultsPools = $this->dbMysql->select($requetePools);

        $arrayResults = [];
        foreach($resultsPools as $poolR) {
            $pool = new Pool();
            $pool->setId($poolR['id_piscine']);
            $pool->setName($poolR['nom']);

            $city = new City();
            $city->setId($poolR['id_ville']);
            $pool->setCity($city);
            array_push($arrayResults, $pool);
        }
        
        return $arrayResults;
    }

    public function findStatsByDates(string $dateStart, string $dateEnd): array
    {
        // 1 = entraînement, 2 = compétition, 3 = échauffement/récup compétition
        $requeteStatsPools = "SELECT pi.id AS id_piscine, se1.nombre AS nombre1, se2.nombre AS nombre2, se3.nombre AS nombre3";
        $requeteStatsPools .= " FROM s_piscines pi";
        $requeteStatsPools .= "     LEFT JOIN (SELECT id_piscine, COUNT(*) AS nombre FROM s_seances WHERE date_seance BETWEEN :dateStart AND :dateEnd AND id_ce = 1 AND id_piscine IS NOT NULL GROUP BY id_piscine) se1 ON (se1.id_piscine = pi.id)";
        $requeteStatsPools .= "     LEFT JOIN (SELECT id_piscine, COUNT(*) AS nombre FROM s_seances WHERE date_seance BETWEEN :dateStart AND :dateEnd AND id_ce = 2 AND id_piscine IS NOT NULL GROUP BY id_piscine) se2 ON (se2.id_piscine = pi.id)";
        $requeteStatsPools .= "     LEFT JOIN (SELECT id_piscine, COUNT(*) AS nombre FROM s_seances WHERE date_seance BETWEEN :dateStart AND :dateEnd AND id_ce = 3 AND id_piscine IS NOT NULL GROUP BY id_piscine) se3 ON (se3.id_piscine = pi.id)";
        $requeteStatsPools .= " GROUP BY pi.id";
        $requeteStatsPools .= " ORDER BY pi.id;";
        $resultsStatsPools = $this->dbMysql->select($requeteStatsPools, ['dateStart' => $dateStart, 'dateEnd' => $dateEnd]);

        $arrayResults = [];
        foreach($resultsStatsPools as $statsPool) {
            $arrayResults[$statsPool['id_piscine']] = ['number1' => $statsPool['nombre1'], 'number2' => $statsPool['nombre2'], 'number3' => $statsPool['nombre3']];
        }
        
        return $arrayResults;
    }

    public function save(): void
    {
        if($_POST['id'] == 0) {
            $requeteInsertPool = "INSERT INTO s_piscines (nom, id_ville) VALUES (:name, :idCity);";
            $resultInsertPool = $this->dbMysql->InsertDeleteUpdate($requeteInsertPool, ['name' => $_POST['name'], 'idCity' => $_POST['idCity']]);
        } else {
            $requeteUpdatePool = "UPDATE s_piscines SET nom = :name WHERE id = :idPool;";
            $resultUpdatePool = $this->dbMysql->InsertDeleteUpdate($requeteUpdatePool, ['name' => $_POST['name'], 'idPool' => $_POST['id']]);
        }
    }
}
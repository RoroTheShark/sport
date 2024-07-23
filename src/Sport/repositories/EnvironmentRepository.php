<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/Environment.php');
require_once('src/Sport/entities/Season.php');
require_once('src/Sport/entities/Sport.php');
require_once('src/Sport/repositories/SportRepository.php');

use Sport\Entity\Environment;
use Sport\Entity\Season;
use Sport\Entity\Sport;
use Sport\Repository\SportRepository;

class EnvironmentRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById($idEnvironment): Environment
    {
        $requeteEnvironment = "SELECT id, nom, id_sport FROM s_environnements WHERE id = :idEnvironment;";
        $resultEnvironment = $this->dbMysql->select_one($requeteEnvironment, ['idEnvironment' => $idEnvironment]);

        $environment = new Environment();
        if($resultEnvironment) {
            $environment->setId($resultEnvironment['id']);
            $environment->setName($resultEnvironment['nom']);
            $sportRepository = new SportRepository();
            $sport = $sportRepository->findOneById($resultEnvironment['id_sport']);
        }
        return $environment;
    }

    public function findAll(): array
    {
        $requeteEnvironments = "SELECT id, nom, id_sport FROM s_environnements ORDER BY nom ASC;";
        $resultsEnvironments = $this->dbMysql->select($requeteEnvironments);

        $arrayResults = [];
        foreach($resultsEnvironments as $environmentR) {
            $environment = new Environment();
            $environment->setId($environmentR['id']);
            $environment->setName($environmentR['nom']);
            $sportRepository = new SportRepository();
            $sport = $sportRepository->findOneById($environmentR['id_sport']);
            $environment->setSport($sport);
            array_push($arrayResults, $environment);
        }
        
        return $arrayResults;
    }

    public function findSeveralBySport(Sport $sport): array
    {
        $requeteEnvironments = "SELECT id, nom FROM s_environnements WHERE id_sport = :idSport ORDER BY nom ASC;";
        $resultsEnvironments = $this->dbMysql->select($requeteEnvironments, ['idSport' => $sport->getId()]);

        $arrayResults = [];
        foreach($resultsEnvironments as $environmentR) {
            $environment = new Environment();
            $environment->setId($environmentR['id']);
            $environment->setName($environmentR['nom']);
            $environment->setSport($sport);
            array_push($arrayResults, $environment);
        }
        
        return $arrayResults;
    }

    public function findSeveralBySportDatesActualAndPrevious(Sport $sport, string $dateStartActual, string $dateEndActual, string $dateStartPrevious, string $dateEndPrevious): array
    {
        $requeteEnvironments = "SELECT env.id, env.nom";
        $requeteEnvironments .= " FROM s_environnements env, s_seances se";
        $requeteEnvironments .= " WHERE env.id = se.id_environnement AND (se.date_seance BETWEEN :dateStartActual AND :dateEndActual OR se.date_seance BETWEEN :dateStartPrevious AND :dateEndPrevious) AND env.id_sport = :idSport";
        $requeteEnvironments .= " GROUP BY env.id, env.nom";
        $requeteEnvironments .= " ORDER BY env.id ASC;";
        $resultsEnvironments = $this->dbMysql->select($requeteEnvironments, ['idSport' => $sport->getId(), 'dateStartActual' => $dateStartActual, 'dateEndActual' => $dateEndActual, 'dateStartPrevious' => $dateStartPrevious, 'dateEndPrevious' => $dateEndPrevious]);

        $arrayResults = [];
        foreach($resultsEnvironments as $environmentR) {
            $environment = new Environment();
            $environment->setId($environmentR['id']);
            $environment->setName($environmentR['nom']);
            array_push($arrayResults, $environment);
        }
        
        return $arrayResults;
    }

    public function save(): void
    {
        if($_POST['id'] == 0) {
            $requeteInsertEnvironment = "INSERT INTO s_environnements (nom) VALUES (:name);";
            $resultInsertEnvironment = $this->dbMysql->InsertDeleteUpdate($requeteInsertEnvironment, ['name' => $_POST['name']]);
        } else {
            $requeteUpdateEnvironment = "UPDATE s_environnements SET nom = :name WHERE id = :idEnvironment;";
            $resultUpdateEnvironment = $this->dbMysql->InsertDeleteUpdate($requeteUpdateEnvironment, ['name' => $_POST['name'], 'idEnvironment' => $_POST['id']]);
        }
    }
}
<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/Environment.php');
require_once('src/Sport/entities/Equipment.php');
require_once('src/Sport/entities/Season.php');
require_once('src/Sport/entities/Sport.php');
require_once('src/Sport/repositories/EnvironmentRepository.php');

use Sport\Entity\Environment;
use Sport\Entity\Equipment;
use Sport\Entity\Season;
use Sport\Entity\Sport;
use Sport\Repository\EnvironmentRepository;

class SportRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById($idSport): Sport
    {
        $requeteSport = "SELECT id, nom FROM s_sports WHERE id = :idSport;";
        $resultSport = $this->dbMysql->select_one($requeteSport, ['idSport' => $idSport]);

        $sport = new Sport();
        if($resultSport) {
            $sport->setId($resultSport['id']);
            $sport->setName($resultSport['nom']);
            $environmentRepository = new EnvironmentRepository();
            $sport->setEnvironments($environmentRepository->findSeveralBySport($sport));
        }
        return $sport;
    }

    public function findAll(): array
    {
        $requeteSports = "SELECT id, nom FROM s_sports ORDER BY nom ASC;";
        $resultsSports = $this->dbMysql->select($requeteSports);

        $arrayResults = [];
        foreach($resultsSports as $sportR) {
            $sport = new Sport();
            $sport->setId($sportR['id']);
            $sport->setName($sportR['nom']);
            $environmentRepository = new EnvironmentRepository();
            $sport->setEnvironments($environmentRepository->findSeveralBySport($sport));
            array_push($arrayResults, $sport);
        }
        
        return $arrayResults;
    }

    public function findSeveralByEquipment(Equipment $equipment): array
    {
        $requeteSports = "SELECT s.id, s.nom FROM s_materiels_sports ms, s_sports s WHERE ms.id_sport = s.id AND ms.id_materiel = :idEquipment ORDER BY s.nom ASC;";
        $resultsSports = $this->dbMysql->select($requeteSports, ['idEquipment' => $equipment->getId()]);

        $arrayResults = [];
        foreach($resultsSports as $sportR) {
            $sport = new Sport();
            $sport->setId($sportR['id']);
            $sport->setName($sportR['nom']);
            array_push($arrayResults, $sport);
        }
        
        return $arrayResults;
    }

    public function findSeveralByDatesActualAndPrevious(string $dateStartActual, string $dateEndActual, string $dateStartPrevious, string $dateEndPrevious): array
    {
        $requeteSports = "SELECT sp.id, sp.nom";
        $requeteSports .= " FROM s_sports sp, s_environnements env, s_seances se";
        $requeteSports .= " WHERE sp.id = env.id_sport AND env.id = se.id_environnement AND (se.date_seance BETWEEN :dateStartActual AND :dateEndActual OR se.date_seance BETWEEN :dateStartPrevious AND :dateEndPrevious)";
        $requeteSports .= " GROUP BY sp.id, sp.nom";
        $requeteSports .= " ORDER BY sp.id ASC;";
        $resultsSports = $this->dbMysql->select($requeteSports, ['dateStartActual' => $dateStartActual, 'dateEndActual' => $dateEndActual, 'dateStartPrevious' => $dateStartPrevious, 'dateEndPrevious' => $dateEndPrevious]);

        $arrayResults = [];
        foreach($resultsSports as $sportR) {
            $sport = new Sport();
            $sport->setId($sportR['id']);
            $sport->setName($sportR['nom']);
            $environmentRepository = new EnvironmentRepository();
            $sport->setEnvironments($environmentRepository->findSeveralBySportDatesActualAndPrevious($sport, $dateStartActual, $dateEndActual, $dateStartPrevious, $dateEndPrevious));
            array_push($arrayResults, $sport);
        }
        
        return $arrayResults;
    }

    public function save(): void
    {
        if($_POST['id'] == 0) {
            $requeteInsertSport = "INSERT INTO s_sports (nom) VALUES (:name);";
            $resultInsertSport = $this->dbMysql->InsertDeleteUpdate($requeteInsertSport, ['name' => $_POST['name']]);
        } else {
            $requeteUpdateSport = "UPDATE s_sports SET nom = :name WHERE id = :idSport;";
            $resultUpdateSport = $this->dbMysql->InsertDeleteUpdate($requeteUpdateSport, ['name' => $_POST['name'], 'idSport' => $_POST['id']]);
        }
    }
}
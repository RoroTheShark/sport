<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/Equipment.php');
require_once('src/Sport/entities/EquipmentSubType.php');
require_once('src/Sport/entities/EquipmentType.php');
require_once('src/Sport/entities/Sport.php');
require_once('src/Sport/repositories/EquipmentTypeRepository.php');
require_once('src/Sport/repositories/SportRepository.php');

use Sport\Entity\Equipment;
use Sport\Entity\EquipmentSubType;
use Sport\Entity\EquipmentType;
use Sport\Entity\Sport;
use Sport\Repository\EquipmentTypeRepository;
use Sport\Repository\SportRepository;

class EquipmentSubTypeRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById($idEquipmentSubType): ?EquipmentSubType
    {
        $requeteEquipmentSubType = "SELECT id, nom, id_type FROM s_materiels_sous_types WHERE id = :idEquipmentSubType;";
        $resultEquipmentSubType = $this->dbMysql->select_one($requeteEquipmentSubType, ['idEquipmentSubType' => $idEquipmentSubType]);

        $equipmentSubType = new EquipmentSubType();
        if($resultEquipmentSubType) {
            $equipmentSubType->setId($resultEquipmentSubType['id']);
            $equipmentSubType->setName($resultEquipmentSubType['nom']);
            $equipmentTypeRepository = new EquipmentTypeRepository();
            $equipmentSubType->setEquipmentType($equipmentTypeRepository->findOneById($resultEquipmentSubType['id_type']));
            $equipmentRepository = new EquipmentRepository();
            $equipmentSubType->setEquipments($equipmentRepository->findSeveralByEquipmentSubType($equipmentSubType));
        }
        return $equipmentSubType;
    }

    public function findSeveralByEquipmentType(EquipmentType $equipmentType): array
    {
        $requeteEquipmentSubType = "SELECT mst.id, mst.nom, mst.id_type";
        $requeteEquipmentSubType .= " FROM s_materiels_sous_types mst";
        $requeteEquipmentSubType .= " WHERE mst.id_type = :idEquipmentType";
        $requeteEquipmentSubType .= " ORDER BY mst.id ASC;";
        $resultsEquipmentSubType = $this->dbMysql->select($requeteEquipmentSubType, ['idEquipmentType' => $equipmentType->getId()]);

        $arrayResults = [];
        foreach($resultsEquipmentSubType as $equipmentSubTypeR) {
            $equipmentSubType = new EquipmentSubType();
            $equipmentSubType->setId($equipmentSubTypeR['id']);
            $equipmentSubType->setName($equipmentSubTypeR['nom']);
            $equipmentSubType->setEquipmentType($equipmentType);

            $equipmentRepository = new EquipmentRepository();
            $equipmentSubType->setEquipments($equipmentRepository->findSeveralByEquipmentSubType($equipmentSubType));

            array_push($arrayResults, $equipmentSubType);
        }
        
        return $arrayResults;
    }

    public function findAll(): array
    {
        $requeteEquipmentSubTypes = "SELECT masoty.id, masoty.nom, maty.id AS id_type FROM s_materiels_sous_types masoty, s_materiels_types maty WHERE masoty.id_type = maty.id ORDER BY masoty.id, maty.id;";
        $resultsEquipmentSubTypes = $this->dbMysql->select($requeteEquipmentSubTypes);

        $arrayResults = [];
        foreach($resultsEquipmentSubTypes as $equipmentSubTypeR) {
            $equipmentSubType = new EquipmentSubType();
            $equipmentSubType->setId($equipmentSubTypeR['id']);
            $equipmentSubType->setName($equipmentSubTypeR['nom']);
            $equipmentTypeRepository = new EquipmentTypeRepository();
            $equipmentSubType->setEquipmentType($equipmentTypeRepository->findOneById($equipmentSubTypeR['id_type']));
            $equipmentRepository = new EquipmentRepository();
            $equipmentSubType->setEquipments($equipmentRepository->findSeveralByEquipmentSubType($equipmentSubType));
            array_push($arrayResults, $equipmentSubType);
        }
        
        return $arrayResults;
    }

    public function save(): void
    {
        if($_POST['id'] == 0) {
            $requeteInsertEquipmentSubType = "INSERT INTO s_materiels_sous_types (nom, id_type) VALUES (:name, :idEquipmentType);";
            $resultInsertEquipmentSubType = $this->dbMysql->InsertDeleteUpdate($requeteInsertEquipmentSubType, ['name' => $_POST['name'], 'idEquipmentType' => $_POST['idEquipmentType']]);
        } else {
            $requeteUpdateEquipmentSubType = "UPDATE s_materiels_sous_types SET nom = :name WHERE id = :idEquipmentSubType;";
            $resultUpdateEquipmentSubType = $this->dbMysql->InsertDeleteUpdate($requeteUpdateEquipmentSubType, ['name' => $_POST['name'], 'idEquipmentSubType' => $_POST['id']]);
        }
    }
}
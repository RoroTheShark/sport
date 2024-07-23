<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/EquipmentType.php');
require_once('src/Sport/repositories/EquipmentSubTypeRepository.php');

use Sport\Entity\EquipmentType;
use Sport\Repository\EquipmentSubTypeRepository;

class EquipmentTypeRepository
{
    private \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById($idEquipmentType): EquipmentType
    {
        $requeteEquipmentType = "SELECT id, nom FROM s_materiels_types WHERE id = :idEquipmentType;";
        $resultEquipmentType = $this->dbMysql->select_one($requeteEquipmentType, ['idEquipmentType' => $idEquipmentType]);

        $equipmentType = new EquipmentType();
        if($resultEquipmentType) {
            $equipmentType->setId($resultEquipmentType['id']);
            $equipmentType->setName($resultEquipmentType['nom']);
            $equipmentSubTypeRepository = new EquipmentSubTypeRepository();
            $equipmentType->setEquipmentSubTypes($equipmentSubTypeRepository->findSeveralByEquipmentType($equipmentType));
        }
        return $equipmentType;
    }

    public function findAll(): array
    {
        $requeteEquipmentTypes = "SELECT id, nom FROM s_materiels_types ORDER BY nom ASC;";
        $resultsEquipmentTypes = $this->dbMysql->select($requeteEquipmentTypes);

        $arrayResults = [];
        foreach($resultsEquipmentTypes as $equipmentTypeR) {
            $equipmentType = new EquipmentType();
            $equipmentType->setId($equipmentTypeR['id']);
            $equipmentType->setName($equipmentTypeR['nom']);
            $equipmentSubTypeRepository = new EquipmentSubTypeRepository();
            $equipmentType->setEquipmentSubTypes($equipmentSubTypeRepository->findSeveralByEquipmentType($equipmentType));
            array_push($arrayResults, $equipmentType);
        }
        
        return $arrayResults;
    }

    public function save(): void
    {
        if($_POST['id'] == 0) {
            $requeteInsertEquipmentType = "INSERT INTO s_materiels_types (nom) VALUES (:name);";
            $resultInsertEquipmentType = $this->dbMysql->InsertDeleteUpdate($requeteInsertEquipmentType, ['name' => $_POST['name']]);
        } else {
            $requeteUpdateEquipmentType = "UPDATE s_materiels_types SET nom = :name WHERE id = :idEquipmentType;";
            $resultUpdateEquipmentType = $this->dbMysql->InsertDeleteUpdate($requeteUpdateEquipmentType, ['name' => $_POST['name'], 'idEquipmentType' => $_POST['id']]);
        }
    }

}
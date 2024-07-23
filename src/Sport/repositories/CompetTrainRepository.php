<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/CompetTrain.php');

use Sport\Entity\CompetTrain;

class CompetTrainRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findAll(): array
    {
        $requeteCTs = "SELECT id, nom FROM s_ce ORDER BY nom ASC;";
        $resultsCTs = $this->dbMysql->select($requeteCTs);

        $arrayResults = [];
        foreach($resultsCTs as $ctR) {
            $competTrain = new CompetTrain();
            $competTrain->setId($ctR['id']);
            $competTrain->setName($ctR['nom']);
            array_push($arrayResults, $competTrain);
        }
        
        return $arrayResults;
    }
}
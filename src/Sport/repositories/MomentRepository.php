<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/Moment.php');

use Sport\Entity\Moment;

class MomentRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findAll(): array
    {
        $requeteMoments = "SELECT id, nom FROM s_moments ORDER BY id ASC;";
        $resultsMoments = $this->dbMysql->select($requeteMoments);

        $arrayResults = [];
        foreach($resultsMoments as $momentR) {
            $moment = new Moment();
            $moment->setId($momentR['id']);
            $moment->setName($momentR['nom']);
            array_push($arrayResults, $moment);
        }
        
        return $arrayResults;
    }
}
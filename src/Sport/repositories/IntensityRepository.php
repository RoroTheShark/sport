<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/Intensity.php');

use Sport\Entity\Intensity;

class IntensityRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findAll(): array
    {
        $requeteIntensities = "SELECT id, valeur FROM s_intensites ORDER BY id ASC;";
        $resultsIntensities = $this->dbMysql->select($requeteIntensities);

        $arrayResults = [];
        foreach($resultsIntensities as $intensityR) {
            $intensity = new Intensity();
            $intensity->setId($intensityR['id']);
            $intensity->setValue($intensityR['valeur']);
            array_push($arrayResults, $intensity);
        }
        
        return $arrayResults;
    }
}
<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/Day.php');

use Sport\Entity\Day;

class DayRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneByNameEnglish($nameEnglish): Day
    {
        $requeteDay = "SELECT id, nom, nom_anglais FROM s_jours WHERE nom_anglais = :nameEnglish;";
        $resultDay = $this->dbMysql->select_one($requeteDay, ['nameEnglish' => $nameEnglish]);

        $day = new Day();
        if($resultDay) {
            $day->setId($resultDay['id']);
            $day->setName($resultDay['nom']);
            $day->setNameEnglish($resultDay['nom_anglais']);
        }
        return $day;
    }
}
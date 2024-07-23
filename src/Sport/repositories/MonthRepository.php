<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/Month.php');
require_once('src/Sport/entities/Season.php');

use Sport\Entity\Month;
use Sport\Entity\Season;

class MonthRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById($idMonth): Event
    {
        $requeteMonth = "SELECT id, nom, nom_anglais, ordre_saison FROM s_mois WHERE id = :idMonth;";
        $resultMonth = $this->dbMysql->select_one($requeteMonth, ['idMonth' => $idMonth]);

        $month = new Month();
        if($resultMonth) {
            $month->setId($resultMonth['id']);
            $month->setName($resultMonth['nom']);
            $month->setNameEnglish($resultMonth['nom_anglais']);
            $month->setOrderSeason($resultMonth['ordre_saison']);
        }
        return $month;
    }

    public function findSeveralByDates(string $dateStart, string $dateEnd): array
    {
        $requeteMonths = "SELECT sm.id, sm.nom";
        $requeteMonths .= " FROM s_mois sm, s_seances se";
        $requeteMonths .= " WHERE sm.id = se.id_mois AND se.date_seance BETWEEN :dateStart AND :dateEnd";
        $requeteMonths .= " GROUP BY sm.id, sm.nom";
        $requeteMonths .= " ORDER BY sm.ordre_saison ASC;";
        $resultsMonths = $this->dbMysql->select($requeteMonths, ['dateStart' => $dateStart, 'dateEnd' => $dateEnd]);

        $arrayResults = [];
        foreach($resultsMonths as $monthR) {
            $month = new Month();
            $month->setId($monthR['id']);
            $month->setName($monthR['nom']);
            array_push($arrayResults, $month);
        }
        
        return $arrayResults;
    }
}
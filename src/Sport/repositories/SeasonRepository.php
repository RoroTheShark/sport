<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/Season.php');

use Sport\Entity\Season;

class SeasonRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById(int $idSeason): ?Season
    {
        $requeteSeason = "SELECT id, annee_debut, annee_fin FROM s_saisons WHERE id = :idSeason ORDER BY annee_debut;";
        $resultSeason = $this->dbMysql->select_one($requeteSeason, ['idSeason' => $idSeason]);

        $season = null;
        if($resultSeason) {
            $season = new Season();
            $season->setId($resultSeason['id']);
            $season->setYearStart($resultSeason['annee_debut']);
            $season->setYearEnd($resultSeason['annee_fin']);
        }
        return $season;
    }

    public function findOneByLastYear($lastDate): ?Season
    {
        $requeteSeason = "SELECT id, annee_debut, annee_fin FROM s_saisons WHERE annee_fin = :lastDate;";
        $resultSeason = $this->dbMysql->select_one($requeteSeason, ['lastDate' => $lastDate]);

        $season = null;
        if($resultSeason) {
            $season = new Season();
            $season->setId($resultSeason['id']);
            $season->setYearStart($resultSeason['annee_debut']);
            $season->setYearEnd($resultSeason['annee_fin']);
        }
        return $season;
    }

    public function findAll(): array
    {
        $requeteSeasons = "SELECT id, annee_debut, annee_fin FROM s_saisons;";
        $resultSeasons = $this->dbMysql->select($requeteSeasons);

        $arrayResults = [];
        foreach($resultSeasons as $seasonR) {
            $season = new Season();
            $season->setId($seasonR['id']);
            $season->setYearStart($seasonR['annee_debut']);
            $season->setYearEnd($seasonR['annee_fin']);

            array_push($arrayResults, $season);
        }
        return $arrayResults;
    }

    public function save($yearStart, $yearEnd): Season
    {
        $requeteInsertSeason = "INSERT INTO s_saison (annee_debut, annee_fin) VALUES (:yearStart, :yearEnd);";
        $resultInsertSeason = $this->dbMysql->InsertDeleteUpdate($requeteInsertSeason, ['yearStart' => $yearStart, 'yearEnd' => $yearEnd]);

        $season = new Season();
        $season->setId($this->dbMysql->lastInsertId()); // Pas besoin d'instancier plus pour la suite

        return $season;
    }
}
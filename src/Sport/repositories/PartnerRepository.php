<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/DisplayDatas.php');
require_once('src/Sport/entities/Partner.php');
require_once('src/Sport/entities/Season.php');

use Sport\Entity\DisplayDatas;
use Sport\Entity\Partner;
use Sport\Entity\Season;

class PartnerRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById($idPartner): Partner
    {
        $requetePartner = "SELECT id, nom FROM s_partenaires WHERE id = :idPartner;";
        $resultPartner = $this->dbMysql->select_one($requetePartner, ['idPartner' => $idPartner]);

        $partner = new Partner();
        if($resultPartner) {
            $partner->setId($resultPartner['id']);
            $partner->setName($resultPartner['nom']);
        }
        return $partner;
    }

    public function findAll(): array
    {
        $requetePartners = "SELECT id, nom FROM s_partenaires ORDER BY nom ASC;";
        $resultsPartners = $this->dbMysql->select($requetePartners);

        $arrayResults = [];
        foreach($resultsPartners as $partnerR) {
            $partner = new Partner();
            $partner->setId($partnerR['id']);
            $partner->setName($partnerR['nom']);
            array_push($arrayResults, $partner);
        }
        
        return $arrayResults;
    }

    public function findStatsByDates(string $dateStart, string $dateEnd): array
    {
        $requeteStatsPartners = "SELECT se.id_mois, sp.id_partenaire, p.nom, COUNT(se.id) AS nombre, SUM(se.temps) AS temps";
        $requeteStatsPartners .= " FROM s_seances se";
        $requeteStatsPartners .= "  LEFT JOIN s_seances_partenaires sp ON se.id = sp.id_seance";
        $requeteStatsPartners .= "  LEFT JOIN s_partenaires p ON sp.id_partenaire = p.id";
        $requeteStatsPartners .= " WHERE se.date_seance BETWEEN :dateStart AND :dateEnd";
        $requeteStatsPartners .= " GROUP BY se.id_mois, sp.id_partenaire, p.nom";
        $requeteStatsPartners .= " ORDER BY se.id_mois, COUNT(se.id) DESC, p.nom;";
        //echo $requeteStatsWorkouts;
        $resultsStatsPartners = $this->dbMysql->select($requeteStatsPartners, ['dateStart' => $dateStart, 'dateEnd' => $dateEnd]);

        $arrayResults = ['months' => [], 'partners' => []];
        $arrayPartners = [];
        $arrayMonths = [];
        foreach($resultsStatsPartners as $statsPartner) {
            $partnerName = $statsPartner['id_partenaire'] == null ? "Solo" : $statsPartner['nom'];
            if(!isset($arrayMonths[$statsPartner['id_mois']])) {
                $arrayMonths[$statsPartner['id_mois']] = [];
            }
            $arrayMonths[$statsPartner['id_mois']][$partnerName] = new DisplayDatas(0, 0, $statsPartner['temps'], 0, $statsPartner['nombre']);

            if(!isset($arrayPartners[$partnerName])) {
                $arrayPartners[$partnerName] = ['number' => 0, 'time' => 0];
            }
            $arrayPartners[$partnerName]['number'] += $statsPartner['nombre'];
            $arrayPartners[$partnerName]['time'] += $statsPartner['temps'];
        }
        foreach($arrayMonths as $idMonth => $tabPartner) {
            // On trie pour avoir celui qui a le plus de séance en haut
            uasort($tabPartner, function($a, $b) {
                if($a->getNumWorkouts() == $b->getNumWorkouts())
                    return 0;
                return ($a->getNumWorkouts() > $b->getNumWorkouts()) ? -1 : 1;
            });
            $arrayResults['months'][$idMonth] = implode("<br />", array_map(fn(string $k, DisplayDatas $v): string => $k." : ".$v->getNumWorkouts(), array_keys($tabPartner), array_values($tabPartner)));
        }
        foreach($arrayPartners as $idPartner => $partner) {
            $arrayResults['partners'][$idPartner] = new DisplayDatas(0, 0, $partner['time'], 0, $partner['number']);
        }
        
        return $arrayResults;
    }

    public function save(): void
    {
        if($_POST['id'] == 0) {
            $requeteInsertPartner = "INSERT INTO s_partenaires (nom) VALUES (:name);";
            $resultInsertPartner = $this->dbMysql->InsertDeleteUpdate($requeteInsertPartner, ['name' => $_POST['name']]);
        } else {
            $requeteUpdatePartner = "UPDATE s_partenaires SET nom = :name WHERE id = :idPartner;";
            $resultUpdatePartner = $this->dbMysql->InsertDeleteUpdate($requeteUpdatePartner, ['name' => $_POST['name'], 'idPartner' => $_POST['id']]);
        }
    }
}
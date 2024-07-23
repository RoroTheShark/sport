<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/Mount.php');
require_once('src/Sport/entities/Country.php');
require_once('src/Sport/repositories/CountryRepository.php');
require_once('src/Sport/repositories/RoadRepository.php');

use Sport\Entity\Mount;
use Sport\Entity\Country;
use Sport\Repository\CountryRepository;
use Sport\Repository\RoadRepository;

class MountRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById($idMount): Mount
    {
        $requeteMount = "SELECT id, nom, id_pays FROM s_monts WHERE id = :idMount;";
        $resultMount = $this->dbMysql->select_one($requeteMount, ['idMount' => $idMount]);

        $mount = new Mount();
        if($resultMount) {
            $mount->setId($resultMount['id']);
            $mount->setName($resultMount['nom']);
            $countryRepository = new CountryRepository();
            $mount->setCountry($countryRepository->findOneById($resultMount['id_pays']));
        }
        return $mount;
    }

    public function findSeveralByCountry(Country $country): array
    {
        $requeteMounts = "SELECT id, nom FROM s_monts WHERE id_pays = :idCountry ORDER BY nom ASC;";
        $resultsMounts = $this->dbMysql->select($requeteMounts, ['idCountry' => $country->getId()]);

        $arrayResults = [];
        foreach($resultsMounts as $mountR) {
            $mount = new Mount();
            $mount->setId($mountR['id']);
            $mount->setName($mountR['nom']);
            $mount->setCountry($country);
            $roadRepository = new RoadRepository();
            $mount->setRoads($roadRepository->findSeveralByMount($mount));
            array_push($arrayResults, $mount);
        }
        
        return $arrayResults;
    }

    public function findSeveralByCountryWithRoads(Country $country): array
    {
        $requeteMounts = "SELECT m.id, m.nom FROM s_monts m INNER JOIN s_routes r ON (r.id_mont = m.id) WHERE m.id_pays = :idCountry GROUP BY m.id, m.nom ORDER BY m.nom ASC;";
        $resultsMounts = $this->dbMysql->select($requeteMounts, ['idCountry' => $country->getId()]);

        $arrayResults = [];
        foreach($resultsMounts as $mountR) {
            $mount = new Mount();
            $mount->setId($mountR['id']);
            $mount->setName($mountR['nom']);
            $mount->setCountry($country);
            $roadRepository = new RoadRepository();
            $mount->setRoads($roadRepository->findSeveralByMount($mount));
            array_push($arrayResults, $mount);
        }
        
        return $arrayResults;
    }

    public function save(): void
    {
        if($_POST['id'] == 0) {
            $requeteInsertMount = "INSERT INTO s_monts (nom, id_pays) VALUES (:name, :idCountry);";
            $resultInsertMount = $this->dbMysql->InsertDeleteUpdate($requeteInsertMount, ['name' => $_POST['name'], 'idCountry' => $_POST['idCountry']]);
        } else {
            $requeteUpdateMount = "UPDATE s_monts SET nom = :name WHERE id = :idMount;";
            $resultUpdateMount = $this->dbMysql->InsertDeleteUpdate($requeteUpdateMount, ['name' => $_POST['name'], 'idMount' => $_POST['id']]);
        }
    }
}
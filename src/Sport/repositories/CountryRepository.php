<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/Country.php');
require_once('src/Sport/entities/Mount.php');
require_once('src/Sport/entities/Road.php');
require_once('src/Sport/entities/Season.php');
require_once('src/Sport/repositories/CityRepository.php');
require_once('src/Sport/repositories/MountRepository.php');

use Sport\Entity\Country;
use Sport\Entity\Mount;
use Sport\Entity\Road;
use Sport\Entity\Season;
use Sport\Repository\CityRepository;
use Sport\Repository\MountRepository;

class CountryRepository
{
    private \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById($idCountry): Country
    {
        $requeteCountry = "SELECT id, nom FROM s_pays WHERE id = :idCountry;";
        $resultCountry = $this->dbMysql->select_one($requeteCountry, ['idCountry' => $idCountry]);

        $country = new Country();
        if($resultCountry) {
            $country->setId($resultCountry['id']);
            $country->setName($resultCountry['nom']);
            $mountRepository = new MountRepository();
            $country->setMounts($mountRepository->findSeveralByCountry($country));
            $cityRepository = new CityRepository();
            $country->setCities($cityRepository->findSeveralByCountry($country));
        }
        return $country;
    }

    public function findAll(): array
    {
        $requeteCountries = "SELECT id, nom FROM s_pays ORDER BY nom ASC;";
        $resultsCountries = $this->dbMysql->select($requeteCountries);

        $arrayResults = [];
        foreach($resultsCountries as $countryR) {
            $country = new Country();
            $country->setId($countryR['id']);
            $country->setName($countryR['nom']);
            $mountRepository = new MountRepository();
            $country->setMounts($mountRepository->findSeveralByCountry($country));
            $cityRepository = new CityRepository();
            $country->setCities($cityRepository->findSeveralByCountry($country));
            array_push($arrayResults, $country);
        }
        
        return $arrayResults;
    }

    public function findSeveralWithMounts(): array
    {
        $requeteCountries = "SELECT p.id, p.nom FROM s_pays p INNER JOIN s_monts m ON (m.id_pays = p.id) GROUP BY p.id, p.nom ORDER BY p.nom ASC;";
        $resultsCountries = $this->dbMysql->select($requeteCountries);

        $arrayResults = [];
        foreach($resultsCountries as $countryR) {
            $country = new Country();
            $country->setId($countryR['id']);
            $country->setName($countryR['nom']);
            $mountRepository = new MountRepository();
            $country->setMounts($mountRepository->findSeveralByCountryWithRoads($country));
            array_push($arrayResults, $country);
        }
        
        return $arrayResults;
    }

    public function findSeveralWithCities(): array
    {
        $requeteCountries = "SELECT p.id, p.nom FROM s_pays p INNER JOIN s_villes v ON (v.id_pays = p.id) GROUP BY p.id, p.nom ORDER BY p.nom ASC;";
        $resultsCountries = $this->dbMysql->select($requeteCountries);

        $arrayResults = [];
        foreach($resultsCountries as $countryR) {
            $country = new Country();
            $country->setId($countryR['id']);
            $country->setName($countryR['nom']);
            $cityRepository = new CityRepository();
            $country->setCities($cityRepository->findSeveralByCountryWithPools($country));
            array_push($arrayResults, $country);
        }
        
        return $arrayResults;
    }

    public function save(): void
    {
        if($_POST['id'] == 0) {
            $requeteInsertCountry = "INSERT INTO s_pays (nom) VALUES (:name);";
            $resultInsertCountry = $this->dbMysql->InsertDeleteUpdate($requeteInsertCountry, ['name' => $_POST['name']]);
        } else {
            $requeteUpdateCountry = "UPDATE s_pays SET nom = :name WHERE id = :idCountry;";
            $resultUpdateCountry = $this->dbMysql->InsertDeleteUpdate($requeteUpdateCountry, ['name' => $_POST['name'], 'idCountry' => $_POST['id']]);
        }
    }
}
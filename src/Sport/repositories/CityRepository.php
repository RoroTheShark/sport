<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/City.php');
require_once('src/Sport/entities/Country.php');
require_once('src/Sport/repositories/CountryRepository.php');
require_once('src/Sport/repositories/PoolRepository.php');

use Sport\Entity\City;
use Sport\Entity\Country;
use Sport\Repository\CountryRepository;
use Sport\Repository\PoolRepository;

class CityRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById($idCity): City
    {
        $requeteCity = "SELECT id, nom, id_pays FROM s_villes WHERE id = :idCity;";
        $resultCity = $this->dbMysql->select_one($requeteCity, ['idCity' => $idCity]);

        if($resultCity) {
            $city = new City();
            $city->setId($resultCity['id']);
            $city->setName($resultCity['nom']);
            $countryRepository = new CountryRepository();
            $city->setCountry($countryRepository->findOneById($resultCity['id_pays']));
        } else {
            $city = new City();
        }
        return $city;
    }

    public function findSeveralByCountry(Country $country): array
    {
        $requeteCities = "SELECT id, nom FROM s_villes WHERE id_pays = :idCountry ORDER BY nom ASC;";
        $resultsCities = $this->dbMysql->select($requeteCities, ['idCountry' => $country->getId()]);

        $arrayResults = [];
        foreach($resultsCities as $cityR) {
            $city = new City();
            $city->setId($cityR['id']);
            $city->setName($cityR['nom']);
            $city->setCountry($country);
            $poolRepository = new PoolRepository();
            $city->setPools($poolRepository->findSeveralByCity($city));
            array_push($arrayResults, $city);
        }
        
        return $arrayResults;
    }

    public function findSeveralByCountryWithPools(Country $country): array
    {
        $requeteCities = "SELECT v.id, v.nom FROM s_villes v INNER JOIN s_piscines p ON (p.id_ville = v.id) WHERE v.id_pays = :idCountry GROUP BY v.id, v.nom ORDER BY v.nom ASC;";
        $resultsCities = $this->dbMysql->select($requeteCities, ['idCountry' => $country->getId()]);

        $arrayResults = [];
        foreach($resultsCities as $cityR) {
            $city = new City();
            $city->setId($cityR['id']);
            $city->setName($cityR['nom']);
            $city->setCountry($country);
            $poolRepository = new PoolRepository();
            $city->setPools($poolRepository->findSeveralByCity($city));
            array_push($arrayResults, $city);
        }
        
        return $arrayResults;
    }

    public function findAll(): array
    {
        $requeteCities = "SELECT v.id AS id_ville, v.nom, p.id AS id_pays FROM s_villes v, s_pays p WHERE v.id_pays = p.id ORDER BY v.nom ASC;";
        $resultsCities = $this->dbMysql->select($requeteCities);

        $arrayResults = [];
        foreach($resultsCities as $cityR) {
            $city = new City();
            $city->setId($cityR['id_ville']);
            $city->setName($cityR['nom']);
            $country = new Country();
            $country->setId($cityR['id_pays']);
            $city->setCountry($country);
            $poolRepository = new PoolRepository();
            $city->setPools($poolRepository->findSeveralByCity($city));
            array_push($arrayResults, $city);
        }
        
        return $arrayResults;
    }

    public function save(): void
    {
        if($_POST['id'] == 0) {
            $requeteInsertCity = "INSERT INTO s_villes (nom, id_pays) VALUES (:name, :idCountry);";
            $resultInsertCity = $this->dbMysql->InsertDeleteUpdate($requeteInsertCity, ['name' => $_POST['name'], 'idCountry' => $_POST['idCountry']]);
        } else {
            $requeteUpdateCity = "UPDATE s_villes SET nom = :name WHERE id = :idCity;";
            $resultUpdateCity = $this->dbMysql->InsertDeleteUpdate($requeteUpdateCity, ['name' => $_POST['name'], 'idCity' => $_POST['id']]);
        }
    }
}
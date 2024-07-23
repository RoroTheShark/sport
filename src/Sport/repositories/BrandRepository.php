<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/Brand.php');

use Sport\Entity\Brand;

class BrandRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById($idBrand): Brand
    {
        $requeteBrand = "SELECT id, nom FROM s_marques WHERE id = :idBrand;";
        $resultBrand = $this->dbMysql->select_one($requeteBrand, ['idBrand' => $idBrand]);

        $brand = new Brand();
        if($resultBrand) {
            $brand->setId($resultBrand['id']);
            $brand->setName($resultBrand['nom']);
        }
        return $brand;
    }

    public function findAll(): array
    {
        $requeteBrands = "SELECT id, nom FROM s_marques ORDER BY nom ASC;";
        $resultsBrands = $this->dbMysql->select($requeteBrands);

        $arrayResults = [];
        foreach($resultsBrands as $brandR) {
            $brand = new Brand();
            $brand->setId($brandR['id']);
            $brand->setName($brandR['nom']);
            array_push($arrayResults, $brand);
        }
        
        return $arrayResults;
    }

    public function save(): void
    {
        if($_POST['id'] == 0) {
            $requeteInsertBrand = "INSERT INTO s_marques (nom) VALUES (:name);";
            $resultInsertBrand = $this->dbMysql->InsertDeleteUpdate($requeteInsertBrand, ['name' => $_POST['name']]);
        } else {
            $requeteUpdateBrand = "UPDATE s_marques SET nom = :name WHERE id = :idBrand;";
            $resultUpdateBrand = $this->dbMysql->InsertDeleteUpdate($requeteUpdateBrand, ['name' => $_POST['name'], 'idBrand' => $_POST['id']]);
        }
    }
}
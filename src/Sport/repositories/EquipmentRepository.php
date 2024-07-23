<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/Brand.php');
require_once('src/Sport/entities/Equipment.php');
require_once('src/Sport/entities/EquipmentType.php');
require_once('src/Sport/entities/EquipmentSubType.php');
require_once('src/Sport/entities/Sport.php');
require_once('src/Sport/repositories/BrandRepository.php');
require_once('src/Sport/repositories/EquipmentSubTypeRepository.php');

use Sport\Entity\Brand;
use Sport\Entity\Equipment;
use Sport\Entity\EquipmentType;
use Sport\Entity\EquipmentSubType;
use Sport\Entity\Sport;
use Sport\Repository\BrandRepository;
use Sport\Repository\EquipmentSubTypeRepository;

class EquipmentRepository
{
    private \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById($idEquipment): Equipment
    {
        $requeteEquipment = "SELECT id, nom, defaut, valeur, date_achat, lien, commentaire, utilise, id_sous_type, id_marque FROM s_materiels WHERE id = :idEquipment;";
        $resultEquipment = $this->dbMysql->select_one($requeteEquipment, ['idEquipment' => $idEquipment]);

        $equipment = new Equipment();
        if($resultEquipment) {
            $equipment->setId($resultEquipment['id']);
            $equipment->setName($resultEquipment['nom']);
            $equipment->setDefault($resultEquipment['defaut']);
            $equipment->setValue($resultEquipment['valeur']);
            $equipment->setDatePurchase($resultEquipment['date_achat']);
            $equipment->setLink($resultEquipment['lien']);
            $equipment->setComment($resultEquipment['commentaire']);
            $equipment->setUsed($resultEquipment['utilise']);
            $equipmentSubTypeRepository = new EquipmentSubTypeRepository();
            $equipment->setEquipmentSubType($equipmentSubTypeRepository->findOneById($resultEquipment['id_sous_type']));
            $brandRepository = new BrandRepository();
            $equipment->setBrand($brandRepository->findOneById($resultEquipment['id_marque']));
            $sportRepository = new SportRepository();
            $equipment->setSports($sportRepository->findSeveralByEquipment($equipment));
        }
        return $equipment;
    }

    public function findAll($all): array
    {
        /*
        $requeteMateriels = "SELECT ma.id, maty.nom AS nom_type, masoty.id AS id_sous_type, masoty.nom AS nom_sous_type, ma.nom AS nom_materiel, mama.nom AS nom_marque, ma.defaut, ma.valeur, ma.date_achat, ma.lien,";
        $requeteMateriels .= " ma.commentaire, GROUP_CONCAT(sp.nom SEPARATOR ', ') AS sports, sums.nb_seances, sums.distance, sums.temps";
        $requeteMateriels .= " FROM materiels_marques mama, materiels_sous_types masoty, materiels_types maty, materiels ma LEFT JOIN materiels_sports masp ON (ma.id = masp.id_materiel)";
        $requeteMateriels .= " LEFT JOIN sports sp ON (masp.id_sport = sp.id) LEFT JOIN";
        $requeteMateriels .= " (SELECT sema.id_materiel, COUNT(*) AS nb_seances, SUM(se.distance) AS distance, SUM(se.temps) AS temps FROM seances_materiels sema, seances se WHERE sema.id_seance = se.id GROUP BY sema.id_materiel) sums";
        $requeteMateriels .= " ON (ma.id = sums.id_materiel)";
        $requeteMateriels .= " WHERE ma.id_marque = mama.id AND ma.id_sous_type = masoty.id AND masoty.id_type = maty.id";
        if(!isset($_GET['inutilise']) || (isset($_GET['inutilise']) && $_GET['inutilise'] != 1)) {
        $requeteMateriels .= " AND ma.utilise = 1";
        }
        $requeteMateriels .= " GROUP BY ma.id, maty.nom, ma.nom, mama.nom, ma.defaut, ma.valeur, ma.date_achat, ma.lien, ma.commentaire";
        $requeteMateriels .= " ORDER BY masoty.id, ma.id;";
        //echo "requeteMateriels : ", $requeteMateriels ,"<br />";
        $resultsMateriels = $dbMysql->select($requeteMateriels);
        */

        //$requeteEquipments = "SELECT ma.id, maty.id AS id_type, maty.nom AS nom_type, masoty.id AS id_sous_type, masoty.nom AS nom_sous_type, ma.nom AS nom_materiel, mama.id AS id_marque, mama.nom AS nom_marque, ma.defaut, ma.valeur, ma.date_achat, ma.lien, ma.commentaire, GROUP_CONCAT(sp.nom SEPARATOR ', ') AS sports, sums.nb_seances, sums.distance, sums.temps";
        $requeteEquipments = "SELECT ma.id, maty.id AS id_type, maty.nom AS nom_type, masoty.id AS id_sous_type, masoty.nom AS nom_sous_type, ma.nom AS nameEquipment, mama.id AS id_marque, mama.nom AS nom_marque, ma.defaut, ma.valeur, ma.date_achat, ma.lien, ma.commentaire, ma.utilise, GROUP_CONCAT(CONCAT(sp.id,'-',sp.nom) SEPARATOR ', ') AS sports";
        $requeteEquipments .= " FROM s_marques mama, s_materiels_sous_types masoty, s_materiels_types maty, s_materiels ma LEFT JOIN s_materiels_sports masp ON (ma.id = masp.id_materiel)";
        $requeteEquipments .= " LEFT JOIN s_sports sp ON (masp.id_sport = sp.id)";
            //$requeteEquipments .= " LEFT JOIN sports sp ON (masp.id_sport = sp.id) LEFT JOIN";
        //$requeteEquipments .= " (SELECT sema.id_materiel, COUNT(*) AS nb_seances, SUM(se.distance) AS distance, SUM(se.temps) AS temps FROM seances_materiels sema, seances se WHERE sema.id_seance = se.id GROUP BY sema.id_materiel) sums";
        //$requeteEquipments .= " ON (ma.id = sums.id_materiel)";
        $requeteEquipments .= " WHERE ma.id_marque = mama.id AND ma.id_sous_type = masoty.id AND masoty.id_type = maty.id";
        if(!$all) {
            $requeteEquipments .= " AND ma.utilise = 1";
        }
        $requeteEquipments .= " GROUP BY ma.id, maty.nom, ma.nom, mama.id, mama.nom, ma.defaut, ma.valeur, ma.date_achat, ma.lien, ma.commentaire, ma.utilise";
        $requeteEquipments .= " ORDER BY masoty.id, ma.id;";

        $resultsEquipments = $this->dbMysql->select($requeteEquipments);

        $arrayResults = [];
        foreach($resultsEquipments as $equipmentR) {
            $equipment = new Equipment();
            $equipment->setId($equipmentR['id']);
            $equipment->setName($equipmentR['nameEquipment']);
            $equipment->setDefault($equipmentR['defaut']);
            $equipment->setValue($equipmentR['valeur']);
            $equipment->setDatePurchase($equipmentR['date_achat']);
            $equipment->setLink($equipmentR['lien']);
            $equipment->setComment($equipmentR['commentaire']);
            $equipment->setUsed($equipmentR['utilise']);

            $equipmentType = new EquipmentType();
            $equipmentType->setId($equipmentR['id_type']);
            $equipmentType->setName($equipmentR['nom_type']);
            $equipmentSubType = new EquipmentSubType();
            $equipmentSubType->setId($equipmentR['id_sous_type']);
            $equipmentSubType->setName($equipmentR['nom_sous_type']);
            $equipmentSubType->setEquipmentType($equipmentType);
            $brand = new Brand();
            $brand->setId($equipmentR['id_marque']);
            $brand->setName($equipmentR['nom_marque']);

            $equipment->setEquipmentSubType($equipmentSubType);
            $equipment->setBrand($brand);

            $arraySports = [];
            if($equipmentR['sports'] != "") {
                $tabSports = explode(", ", $equipmentR['sports']);
                foreach($tabSports as $sportR) {
                    $values = explode("-", $sportR);
                    $sport = new Sport();
                    $sport->setId(intval($values[0]));
                    $sport->setName($values[1]);
                    array_push($arraySports, $sport);
                }
            }
            $equipment->setSports($arraySports);

            $workoutRepository = new WorkoutRepository();
            $equipment->setWorkouts($workoutRepository->findSeveralByEquipment($equipment));

            array_push($arrayResults, $equipment);
        }
        /*
        $requeteEquipments = "SELECT id, nom, defaut, valeur, date_achat, lien, commentaire, utilise, id_sous_type, id_marque FROM s_materiels ORDER BY nom ASC;";
        $resultsEquipments = $this->dbMysql->select($requeteEquipments);

        $arrayResults = [];
        foreach($resultsEquipments as $equipmentR) {
            $equipment = new Equipment();
            $equipment->setId($equipmentR['id']);
            $equipment->setName($equipmentR['nom']);
            $equipment->setDefault($equipmentR['defaut']);
            $equipment->setValue($equipmentR['valeur']);
            $equipment->setDatePurchase($equipmentR['date_achat']);
            $equipment->setLink($equipmentR['lien']);
            $equipment->setComment($equipmentR['commentaire']);
            $equipment->setUsed($equipmentR['utilise']);
            $equipmentSubTypeRepository = new EquipmentSubTypeRepository();
            $equipment->setEquipmentSubType($equipmentSubTypeRepository->findOneById($equipmentR['id_sous_type']));
            $brandRepository = new BrandRepository();
            $equipment->setBrand($brandRepository->findOneById($equipmentR['id_marque']));
            array_push($arrayResults, $equipment);
        }
        */
        return $arrayResults;
    }

    public function findSeveralByEquipmentSubType(EquipmentSubType $equipmentSubType): array
    {
        $requeteEquipments = "SELECT ma.id, ma.nom AS nameEquipment, mama.id AS id_marque, mama.nom AS nom_marque, ma.defaut, ma.valeur, ma.date_achat, ma.lien, ma.commentaire, ma.utilise, GROUP_CONCAT(CONCAT(sp.id,'-',sp.nom) SEPARATOR ', ') AS sports";
        $requeteEquipments .= " FROM s_marques mama, s_materiels ma LEFT JOIN s_materiels_sports masp ON (ma.id = masp.id_materiel)";
        $requeteEquipments .= " LEFT JOIN s_sports sp ON (masp.id_sport = sp.id)";
        $requeteEquipments .= " WHERE ma.id_marque = mama.id AND ma.id_sous_type = :equipmentSubType";
        $requeteEquipments .= " GROUP BY ma.id, ma.nom, mama.id, mama.nom, ma.defaut, ma.valeur, ma.date_achat, ma.lien, ma.commentaire, ma.utilise";
        $requeteEquipments .= " ORDER BY ma.nom;";

        $resultsEquipments = $this->dbMysql->select($requeteEquipments, ['equipmentSubType' => $equipmentSubType->getId()]);

        $arrayResults = [];
        foreach($resultsEquipments as $equipmentR) {
            $equipment = new Equipment();
            $equipment->setId($equipmentR['id']);
            $equipment->setName($equipmentR['nameEquipment']);
            $equipment->setDefault($equipmentR['defaut']);
            $equipment->setValue($equipmentR['valeur']);
            $equipment->setDatePurchase($equipmentR['date_achat']);
            $equipment->setLink($equipmentR['lien']);
            $equipment->setComment($equipmentR['commentaire']);
            $equipment->setUsed($equipmentR['utilise']);

            $equipment->setEquipmentSubType($equipmentSubType);

            $brand = new Brand();
            $brand->setId($equipmentR['id_marque']);
            $brand->setName($equipmentR['nom_marque']);
            $equipment->setBrand($brand);

            $arraySports = [];
            if($equipmentR['sports'] != "") {
                $tabSports = explode(", ", $equipmentR['sports']);
                foreach($tabSports as $sportR) {
                    $values = explode("-", $sportR);
                    $sport = new Sport();
                    $sport->setId(intval($values[0]));
                    $sport->setName($values[1]);
                    array_push($arraySports, $sport);
                }
            }
            $equipment->setSports($arraySports);

            array_push($arrayResults, $equipment);
        }

        return $arrayResults;
    }

    public function save(): void
    {
        $idEquipment = 0;
        $used = isset($_POST['used']) && $_POST['used'] == true ? 1 : 0;
        if($_POST['id'] == 0) {
            $requeteInsertEquipment = "INSERT INTO s_materiels (nom, defaut, valeur, date_achat, lien, commentaire, utilise, id_sous_type, id_marque) VALUES (:name, :default, :value, :datePurchase, :link, :comment, :used, :idEquipmentSubType, :idBrand);";
            $resultInsertEquipment = $this->dbMysql->InsertDeleteUpdate($requeteInsertEquipment, ['name' => $_POST['name'], 'default' => $_POST['default'], 'value' => $_POST['value'], 'datePurchase' => $_POST['datePurchase'], 'link' => $_POST['link'], 'comment' => $_POST['comment'], 'used' => $used, 'idEquipmentSubType' => $_POST['idEquipmentSubType'], 'idBrand' => $_POST['idBrand']]);
            $idEquipment = $this->dbMysql->lastInsertId();
        } else {
            $requeteUpdateEquipment = "UPDATE s_materiels SET nom = :name, defaut = :default, valeur = :value, date_achat = :datePurchase, lien = :link, commentaire = :comment, utilise = :used, id_sous_type = :idEquipmentSubType, id_marque = :idBrand WHERE id = :idEquipment;";
            $resultUpdateEquipment = $this->dbMysql->InsertDeleteUpdate($requeteUpdateEquipment, ['name' => $_POST['name'], 'default' => $_POST['default'], 'value' => $_POST['value'], 'datePurchase' => $_POST['datePurchase'], 'link' => $_POST['link'], 'comment' => $_POST['comment'], 'used' => $used, 'idEquipmentSubType' => $_POST['idEquipmentSubType'], 'idBrand' => $_POST['idBrand'], 'idEquipment' => $_POST['id']]);
            $idEquipment = $_POST['id'];
        }


        $requeteSports = "SELECT id, nom FROM s_sports ORDER BY id;";
        $resultsSports = $this->dbMysql->select($requeteSports);
        foreach($resultsSports as $sport) {
            $requeteVerif = "SELECT id FROM s_materiels_sports WHERE id_materiel = :idEquipment AND id_sport = :idSport;";
            $resultVerif = $this->dbMysql->select_one($requeteVerif, ['idEquipment' => $idEquipment, 'idSport' => $sport['id']]);

            $requeteSport = "";
            if(in_array($sport['id'], $_POST['sports']) && !$resultVerif) {
                $requeteSport = "INSERT INTO s_materiels_sports (id_materiel, id_sport) VALUES (:idEquipment, :idSport);";
            } else if(!in_array($sport['id'], $_POST['sports']) && $resultVerif) {
                $requeteSport = "DELETE FROM s_materiels_sports WHERE id_materiel = :idEquipment AND id_sport = :idSport;";
            }
            if($requeteSport != "")
                $resultSport = $this->dbMysql->InsertDeleteUpdate($requeteSport, ['idEquipment' => $idEquipment, 'idSport' => $sport['id']]);
        }
    }
}
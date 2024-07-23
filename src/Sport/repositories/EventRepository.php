<?php

namespace Sport\Repository;

require_once('db.class.php');
require_once('src/Sport/entities/Event.php');

use Sport\Entity\Event;

class EventRepository
{
    public \DatabaseConnection $dbMysql;

    function __construct() {
        $this->dbMysql = new \DatabaseConnection();
    }

    public function findOneById($idEvent): Event
    {
        $requeteEvent = "SELECT id, nom, date_debut, date_fin FROM s_evenements WHERE id = :idEvent;";
        $resultEvent = $this->dbMysql->select_one($requeteEvent, ['idEvent' => $idEvent]);

        $event = new Event();
        if($resultEvent) {
            $event->setId($resultEvent['id']);
            $event->setName($resultEvent['nom']);
            $event->setDateStart($resultEvent['date_debut']);
            $event->setDateEnd($resultEvent['date_fin']);
        }
        return $event;
    }

    public function findAll(): array
    {
        $requeteEvents = "SELECT id, nom, date_debut, date_fin FROM s_evenements ORDER BY date_debut ASC;";
        $resultsEvents = $this->dbMysql->select($requeteEvents);

        $arrayResults = [];
        foreach($resultsEvents as $eventR) {
            $event = new Event();
            $event->setId($eventR['id']);
            $event->setName($eventR['nom']);
            $event->setDateStart($eventR['date_debut']);
            $event->setDateEnd($eventR['date_fin']);
            array_push($arrayResults, $event);
        }
        
        return $arrayResults;
    }


    public function save(): void
    {
        if($_POST['id'] == 0) {
            $requeteInsertEvent = "INSERT INTO s_evenements (nom, date_debut, date_fin) VALUES (:name, :dateStart, :dateEnd);";
            $resultInsertEvent = $this->dbMysql->InsertDeleteUpdate($requeteInsertEvent, ['name' => $_POST['name'], 'dateStart' => $_POST['dateStart'], 'dateEnd' => $_POST['dateEnd']]);
        } else {
            $requeteUpdateEvent = "UPDATE s_evenements SET nom = :name, date_debut = :dateStart, date_fin = :dateEnd WHERE id = :idEvent;";
            $resultUpdateEvent = $this->dbMysql->InsertDeleteUpdate($requeteUpdateEvent, ['name' => $_POST['name'], 'dateStart' => $_POST['dateStart'], 'dateEnd' => $_POST['dateEnd'], 'idEvent' => $_POST['id']]);
        }
    }
}
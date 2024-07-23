<?php

namespace Sport\Entity;

require_once('src/Sport/entities/CompetTrain.php');
require_once('src/Sport/entities/Day.php');
require_once('src/Sport/entities/Environment.php');
require_once('src/Sport/entities/Equipment.php');
require_once('src/Sport/entities/Intensity.php');
require_once('src/Sport/entities/Moment.php');
require_once('src/Sport/entities/Partner.php');
require_once('src/Sport/entities/Pool.php');
require_once('src/Sport/entities/Season.php');
require_once('src/Sport/entities/Month.php');
require_once('src/Sport/entities/WorkoutRoad.php');

require_once('src/Sport/traits/Distance.php');
require_once('src/Sport/traits/Elevation.php');
require_once('src/Sport/traits/Time.php');

use Sport\Entity\CompetTrain;
use Sport\Entity\Day;
use Sport\Entity\Environment;
use Sport\Entity\Equipment;
use Sport\Entity\Intensity;
use Sport\Entity\Moment;
use Sport\Entity\Partner;
use Sport\Entity\Pool;
use Sport\Entity\Season;
use Sport\Entity\Month;
use Sport\Entity\WorkoutRoad;

use Sport\Trait\Distance;
use Sport\Trait\Elevation;
use Sport\Trait\Time;

class Workout
{
    use Distance, Elevation, Time;

    protected int $id = 0;
    protected ?Environment $environment = null;
    protected ?CompetTrain $competTrain = null;
    protected ?\DateTime $date = null;
    protected ?Month $month = null;
    protected ?Day $day = null;
    protected ?Moment $moment = null;
    protected ?Season $season = null;
    protected ?int $time = null;
    protected ?Intensity $intensity = null;
    protected ?int $idStrava = 0;
    protected ?string $idDecathlon = null;
    protected ?string $comment = null;
    protected ?string $training = null;
    protected array $partners = [];
    protected array $equipments = [];
    protected array $workoutsRoads = [];

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setEnvironment(Environment $environment): void
    {
        $this->environment = $environment;
    }
    public function getEnvironment(): ?Environment
    {
        return $this->environment;
    }

    public function setCompetTrain(CompetTrain $competTrain): void
    {
        $this->competTrain = $competTrain;
    }
    public function getCompetTrain(): ?CompetTrain
    {
        return $this->competTrain;
    }

    public function setDate(string $date): void
    {
        $this->date = new \DateTime($date);
    }
    public function getDate(): \DateTime
    {
        return $this->date ? $this->date : new \DateTime();
    }

    public function setMonth(Month $month): void
    {
        $this->month = $month;
    }
    public function getMonth(): ?Month
    {
        return $this->month;
    }
    
    public function setDay(Day $day): void
    {
        $this->day = $day;
    }
    public function getDay(): ?Day
    {
        return $this->day;
    }
    
    public function setMoment(Moment $moment): void
    {
        $this->moment = $moment;
    }
    public function getMoment(): ?Moment
    {
        return $this->moment;
    }
    
    public function setSeason(Season $season): void
    {
        $this->season = $season;
    }
    public function getSeason(): ?Season
    {
        return $this->season;
    }
    
    public function setTime(int|string $time): void
    {
        if(str_contains($time, ':')) {
            $seconds = substr($time,6,2);
            $minutes = substr($time,3,2);
            $hours = substr($time,0,2);
            $time = $seconds+($minutes*60)+($hours*60*60);
        }

        $this->time = $time;
    }
    public function getTime(): ?int
    {
        return $this->time;
    }
    public function getTimeFormated(string $type = "texte"): string
    {
        return $this->formateTime($this->time, $type);
    }

    public function setIntensity(Intensity $intensity): void
    {
        $this->intensity = $intensity;
    }
    public function getIntensity(): ?Intensity
    {
        return $this->intensity;
    }
    
    public function setIdStrava(?int $idStrava): void
    {
        $this->idStrava = $idStrava;
    }
    public function getIdStrava(): ?int
    {
        return $this->idStrava;
    }

    public function setIdDecathlon(?string $idDecathlon): void
    {
        $this->idDecathlon = $idDecathlon;
    }
    public function getIdDecathlon(): ?string
    {
        return $this->idDecathlon;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }
    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setTraining(?string $training): void
    {
        $this->training = $training;
    }
    public function getTraining(): ?string
    {
        return $this->training;
    }

    public function setPartners(array $partners): void
    {
        $this->partners = $partners;
    }

    public function getPartners(): array
    {
        return $this->partners;
    }

    public function asPartner(Partner $partner): bool
    {
        return in_array($partner->getId(), array_map(function($p) {return $p->getId();},$this->partners));
    }

    public function setEquipments(array $equipments): void
    {
        $this->equipments = $equipments;
    }

    public function getEquipments(): array
    {
        return $this->equipments;
    }

    public function asEquipment(Equipment $equipment): bool
    {
        return in_array($equipment->getId(), array_map(function($e) {return $e->getId();},$this->equipments));
    }

    public function setWorkoutsRoads(array $workoutsRoads): void
    {
        $this->workoutsRoads = $workoutsRoads;
    }

    public function getWorkoutsRoads(): array
    {
        return $this->workoutsRoads;
    }

    public function getWorkoutRoadNumbers(Road $road): int
    {
        return array_reduce(array_filter($this->workoutsRoads, function($wr) use ($road) {return $wr->getRoad()->getId() == $road->getId();}), function($carry, $item) {
            return $carry+$item->getNumber();
        }, 0);
    }

    /**
     * @param int idType On attend un id du type d'équipement "1 : habit, 2 : matériel"
     * @return string Retourne la liste des équipements de type "Habit" (id 1) sous forme de string, séparés par des virgules
     */
    public function getListEquipments(int $idType): string
    {
        return implode(", ",array_map(function($e) use ($idType) {return $e->getName();},array_filter($this->equipments, function($e) use ($idType) {return $e->getEquipmentSubType()->getEquipmentType()->getId() == $idType;})));
    }

    public function getPool(): ?Pool
    {
        return null;
    }
}
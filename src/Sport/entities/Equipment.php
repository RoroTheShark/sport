<?php

namespace Sport\Entity;

require_once('src/Sport/entities/Brand.php');
require_once('src/Sport/entities/EquipmentSubType.php');
require_once('src/Sport/entities/Sport.php');
require_once('src/Sport/traits/Time.php');
require_once('src/Sport/traits/Distance.php');

use Sport\Entity\Brand;
use Sport\Entity\EquipmentSubType;
use Sport\Entity\Sport;

use Sport\Trait\Distance;
use Sport\Trait\Time;

class Equipment
{
    use Distance, Time;

    private int $id = 0;
    private ?string $name = null;
    private ?bool $default = null;
    private ?float $value = null;
    private ?\DateTime $datePurchase = null;
    private ?string $link = null;
    private ?string $comment = null;
    private ?bool $used = null;
    private ?EquipmentSubType $equipmentSubType = null;
    private ?Brand $brand = null;
    private array $sports = [];
    protected array $workouts = [];

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setDefault(bool $default): void
    {
        $this->default = $default == 1;
    }
    public function isDefault(): ?bool
    {
        return $this->default;
    }

    public function setValue(float $value): void
    {
        $this->value = $value;
    }
    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setDatePurchase(?string $datePurchase): void
    {
        $this->datePurchase = $datePurchase ? new \DateTime($datePurchase) : null;
    }
    public function getDatePurchase(): ?\DateTime
    {
        return $this->datePurchase;
    }

    public function setLink(string $link): void
    {
        $this->link = $link;
    }
    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }
    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setUsed(bool $used): void
    {
        $this->used = $used;
    }
    public function isUsed(): ?bool
    {
        return $this->used;
    }

    public function setEquipmentSubType(EquipmentSubType $equipmentSubType): void
    {
        $this->equipmentSubType = $equipmentSubType;
    }
    public function getEquipmentSubType(): ?EquipmentSubType
    {
        return $this->equipmentSubType;
    }

    public function setBrand(Brand $brand): void
    {
        $this->brand = $brand;
    }
    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setSports(array $sports): void
    {
        $this->sports = $sports;
    }

    public function getSports(): array
    {
        return $this->sports;
    }

    public function asSport(Sport $sport): bool
    {
        return in_array($sport->getId(), array_map(fn($s): int => $s->getId(),$this->sports));
    }

    /**
     * @return string Retourne la liste des id séparés de virgules
     */
    public function getSportsIdString(): string
    {
        return implode(",", array_map(fn($s): int => $s->getId(),$this->sports));
    }

    public function setWorkouts(array $workouts): void
    {
        $this->workouts = $workouts;
    }

    public function getWorkouts(): array
    {
        return $this->workouts;
    }

    public function getWorkoutsNumber(): string
    {
        return count($this->workouts);
    }

    public function getWorkoutsSumDistance(): string
    {
        return $this->formateDistanceKM(array_reduce(array_map(fn($w):string => $w->getDistance(), $this->workouts), fn($c, $i):int => $c+$i, 0)/1000, "texte");
    }

    public function getWorkoutsSumTime(): string
    {
        return $this->formateTime(array_reduce(array_map(fn($w):string => $w->getTime(), $this->workouts), fn($c, $i):int => $c+$i, 0), "texte");
    }

}
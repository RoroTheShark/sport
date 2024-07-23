<?php

namespace Sport\Entity;

require_once('src/Sport/entities/Country.php');
require_once('src/Sport/repositories/RoadRepository.php');

use Sport\Entity\Country;
use Sport\Repository\RoadRepository;

class Mount
{
    private int $id = 0;
    private ?Country $country = null;
    private ?string $name = null;
    private array $roads;

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setCountry(Country $country): void
    {
        $this->country = $country;
    }
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setRoads($roads): void
    {
        $this->roads = $roads;
    }

    public function getRoads(): array
    {
        return $this->roads;
    }

    public function getRoadsWorkoutsSumNumber(): int
    {
        return array_reduce(array_map(function($r) {return $r->getWorkoutsSumNumber();}, $this->roads), function($carry, $item) {
            return $carry+$item;
        }, 0);
    }
}
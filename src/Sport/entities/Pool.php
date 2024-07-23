<?php

namespace Sport\Entity;

require_once('src/Sport/entities/City.php');
//require('src/Sport/repositories/RoadRepository.php');

use Sport\Entity\City;
//use Sport\Repository\RoadRepository;

class Pool
{
    private int $id = 0;
    private ?City $city = null;
    private ?string $name = null;
    protected array $workouts = [];

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setCity(City $city): void
    {
        $this->city = $city;
    }
    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setWorkouts(array $workouts): void
    {
        $this->workouts = $workouts;
    }

    public function getWorkouts(): array
    {
        return $this->workouts;
    }

    public function getWorkoutsNumber(): int
    {
        return count($this->workouts);
    }
}
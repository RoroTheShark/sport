<?php

namespace Sport\Entity;

require_once('src/Sport/entities/Mount.php');
require_once('src/Sport/repositories/CityRepository.php');
require_once('src/Sport/repositories/MountRepository.php');

use Sport\Entity\Mount;
use Sport\Repository\CityRepository;
use Sport\Repository\MountRepository;

class Country
{
    private int $id = 0;
    private ?string $name = null;
    private array $mounts;
    private array $cities;

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

    public function addMount(Mount $mount): void
    {
        array_push($this->mounts, $mount);
    }

    public function setMounts(array $mounts): void
    {
        $this->mounts = $mounts;
    }

    public function getMounts(): array
    {
        return $this->mounts;
    }

    public function setCities(array $cities): void
    {
        $this->cities = $cities;
    }

    public function getCities(): array
    {
        return $this->cities;
    }

    public function getNumberMounts(): int
    {
        return count($this->mounts);
    }

    public function getNumberCities(): int
    {
        return count($this->cities);
    }

    public function getNumberRoads(): int
    {
        return array_reduce($this->mounts, fn($c, $i) => $c+count($i->getRoads()), 0);
    }

    public function getNumberPools(): int
    {
        return array_reduce($this->cities, fn($c, $i) => $c+count($i->getPools()), 0);
    }

    public function getMountsRoadsWorkoutsSumNumber(): int
    {
        return array_reduce(array_map(fn($m):int => $m->getRoadsWorkoutsSumNumber(), $this->mounts), fn($c, $i):int => $c+$i, 0);
    }

    public function getCitiesPoolsWorkoutsSumNumber(): int
    {
        return array_reduce(array_map(fn($m):int => $m->getPoolsWorkoutsSumNumber(), $this->cities), fn($c, $i):int => $c+$i, 0);
    }
}
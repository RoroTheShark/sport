<?php

namespace Sport\Entity;

require_once('src/Sport/entities/Country.php');
require_once('src/Sport/repositories/PoolRepository.php');

use Sport\Entity\Country;
use Sport\Repository\PoolRepository;

class City
{
    private int $id = 0;
    private ?Country $country = null;
    private ?string $name = null;
    private array $pools;

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

    public function setPools(array $pools): void
    {
        $this->pools = $pools;
    }

    public function getPools(): array
    {
        return $this->pools;
    }

    public function getPoolsWorkoutsSumNumber(): int
    {
        return array_reduce(array_map(fn($r):string => $r->getWorkoutsNumber(), $this->pools), fn($c, $i):int => $c+$i, 0);
    }
}
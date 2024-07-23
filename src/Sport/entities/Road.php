<?php

namespace Sport\Entity;

require_once('src/Sport/entities/Mount.php');

use Sport\Entity\Mount;

class Road
{
    protected int $id = 0;
    protected ?Mount $mount = null;
    protected ?string $name = null;
    protected array $workoutsRoads = [];

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setMount(Mount $mount): void
    {
        $this->mount = $mount;
    }
    public function getMount(): ?Mount
    {
        return $this->mount;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setWorkoutsRoads(array $workoutsRoads): void
    {
        $this->workoutsRoads = $workoutsRoads;
    }

    public function getWorkoutsRoads(): array
    {
        return $this->workoutsRoads;
    }

    public function getWorkoutsSumNumber(): int
    {
        return array_reduce($this->workoutsRoads, fn($c, $i): int => $c+$i->getNumber(), 0);
    }
}
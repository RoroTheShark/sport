<?php

namespace Sport\Entity;

require_once('src/Sport/entities/Sport.php');

use Sport\Entity\Sport;

class Environment
{
    private int $id = 0;
    private ?string $name = null;
    private ?Sport $sport = null;

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

    public function setSport(Sport $sport): void
    {
        $this->sport = $sport;
    }
    public function getSport(): ?Sport
    {
        return $this->sport;
    }
}
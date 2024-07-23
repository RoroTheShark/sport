<?php

namespace Sport\Entity;

require_once('src/Sport/repositories/EnvironmentRepository.php');

use Sport\Repository\EnvironmentRepository;

class Sport
{
    private int $id = 0;
    private ?string $name = null;
    private array $environments;

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

    public function setEnvironments($environments): void
    {
        $this->environments = $environments;
    }

    public function getEnvironments(): array
    {
        return $this->environments;
    }
}
<?php

namespace Sport\Entity;

class Event
{
    private int $id = 0;
    private ?string $name = null;
    private ?\DateTime $dateStart = null;
    private ?\DateTime $dateEnd = null;

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

    public function setDateStart(string $dateStart): void
    {
        $this->dateStart = new \DateTime($dateStart);
    }
    public function getDateStart(): \DateTime
    {
        return $this->dateStart ? $this->dateStart : new \DateTime();
    }

    public function setDateEnd(string $dateEnd): void
    {
        $this->dateEnd = new \DateTime($dateEnd);
    }
    public function getDateEnd(): \DateTime
    {
        return $this->dateEnd ? $this->dateEnd : new \DateTime();
    }
}
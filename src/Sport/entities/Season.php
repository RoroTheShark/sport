<?php

namespace Sport\Entity;

class Season
{
    private int $id = 0;
    private ?int $yearStart = null;
    private ?int $yearEnd = null;

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setYearStart(int $yearStart): void
    {
        $this->yearStart = $yearStart;
    }
    public function getYearStart(): ?int
    {
        return $this->yearStart;
    }

    public function setYearEnd(int $yearEnd): void
    {
        $this->yearEnd = $yearEnd;
    }
    public function getYearEnd(): ?int
    {
        return $this->yearEnd;
    }
}
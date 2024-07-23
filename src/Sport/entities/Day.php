<?php

namespace Sport\Entity;

class Day
{
    private int $id = 0;
    private ?string $name = null;
    private ?string $nameEnglish = null;

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

    public function setNameEnglish(string $nameEnglish): void
    {
        $this->nameEnglish = $nameEnglish;
    }
    public function getNameEnglish(): ?string
    {
        return $this->nameEnglish;
    }
}
<?php

namespace Sport\Entity;

class Intensity
{
    private int $id = 0;
    private ?int $value = null;

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }
    public function getValue(): ?int
    {
        return $this->value;
    }
}
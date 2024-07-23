<?php

namespace Sport\Entity;

class EquipmentType
{
    private int $id = 0;
    private ?string $name = null;
    private array $equipmentSubTypes;

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

    public function setEquipmentSubTypes($equipmentSubTypes): void
    {
        $this->equipmentSubTypes = $equipmentSubTypes;
    }

    public function getEquipmentSubTypes(): array
    {
        return $this->equipmentSubTypes;
    }
}
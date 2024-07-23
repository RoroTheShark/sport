<?php

namespace Sport\Entity;

require_once('src/Sport/entities/EquipmentType.php');

use Sport\Entity\EquipmentType;

class EquipmentSubType
{
    private int $id = 0;
    private ?EquipmentType $equipmentType = null;
    private ?string $name = null;
    private array $equipments = [];

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setEquipmentType(EquipmentType $equipmentType): void
    {
        $this->equipmentType = $equipmentType;
    }
    public function getEquipmentType(): ?EquipmentType
    {
        return $this->equipmentType;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setEquipments(array $equipments): void
    {
        $this->equipments = $equipments;
    }

    public function getEquipments(): array
    {
        return $this->equipments;
    }

}
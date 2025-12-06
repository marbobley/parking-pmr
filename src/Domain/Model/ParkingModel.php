<?php

namespace App\Domain\Model;

/**
 * Modèle de domaine (Value Object/Entity) représentant une place de parking.
 */
final class ParkingModel
{
    public function __construct(
        private readonly string $id,
        private readonly float $latitude,
        private readonly float $longitude,
        private readonly ?string $label = null,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }
}

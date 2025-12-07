<?php

namespace App\Domain\Model;

/**
 * Modèle de domaine (Value Object/Entity) représentant une place de parking.
 */
final readonly class ParkingModel
{
    public function __construct(
        private string $id,
        private float  $latitude,
        private float  $longitude,
        private int $nombrePlaceDisponible
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

    public function getNombrePlaceDisponible(): int
    {
        return $this->nombrePlaceDisponible;
    }
}

<?php

namespace App\Domain\Model;

/**
 * Modèle de domaine coordonées représentant une latitude et longitude
 */
final readonly class CoordinateModel
{
    public function __construct(
        private float $latitude,
        private float $longitude
    )
    {
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}

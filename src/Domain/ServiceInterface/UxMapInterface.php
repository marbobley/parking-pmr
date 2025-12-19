<?php

namespace App\Domain\ServiceInterface;

use Symfony\UX\Map\Map;

interface UxMapInterface
{
    public function generate(array $parkings): Map;

    public function generateWithLocalisation(array $parkings, float $latitude, float $longitude): Map;
}

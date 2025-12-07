<?php

namespace App\Domain\ProviderInterface;

use App\Domain\Model\ParkingModel;

/**
 * Port primaire (interface) pour accéder aux parkings.
 */
interface VisitorIncrementProviderInterface
{
    public function increment(): void;
}

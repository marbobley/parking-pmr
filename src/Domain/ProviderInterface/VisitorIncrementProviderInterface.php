<?php

namespace App\Domain\ProviderInterface;

/**
 * Port primaire (interface) pour accéder aux parkings.
 */
interface VisitorIncrementProviderInterface
{
    public function get(): int;

    public function save(?string $clientIP, ?string $browser, \DateTimeImmutable $date);
}

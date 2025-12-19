<?php

namespace App\Domain\ProviderInterface;

use DateTimeImmutable;

/**
 * Port primaire (interface) pour accéder aux parkings.
 */
interface VisitorIncrementProviderInterface
{
    /**
     * return the count of visitors of all time
     * @return int full quantity of visitors of all time
     */
    public function get(): int;


    /**
     * @param string|null $clientIP
     * @param string|null $browser
     * @param DateTimeImmutable $date
     * @return void
     */
    public function save(?string $clientIP, ?string $browser, DateTimeImmutable $date): void;
}

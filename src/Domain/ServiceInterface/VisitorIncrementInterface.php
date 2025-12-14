<?php

namespace App\Domain\ServiceInterface;

interface VisitorIncrementInterface
{
    function getCount(): int;

    public function addConnexion(?string $clientIP, ?string $browser, \DateTimeImmutable $date);
}

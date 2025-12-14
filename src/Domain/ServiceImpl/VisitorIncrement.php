<?php

namespace App\Domain\ServiceImpl;

use App\Domain\ProviderInterface\VisitorIncrementProviderInterface;
use App\Domain\ServiceInterface\VisitorIncrementInterface;

readonly class VisitorIncrement implements VisitorIncrementInterface
{
    public function __construct(private VisitorIncrementProviderInterface $provider)
    {

    }

    public function getCount(): int
    {
        return $this->provider->get();
    }

    public function addConnexion(?string $clientIP, ?string $browser, \DateTimeImmutable $date): void
    {
        $this->provider->save($clientIP, $browser, $date);
    }
}

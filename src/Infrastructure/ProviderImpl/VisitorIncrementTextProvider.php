<?php

namespace App\Infrastructure\ProviderImpl;

use App\Domain\ProviderInterface\VisitorIncrementProviderInterface;
use App\Entity\VisitorConnexion;
use App\Repository\VisitorConnexionRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

final readonly class VisitorIncrementTextProvider implements VisitorIncrementProviderInterface
{
    public function __construct(private EntityManagerInterface     $manager,
                                private VisitorConnexionRepository $repository)
    {

    }

    /**
     * Retourne la valeur actuelle sans incrémenter.
     */
    public function get(): int
    {
        return $this->repository->count();
    }

    public function save(?string $clientIP, ?string $browser, DateTimeImmutable $date): void
    {
        $visitor = new VisitorConnexion();
        $visitor->setClientIP($clientIP);
        $visitor->setBrowser($browser);
        $visitor->setDateConnexion($date);

        $this->manager->persist($visitor);
        $this->manager->flush();
    }
}

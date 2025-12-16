<?php

namespace App\Infrastructure\ProviderImpl;

use App\Domain\Model\AdresseProcheModel;
use App\Domain\ProviderInterface\AdresseProcheOriginProviderInterface;
use App\Infrastructure\Mapper\AdresseProcheMapper;
use App\Repository\AdresseProcheOriginRepository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class AdresseProcheOriginProvider implements AdresseProcheOriginProviderInterface
{

    public function __construct(private EntityManagerInterface        $manager,
                                private AdresseProcheOriginRepository $repository,
                                private AdresseProcheMapper           $mapper)
    {

    }

    /**
     * @param list<AdresseProcheModel> $adresseProches
     * @return void
     */
    public function saveAll(array $adresseProches): void
    {
        foreach ($adresseProches as $adresseProche) {
            $this->manager->persist($this->mapper->mapperModelToEntity($adresseProche));
        }

        $this->manager->flush();
    }

    public function findAll(): array
    {
        $results = $this->repository->findAll();

        return array_map(fn($result) => $this->mapper->mapperEntityToModel($result), $results);
    }

    public function deleteAll(): void
    {
        $this->repository->deleteAll();
    }
}

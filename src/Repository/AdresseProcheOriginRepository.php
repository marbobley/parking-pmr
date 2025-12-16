<?php

namespace App\Repository;

use App\Entity\AdresseProcheOrigin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdresseProcheOrigin>
 */
class AdresseProcheOriginRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdresseProcheOrigin::class);
    }

    public function deleteAll()
    {
        return $this->createQueryBuilder('a')
            ->delete()
            ->getQuery()
            ->execute();
    }
}

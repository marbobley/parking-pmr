<?php

namespace App\Infrastructure\ProviderImpl;

use App\Domain\Exception\GenericException;
use App\Domain\Model\AdresseProcheModel;
use App\Domain\Model\CoordinateModel;
use App\Domain\ProviderInterface\AdresseProcheProviderInterface;
use App\Infrastructure\Mapper\GeoPlatformMapper;
use App\Infrastructure\Repository\ApiGeoPlatformRepository;

final readonly class ApiGeoPlatformProvider implements AdresseProcheProviderInterface
{
    public function __construct(
        private ApiGeoPlatformRepository $httpClient,
        private GeoPlatformMapper        $mapper
    )
    {
    }

    /**
     * @param CoordinateModel[] $coordinates
     * @return AdresseProcheModel[]
     */
    public function findAll(array $coordinates): array
    {
        $result = array();
        foreach ($coordinates as $coordinate) {
            try {
                $adresseProche = $this->httpClient->findOne($coordinate->getLatitude(), $coordinate->getLongitude());
                $result[] = $this->mapper->mapperEntityToModelWithOrigin($adresseProche, $coordinate);
                sleep(1);
            } catch (GenericException) {
                continue;
            }
        }

        return $result;
    }

}

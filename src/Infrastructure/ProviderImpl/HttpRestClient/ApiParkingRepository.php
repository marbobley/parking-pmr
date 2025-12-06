<?php

namespace App\Infrastructure\ProviderImpl\HttpRestClient;

use App\Domain\Model\Parking;
use App\Domain\ProviderInterface\ParkingRepositoryInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ApiParkingRepository implements ParkingRepositoryInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly ?string $apiUrl = null,
    ) {
    }

    /**
     * @return list<Parking>
     */
    public function findAll(): array
    {
        $array = null;
        if (!$this->apiUrl) {
            // Si aucune URL n'est configurée, retourner une liste vide pour rester résilient.
           $array = [];
        }

        try {
            $response = $this->httpClient->request('GET', $this->apiUrl);
            if (200 !== $response->getStatusCode()) {
                $array = [];
            }

            $array = $response->toArray(false);
        } catch (\Throwable $e) {
            // En cas d'erreur réseau/JSON, retourner une liste vide pour ne pas casser l'app
            $array = [];
        }
        return $array;
    }
}

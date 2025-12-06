<?php

namespace App\Infrastructure\HttpRestClient;

use App\Domain\Model\Parking;
use App\Domain\ProviderInterface\ParkingRepositoryInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Adaptateur secondaire: récupère les parkings depuis une API REST externe.
 */
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
        if (!$this->apiUrl) {
            // Si aucune URL n'est configurée, retourner une liste vide pour rester résilient.
            return [];
        }

        try {
            $response = $this->httpClient->request('GET', $this->apiUrl);
            if (200 !== $response->getStatusCode()) {
                return [];
            }
            $data = $response->toArray(false);

            return $data;
        } catch (\Throwable $e) {
            // En cas d'erreur réseau/JSON, retourner une liste vide pour ne pas casser l'app
            return [];
        }
    }
}

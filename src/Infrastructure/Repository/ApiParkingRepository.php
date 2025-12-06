<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Model\Parking;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class ApiParkingRepository
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private SerializerInterface $serializer,
        private ?string             $apiUrl = null,
    ) {
    }

    /**
     * @return list<Parking>
     */
    public function findAll(string $offset = '0', string $limit = '1000'): array
    {
        $array = null;
        if (!$this->apiUrl) {
            // Si aucune URL n'est configurée, retourner une liste vide pour rester résilient.
           $array = [];
        }

        try {
            $response = $this->httpClient->request('GET', $this->apiUrl . '?offset=' . $offset . '&limit=' . $limit);
            if (200 !== $response->getStatusCode()) {
                $array = [];
            }
            $jsonData = $response->getContent();
            $array = $this->serializer->deserialize($jsonData, Parking::class.'[]', 'json');

        } catch (\Throwable $e) {
            // En cas d'erreur réseau/JSON, retourner une liste vide pour ne pas casser l'app
            $array = [];
        }
        return $array;
    }
}

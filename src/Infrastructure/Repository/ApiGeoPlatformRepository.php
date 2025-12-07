<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Model\GeoPlatformAdress;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class ApiGeoPlatformRepository
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private SerializerInterface $serializer,
        private ?string             $apiUrl = null,
    ) {
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @return GeoPlatformAdress
     */
    public function findOne(float $latitude, float $longitude ): GeoPlatformAdress
    {
        $array = null;
        if (!$this->apiUrl) {
            // Si aucune URL n'est configurée, retourner une liste vide pour rester résilient.
           $array = [];
        }

        try {
            $response = $this->httpClient->request('GET', $this->apiUrl . '?limit=1&lat=' . $latitude . '&lon=' . $longitude);
            if (200 !== $response->getStatusCode()) {
                $array = [];
            }
            $jsonData = $response->getContent();
            $array = $this->serializer->deserialize($jsonData, GeoPlatformAdress::class, 'json');

        } catch (\Throwable $e) {
            // En cas d'erreur réseau/JSON, retourner une liste vide pour ne pas casser l'app
            $array = [];
        }
        return $array;
    }
}

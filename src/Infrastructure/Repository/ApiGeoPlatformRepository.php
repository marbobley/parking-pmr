<?php

namespace App\Infrastructure\Repository;

use App\Domain\Exception\GenericException;
use App\Infrastructure\Model\GeoPlatformAdress;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

final readonly class ApiGeoPlatformRepository
{
    const ERROR_MESSAGE_API_GEOPLATEFORM_ADRESS_NOT_CONFIGURED = "L'url de l'API GeoPlateform n'est pas configurée";
    const ERROR_MESSAGE_API_GEOPLATEFORM_NOT_OK = "Le retour de l'API GeoPlateform n'est pas ok";
    const ERROR_MESSAGE_API_GEOPLATEFORM_THROW_EX = "Une exception a été levée : %s";

    public function __construct(
        private HttpClientInterface $httpClient,
        private SerializerInterface $serializer,
        private LoggerInterface     $logger,
        private ?string             $apiUrl = null
    )
    {
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @return GeoPlatformAdress|null
     * @throws GenericException
     */
    public function findOne(float $latitude, float $longitude): ?GeoPlatformAdress
    {
        if (!$this->apiUrl) {
            $this->logger->error(self::ERROR_MESSAGE_API_GEOPLATEFORM_ADRESS_NOT_CONFIGURED);
            throw new GenericException(self::ERROR_MESSAGE_API_GEOPLATEFORM_ADRESS_NOT_CONFIGURED);
        }

        try {
            $response = $this->httpClient->request('GET', $this->apiUrl . '?limit=1&lat=' . $latitude . '&lon=' . $longitude);
            if (200 !== $response->getStatusCode()) {
                $this->logger->error(self::ERROR_MESSAGE_API_GEOPLATEFORM_NOT_OK);
                throw new GenericException(self::ERROR_MESSAGE_API_GEOPLATEFORM_NOT_OK);
            }
            $jsonData = $response->getContent();
            $geoPlatformAdress = $this->serializer->deserialize($jsonData, GeoPlatformAdress::class, 'json');

        } catch (Throwable $e) {
            $message = sprintf(self::ERROR_MESSAGE_API_GEOPLATEFORM_THROW_EX, $e->getMessage());
            // En cas d'erreur réseau/JSON, retourner une liste vide pour ne pas casser l'app
            $this->logger->error($message);
            throw new GenericException($message);
        }
        return $geoPlatformAdress;
    }
}

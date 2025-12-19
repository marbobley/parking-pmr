<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\ParkingModel;
use App\Infrastructure\Model\Coordinate;
use App\Infrastructure\Model\Parking;
use App\Infrastructure\Model\SlotStatus;
use App\Repository\AdresseProcheOriginRepository;

class ParkingMapper
{
    public function __construct(
        private AdresseProcheOriginRepository $adresseProcheOriginRepository,
    )
    {
    }

    public function mapperEntityToModel(Parking $object): ParkingModel
    {
        $id = (string)($object->id ?? '');
        if ($id === '') {
            throw new \InvalidArgumentException('Parking.id est manquant ou vide.');
        }

        $lat = $this->extractCoordinateFloat($object->latitude ?? null, 'latitude');
        $lon = $this->extractCoordinateFloat($object->longitude ?? null, 'longitude');
        $parkingPlace = $this->extractNombrePlaceInteger($object->slot ?? null);
        $adresse = $this->adresseProcheOriginRepository->findOneBy(array('latitude' => $lat, 'longitude' => $lon));
        $label = is_null($adresse) ? '' : $adresse->getLabel();
        return new ParkingModel($id, $lat, $lon, $parkingPlace, $label);
    }

    /**
     * Extrait une coordonnée (latitude/longitude) en float à partir de
     * différentes formes de données : Coordinate, tableau, scalaire.
     * Valide également l'intervalle.
     */
    private function extractCoordinateFloat(mixed $value, string $field): float
    {
        // Normaliser la valeur potentielle vers un scalaire
        if ($value instanceof Coordinate) {
            $value = $value->value;
        } elseif (\is_object($value) && property_exists($value, 'value')) {
            /** @var mixed $tmp */
            $tmp = $value->value;
            $value = $tmp;
        } elseif (\is_array($value)) {
            $value = $value['value'] ?? $value[$field] ?? null;
        }

        if ($value === null) {
            return 0.0;
        }

        if (!\is_scalar($value) || !is_numeric($value)) {
            return 0.0;
        }

        $float = (float)$value;

        // Validation des bornes
        if ($field === 'latitude' && ($float < -90.0 || $float > 90.0)) {
            return 0.0;
        }
        if ($field === 'longitude' && ($float < -180.0 || $float > 180.0)) {
            return 0.0;
        }

        return $float;
    }

    private function extractNombrePlaceInteger(SlotStatus|null $slot): int
    {
        if ($slot === null || $slot->value === null) {
            return -1;
        }
        return (int)($slot->value);
    }
}

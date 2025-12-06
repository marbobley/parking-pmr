<?php

namespace App\Infrastructure\Model;


use Symfony\Component\Serializer\Attribute\SerializedName;

class Parking
{
    public string $id;
    public string $type;

    #[SerializedName('Latitude')]
    public Latitude $latitude;
    #[SerializedName('Longitude')]
    public Longitude $longitude;
    #[SerializedName('slotStatus')]
    public SlotStatus $slot;
}

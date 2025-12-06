<?php

namespace App\Infrastructure\Model;
class Parking
{
    public string $id;
    public string $type;
    public Latitude $latitude;
    public Longitude $longitude;
    public TimeInstant $timeInstant;
    public SlotStatus $slotStatus;

    public function __construct(
        string $id,
        string $type,
        Latitude $latitude,
        Longitude $longitude,
        TimeInstant $timeInstant,
        SlotStatus $slotStatus
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->timeInstant = $timeInstant;
        $this->slotStatus = $slotStatus;
    }
}

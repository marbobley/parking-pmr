<?php

namespace App\Infrastructure\Model;


use Symfony\Component\Serializer\Attribute\SerializedName;
use App\Infrastructure\Model\GeoPlatformFeatures;

class GeoPlatformAdress
{
    #[SerializedName('features')]
    /**
     * @var GeoPlatformFeatures[]
     */
    public array $features = [];
}

<?php

namespace App\Infrastructure\Model;


use Symfony\Component\Serializer\Attribute\SerializedName;

class GeoPlatformAdress
{
    #[SerializedName('features')]
    /**
     * @var $features GeoPlatformFeatures[]
     */
    public array $features = [];
}

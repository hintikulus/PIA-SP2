<?php

namespace App\Domain\Location;

use App\Model\Database\Transformer\AbstractTransformer;

/**
 * A transformer class for converting Location objects to an array.
 *
 * @template-extends AbstractTransformer<Location>
 */
class LocationTransformer extends AbstractTransformer
{
    /**
     * Transforms a Location object into an associative array.
     *
     * @param Location $location The Location object to transform.
     * @return array<string> An associative array representing the Location.
     */
    public function transform($location): array
    {
        return [
            'latitude'  => $location->getLatitude(),
            'longitude' => $location->getLongitude(),
        ];
    }
}

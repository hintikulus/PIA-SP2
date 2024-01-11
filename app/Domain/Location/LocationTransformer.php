<?php

namespace App\Domain\Location;

use App\Model\Database\Transformer\AbstractTransformer;

/**
 * @template-extends AbstractTransformer<Location>
 */
class LocationTransformer extends AbstractTransformer
{
    /**
     * @param Location $location
     * @return array<mixed>
     */
    public function transform($location): array
    {
        return [
            'latitude'       => $location->getLatitude(),
            'longitude'     => $location->getLongitude(),
        ];
    }
}

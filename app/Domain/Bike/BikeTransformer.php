<?php

namespace App\Domain\Bike;

use App\Domain\Location\Location;
use App\Domain\Location\LocationTransformer;
use App\Model\App;
use App\Model\Database\Transformer\AbstractTransformer;

/**
 * @template-extends AbstractTransformer<Bike>
 */
class BikeTransformer extends AbstractTransformer
{
    private LocationTransformer $locationTransformer;

    public function __construct(
        LocationTransformer $locationTransformer,
    )
    {
        $this->locationTransformer = $locationTransformer;
    }

    /**
     * @param Bike $item
     * @return array
     */
    public function transform($item): array
    {
        return [
            'id'                     => $item->getId(),
            'stand_id'               => $item->getStand()?->getId(),
            'location'               => $this->locationTransformer->transform($item->getLocation()),
            'last_service_timestamp' => $item->getLastServiceTimestamp()->format(App::DATETIME_MILLISECONDS_PICKER_FORMAT),
        ];
    }

    public function transformBikeLocationUpdateData(Bike $bike, Location $location): array
    {
        return [
            'type' => 'bike_location_update',
            'bike_id'  => $bike->getId()->toString(),
            'location' => $this->locationTransformer->transform($location),
        ];
    }
}

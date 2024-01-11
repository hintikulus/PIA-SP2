<?php

namespace App\Domain\Bike;

use App\Domain\Location\Location;
use App\Domain\Location\LocationTransformer;
use App\Model\App;
use App\Model\Database\Transformer\AbstractTransformer;

/**
 * A transformer class for converting Bike objects to arrays.
 *
 * @template-extends AbstractTransformer<Bike>
 */
class BikeTransformer extends AbstractTransformer
{
    private LocationTransformer $locationTransformer;

    /**
     * Constructor to initialize the BikeTransformer.
     *
     * @param LocationTransformer $locationTransformer The LocationTransformer for transforming Location objects.
     */
    public function __construct(LocationTransformer $locationTransformer)
    {
        $this->locationTransformer = $locationTransformer;
    }

    /**
     * Transforms a Bike object into an associative array.
     *
     * @param Bike $item The Bike object to transform.
     * @return array An associative array representing the Bike.
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

    /**
     * Transforms data for updating the location of a Bike.
     *
     * @param Bike $bike The Bike object being updated.
     * @param Location $location The new Location for the Bike.
     * @return array An associative array representing the Bike location update data.
     */
    public function transformBikeLocationUpdateData(Bike $bike, Location $location): array
    {
        return [
            'type'     => 'bike_location_update',
            'bike_id'  => $bike->getId()->toString(),
            'location' => $this->locationTransformer->transform($location),
        ];
    }
}


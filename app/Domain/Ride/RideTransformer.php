<?php

namespace App\Domain\Ride;

use App\Domain\Location\Location;
use App\Domain\Location\LocationTransformer;
use App\Domain\Stand\Stand;
use App\Model\App;
use App\Model\Database\Transformer\AbstractTransformer;

/**
 * @template-extends AbstractTransformer<Ride>
 */
class RideTransformer extends AbstractTransformer
{
    private LocationTransformer $locationTransformer;

    public function __construct(
        LocationTransformer $locationTransformer,
    )
    {
        $this->locationTransformer = $locationTransformer;
    }

    /**
     * @param Ride $ride
     * @return array
     */
    public function transform($ride): array
    {
        return [
            'id'              => $ride->getId(),
            'user_id'         => $ride->getUser()->getId(),
            'bike_id'         => $ride->getBike()->getId(),
            'start_stand_id'  => $ride->getStartStand()->getId(),
            'start_timestamp' => $ride->getStartTimestamp()->format(App::DATETIME_MILLISECONDS_PICKER_FORMAT),
            'end_stand_id'    => $ride->getEndStand()?->getId(),
            'end_timestamp'   => $ride->getEndTimestamp()?->format(App::DATETIME_MILLISECONDS_PICKER_FORMAT),
            'state'           => $ride->getState(),
        ];
    }
}

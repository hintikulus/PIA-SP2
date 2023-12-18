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
     * @param Ride $item
     * @return array
     */
    public function transform($item): array
    {
        return [
            'id'              => $item->getId(),
            'user_id'         => $item->getUser()->getId(),
            'bike_id'         => $item->getBike()->getId(),
            'start_stand_id'  => $item->getStartStand()->getId(),
            'start_timestamp' => $item->getStartTimestamp()->format(App::DATETIME_MILLISECONDS_PICKER_FORMAT),
            'end_stand_id'    => $item->getEndStand()?->getId(),
            'end_timestamp'   => $item->getEndTimestamp()?->format(App::DATETIME_MILLISECONDS_PICKER_FORMAT),
            'state'           => $item->getState(),
        ];
    }
}

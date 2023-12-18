<?php

namespace App\Domain\Stand;

use App\Domain\Location\Location;
use App\Domain\Location\LocationTransformer;
use App\Model\Database\Transformer\AbstractTransformer;

/**
 * @template-extends AbstractTransformer<Stand>
 */
class StandTransformer extends AbstractTransformer
{
    private LocationTransformer $locationTransformer;

    public function __construct(
        LocationTransformer $locationTransformer,)
    {
        $this->locationTransformer = $locationTransformer;
    }

    /**
     * @param Stand $stand
     * @return array
     */
    public function transform($stand): array
    {
        return [
            'id'       => $stand->getId(),
            'name'     => $stand->getName(),
            'location' => $this->locationTransformer->transform($stand->getLocation()),
        ];
    }
}

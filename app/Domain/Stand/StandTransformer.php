<?php

namespace App\Domain\Stand;

use App\Domain\Location\Location;
use App\Domain\Location\LocationTransformer;
use App\Model\Database\Transformer\AbstractTransformer;

/**
 * A transformer class for converting Stand objects to arrays.
 *
 * @template-extends AbstractTransformer<Stand>
 */
class StandTransformer extends AbstractTransformer
{
    private LocationTransformer $locationTransformer;

    /**
     * Constructor to initialize the StandTransformer.
     *
     * @param LocationTransformer $locationTransformer The LocationTransformer for transforming Location objects.
     */
    public function __construct(LocationTransformer $locationTransformer)
    {
        $this->locationTransformer = $locationTransformer;
    }

    /**
     * Transforms a Stand object into an associative array.
     *
     * @param Stand $stand The Stand object to transform.
     * @return array An associative array representing the Stand.
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


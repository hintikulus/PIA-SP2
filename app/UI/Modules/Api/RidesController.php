<?php

namespace App\UI\Modules\Api;

use App\Domain\Ride\RideFacade;
use App\Domain\Ride\RideService;
use App\Domain\Ride\RideTransformer;
use App\Model\Exception\Logic\RideNotFoundException;
use Contributte\ApiRouter\ApiRoute;

/**
 * API for managing users
 *
 * @ApiRoute(
 * 	"/api/rides[/<id>]",
 * 	parameters={
 * 		"id"={}
 * 	},
 *  priority=1,
 *  presenter="Api:Rides"
 * )
 */
class RidesController extends BaseController
{
    private RideService $rideService;
    private RideTransformer $rideTransformer;

    public function __construct(
        RideService $rideService,
        RideTransformer $rideTransformer,
    )
    {
        $this->rideService = $rideService;
        $this->rideTransformer = $rideTransformer;
    }


    /**
     * Get user detail
     *
     * @ApiRoute(
     * 	"/api/rides[/<id>]",
     * 	parameters={
     * 		"id"={}
     * 	},
     * 	method="GET"
     * )
     */
    public function actionDefault(?string $id)
    {
        if($id === null)
        {
            $this->sendNotFoundError();
        }

        $ride = null;

        try
        {
            $ride = $this->rideService->getById($id);
        } catch (RideNotFoundException)
        {
            $this->sendNotFoundError('Ride');
        }

        $this->sendJson($this->rideTransformer->transform($ride));
    }
}

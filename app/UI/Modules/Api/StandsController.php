<?php

namespace App\UI\Modules\Api;

use App\Domain\Stand\StandFacade;
use App\Domain\Stand\StandService;
use App\Domain\Stand\StandTransformer;
use App\Model\Exception\Logic\StandNotFoundException;
use Contributte\ApiRouter\ApiRoute;

/**
 * API for managing users
 *
 * @ApiRoute(
 * 	"/api/stands[/<id>]",
 * 	parameters={
 * 		"id"={}
 * 	},
 *  priority=1,
 *  presenter="Api:Stands"
 * )
 */
class StandsController extends BaseController
{
    private StandService $standService;
    private StandTransformer $standTransformer;

    public function __construct(
        StandService $standService,
        StandTransformer $standTransformer,
    )
    {
        $this->standService = $standService;
        $this->standTransformer = $standTransformer;
    }

    /**
     * Get user detail
     *
     * @ApiRoute(
     * 	"/api/stands[/<id>]",
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
            $this->sendJson($this->standTransformer->transformCollection($this->standService->getAll()));
        }

        $stand = null;

        try {
            $stand = $this->standService->getById($id);
        } catch (StandNotFoundException)
        {
            $this->sendNotFoundError('Stand');
        }

        $this->sendJson($this->standTransformer->transform($stand));
    }
}

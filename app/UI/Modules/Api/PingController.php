<?php

namespace App\UI\Modules\Api;

use Nette\Application\UI\Presenter;

use Contributte\ApiRouter\ApiRoute;
use Nette\Application\Request;
use Nette\Application\Response;
use Nette\Application\Responses\TextResponse;

/**
 * API for ping/pong
 *
 * @ApiRoute(
 * 	"/api/ping",
 * 	methods={
 * 		"GET"="run"
 * 	},
 *  priority=1,
 *  presenter="Api:Ping",
 *  format="plain"
 * )
 */
final class PingController extends Presenter
{

    public function run(Request $request): Response
    {
        return new TextResponse('pong');
    }
}

<?php

namespace App\UI\Modules\Api;

use Nette\Application\UI\Presenter;

class BaseController extends Presenter
{
    public function sendNotFoundError(string $name = null)
    {
        $message = '404 ' . ($name ? $name . ' ' : '') . 'Not Found';

        return $this->sendJson(['message' => $message]);
    }
}

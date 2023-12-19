<?php declare(strict_types = 1);

namespace App\UI\Modules\Base;

use App\Model\App;
use Nette\Security\UserStorage;

abstract class SecuredPresenter extends BasePresenter
{

	public function checkRequirements(mixed $element): void
	{
        if(!$this->user->isLoggedIn())
        {
            $this->redirect(':Front:Sign:in');
        }
	}

}

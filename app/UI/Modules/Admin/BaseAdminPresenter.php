<?php declare(strict_types = 1);

namespace App\UI\Modules\Admin;

use App\Model\App;
use App\UI\Modules\Base\SecuredPresenter;

abstract class BaseAdminPresenter extends SecuredPresenter
{

    public function checkRequirements($element): void
    {
        parent::checkRequirements($element);

        $resource = $this->getRequest()?->getPresenterName() . ':' . $this->getAction();

        try
        {
            $isAllowed = $this->user->isAllowed($resource);
        } catch (\Nette\InvalidStateException)
        {
            $this->error('Page not found', 404);
        }

        if (!$isAllowed && $this->getRequest()?->getPresenterName() !== 'Front:Sign')
        {
            $sessionKey = $this->storeRequest();
            $this->flashError('Pro zobrazení této položky je potřeba se nejprve přihlásit.');
            $this->redirect(App::DESTINATION_SIGN_IN, ['key' => $sessionKey]);
        }

        if (!$this->user->isAllowed('Admin:Home'))
        {
            $this->flashError('You cannot access this with user role');
            $this->redirect('Front:Home');
        }
    }

}

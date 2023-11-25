<?php declare(strict_types = 1);

namespace App\UI\Modules\Front\Home;

use App\Domain\User\UserFacade;
use App\UI\Modules\Front\BaseFrontPresenter;

final class HomePresenter extends BaseFrontPresenter
{
    private UserFacade $userFacade;

    public function __construct(UserFacade $userFacade,)
    {
        $this->userFacade = $userFacade;
    }

    public function actionDefault(): void
    {
        $this->template->bikeCount = 100;
        $this->template->standCount = 20;
        $this->template->ridesDone = 1256;
    }

    public function handleCreateUser()
    {
        $this->userFacade->createUserFromArray([
            'name' => 'Test',
            'email' => 'test@test.cz',
            'password' => 'password',
        ]);
    }
}

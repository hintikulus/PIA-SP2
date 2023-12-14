<?php

namespace App\UI\Modules\Admin\MyRides;

use App\Domain\Ride\RideFacade;
use App\Domain\User\User;
use App\Domain\User\UserFacade;
use App\Model\Exception\Logic\UserNotFoundException;
use App\UI\Components\Admin\Ride\UserRideListGrid;
use App\UI\Components\Admin\Ride\UserRideListGridFactory;
use App\UI\Modules\Admin\BaseAdminPresenter;

class MyRidesPresenter extends BaseAdminPresenter
{
    private UserRideListGridFactory $rideListGridFactory;
    private UserFacade $userFacade;
    private RideFacade $rideFacade;
    private User $domainUser;

    public function __construct(
        UserRideListGridFactory $rideListGridFactory,
        UserFacade $userFacade,
        RideFacade $rideFacade,
    )
    {
        $this->rideListGridFactory = $rideListGridFactory;
        $this->userFacade = $userFacade;
        $this->rideFacade = $rideFacade;
    }

    public function actionDefault()
    {
        $user = $this->userFacade->get($this->user->getId());

        if($user === null)
        {
            throw new UserNotFoundException($this->user->getId());
        }

        $this->domainUser = $user;

        $this->template->usersActiveRide = $this->rideFacade->getUsersActiveRide($user);
    }

    public function createComponentUserRideListGrid(): UserRideListGrid
    {
        return $this->rideListGridFactory->create($this->domainUser);
    }

}

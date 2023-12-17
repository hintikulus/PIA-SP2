<?php

namespace App\UI\Modules\Admin\MyRides;

use App\Domain\Ride\RideFacade;
use App\Domain\User\User;
use App\Domain\User\UserService;
use App\Model\Exception\Logic\UserNotFoundException;
use App\UI\Components\Admin\Ride\UserRideListGrid;
use App\UI\Components\Admin\Ride\UserRideListGridFactory;
use App\UI\Modules\Admin\BaseAdminPresenter;

class MyRidesPresenter extends BaseAdminPresenter
{
    private UserRideListGridFactory $rideListGridFactory;
    private UserService $userService;
    private RideFacade $rideFacade;
    private User $domainUser;

    public function __construct(
        UserRideListGridFactory $rideListGridFactory,
        UserService $userService,
        RideFacade $rideFacade,
    )
    {
        $this->rideListGridFactory = $rideListGridFactory;
        $this->userService =$userService;
        $this->rideFacade = $rideFacade;
    }

    public function actionDefault()
    {
        $user = $this->userService->getById($this->user->getId());

        $this->domainUser = $user;

        $this->template->usersActiveRide = $this->rideFacade->getUsersActiveRide($user);
    }

    public function createComponentUserRideListGrid(): UserRideListGrid
    {
        return $this->rideListGridFactory->create($this->domainUser);
    }

}

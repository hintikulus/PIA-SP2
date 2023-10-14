<?php

namespace App\UI\Modules\Admin\User;

use App\UI\Components\Admin\User\UserListGrid;
use App\UI\Components\Admin\User\UserListGridFactory;
use App\UI\Modules\Admin\BaseAdminPresenter;

class UserPresenter extends BaseAdminPresenter
{
    private UserListGridFactory $userListGridFactory;

    public function __construct(
        UserListGridFactory $userListGridFactory,
    )
    {
        $this->userListGridFactory = $userListGridFactory;
    }

    public function createComponentUserListGrid(): UserListGrid
    {
        return $this->userListGridFactory->create();
    }

}
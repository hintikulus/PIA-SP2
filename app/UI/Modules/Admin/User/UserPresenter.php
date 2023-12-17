<?php

namespace App\UI\Modules\Admin\User;

use App\Domain\User\User;
use App\Domain\User\UserService;
use App\Model\Exception\Logic\UserNotFoundException;
use App\UI\Components\Admin\User\UserForm;
use App\UI\Components\Admin\User\UserFormFactory;
use App\UI\Components\Admin\User\UserListGrid;
use App\UI\Components\Admin\User\UserListGridFactory;
use App\UI\Modules\Admin\BaseAdminPresenter;

class UserPresenter extends BaseAdminPresenter
{
    private UserListGridFactory $userListGridFactory;
    private UserFormFactory $userFormFactory;

    private UserService $userService;

    private ?User $userEntity = null;

    public function __construct(
        UserListGridFactory $userListGridFactory,
        UserFormFactory     $userFormFactory,
        UserService $userService,
    )
    {
        $this->userListGridFactory = $userListGridFactory;
        $this->userFormFactory = $userFormFactory;
        $this->userService = $userService;
    }

    public function actionEdit(string $id): void
    {
        $this->userEntity = $this->userService->getById($id);
    }


    public function createComponentUserListGrid(): UserListGrid
    {
        return $this->userListGridFactory->create();
    }

    public function createComponentUserForm(): UserForm
    {
        $form = $this->userFormFactory->create($this->userEntity, $this->link(':list'));
        $form['form']->onSuccess[] = function()
        {
            $this->redirect(':list');
        };
        return $form;
    }

}

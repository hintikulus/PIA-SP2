<?php

namespace App\UI\Modules\Admin\User;

use App\Domain\User\User;
use App\Domain\User\UserFacade;
use App\UI\Components\Admin\User\UserForm;
use App\UI\Components\Admin\User\UserFormFactory;
use App\UI\Components\Admin\User\UserListGrid;
use App\UI\Components\Admin\User\UserListGridFactory;
use App\UI\Modules\Admin\BaseAdminPresenter;

class UserPresenter extends BaseAdminPresenter
{
    private UserListGridFactory $userListGridFactory;
    private UserFormFactory $userFormFactory;

    private UserFacade $userFacade;

    private ?User $userEntity = null;

    public function __construct(
        UserListGridFactory $userListGridFactory,
        UserFormFactory     $userFormFactory,
        UserFacade $userFacade,
    )
    {
        $this->userListGridFactory = $userListGridFactory;
        $this->userFormFactory = $userFormFactory;
        $this->userFacade = $userFacade;
    }

    public function actionEdit(string $id): void
    {
        $user = $this->userFacade->get($id);

        if($user === null)
        {
            $this->error('User entity not found.', 404);
        }

        $this->userEntity = $user;
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
<?php

namespace App\UI\Components\User;

use App\Domain\User\UserFacade;
use App\UI\Components\Base\BaseComponent;
use App\UI\DataGrid\BaseGrid;

class UserListGrid extends BaseComponent
{
    private UserFacade $userFacade;

    public function __construct(
        UserFacade $userFacade,
    )
    {
        $this->userFacade = $userFacade;
    }

    public function createComponentGrid(): BaseGrid
    {
        $grid = new BaseGrid();
        $grid->setDataSource($this->userFacade->getAll());
        $grid->addColumnText('id', 'ID');


        return $grid;
    }
}
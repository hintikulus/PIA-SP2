<?php

namespace App\UI\Components\Admin\User;

use App\Domain\User\UserFacade;
use App\UI\Components\Base\BaseComponent;
use App\UI\DataGrid\BaseGrid;
use Contributte\Translation\Translator;

class UserListGrid extends BaseComponent
{
    private UserFacade $userFacade;
    private Translator $translator;

    public function __construct(
        UserFacade $userFacade,
        Translator $translator,
    )
    {
        $this->userFacade = $userFacade;
        $this->translator = $translator;
    }

    public function createComponentGrid(): BaseGrid
    {
        $grid = new BaseGrid();
        $grid->setTranslator($this->translator);
        $grid->setDataSource($this->userFacade->getAllQueryBuilder());
        $grid->addColumnText('id', 'ID');
        $grid->addColumnText('name', 'name');
        $grid->addColumnText('emailAddress', 'E-mail');

        return $grid;
    }
}
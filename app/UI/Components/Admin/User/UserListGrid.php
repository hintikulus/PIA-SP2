<?php

namespace App\UI\Components\Admin\User;

use App\Domain\User\UserFacade;
use App\Domain\User\UserQuery;
use App\Model\Database\QueryBuilderManager;
use App\UI\Components\Base\BaseComponent;
use App\UI\DataGrid\BaseGrid;
use Contributte\Translation\Translator;

class UserListGrid extends BaseComponent
{
    private UserFacade $userFacade;
    private QueryBuilderManager $queryBuilderManager;
    private Translator $translator;

    public function __construct(
        UserFacade   $userFacade,
        QueryBuilderManager $queryBuilderManager,
        Translator          $translator,
    )
    {
        $this->userFacade = $userFacade;
        $this->queryBuilderManager = $queryBuilderManager;
        $this->translator = $translator;
    }

    public function createComponentGrid(): BaseGrid
    {
        $grid = new BaseGrid();
        $grid->setTranslator($this->translator);
        $grid->setDataSource($this->queryBuilderManager->getQueryBuilder(UserQuery::getAll()));
        $grid->addColumnText('id', 'ID');
        $grid->addColumnText('name', 'name');
        $grid->addColumnText('emailAddress', 'E-mail');
        $grid->addColumnText('role', 'Role');
        $grid->addColumnDateTime('lastlogin', 'Posl. přihlášení');

        return $grid;
    }
}

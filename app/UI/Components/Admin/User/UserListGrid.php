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
        $translator = $this->translator->createPrefixedTranslator('admin.userListGrid');
        $grid = new BaseGrid();
        $grid->setTranslator($this->translator);
        $grid->setDataSource($this->queryBuilderManager->getQueryBuilder(UserQuery::getAll()));

        $grid->addColumnText('name', $translator->translate('column_name'));
        $grid->addColumnText('email', $translator->translate('column_email'), 'emailAddress');
        $grid->addColumnText('role', $translator->translate('column_role'));
        $grid->addColumnDateTime('lastlogin', $translator->translate('column_lastlogin'));

        return $grid;
    }
}

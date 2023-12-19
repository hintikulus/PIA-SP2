<?php

namespace App\UI\Components\Admin\User;

use App\Domain\User\User;
use App\Domain\User\UserService;
use App\Domain\User\UserQuery;
use App\Model\App;
use App\Model\Database\QueryBuilderManager;
use App\Model\Utils\Html;
use App\UI\Components\Base\BaseComponent;
use App\UI\DataGrid\BaseGrid;
use Contributte\Translation\Translator;
use Nette\Application\ForbiddenRequestException;

class UserListGrid extends BaseComponent
{
    private UserService $userService;
    private QueryBuilderManager $queryBuilderManager;
    private Translator $translator;

    public function __construct(
        UserService   $userService,
        QueryBuilderManager $queryBuilderManager,
        Translator          $translator,
    )
    {
        $this->userService = $userService;
        $this->queryBuilderManager = $queryBuilderManager;
        $this->translator = $translator;
    }

    public function createComponentGrid(): BaseGrid
    {
        if(!$this->presenter->user->isAllowed(User::RESOURCE_ID, 'list'))
        {
            throw new ForbiddenRequestException();
        }

        $translator = $this->translator->createPrefixedTranslator('admin.userListGrid');
        $grid = new BaseGrid();
        $grid->setTranslator($this->translator);
        $grid->setDataSource($this->userService->getAllDataSource());

        $grid->addColumnText('name', $translator->translate('column_name'));
        $grid->addFilterText('name', $translator->translate('filter_name'));

        $grid->addColumnText('email', $translator->translate('column_email'), 'emailAddress');
        $grid->addFilterText('email', $translator->translate('filter_name'));

        $grid->addColumnText('role', $translator->translate('column_role'))->setRenderer(function (User $user)
        {
            $roleString = $this->translator->translate('base.role.' . $user->getRole());
            $html = Html::el('span')->setText($roleString);

            switch ($user->getRole())
            {
                case User::ROLE_REGULAR:
                    return $html->setAttribute('class', 'badge bg-gradient-secondary');
                case User::ROLE_SERVICEMAN:
                    return $html->setAttribute('class', 'badge bg-gradient-warning');
                case User::ROLE_ADMIN:
                    return $html->setAttribute('class', 'badge bg-gradient-primary');
                default:
                    return $html->setAttribute('class', 'badge bg-gradient-default');
            }
        })
        ->setFitContent();
        $grid->addFilterSelect('role', $translator->translate('filter_role'), [
            'regular' => $this->translator->translate('base.role.regular'),
            'serviceman' => $this->translator->translate('base.role.serviceman'),
            'admin' => $this->translator->translate('base.role.admin'),
        ])
        ->setPrompt($translator->translate('filter_role'));


        $grid->addColumnDateTime('lastlogin', $translator->translate('column_lastlogin'), 'lastLogin')
        ->setSortable()
        ->setFormat(App::DATETIME_FORMAT);

        if($this->presenter->user->isAllowed(User::RESOURCE_ID, 'edit'))
        {
            $grid->addAction('edit', $translator->translate('action_edit'), 'User:edit')
                ->setClass('btn btn-sm bg-gradient-secondary mb-0')
            ;
        }

        return $grid;
    }
}

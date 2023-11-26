<?php

namespace App\UI\Components\Admin\User;

use App\Domain\User\User;
use App\Domain\User\UserFacade;
use App\Model\Exception\Runtime\AuthenticationException;
use App\UI\Components\Base\BaseComponent;
use App\UI\Form\BaseForm;
use Contributte\Translation\Translator;
use Nette\Utils\ArrayHash;

class UserForm extends BaseComponent
{
    private Translator $translator;
    private UserFacade $userFacade;
    private ?User $user;
    private ?string $cancelUrl = null;

    public function __construct(
        Translator $translator,
        UserFacade $userFacade,
        ?User      $user = null,
        ?string    $cancelUrl = null,
    )
    {
        $this->translator = $translator;
        $this->userFacade = $userFacade;
        $this->user = $user;
        $this->cancelUrl = $cancelUrl;
    }

    public function render(mixed $params = null): void
    {
        if ($this->user !== null)
        {
            $this['form']->setDefaults([
                'name'  => $this->user->getName(),
                'email' => $this->user->getEmailAddress(),
                'role'  => $this->user->getRole(),
            ]);
        }
        else
        {
            $this['form']->setDefaults([
                'role' => User::ROLE_REGULAR,
            ]);
        }

        parent::render($params);
    }

    public function createComponentForm(): BaseForm
    {
        $translator = $this->translator->createPrefixedTranslator('admin.userForm');
        $form = new BaseForm();

        $form->addText('name', $translator->translate('input_name'))
            ->setRequired()
        ;

        $form->addEmail('email', $translator->translate('input_email'))
            ->setRequired()
        ;

        $form->addPassword('password', $translator->translate('input_password'));

        $form->addRadioList('role', $translator->translate('input_role'), [
                User::ROLE_REGULAR    => $translator->translate('option_role.' . User::ROLE_REGULAR),
                User::ROLE_SERVICEMAN => $translator->translate('option_role.' . User::ROLE_SERVICEMAN),
                User::ROLE_ADMIN      => $translator->translate('option_role.' . User::ROLE_ADMIN),
            ]
        );

        if ($this->cancelUrl !== null)
        {
            $form->addCancelButton($this->cancelUrl);
        }

        $form->addSubmit('send');
        $form->onSuccess[] = [$this, 'formSucceeded'];
        $form->onValidate[] = [$this, 'formValidated'];

        return $form;
    }

    public function formValidated(BaseForm $form, ArrayHash $values)
    {

    }

    public function formSucceeded(BaseForm $form, ArrayHash $values)
    {
        $transformedValues = $this->transformValues($values);

        try
        {
            $this->userFacade->saveUser($this->user, $transformedValues['name'], $transformedValues['password'], $transformedValues['email'], $transformedValues['role']);
            $this->flashSuccess('Uložení proběhlo úspěšně.');
        }
        catch (AuthenticationException $e)
        {
            $form->addError('Emailová adresa je obsazena.');
        }
        catch (\Exception $exception)
        {
            $this->flashError('Při ukládání se vyskytla chyba.');
        }
    }

    private function transformValues(ArrayHash $values): array
    {
        $transformedValues = [
            'name'     => $values['name'],
            'password' => !empty($values['password']) ? $values['password'] : null,
            'email'    => $values['email'],
            'role'     => $values['role'],
        ];

        return $transformedValues;
    }
}
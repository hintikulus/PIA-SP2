<?php

namespace App\UI\Components\Front\Sign;

use App\Model\Exception\Runtime\AuthenticationException;
use App\UI\Components\Base\BaseComponent;
use App\UI\Form\BaseForm;
use Contributte\Translation\Translator;
use Nette\Security\User;
use Nette\Utils\ArrayHash;

class SignInForm extends BaseComponent
{
    private User $user;
    private Translator $translator;

    public function __construct(
        User       $user,
        Translator $translator,
    )
    {
        $this->user = $user;
        $this->translator = $translator;
    }

    public function createComponentForm(): BaseForm
    {
        $translator = $this->translator->createPrefixedTranslator('front.signInForm');
        $form = new BaseForm();

        $form->addEmail('email', 'Email')
            ->setRequired('Položka musí být vyplněna')
        ;

        $form->addPassword('password', 'Password')
            ->setRequired('Položka musí být vyplněna')
        ;

        $form->addCheckbox('remember', 'Remember me');

        $form->addSubmit('send');

        $form->onSuccess[] = [$this, 'formSucceeded'];

        return $form;
    }

    public function formSucceeded(BaseForm $form, ArrayHash $values): void
    {
        try
        {
            $this->user->login($values['email'], $values['password']);
        }
        catch (AuthenticationException $e)
        {
            $this->flashWarning('Autentizace selhala.');
            $form->addError('Autentizace selhala.');
            return;
        }
        catch (\Exception $e)
        {
            $this->flashError('Vyskytla se chyba.');
            $form->addError('Vyskytla se chyba.');
            return;
        }

        $this->flashSuccess('Úspěšně přihlášen.');
    }
}

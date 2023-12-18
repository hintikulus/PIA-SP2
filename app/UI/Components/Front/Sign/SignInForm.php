<?php

namespace App\UI\Components\Front\Sign;

use App\Model\Exception\Logic\UserNotFoundException;
use App\Model\Exception\Runtime\AuthenticationException;
use App\UI\Components\Base\BaseComponent;
use App\UI\Form\BaseForm;
use Contributte\Translation\PrefixedTranslator;
use Contributte\Translation\Translator;
use Nette\Security\User;
use Nette\Utils\ArrayHash;

class SignInForm extends BaseComponent
{
    private User $user;
    private Translator $translator;
    private PrefixedTranslator $pt;

    public function __construct(
        User       $user,
        Translator $translator,
    )
    {
        $this->user = $user;
        $this->translator = $translator;
        $this->pt = $translator->createPrefixedTranslator('front.signInForm');
    }

    public function createComponentForm(): BaseForm
    {
        $translator = $this->translator->createPrefixedTranslator('front.signInForm');
        $form = new BaseForm();

        $form->addEmail('email', $translator->translate('input_email'))
            ->setRequired($this->translator->translate('base.form.required'))
            ->setHtmlAttribute('placeholder', $translator->translate('input_email'))
            ->setHtmlAttribute('aria-label', $translator->translate('input_email'))
        ;

        $form->addPassword('password', $translator->translate('input_password'))
            ->setRequired($this->translator->translate('base.form.required'))
            ->setHtmlAttribute('placeholder', $translator->translate('input_password'))
            ->setHtmlAttribute('aria-label', $translator->translate('input_password'))
        ;

        $form->addCheckbox('remember', $translator->translate('input_remember'));

        $form->addSubmit('send', $translator->translate('input_submit'));

        $form->onSuccess[] = [$this, 'formSucceeded'];

        return $form;
    }

    public function formSucceeded(BaseForm $form, ArrayHash $values): void
    {
        try
        {
            $this->user->login($values['email'], $values['password']);
        }
        catch (AuthenticationException|UserNotFoundException $e)
        {
            $this->flashWarning($this->pt->translate('flash_authentication_error'));
            $form->addError($this->pt->translate('error_authentication_error'));
            return;
        }
        catch (\Exception $e)
        {
            $this->flashError($this->pt->translate('flash_error'));
            $form->addError($this->pt->translate('error_error'));
            return;
        }

        $this->flashSuccess($this->pt->translate('flash_success'));
    }
}

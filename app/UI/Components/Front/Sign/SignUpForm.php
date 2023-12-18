<?php

namespace App\UI\Components\Front\Sign;

use App\Domain\User\UserService;
use App\Model\Exception\Logic\UserNotFoundException;
use App\Model\Exception\Runtime\AuthenticationException;
use App\UI\Components\Base\BaseComponent;
use App\UI\Form\BaseForm;
use Contributte\Translation\PrefixedTranslator;
use Contributte\Translation\Translator;
use Nette\Forms\Controls\TextInput;
use Nette\Utils\ArrayHash;

class SignUpForm extends BaseComponent
{
    private UserService $userService;
    private Translator $translator;
    private PrefixedTranslator $pt;

    public function __construct(
        UserService $userService,
        Translator $translator,
    )
    {
        $this->userService = $userService;
        $this->translator = $translator;
        $this->pt = $this->translator->createPrefixedTranslator('front.signUpForm');
    }

    public function createComponentForm(): BaseForm
    {
        $form = new BaseForm();

        $form->addText('name', $this->pt->translate('input_name'))
            ->setRequired($this->translator->translate('base.form.required'))
        ;

        $form->addEmail('email', $this->pt->translate('input_email'))
            ->setRequired($this->translator->translate('base.form.required'))
        ;

        $form->addPassword('password1', $this->pt->translate('input_password1'))
            ->setRequired($this->translator->translate('base.form.required'))
            ->addRule(BaseForm::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků.', 8)
        ;

        $form->addPassword('password2', $this->pt->translate('input_password2'))
            ->setRequired($this->translator->translate('base.form.required'))
        ;

        $form->addCheckbox('agreement', $this->pt->translate('input_agreement'))
        ->setRequired($this->translator->translate('base.form.required'));

        $form->addSubmit('send', $this->pt->translate('input_send'));

        $form->onValidate[] = [$this, 'formValidated'];
        $form->onSuccess[] = [$this, 'formSucceeded'];

        return $form;
    }

    public function formValidated(BaseForm $form, ArrayHash $values)
    {
        if($values['password1'] !== $values['password2'])
        {
            $form->addError($this->pt->translate('error_passwordNotMatch'));
        }
    }

    public function formSucceeded(BaseForm $form, ArrayHash $values): void
    {
        try {
            $this->userService->createUser($values['name'], $values['email'], $values['password1']);
            $this->flashSuccess($this->pt->translate('flash_success'));
        } catch (UserNotFoundException $e)
        {
            $form->addError($this->pt->translate('error_emailInUse'));
        } catch (\Exception $e)
        {
            $form->addError($this->pt->translate('error_error'));
        }
    }
}

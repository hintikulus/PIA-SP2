<?php

namespace App\UI\Components\Front\Sign;

use App\Domain\User\UserFacade;
use App\Model\Exception\Logic\UserNotFoundException;
use App\Model\Exception\Runtime\AuthenticationException;
use App\UI\Components\Base\BaseComponent;
use App\UI\Form\BaseForm;
use Nette\Forms\Controls\TextInput;
use Nette\Utils\ArrayHash;

class SignUpForm extends BaseComponent
{
    private UserFacade $userFacade;
    public function __construct(
        UserFacade $userFacade,
    )
    {
        $this->userFacade = $userFacade;
    }

    public function createComponentForm(): BaseForm
    {
        $form = new BaseForm();

        $form->addText('name', 'Jméno a příjmení')
            ->setRequired()
        ;

        $form->addEmail('email', 'E-mail')
            ->setRequired()
        ;

        $form->addPassword('password1', 'Heslo')
            ->setRequired()
            ->addRule(BaseForm::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků.', 8)
        ;

        $form->addPassword('password2', 'Znovu heslo pro ověření')
            ->setRequired()
        ;

        $form->addCheckbox('agreement', 'Souhlasím s podmínkami.')
        ->setRequired();

        $form->addSubmit('send', 'Registrovat');

        $form->onValidate[] = [$this, 'formValidated'];
        $form->onSuccess[] = [$this, 'formSucceeded'];

        return $form;
    }

    public function formValidated(BaseForm $form, ArrayHash $values)
    {
        if($values['password1'] !== $values['password2'])
        {
            $form->addError('Passwords does not match');
        }
    }

    public function formSucceeded(BaseForm $form, ArrayHash $values): void
    {
        try {
            $this->userFacade->createUser($values['name'], $values['email'], $values['password1']);
            $this->flashSuccess('Registrace proběhla úspěšně.');
        } catch (UserNotFoundException $e)
        {
            $form->addError('Na Vámi zadanou emailovou adresu již evidujeme registrovaný účet, použijte prosím jinou nebo se zkuste přihlásit.');
        } catch (\Exception $e)
        {
            bdump($e);
            $form->addError('Při registraci se vyskytla chyba. Zkuste to prosím znovu.');
        }
    }
}

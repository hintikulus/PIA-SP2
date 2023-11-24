<?php

namespace App\UI\Modules\Front\Sign;

use App\UI\Components\Front\Sign\SignInForm;
use App\UI\Components\Front\Sign\SignInFormFactory;
use App\UI\Components\Front\Sign\SignUpForm;
use App\UI\Components\Front\Sign\SignUpFormFactory;
use App\UI\Modules\Front\BaseFrontPresenter;

class SignPresenter extends BaseFrontPresenter
{
    private SignInFormFactory $signInFormFactory;
    private SignUpFormFactory $signUpFormFactory;

    public function __construct(
        SignInFormFactory $signInFormFactory,
        SignUpFormFactory $signUpFormFactory,
    )
    {
        $this->signInFormFactory = $signInFormFactory;
        $this->signUpFormFactory = $signUpFormFactory;
    }

    public function actionIn(): void
    {
        if ($this->user->isLoggedIn())
        {
            $this->redirect(':Admin:Home:');
        }
    }

    public function actionOut(): void
    {
        if (!$this->user->isLoggedIn())
        {
            $this->redirect('Sign:in');
        }

        $this->user->logout(true);
        $this->flashSuccess('Uživatel úspěšně odhlášen.');
        $this->redirect(':Front:Home:');
    }

    public function actionUp(): void
    {
        if ($this->user->isLoggedIn())
        {
            $this->redirect(':Admin:Home:');
        }
    }

    public function createComponentSignInForm(): SignInForm
    {
        $form = $this->signInFormFactory->create();
        $form['form']->onSuccess[] = function() {
            $this->redirect(':Admin:Home:');
        };
        return $form;
    }

    public function createComponentSignUpForm(): SignUpForm
    {
        $form = $this->signUpFormFactory->create();
        $form['form']->onSuccess[] = function() {
            $this->redirect(':Admin:Home:');
        };
        return $form;
    }
}

<?php

namespace App\UI\Modules\Front\Sign;

use App\UI\Components\Admin\Sign\SignInForm;
use App\UI\Components\Admin\Sign\SignInFormFactory;
use App\UI\Modules\Front\BaseFrontPresenter;

class SignPresenter extends BaseFrontPresenter
{
    private SignInFormFactory $signInFormFactory;
    public function __construct(
        SignInFormFactory $signInFormFactory,
    )
    {
        $this->signInFormFactory = $signInFormFactory;
    }

    public function actionIn(): void
    {
        if($this->user->isLoggedIn())
        {
            $this->redirect(':Admin:Home:');
        }
    }

    public function actionOut(): void
    {
        if($this->user->isLoggedIn())
        {
            $this->user->logout(true);
            $this->flashSuccess('Uživatel úspěšně odhlášen.');
            $this->redirect(':Front:Home:');
        }
    }

    public function actionUp(): void
    {

    }

    public function createComponentSignInForm(): SignInForm
    {
        $form = $this->signInFormFactory->create();
        $form['form']->onSuccess[] = function()
        {
            $this->redirect(':Admin:Home:');
        };
        return $form;
    }
}
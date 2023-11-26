<?php

namespace App\UI\Components\Front\Sign\GoogleButton;

use App\Domain\User\UserFacade;
use App\Model\Exception\Runtime\AuthenticationException;
use App\UI\Components\Base\BaseComponent;
use Contributte\OAuth2Client\Flow\Google\GoogleAuthCodeFlow;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GoogleUser;
use Nette\Application\UI\Control;
use Nette\Security\User;

class GoogleButton extends BaseComponent
{
    private GoogleAuthCodeFlow $flow;
    private UserFacade $userFacade;
    private User $user;

    public function __construct(
        GoogleAuthCodeFlow $flow,
        UserFacade $userFacade,
        User $user,
    )
    {
        $this->flow = $flow;
        $this->userFacade = $userFacade;
        $this->user = $user;
    }

    public function authenticate(string $authorizationUrl): void
    {
        $this->presenter->redirectUrl(
            $this->flow->getAuthorizationUrl($authorizationUrl)
        );
    }

    public function authorize(array $parameters = null): void
    {
        try {
            $parameters = $parameters ?? $this->getPresenter()->getHttpRequest()->getQuery();
            $accessToken = $this->flow->getAccessToken($parameters);
        } catch (IdentityProviderException $e) {
            $this->flashError('Vyskytla se chyba při zpracování požadavku.');
            $this->presenter->redirect(':in');
        }

        /** @var GoogleUser $owner */
        $owner = $this->flow->getProvider()->getResourceOwner($accessToken);
        $user = $this->userFacade->getByEmail($owner->getEmail());
        if($user === null)
        {
            $user = $this->userFacade->createUserWithGoogle($owner->getName(), $owner->getEmail(), $owner->getId());
        }
        $this->userFacade->updateLastLoginDatetime($user);

        $this->user->login($user->toIdentity());
        $this->flashSuccess('Úspěšně přihlášen');
        $this->presenter->redirect(':Admin:Home:');
    }

}

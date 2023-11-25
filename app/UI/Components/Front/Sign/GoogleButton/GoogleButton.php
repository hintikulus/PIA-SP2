<?php

namespace App\UI\Components\Front\Sign\GoogleButton;

use App\Domain\User\UserFacade;
use App\Model\Exception\Runtime\AuthenticationException;
use Contributte\OAuth2Client\Flow\Google\GoogleAuthCodeFlow;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GoogleUser;
use Nette\Application\UI\Control;
use Nette\Security\User;

class GoogleButton extends Control
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
            // TODO - Identity provider failure, cannot get information about user
            throw new AuthenticationException();
        }

        /** @var GoogleUser $owner */
        $owner = $this->flow->getProvider()->getResourceOwner($accessToken);
        bdump($owner);
        $user = $this->userFacade->getByEmail($owner->getEmail());
        if($user === null)
        {
            throw new AuthenticationException();
        }

        $this->user->login($user->toIdentity());
        // TODO - try sign in user with it's email ($owner->getEmail())
    }

}
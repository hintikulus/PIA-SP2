<?php

namespace App\UI\Components\Front\Sign\GoogleButton;

use App\Domain\User\UserService;
use App\Model\Exception\Logic\UserNotFoundException;
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
    private UserService $userService;
    private User $user;

    public function __construct(
        GoogleAuthCodeFlow $flow,
        UserService $userService,
        User               $user,
    )
    {
        $this->flow = $flow;
        $this->userService = $userService;
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
        try
        {
            $parameters = $parameters ?? $this->getPresenter()->getHttpRequest()->getQuery();
            $accessToken = $this->flow->getAccessToken($parameters);
        }
        catch (IdentityProviderException $e)
        {
            $this->flashError('Vyskytla se chyba při zpracování požadavku.');
            $this->presenter->redirect(':in');
        }

        /** @var GoogleUser $owner */
        $owner = $this->flow->getProvider()->getResourceOwner($accessToken);

        try
        {
            $user = $this->userService->findByEmail($owner->getEmail());
            if ($user === null)
            {
                $user = $this->userService->createUser($owner->getName(), $owner->getEmail(), null, ['discord_id' => $owner->getId()]);
            }
            $this->userService->updateLastLoginDatetime($user);
            $this->user->login($user->toIdentity());
        }
        catch (UserNotFoundException)
        {
            $this->flashError('Uživatel nenalezen.');
            return;
        }
        catch (\Exception $e)
        {
            $this->flashError('Vyskytla se chyba.');
            return;
        }

        $this->flashSuccess('Úspěšně přihlášen');
        $this->presenter->redirect(':Front:Sign:in');
    }

}

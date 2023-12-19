<?php

namespace App\UI\Components\Base\RideableBikesAndStandMap;

use App\Domain\Bike\BikeService;
use App\Domain\Config\ConfigService;
use App\Domain\Ride\RideService;
use App\Domain\Stand\StandService;
use App\Domain\User\UserService;
use App\Model\Utils\Html;
use App\UI\Components\Base\BaseComponent;
use App\UI\Map\BaseMap;
use App\UI\Map\Map;
use Contributte\Translation\Translator;

class RideableBikesAndStandMap extends BaseComponent
{
    private UserService $userService;
    private BikeService $bikeService;
    private StandService $standService;
    private RideService $rideService;
    private ConfigService $configService;
    private Translator $translator;

    public function __construct(
        UserService  $userService,
        BikeService $bikeService,
        StandService $standService,
        RideService  $rideService,
        ConfigService $configService,
        Translator  $translator,
    )
    {
        $this->userService = $userService;
        $this->bikeService = $bikeService;
        $this->standService = $standService;
        $this->rideService = $rideService;
        $this->configService = $configService;
        $this->translator = $translator;
    }

    public function createComponentMap(): Map
    {
        $translator = $this->translator->createPrefixedTranslator('base.rideableBikesAndStandMap');
        $map = new BaseMap();


        foreach ($this->standService->getAll() as $stand)
        {
            $map->addMarker($stand->getLocation(), $stand->getId()->toString(), 'stand');
        }

        foreach ($this->bikeService->getRideableBikes() as $bike)
        {
            $marker = $map->addMarker($bike->getLocation(), $bike->getId()->toString(), $bike->isInStand() ? 'bike' : 'bike_ride', 'bike');

            $popupName = Html::el('span');
            $popupName->addHtml(Html::el('b')->addText($translator->translate('popup_bike_state')));
            $popupName->addHtml(Html::el('span')->addText($translator->translate($bike->isInStand() ? 'popup_bike_state_parked' : 'popup_bike_state_in_ride')));

            $popup = Html::el('div', ['class' => 'text-center'])->addHtml($popupName)->addHtml(Html::el('br'));

            if ($this->canUserTakeRide())
            {
                if ($bike->isInStand() && !$bike->isDueForService($this->configService->getBikeServiceInterval()))
                {
                    $popupStartRideLink = Html::el(
                        'a',
                        [
                            'class' => 'btn btn-sm bg-gradient-primary mb-0 mt-2 stand-choose',
                            'href'  => $this->link('startRide!', ['bikeId' => $bike->getId()->toString()])
                        ]
                    )
                        ->setText($translator->translate('popup_action_start_ride'))
                    ;
                    $popup->addHtml($popupStartRideLink);
                }
            }

            $marker->setPopup($popup);
        }

        return $map;
    }

    public function handleStartRide(string $bikeId): void
    {
        if(!$this->presenter->user->isAllowed('Admin:Ride:start')){
            $this->flashWarning($this->translator->translate('base.notPermitted'));
            return;
        }
        $bike = $this->bikeService->getById($bikeId);

        $user = $this->userService->getById($this->presenter->user->getId());

        $ride = $this->rideService->startRide($user, $bike);

        $this->flashSuccess($this->translator->translate('base.rideableBikesAndStandMap.flash_rideStarted'));
        $this->presenter->redirect(':Admin:Ride:detail', ['id' => $ride->getId()->toString()]);
    }

    private function canUserTakeRide(): bool
    {
        if (!$this->presenter->user->isLoggedIn() || !$this->presenter->user->isAllowed('Admin:Ride:start'))
        {
            return false;
        }

        $userId = $this->presenter->user->getId();
        $user = $this->userService->getById($userId);

        return !$this->rideService->isUserInRide($user);
    }
}

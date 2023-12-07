<?php

namespace App\UI\Components\Front\RideableBikesAndStandMap;

use App\Domain\Bike\BikeFacade;
use App\Domain\Stand\StandFacade;
use App\Model\Utils\Html;
use App\UI\Components\Base\BaseComponent;
use App\UI\Map\BaseMap;
use Contributte\Translation\Translator;

class RideableBikesAndStandMap extends BaseComponent
{
    private BikeFacade $bikeFacade;
    private StandFacade $standFacade;
    private Translator $translator;

    public function __construct(
        BikeFacade  $bikeFacade,
        StandFacade $standFacade,
        Translator  $translator,
    )
    {
        $this->bikeFacade = $bikeFacade;
        $this->standFacade = $standFacade;
        $this->translator = $translator;
    }

    public function createComponentMap()
    {
        $translator = $this->translator->createPrefixedTranslator('admin.rideableBikesAndStandMap');
        $map = new BaseMap();

        $showPopup = $this->presenter->user->isLoggedIn();

        foreach ($this->standFacade->getAll() as $stand)
        {
            $map->addMarker($stand->getLocation(), $stand->getId()->toString(), 'stand');
        }

        foreach ($this->bikeFacade->getRideableBikes() as $bike)
        {
            $marker = $map->addMarker($bike->getLocation(), $bike->getId()->toString(), $bike->isInStand() ? 'bike' : 'bike_ride', 'bike');


            $popupName = Html::el('span');
            $popupName->addHtml(Html::el('b')->addText($translator->translate('popup_bike_state')));
            $popupName->addHtml(Html::el('span')->addText($translator->translate($bike->isInStand() ? 'popup_bike_state_parked' : 'popup_bike_state_in_ride')));

            $popup = Html::el('div', ['class' => 'text-center'])->addHtml($popupName)->addHtml(Html::el('br'));

            if ($this->presenter->user->isLoggedIn())
            {
                if ($bike->isInStand() && !$bike->isDueForService())
                {
                    $popupStartRideLink = Html::el('span', ['class' => 'btn btn-sm bg-gradient-primary mb-0 mt-2 stand-choose',])->setText($translator->translate('popup_action_start_ride'));
                    $popup->addHtml($popupStartRideLink);
                }
            }

            $marker->setPopup($popup);
        }

        return $map;
    }
}

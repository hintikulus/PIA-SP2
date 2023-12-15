<?php

namespace App\UI\Components\Admin\Ride;

use App\Domain\Ride\Ride;
use App\Domain\Ride\RideFacade;
use App\Domain\Stand\StandFacade;
use App\Model\Exception\Logic\RideNotFoundException;
use App\Model\Exception\Logic\StandNotFoundException;
use App\Model\Exception\LogicException;
use App\Model\Utils\Html;
use App\UI\Components\Base\BaseComponent;
use App\UI\Map\BaseMap;
use Contributte\Translation\Translator;

class RideProgressMap extends BaseComponent
{
    private StandFacade $standFacade;
    private RideFacade $rideFacade;
    private Translator $translator;
    private Ride $ride;

    /** @var array<callable> $onRideEnd */
    private array $onRideEnd;

    public function __construct(
        StandFacade $standFacade,
        RideFacade  $rideFacade,
        Translator  $translator,
        Ride        $ride,
    )
    {
        $this->standFacade = $standFacade;
        $this->rideFacade = $rideFacade;
        $this->translator = $translator;
        $this->ride = $ride;
    }

    public function createComponentMap(): BaseMap
    {
        $translator = $this->translator->createPrefixedTranslator('admin.rideProgressMap');
        $map = new BaseMap();

        $map->addMarker($this->ride->getBike()->getLocation(), 'bike', 'bike_ride', 'bike');

        foreach ($this->standFacade->getAll() as $stand)
        {
            $marker = $map->addMarker($stand->getLocation(), 'stand', $stand !== $this->ride->getStartStand() ? 'stand' : 'stand_green', 'stand');

            $popupName = Html::el('span');
            $popupName->addHtml(Html::el('b')->addText($translator->translate('popup_stand_name')));
            $popupName->addHtml(Html::el('span')->addText($stand->getName()));

            $popup = Html::el('div', ['class' => 'text-center'])->addHtml($popupName)->addHtml(Html::el('br'));

            $popupEndRideLink = Html::el(
                'a',
                [
                    'class' => 'btn btn-sm bg-gradient-primary mb-0 mt-2 stand-choose ajax',
                    'href'  => $this->link('endRide!', ['rideId' => $this->ride->getId()->toString(), 'standId' => $stand->getId()->toString()])
                ]
            )
                ->setText($translator->translate('popup_action_end_ride'))
            ;
            $popup->addHtml($popupEndRideLink);

            $marker->setPopup($popup);
        }


        return $map;
    }

    public function handleEndRide(string $rideId, string $standId): void
    {
        $ride = $this->rideFacade->get($rideId);

        if ($ride === null)
            throw new RideNotFoundException($rideId);

        $stand = $this->standFacade->get($standId);

        if ($stand === null)
            throw new StandNotFoundException($standId);

        try {
            $this->rideFacade->endRide($ride, $stand);
        } catch (LogicException $e)
        {
            $this->flashInfo($e->getMessage());
            return;
        }
        $this->onRideEnd();
    }
}

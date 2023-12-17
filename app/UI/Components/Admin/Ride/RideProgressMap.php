<?php

namespace App\UI\Components\Admin\Ride;

use App\Domain\Ride\Ride;
use App\Domain\Ride\RideService;
use App\Domain\Stand\StandService;
use App\Model\Exception\Logic\RideNotFoundException;
use App\Model\Exception\Logic\StandNotFoundException;
use App\Model\Exception\LogicException;
use App\Model\Utils\Html;
use App\UI\Components\Base\BaseComponent;
use App\UI\Map\BaseMap;
use Contributte\Translation\Translator;

class RideProgressMap extends BaseComponent
{
    private StandService $standService;
    private RideService $rideService;
    private Translator $translator;
    private Ride $ride;

    /** @var array<callable> $onRideEnd */
    public array $onRideEnd = [];

    public function __construct(
        StandService $standService,
        RideService  $rideService,
        Translator  $translator,
        Ride        $ride,
    )
    {
        $this->standService = $standService;
        $this->rideService = $rideService;
        $this->translator = $translator;
        $this->ride = $ride;
    }

    public function render(mixed $params = null): void
    {
        $this->template->ride = $this->ride;
        parent::render($params);
    }

    public function createComponentMap(): BaseMap
    {
        $translator = $this->translator->createPrefixedTranslator('admin.rideProgressMap');
        $map = new BaseMap();

        foreach ($this->standService->getAll() as $stand)
        {
            $marker = $map->addMarker($stand->getLocation(), $stand->getId()->toString(), $stand !== $this->ride->getStartStand() ? 'stand' : 'stand_green', 'stand');

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

        $map->addMarker($this->ride->getBike()->getLocation(), $this->ride->getBike()->getId()->toString(), 'bike_ride', 'bike');

        return $map;
    }

    public function handleEndRide(string $rideId, string $standId): void
    {
        $ride = $this->rideService->getById($rideId);

        $stand = $this->standService->getById($standId);

        try {
            $this->rideService->completeRide($ride, $stand);
        } catch (LogicException $e)
        {
            $this->flashInfo($e->getMessage());
            return;
        }

        foreach ($this->onRideEnd as $handler)
            $handler();
    }
}

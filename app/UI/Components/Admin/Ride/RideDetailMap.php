<?php

namespace App\UI\Components\Admin\Ride;

use App\Domain\Ride\Ride;
use App\Domain\Stand\Stand;
use App\Model\Utils\Html;
use App\UI\Components\Base\BaseComponent;
use App\UI\Map\BaseMap;
use App\UI\Map\Map;
use Contributte\Translation\Translator;

class RideDetailMap extends BaseComponent
{
    private Translator $translator;
    private Ride $ride;

    public function __construct(
        Translator $translator,
        Ride       $ride,
    )
    {
        $this->translator = $translator;
        $this->ride = $ride;
    }

    public function createComponentMap(): BaseMap
    {
        $translator = $this->translator->createPrefixedTranslator('admin.rideDetailMap');
        $map = new BaseMap();

        $popupCallable = fn(Stand $stand) => Html::el('div', ['class' => 'text-center'])
            ->addHtml(Html::el('b')->addText($translator->translate('popup_stand_name')))
            ->addHtml(
                Html::el('span')
                    ->addText($stand->getName())
            )
            ->addHtml(Html::el('br'))
        ;

        if($this->ride->getStartStand() !== $this->ride->getEndStand())
        {
            $map->addMarker($this->ride->getStartStand()->getLocation(), 'stand', 'stand_green', 'stand')
                ->setPopup($popupCallable($this->ride->getStartStand()))
            ;
            $map->addMarker($this->ride->getEndStand()->getLocation(), 'stand', 'stand_red', 'stand')
                ->setPopup($popupCallable($this->ride->getEndStand()))
            ;
        } else {
            $map->addMarker($this->ride->getEndStand()->getLocation(), 'stand', 'stand_green_red', 'stand')
                ->setPopup($popupCallable($this->ride->getStartStand()))
            ;
        }

        return $map;
    }
}
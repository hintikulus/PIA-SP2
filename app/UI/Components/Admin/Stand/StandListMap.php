<?php

namespace App\UI\Components\Admin\Stand;

use App\Domain\Location\Location;
use App\Domain\Stand\StandFacade;
use App\Model\Utils\Html;
use App\UI\Components\Base\BaseComponent;
use App\UI\Map\BaseMap;
use Nette\Application\LinkGenerator;

class StandListMap extends BaseComponent
{
    private StandFacade $standFacade;
    private LinkGenerator $linkGenerator;

    public function __construct(
        StandFacade $standFacade,
        LinkGenerator $linkGenerator,
    )
    {
        $this->standFacade = $standFacade;
        $this->linkGenerator = $linkGenerator;
    }

    public function render(mixed $params = null): void
    {
        $this->template->stands = $this->standFacade->getAll();
        parent::render($params);
    }

    public function createComponentMap(): BaseMap
    {
        $map = new BaseMap();

        foreach ($this->standFacade->getAll() as $stand)
        {
            $popupName = Html::el('span');
            $popupName->addHtml(Html::el('b')->addText('Název: '));
            $popupName->addHtml(Html::el('span')->addText($stand->getName()));
            $popupEditLink = Html::el('a', ['class' => 'btn btn-sm bg-gradient-primary mb-0 mt-2', 'href' => $this->linkGenerator->link('Admin:Stand:edit', ['id' => $stand->getId()->toString()])])->setText('Upravit');

            $map->addMarker($stand->getLocation(), $stand->getName(), 'stand')
            ->setPopup(Html::el('div', ['class' => 'text-center'])->addHtml($popupName)->addHtml(Html::el('br'))->addHtml($popupEditLink));
        }
        return $map;
    }
}
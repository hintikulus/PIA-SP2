<?php

namespace App\UI\Components\Admin\Stand;

use App\Domain\Location\Location;
use App\Domain\Stand\StandFacade;
use App\Model\Utils\Html;
use App\UI\Components\Base\BaseComponent;
use App\UI\Map\BaseMap;
use Contributte\Translation\Translator;
use Nette\Application\LinkGenerator;

class StandListMap extends BaseComponent
{
    private StandFacade $standFacade;
    private LinkGenerator $linkGenerator;
    private Translator $translator;

    public function __construct(
        StandFacade $standFacade,
        LinkGenerator $linkGenerator,
        Translator $translator,
    )
    {
        $this->standFacade = $standFacade;
        $this->linkGenerator = $linkGenerator;
        $this->translator = $translator;
    }

    public function render(mixed $params = null): void
    {
        $this->template->stands = $this->standFacade->getAll();
        parent::render($params);
    }

    public function createComponentMap(): BaseMap
    {
        $translator = $this->translator->createPrefixedTranslator('admin.standListMap');
        $map = new BaseMap();

        foreach ($this->standFacade->getAll() as $stand)
        {
            $popupName = Html::el('span');
            $popupName->addHtml(Html::el('b')->addText($translator->translate('popup_name')));
            $popupName->addHtml(Html::el('span')->addText($stand->getName()));
            $popupEditLink = Html::el('a', ['class' => 'btn btn-sm bg-gradient-primary mb-0 mt-2', 'href' => $this->linkGenerator->link('Admin:Stand:edit', ['id' => $stand->getId()->toString()])])->setText($translator->translate('popup_action_edit'));

            $map->addMarker($stand->getLocation(), $stand->getName(), 'stand')
            ->setPopup(Html::el('div', ['class' => 'text-center'])->addHtml($popupName)->addHtml(Html::el('br'))->addHtml($popupEditLink));
        }
        return $map;
    }
}
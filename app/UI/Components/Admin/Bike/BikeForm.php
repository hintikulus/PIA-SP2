<?php

namespace App\UI\Components\Admin\Bike;

use App\Domain\Bike\Bike;
use App\Domain\Bike\BikeFacade;
use App\Model\App;
use App\UI\Components\Base\BaseComponent;
use App\UI\Form\BaseForm;
use Contributte\Translation\Translator;
use Nette\Utils\ArrayHash;

class BikeForm extends BaseComponent
{
    private BikeFacade $bikeFacade;
    private Translator $translator;
    private ?Bike $bike = null;
    private ?string $cancelUrl = null;

    public function __construct(
        BikeFacade $bikeFacade,
        Translator $translator,
        ?Bike      $bike = null,
        ?string    $cancelUrl = null,
    )
    {
        $this->bikeFacade = $bikeFacade;
        $this->translator = $translator;
        $this->bike = $bike;
        $this->cancelUrl = $cancelUrl;
    }

    public function render(mixed $params = null): void
    {
        if ($this->bike)
        {
            $this['form']->setDefaults([
                'stand_id'              => $this->bike->getStand()?->getId()?->toString(),
                'stand_title'           => $this->bike->getStand()?->getName(),
                'last_service_datetime' => $this->bike->getLastServiceTimestamp()->format(App::DATETIME_PICKER_FORMAT),
            ]);
        }

        parent::render($params); // TODO: Change the autogenerated stub
    }

    public function createComponentForm(): BaseForm
    {
        $translator = $this->translator->createPrefixedTranslator('admin.bikeForm');
        $form = new BaseForm();

        $standTitleText = $form->addText('stand_title', $translator->translate('input_stand_title'))
            ->setHtmlAttribute('readonly')
        ;

        $standIdText = $form->addText('stand_id', $translator->translate('input_stand_id'));

        if ($this->bike === null)
        {
            $standIdText->setRequired();
            $standTitleText->setRequired();
        }

        if ($this->bike)
        {
            $form->addDatetime('last_service_datetime', $translator->translate('input_last_service_datetime'));
        }

        $form->addSubmit('send');

        $form->onSuccess[] = [$this, 'formSucceeded'];

        return $form;
    }

    public function formSucceeded(BaseForm $form, ArrayHash $values)
    {
        $transformedValues = $this->transformValues($values);
        bdump($transformedValues);
        try
        {
            $this->bikeFacade->save($this->bike, $transformedValues['stand_id'], $transformedValues['last_service_datetime'] ?? null);
            $this->flashSuccess('Kolo úspěšně uloženo.');
        }
        catch (\Exception $e)
        {
            $this->flashError('Při ukládání se vyskytla chyba.');
        }
    }

    private function transformValues(ArrayHash $values): array
    {
        $transformedValues = [
            'stand_id'              => $values['stand_id'] ? : null,
            'last_service_datetime' => isset($values['last_service_datetime']) ? new \DateTime($values['last_service_datetime']) : null,
        ];

        return $transformedValues;
    }

}
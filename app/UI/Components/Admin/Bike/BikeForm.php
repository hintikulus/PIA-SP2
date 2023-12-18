<?php

namespace App\UI\Components\Admin\Bike;

use App\Domain\Bike\Bike;
use App\Domain\Bike\BikeService;
use App\Model\App;
use App\UI\Components\Base\BaseComponent;
use App\UI\Form\BaseForm;
use Contributte\Translation\Translator;
use Nette\Utils\ArrayHash;

class BikeForm extends BaseComponent
{
    private BikeService $bikeService;
    private Translator $translator;
    private ?Bike $bike = null;
    private ?string $cancelUrl = null;

    public function __construct(
        BikeService $bikeService,
        Translator  $translator,
        ?Bike       $bike = null,
        ?string     $cancelUrl = null,
    )
    {
        $this->bikeService = $bikeService;
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
            $standIdText->setRequired($this->translator->translate('base.form.required'));
            $standTitleText->setRequired($this->translator->translate('base.form.required'));
        }

        if ($this->bike)
        {
            $form->addDatetime('last_service_datetime', $translator->translate('input_last_service_datetime'))
                ->setRequired($this->translator->translate('base.form.required'))
            ;
        }

        $form->addSubmit('send');

        $form->onSuccess[] = [$this, 'formSucceeded'];

        return $form;
    }

    public function formSucceeded(BaseForm $form, ArrayHash $values)
    {
        $transformedValues = $this->transformValues($values);
        try
        {
            if ($this->bike)
            {
                $this->bikeService->updateBike(
                    $this->bike,
                    $transformedValues['stand_id'],
                    $transformedValues['last_service_datetime'] ?? null
                );
            }
            else
            {
                $this->bikeService->createBike($transformedValues['stand_id']);
            }

            $this->flashSuccess($this->translator->translate('admin.bikeForm.flash_success'));
        }
        catch (\Exception $e)
        {
            $this->flashError($this->translator->translate('admin.bikeForm.flash_error'));
        }
    }

    private function transformValues(ArrayHash $values): array
    {
        $transformedValues = [
            'stand_id'              => $values['stand_id'] ? : null,
            'last_service_datetime' => isset($values['last_service_datetime']) ? new \DateTime($values['last_service_datetime']->format(App::DATETIME_PICKER_FORMAT)) : null,
        ];

        return $transformedValues;
    }

}

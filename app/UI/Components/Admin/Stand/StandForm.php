<?php

namespace App\UI\Components\Admin\Stand;

use App\Domain\Location\Location;
use App\Domain\Stand\Stand;
use App\Domain\Stand\StandService;
use App\UI\Components\Base\BaseComponent;
use App\UI\Form\BaseForm;
use Contributte\Translation\Translator;
use Nette\Utils\ArrayHash;

class StandForm extends BaseComponent
{
    private StandService $standService;
    private Translator $translator;
    private ?string $cancelUrl;
    private ?Stand $stand;

    public function __construct(
        StandService $standService,
        Translator   $translator,
        ?Stand       $stand,
        string       $cancelUrl = null,
    )
    {
        $this->standService = $standService;
        $this->translator = $translator;
        $this->stand = $stand;
        $this->cancelUrl = $cancelUrl;
    }

    public function render(mixed $params = null): void
    {
        if ($this->stand)
        {
            $this['form']->setDefaults([
                'name'      => $this->stand->getName(),
                'latitude'  => $this->stand->getLocation()->getLatitude(),
                'longitude' => $this->stand->getLocation()->getLongitude(),
            ]);
        }

        parent::render($params);
    }

    public function createComponentForm(): BaseForm
    {
        $translator = $this->translator->createPrefixedTranslator('admin.standForm');
        $form = new BaseForm();

        $form->addText('name', $translator->translate('input_name'))
            ->setRequired($this->translator->translate('base.form.required'))
        ;
        $form->addFloat('latitude', $translator->translate('input_latitude'))
            ->setRequired($this->translator->translate('base.form.required'))
        ;
        $form->addFloat('longitude', $translator->translate('input_longitude'))
            ->setRequired($this->translator->translate('base.form.required'))
        ;

        $form->addSubmit('send', $translator->translate('input_send'));

        if ($this->cancelUrl)
        {
            $form->addCancelButton($this->cancelUrl);
        }

        $form->onSuccess[] = [$this, 'formSucceeded'];

        return $form;
    }

    public function formSucceeded(BaseForm $form, ArrayHash $values): void
    {
        try
        {
            if ($this->stand)
            {
                $this->standService->updateStand($this->stand, $values['name'], new Location($values['latitude'], $values['longitude']));
            }
            else
            {
                $this->standService->createStand($values['name'], new Location($values['latitude'], $values['longitude']));
            }

            $this->flashSuccess($this->translator->translate('admin.standForm.flash_success'));
        }
        catch (\Exception $e)
        {
            $this->flashError($this->translator->translate('admin.standForm.flash_error'));
        }
    }
}
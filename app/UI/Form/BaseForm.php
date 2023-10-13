<?php declare(strict_types = 1);

namespace App\UI\Form;

use App\Model\App;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\TextInput;

class BaseForm extends Form
{

    public function addFloat(string $name, ?string $label = null): TextInput
    {
        $input = self::addText($name, $label);
        $input->addCondition(self::FILLED)
            ->addRule(self::MAX_LENGTH, null, 255)
            ->addRule(self::FLOAT)
        ;

        return $input;
    }

    public function addNumeric(string $name, ?string $label = null): TextInput
    {
        $input = self::addText($name, $label);
        $input->addCondition(self::FILLED)
            ->addRule(self::MAX_LENGTH, null, 255)
            ->addRule(self::NUMERIC)
        ;

        return $input;
    }

    public function addCancelButton(string $href): HrefButton
    {
        return $this->addHrefButton('cancel', 'Zrušit', $href);
    }

    public function addHrefButton(string $name, string $caption, string $href): HrefButton
    {
        $input = new HrefButton($caption, $href);
        self::addComponent($input, $name);
        return $input;
    }

    public function addTextUrl(string $name, string $label = null, ?int $cols = null, ?int $maxLength = null): TextInput
    {
        $input = self::addText($name, $label, $cols, $maxLength);
        $input->addRule(self::URL, 'Text musí být odkaz!');
        return $input;
    }

    public function addDate(string $name, string $label = null, ?int $cols = null, ?int $maxLength = null): TextInput
    {
        $input = $this->addText($name, $label, $cols, $maxLength);
        $input->setHtmlType('date');
        //$input->setHtmlAttribute('max', App::DATE_PICKER_MAX_VALUE);
        return $input;
    }

    public function addDatetime(string $name, string $label = null, ?int $cols = null, ?int $maxLength = null): TextInput
    {
        $input = $this->addText($name, $label, $cols, $maxLength);
        $input->setHtmlType('datetime-local');
        $input->setHtmlAttribute('max', App::DATETIME_PICKER_MAX_VALUE);
        return $input;
    }

}

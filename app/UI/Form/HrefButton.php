<?php

namespace App\UI\Form;

use App\Model\Utils\Html;
use Nette\Forms\Controls\BaseControl;

class HrefButton extends BaseControl
{
    protected string $href = '#';
    protected string $class = 'btn btn-default';

    public function __construct(string $caption, string $href)
    {
        $this->caption = $caption;
        $this->href = $href;

        parent::__construct($caption);
    }

    public function getControl(): Html
    {
        $caption = is_string($this->caption) ? $this->caption : "";
        return Html::el('a', ['href' => $this->href, 'class' => $this->class])->setText($caption);
    }

    public function isOmitted(): bool
    {
        return true;
    }

    function getLabel($caption = null): ?string
    {
        return null;
    }

    public function setHref(string $href): void
    {
        $this->href = $href;
    }

    public function setClass(string $class): void
    {
        $this->class = $class;
    }

    public function addClass(string $class): void
    {
        $this->class .= ' ' . $class;
    }
}

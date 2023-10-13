<?php declare(strict_types = 1);

namespace App\UI\Control;

use App\Model\Utils\FlashMessage;
use App\Modules\Base\BasePresenter;
use stdClass;

/**
 * @mixin BasePresenter
 */
trait TFlashMessage
{

    /**
     * @param string $message
     * @param string $type
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
     * @internal
     */
    public function flashMessage($message, $type = 'info'): stdClass
    {
        $class = parent::flashMessage($message, $type);

        if ($this->isAjax())
        {
            $this->redrawControl('flashes');
        }

        return $class;
    }

    public function flashInfo(string $message): stdClass
    {
        return $this->flashMessage('Informace;' . $message, 'bg-info');
    }

    public function flashSuccess(string $message): stdClass
    {
        return $this->flashMessage('Úspěch;' . $message, 'bg-success');
    }

    public function flashWarning(string $message): stdClass
    {
        return $this->flashMessage('Varování;' . $message, 'bg-warning');
    }

    public function flashError(string $message): stdClass
    {
        return $this->flashMessage('Chyba;' . $message, 'bg-danger');
    }

    public function flash(FlashMessage $flashMessage): stdClass
    {
        return match ($flashMessage->getType())
        {
            FlashMessage::TYPE_SUCCESS => $this->flashSuccess($flashMessage->getMessage()),
            FlashMessage::TYPE_INFO    => $this->flashInfo($flashMessage->getMessage()),
            FlashMessage::TYPE_WARNING => $this->flashWarning($flashMessage->getMessage()),
            FlashMessage::TYPE_ERROR   => $this->flashError($flashMessage->getMessage()),
            default                    => $this->flashMessage($flashMessage->getMessage()),
        };
    }

}

<?php

namespace App\UI\Map;

use App\Domain\Location\Location;
use Nette\Application\InvalidPresenterException;
use Nette\Application\UI\Control;
use Nette\Application\UI\Presenter;
use Nette\Bridges\ApplicationLatte\Template;
use UnexpectedValueException;

class Map extends Control
{
    public const TILE_LAYER_URL_OPEN_STREET_MAP = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png";

    private array $markerTypes = [];
    private array $markers = [];
    private ?string $tileLayerUrl = self::TILE_LAYER_URL_OPEN_STREET_MAP;
    private array $zoomRange = ['min' => 0, 'max' => 19];
    private Location $viewLocation;
    private int $viewZoom;

    private ?string $componentFullName;
    private ?string $templateFile = null;

    public function __construct()
    {
        $this->monitor(
            Presenter::class,
            function(Presenter $presenter): void {
                $this->componentFullName = $this->lookupPath();
            }
        );
    }

    public function render(): void
    {
        if ($this->tileLayerUrl === null)
        {
            throw new UnexpectedValueException("Tile layer URL have to be specified");
        }

        $template = $this->getTemplate();

        if (!$template instanceof Template)
        {
            throw new \UnexpectedValueException;
        }

        $template->tileLayerUrl = $this->tileLayerUrl;
        $template->zoomRange = $this->zoomRange;
        $template->viewLocation = $this->viewLocation;
        $template->viewZoom = $this->viewZoom;
        $template->markerTypes = $this->markerTypes;
        $template->markers = $this->markers;

        $template->setFile($this->getTemplateFile());
        $template->render();
    }

    public function getFullName()
    {
        if ($this->componentFullName === null)
        {
            throw new InvalidPresenterException('Map have to be attached to presenter');
        }

        return $this->componentFullName;
    }

    /******************************************************************************
     *                                  TEMPLATING *
     ******************************************************************************/
    public function setTemplateFile(string $templateFile): self
    {
        $this->templateFile = $templateFile;
        return $this;
    }

    public function getTemplateFile(): string
    {
        return $this->templateFile ?? $this->getOriginalTemplateFile();
    }

    public function getOriginalTemplateFile(): string
    {
        return __DIR__ . '/templates/map.latte';
    }

    /******************************************************************************
     *                                  MARKER TYPES *
     ******************************************************************************/
    public function addMarkerType(string $name): MarkerType
    {
        if(isset($this->markerTypes[$name]))
        {
            throw new \Exception('Marker type with this name already exists');
        }

        $markerType = new MarkerType($name);
        $this->markerTypes[$name] = $markerType;
        return $markerType;
    }

    public function addMarker(Location $location, ?string $label, ?string $markerType = null, string $type = null): Marker
    {
        $marker = new Marker($location, $label, $markerType, $type);
        $this->markers[] = $marker;
        return $marker;
    }

    public function setTileLayerUrl(string $tileLayerUrl)
    {
        $this->tileLayerUrl = $tileLayerUrl;
    }

    public function getZoomRange(): array
    {
        return $this->zoomRange;
    }

    public function setZoomRange(int $min, int $max): void
    {
        $this->zoomRange['min'] = $min;
        $this->zoomRange['max'] = $max;
    }

    public function setView(Location $location, int $zoom)
    {
        $this->viewLocation = $location;
        $this->viewZoom = $zoom;
    }
}

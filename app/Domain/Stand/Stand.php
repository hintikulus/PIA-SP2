<?php

namespace App\Domain\Stand;

use App\Domain\Bike\Bike;
use App\Domain\Location\Location;
use App\Model\Database\Entity\AbstractEntity;
use App\Model\Database\Entity\TUuid;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Nette\Security\Resource;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Stand\StandRepository")
 * @ORM\Table(name="`stand`")
 * @ORM\HasLifecycleCallbacks
 */
class Stand extends AbstractEntity implements Resource
{
    public const RESOURCE_ID = 'Stand';
    use TUuid;

    /** @ORM\Column(type="string", length=255, nullable=FALSE, unique=false) */
    private string $name;

    /** @ORM\Column(type="location", nullable=FALSE, unique=false) */
    private Location $location;

    /**
     *  @var Collection<int, Bike>
     *  @ORM\OneToMany(targetEntity="App\Domain\Bike\Bike", mappedBy="stand")
     */
    private Collection $bikes;

    public function __construct(string $name, Location $location)
    {
        $this->name = $name;
        $this->location = $location;
    }

    /**
     * Gets the name of the stand.
     *
     * @return string The name of the stand.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the name of the stand.
     *
     * @param string $name The new name for the stand.
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Gets the location of the stand.
     *
     * @return Location The location of the stand.
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * Sets the location of the stand.
     *
     * @param Location $location The new location for the stand.
     */
    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    /**
     * Returns a string representation of the stand.
     *
     * @return string The string representation of the stand.
     */
    public function __toString()
    {
        return "Stand{id={$this->getId()}, name='{$this->getName()}', location={$this->location}}";
    }

    /**
     * Gets the resource ID associated with the stand.
     *
     * @return string The resource ID of the stand.
     */
    function getResourceId(): string
    {
        return self::RESOURCE_ID;
    }
}
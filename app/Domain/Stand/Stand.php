<?php

namespace App\Domain\Stand;

use App\Domain\Bike\Bike;
use App\Domain\Location\Location;
use App\Model\Database\Entity\AbstractEntity;
use App\Model\Database\Entity\TUuid;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Stand\StandRepository")
 * @ORM\Table(name="`stand`")
 * @ORM\HasLifecycleCallbacks
 */
class Stand extends AbstractEntity
{
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    public function __toString()
    {
        return "Stand{id={$this->getId()}, name='{$this->getName()}', location={$this->location}}";
    }
}
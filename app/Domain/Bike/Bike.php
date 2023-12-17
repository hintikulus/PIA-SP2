<?php

namespace App\Domain\Bike;

use App\Domain\Location\Location;
use App\Domain\Ride\Ride;
use App\Domain\Stand\Stand;
use App\Domain\User\User;
use App\Model\App;
use App\Model\Database\Entity\AbstractEntity;
use App\Model\Database\Entity\TUuid;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Bike\BikeRepository")
 * @ORM\Table(name="`bike`")
 * @ORM\HasLifecycleCallbacks
 */
class Bike extends AbstractEntity
{
    use TUuid;

    /** @ORM\Column(type="location", nullable=FALSE, unique=false) */
    private Location $location;

    /** @ORM\Column(type="datetime", nullable=FALSE, unique=false) */
    private \DateTime $lastServiceTimestamp;

    /**
     * @var Stand|null
     * @ORM\ManyToOne(targetEntity="App\Domain\Stand\Stand", inversedBy="bikes")
     * @ORM\JoinColumn(name="stand_id", referencedColumnName="id")
     */
    private ?Stand $stand;

    /**
     * @var Collection<int, Ride>
     * @ORM\OneToMany(targetEntity="App\Domain\Ride\Ride", mappedBy="bike")
     */
    private Collection $rides;

    public function __construct(Location|Stand $location)
    {
        if ($location instanceof Stand)
        {
            $this->location = $location->getLocation();
            $this->stand = $location;
        }
        else
        {
            $this->location = $location;
        }

        $this->lastServiceTimestamp = new \DateTime();
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    public function getLastServiceTimestamp(): \DateTime
    {
        return $this->lastServiceTimestamp;
    }

    public function setLastServiceTimestamp(\DateTime $dateTime): void
    {
        $this->lastServiceTimestamp = $dateTime;
    }

    public function updateLastServiceTimestamp(): void
    {
        $this->lastServiceTimestamp = new \DateTime();
    }

    public function getStand(): ?Stand
    {
        return $this->stand;
    }

    public function setStand(?Stand $stand): void
    {
        $this->stand = $stand;
    }

    public function isInStand(): bool
    {
        return $this->stand !== null;
    }

    public function getNextServiceDatetime(): \DateTime
    {
        return (clone $this->lastServiceTimestamp)->modify('+ 6 months');
    }

    public function isDueForService(): bool
    {
        $now = new \DateTime();
        $nextService = $this->getNextServiceDatetime();
        return $now > $nextService;
    }

    public function startRide(User $user): Ride
    {
        if (!$this->isInStand())
        {
            throw new \Exception('Bike is in ride');
        }

        if ($this->isDueForService())
        {
            throw new \Exception('Bike is due for service');
        }

        $ride = new Ride($user, $this, $this->stand);
        $this->setStand(null);
        return $ride;
    }

    public function __toString(): string
    {
        return "Bike{id={$this->id}, location={$this->location}, lastServiceTimestamp={$this->lastServiceTimestamp->format(App::DATETIME_SECONDS_FORMAT)}, stand={$this->stand}}";
    }
}

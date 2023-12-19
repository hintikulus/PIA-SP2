<?php

namespace App\Domain\Bike;

use App\Domain\Location\Location;
use App\Domain\Ride\Ride;
use App\Domain\Stand\Stand;
use App\Domain\User\User;
use App\Model\App;
use App\Model\Database\Entity\AbstractEntity;
use App\Model\Database\Entity\TUuid;
use App\Model\Exception\Logic\BikeNotRideableException;
use App\Model\Utils\DateTime;
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

    public function getNextServiceDatetime(\DateInterval $dateInterval): \DateTime
    {

        return (clone $this->lastServiceTimestamp)->add($dateInterval);
    }

    public function isDueForService(\DateInterval $dateInteval): bool
    {
        $now = new \DateTime();
        $nextService = $this->getNextServiceDatetime($dateInteval);
        return $now > $nextService;
    }

    public function startRide(User $user, \DateInterval $serviceDateInterval): Ride
    {
        if (!$this->isInStand() || $this->isDueForService($serviceDateInterval))
        {
            throw new BikeNotRideableException($this);
        }

        $ride = new Ride($user, $this, $this->stand);
        $this->setStand(null);
        return $ride;
    }

    public function __toString(): string
    {
        return "Bike{" . (!isset($this->id) ?: "id={$this->id}, ");
    }
}

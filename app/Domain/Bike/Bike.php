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
use Nette\Security\Resource;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Bike\BikeRepository")
 * @ORM\Table(name="`bike`")
 * @ORM\HasLifecycleCallbacks
 */
class Bike extends AbstractEntity implements Resource
{
    public const RESOURCE_ID = 'Bike';
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

    /**
     * Gets the current location of the bike.
     *
     * @return Location The location of the bike.
     */
    public function getLocation(): Location
    {
        return $this->location;
    }
    /**
     * Sets the location of the bike.
     *
     * @param Location $location The new location of the bike.
     */
    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    /**
     * Gets the timestamp of the last service for the bike.
     *
     * @return \DateTime The timestamp of the last service.
     */
    public function getLastServiceTimestamp(): \DateTime
    {
        return $this->lastServiceTimestamp;
    }

    /**
     * Sets the timestamp of the last service for the bike.
     *
     * @param \DateTime $dateTime The new timestamp of the last service.
     */
    public function setLastServiceTimestamp(\DateTime $dateTime): void
    {
        $this->lastServiceTimestamp = $dateTime;
    }

    /**
     * Updates the timestamp of the last service to the current datetime.
     */
    public function updateLastServiceTimestamp(): void
    {
        $this->lastServiceTimestamp = new \DateTime();
    }

    /**
     * Gets the stand where the bike is currently located.
     *
     * @return Stand|null The stand where the bike is located, or null if the bike is not in any stand.
     */
    public function getStand(): ?Stand
    {
        return $this->stand;
    }

    /**
     * Sets the stand where the bike is currently located.
     *
     * @param Stand|null $stand The stand where the bike is located, or null if the bike is not in any stand.
     */
    public function setStand(?Stand $stand): void
    {
        $this->stand = $stand;
    }

    /**
     * Checks if the bike is currently in a stand.
     *
     * @return bool True if the bike is in a stand, false otherwise.
     */
    public function isInStand(): bool
    {
        return $this->stand !== null;
    }

    /**
     * Calculates the datetime when the next service is due based on the provided date interval.
     *
     * @param \DateInterval $dateInterval The interval between services.
     * @return \DateTime The datetime when the next service is due.
     */
    public function getNextServiceDatetime(\DateInterval $dateInterval): \DateTime
    {
        return (clone $this->lastServiceTimestamp)->add($dateInterval);
    }

    /**
     * Checks if the bike is due for service based on the provided date interval.
     *
     * @param \DateInterval $dateInteval The interval between services.
     * @return bool True if the bike is due for service, false otherwise.
     */
    public function isDueForService(\DateInterval $dateInterval): bool
    {
        $now = new \DateTime();
        $nextService = $this->getNextServiceDatetime($dateInterval);
        return $now > $nextService;
    }

    /**
     * Starts a new ride for the specified user and service date interval.
     *
     * @param User $user The user starting the ride.
     * @param \DateInterval $serviceDateInterval The interval between services.
     * @return Ride The newly started ride entity.
     * @throws BikeNotRideableException When the bike is not in a stand or is due for service.
     */
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

    /**
     * Returns a string representation of the bike.
     *
     * @return string The string representation of the bike.
     */
    public function __toString(): string
    {
        return "Bike{" . (!isset($this->id) ? : "id={$this->id}, ");
    }

    /**
     * Gets the resource ID for the bike.
     *
     * @return string The resource ID.
     */
    function getResourceId(): string
    {
        return self::RESOURCE_ID;
    }
}

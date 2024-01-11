<?php

namespace App\Domain\Ride;

use App\Domain\Bike\Bike;
use App\Domain\Stand\Stand;
use App\Domain\User\User;
use App\Model\Database\Entity\AbstractEntity;
use App\Model\Database\Entity\TUuid;

use Doctrine\ORM\Mapping as ORM;
use Nette\Security\Resource;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Ride\RideRepository")
 * @ORM\Table(name="`ride`")
 * @ORM\HasLifecycleCallbacks
 */
class Ride extends AbstractEntity implements Resource
{
    public const RESOURCE_ID = 'Ride';
    public const STATE_STARTED = 1;
    public const STATE_COMPLETED = 2;

    public const STATES = [
        self::STATE_STARTED => 'started',
        self::STATE_COMPLETED => 'completed',
    ];

    use TUuid;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Domain\User\User", inversedBy="rides")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private User $user;

    /**
     * @var Bike
     * @ORM\ManyToOne(targetEntity="App\Domain\Bike\Bike", inversedBy="rides")
     * @ORM\JoinColumn(name="bike_id", referencedColumnName="id")
     */
    private Bike $bike;

    /**
     * @var int
     * @ORM\Column(name="state", type="integer", nullable=false, unique=false)
     */
    private int $state;

    /**
     * @var \DateTime
     * @ORM\Column(name="start_timestamp", type="datetime", nullable=false, unique=false)
     */
    private \DateTime $startTimestamp;

    /**
     * @var Stand
     * @ORM\ManyToOne(targetEntity="App\Domain\Stand\Stand")
     * @ORM\JoinColumn(name="start_stand_id", referencedColumnName="id")
     */
    private Stand $startStand;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="end_timestamp", type="datetime", nullable=true, unique=false)
     */
    private ?\DateTime $endTimestamp;

    /**
     * @var Stand|null
     * @ORM\ManyToOne(targetEntity="App\Domain\Stand\Stand")
     * @ORM\JoinColumn(name="end_stand_id", referencedColumnName="id")
     */
    private ?Stand $endStand = null;

    public function __construct(User $user, Bike $bike, Stand $startStand)
    {
        $this->user = $user;
        $this->bike = $bike;
        $this->startStand = $startStand;
        $this->startTimestamp = new \DateTime();
        $this->state = self::STATE_STARTED;
    }

    /**
     * Gets the associated user for this ride.
     *
     * @return User The user associated with this ride.
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Gets the associated bike for this ride.
     *
     * @return Bike The bike associated with this ride.
     */
    public function getBike(): Bike
    {
        return $this->bike;
    }

    /**
     * Gets the state of this ride.
     *
     * @return int The state of the ride.
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * Gets the stand where the ride started.
     *
     * @return Stand The stand where the ride started.
     */
    public function getStartStand(): Stand
    {
        return $this->startStand;
    }

    /**
     * Gets the timestamp when the ride started.
     *
     * @return \DateTime The timestamp when the ride started.
     */
    public function getStartTimestamp(): \DateTime
    {
        return $this->startTimestamp;
    }

    /**
     * Gets the stand where the ride ended, or null if the ride is not completed.
     *
     * @return Stand|null The stand where the ride ended, or null if the ride is not completed.
     */
    public function getEndStand(): ?Stand
    {
        return $this->endStand;
    }

    /**
     * Gets the timestamp when the ride ended, or null if the ride is not completed.
     *
     * @return \DateTime|null The timestamp when the ride ended, or null if the ride is not completed.
     */
    public function getEndTimestamp(): ?\DateTime
    {
        return $this->endTimestamp;
    }

    /**
     * Completes the ride by updating its state, end timestamp, end stand, and the associated bike's stand.
     *
     * @param Stand $endStand The stand where the ride ends.
     */
    public function complete(Stand $endStand): void
    {
        $this->state = self::STATE_COMPLETED;
        $this->endTimestamp = new \DateTime();
        $this->endStand = $endStand;
        $this->bike->setStand($endStand);
    }

    /**
     * Checks if the ride has started.
     *
     * @return bool True if the ride has started, false otherwise.
     */
    public function isStarted(): bool
    {
        return $this->state === self::STATE_STARTED;
    }

    /**
     * Checks if the ride is completed.
     *
     * @return bool True if the ride is completed, false otherwise.
     */
    public function isCompleted(): bool
    {
        return $this->state === self::STATE_COMPLETED;
    }

    /**
     * Returns a string representation of the ride.
     *
     * @return string The string representation of the ride.
     */
    public function __toString(): string
    {
        return "Ride{id=$this->id}";
    }

    /**
     * Gets the resource ID associated with the ride.
     *
     * @return string The resource ID of the ride.
     */
    function getResourceId(): string
    {
        return self::RESOURCE_ID;
    }
}

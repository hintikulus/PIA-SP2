<?php

namespace App\Domain\Ride;

use App\Domain\Bike\Bike;
use App\Domain\Stand\Stand;
use App\Domain\User\User;
use App\Model\Database\Entity\AbstractEntity;
use App\Model\Database\Entity\TUuid;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Ride\RideRepository")
 * @ORM\Table(name="`ride`")
 * @ORM\HasLifecycleCallbacks
 */
class Ride extends AbstractEntity
{
    public const STATE_STARTED = 1;
    public const STATE_COMPLETED = 2;

    public const STATES = [
        self::STATE_STARTED => self::STATE_STARTED,
        self::STATE_COMPLETED => self::STATE_COMPLETED,
    ];

    use TUuid;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Domain\User\User", inversedBy="rides")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private User $user;

    /**
     * @var User
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

    public function getUser(): User
    {
        return $this->user;
    }

    public function getBike(): Bike
    {
        return $this->bike;
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function getStartStand(): Stand
    {
        return $this->startStand;
    }

    public function getStartTimestamp(): \DateTime
    {
        return $this->startTimestamp;
    }

    public function getEndStand(): ?Stand
    {
        return $this->endStand;
    }

    public function getEndTimestamp(): ?\DateTime
    {
        return $this->endTimestamp;
    }

    public function complete(Stand $endStand): void
    {
        $this->state = self::STATE_COMPLETED;
        $this->endTimestamp = new \DateTime();
        $this->endStand = $endStand;
    }

    public function isStarted(): bool
    {
        return $this->state === self::STATE_STARTED;
    }

    public function isCompleted(): bool
    {
        return $this->state = self::STATE_COMPLETED;
    }
}

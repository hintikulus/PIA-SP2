<?php declare(strict_types = 1);

namespace App\Domain\User;

use App\Domain\Ride\Ride;
use App\Model\Database\Entity\AbstractEntity;
use App\Model\Database\Entity\TCreatedAt;
use App\Model\Database\Entity\TId;
use App\Model\Database\Entity\TUuid;
use App\Model\Database\Entity\TUpdatedAt;
use App\Model\Exception\Logic\InvalidArgumentException;
use App\Model\Security\Identity;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Domain\User\UserRepository")
 * @ORM\Table(name="`user`")
 * @ORM\HasLifecycleCallbacks
 */
class User extends AbstractEntity
{
    public const ROLE_REGULAR = 'regular';
    public const ROLE_SERVICEMAN = 'serviceman';
    public const ROLE_ADMIN = 'admin';
    public const ROLES = [
        self::ROLE_REGULAR    => self::ROLE_REGULAR,
        self::ROLE_SERVICEMAN => self::ROLE_SERVICEMAN,
        self::ROLE_ADMIN      => self::ROLE_ADMIN,
    ];

    use TUuid;

    /** @ORM\Column(type="string", length=255, nullable=FALSE, unique=false) */
    private string $name;

    /** @ORM\Column(type="string", length=255, nullable=FALSE, unique=false) */
    private string $emailAddress;

    /** @ORM\Column(type="string", length=255, nullable=TRUE, unique=false) */
    private ?string $passwordHash;

    /** @ORM\Column(type="string", length=45, nullable=FALSE, unique=false) */
    private string $role = self::ROLE_REGULAR;

    /** @ORM\Column(type="datetime", nullable=TRUE, unique=false) */
    private ?DateTime $lastLogin;

    /** @ORM\Column(type="string", nullable=TRUE, unique=true) */
    private ?string $googleId;

    /**
     * @var Collection<int, Ride>
     * @ORM\OneToMany(targetEntity="App\Domain\Ride\Ride", mappedBy="user")
     */
    private Collection $rides;

    public function __construct(string $name, string $emailAddress)
    {
        $this->name = $name;
        $this->emailAddress = $emailAddress;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string $email): void
    {
        $this->emailAddress = $email;
    }

    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $password): void
    {
        $this->passwordHash = $password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        if (!isset(self::ROLES[$role]))
        {
            throw new InvalidArgumentException();
        }

        $this->role = $role;
    }

    public function getLastLogin(): ?DateTime
    {
        return $this->lastLogin;
    }

    public function updateLastLogin(): void
    {
        $this->lastLogin = new DateTime();
    }

    public function getGravatar(): string
    {
        return 'https://www.gravatar.com/avatar/' . md5($this->emailAddress);
    }

    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

    public function setGoogleId(?string $googleId): void
    {
        $this->googleId = $googleId;
    }

    public function toIdentity(): Identity
    {
        return new Identity($this->getId()->toString(), [$this->getRole()], [
            'email'    => $this->emailAddress,
            'name'     => $this->name,
            'gravatar' => $this->getGravatar(),
        ]);
    }

    public function __toString(): string
    {
        return "User{id={$this->id}, name='{$this->name}', emailAddress='{$this->emailAddress}', role={$this->role}}";
    }

}

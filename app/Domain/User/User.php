<?php declare(strict_types = 1);

namespace App\Domain\User;

use App\Model\Database\Entity\AbstractEntity;
use App\Model\Database\Entity\TCreatedAt;
use App\Model\Database\Entity\TId;
use App\Model\Database\Entity\TUuid;
use App\Model\Database\Entity\TUpdatedAt;
use App\Model\Exception\Logic\InvalidArgumentException;
use App\Model\Security\Identity;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Domain\User\UserRepository")
 * @ORM\Table(name="`user`")
 * @ORM\HasLifecycleCallbacks
 */
class User extends AbstractEntity
{
    use TUuid;

    /** @ORM\Column(type="string", length=255, nullable=FALSE, unique=false) */
    private string $name;

    /** @ORM\Column(type="string", length=255, nullable=FALSE, unique=false) */
    private string $emailAddress;

    /** @var @ORM\Column(type="string", length=255, nullable=FALSE, unique=false) */
    private string $passwordHash;

    public function __construct(string $name, string $emailAddress, string $passwordHash)
    {
        $this->name = $name;
        $this->emailAddress = $emailAddress;
        $this->passwordHash = $passwordHash;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

	public function getGravatar(): string
	{
		return 'https://www.gravatar.com/avatar/' . md5($this->emailAddress);
	}

	public function toIdentity(): Identity
	{
		return new Identity($this->getId()->toString(), [], [
			'email' => $this->emailAddress,
			'name' => $this->name,
			'gravatar' => $this->getGravatar(),
		]);
	}

}

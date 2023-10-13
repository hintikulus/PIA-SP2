<?php

namespace App\Model\Database\Entity;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidV7Generator;

trait TUuid
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid_binary", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidV7Generator")
     */
    private UuidInterface $id;

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}

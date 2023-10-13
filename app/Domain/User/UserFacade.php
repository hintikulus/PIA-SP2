<?php

namespace App\Domain\User;

use App\Model\Database\EntityManagerDecorator;
use App\Model\Security\Passwords;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Mockery\Generator\StringManipulation\Pass\Pass;

class UserFacade
{
    private EntityManagerDecorator $em;
    private Passwords $passwords;

    public function __construct(
        EntityManagerDecorator $em,
        Passwords $passwords,
    )
    {
        $this->em = $em;
        $this->passwords = $passwords;
    }

    public function createUserFromArray(array $data)
    {
        $user = new User($data['name'], $data['email'], $data['password']);

        $this->em->persist($user);
        $this->em->flush();
    }

    public function getAllQueryBuilder(): QueryBuilder
    {
        return $this->em
            ->getUserRepository()
            ->getAllQueryBuilder();

    }

    public function getAll(): array
    {
        return $this->em->getUserRepository()->findAll();
    }
}
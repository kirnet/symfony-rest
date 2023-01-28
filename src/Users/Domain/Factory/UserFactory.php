<?php

declare(strict_types=1);

namespace App\Users\Domain\Factory;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Service\UserPasswordHasherInterface;

class UserFactory
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function create(
        string $email,
        array $roles,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $phone = null,
        ?string $password = null,
    ): User
    {
        $user = new User(
            $email,
            $roles,
            $firstName,
            $lastName,
            $phone
        );
        $user->setPassword($password, $this->passwordHasher);

        return $user;
    }
}

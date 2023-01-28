<?php

declare(strict_types=1);

namespace App\Users\Application\DTO;

use App\Users\Domain\Entity\User;

readonly class UserDTO
{
    public function __construct(
        public int $id,
        public string $email,
        public array $roles,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $phone = null
    ) {
    }

    public static function fromEntity(User $user): self
    {
        return new self(
            $user->getId(),
            $user->getEmail(),
            $user->getRoles(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getPhone()
        );
    }

}

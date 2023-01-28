<?php

declare(strict_types=1);

namespace App\Users\Application\Command\CreateUser;

use App\Shared\Application\Command\CommandInterface;
use App\Users\Infrastructure\Validator\UniqueUserField\Constraint\UniqueUserField;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateUserCommand implements CommandInterface
{
    public function __construct(
        #[Assert\Email]
        #[UniqueUserField(field: 'email')]
        public string $email,
        #[Assert\NotNull]
        public array $roles,
        #[Assert\Length(min:2, max: 100)]
        public ?string $firstName = null,
        #[Assert\Length(min:2, max: 100)]
        public ?string $lastName = null,
        #[Assert\Length(min: 7, max: 15, minMessage: 'Phone is too short', maxMessage: 'Phone is too long')]
        #[Assert\Regex(pattern: '/^[+]{1}\S+/', message: 'Phone not valid')]
        public ?string $phone = null,
        public ?string $password = null
    )
    {

    }
}

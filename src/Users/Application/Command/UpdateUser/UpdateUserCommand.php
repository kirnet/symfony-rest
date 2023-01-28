<?php

declare(strict_types=1);

namespace App\Users\Application\Command\UpdateUser;

use App\Shared\Application\Command\CommandInterface;

class UpdateUserCommand implements CommandInterface
{
    public function __construct(
        public int $id,
        public ?string $firstName = null,
        public ?string $lastName  = null,
        public ?string $phone  = null,
        public ?string $password = null
    )
    {
    }
}

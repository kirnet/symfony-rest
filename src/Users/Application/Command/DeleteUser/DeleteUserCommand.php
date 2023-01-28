<?php

declare(strict_types=1);

namespace App\Users\Application\Command\DeleteUser;

use App\Shared\Application\Command\CommandInterface;

readonly class DeleteUserCommand implements CommandInterface
{
    public function __construct(
        public int $id,
    )
    {
    }
}

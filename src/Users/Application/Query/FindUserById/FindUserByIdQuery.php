<?php

declare(strict_types=1);

namespace App\Users\Application\Query\FindUserById;

use App\Shared\Application\Query\QueryInterface;

class FindUserByIdQuery implements QueryInterface
{
    public function __construct(public readonly int $id)
    {
    }
}

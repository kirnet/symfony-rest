<?php

declare(strict_types=1);

namespace App\Users\Domain\Repository;

use App\Users\Domain\Entity\User;

interface UserFlusherInterface
{
    public function flush(User $user): void;
}
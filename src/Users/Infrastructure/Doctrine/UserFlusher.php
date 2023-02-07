<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Doctrine;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Repository\UserFlusherInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserFlusher implements UserFlusherInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function flush(?User $user = null): void
    {
        $this->em->flush();
    }
}
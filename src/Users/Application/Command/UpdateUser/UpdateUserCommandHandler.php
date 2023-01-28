<?php

declare(strict_types=1);

namespace App\Users\Application\Command\UpdateUser;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Domain\Repository\UserFlusherInterface;
use App\Users\Domain\Repository\UserRepositoryInterface;
use App\Users\Domain\Service\UserPasswordHasherInterface;

readonly class UpdateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserFlusherInterface $flusher,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function __invoke(UpdateUserCommand $updateUserCommand): void
    {
        $user = $this->userRepository->findById($updateUserCommand->id);

        if (!$user) {
            throw new \Exception('User not found');
        }

        $user->setFirstName($updateUserCommand->firstName);
        $user->setLastName($updateUserCommand->lastName);
        $user->setPhone($updateUserCommand->phone);
        if (!is_null($updateUserCommand->password)) {
            $user->setPassword($updateUserCommand->password, $this->passwordHasher);
        }
        $this->flusher->flush($user);
    }
}

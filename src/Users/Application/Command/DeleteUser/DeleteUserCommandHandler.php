<?php

declare(strict_types=1);

namespace App\Users\Application\Command\DeleteUser;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Domain\Repository\UserFlusherInterface;
use App\Users\Domain\Repository\UserRepositoryInterface;

readonly class DeleteUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
//        private UserFlusherInterface $flusher,
    ) {
    }

    public function __invoke(DeleteUserCommand $deleteUserCommand): void
    {
        $user = $this->userRepository->findById($deleteUserCommand->id);
        if (!$user) {
            throw new \Exception('User not found');
        }
        $this->userRepository->delete($user);

        //$this->flusher->flush($user);
    }
}

<?php

declare(strict_types=1);

namespace App\Users\Application\Command\CreateUser;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserFlusherInterface;
use App\Users\Infrastructure\Repository\UserRepository;

readonly class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserFactory $userFactory,
        private UserRepository $userRepository,
        private UserFlusherInterface $flusher
    ) {
    }

    /**
     * @return int UserId
     */
    public function __invoke(CreateUserCommand $createUserCommand): int
    {
        $user = $this->userFactory->create(
            $createUserCommand->email,
            $createUserCommand->roles,
            $createUserCommand->firstName,
            $createUserCommand->lastName,
            $createUserCommand->phone,
            $createUserCommand->password
        );

        $this->userRepository->add($user);
        $this->flusher->flush();

        return $user->getId();
    }
}

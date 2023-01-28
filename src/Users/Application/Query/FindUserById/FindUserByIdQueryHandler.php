<?php

declare(strict_types=1);

namespace App\Users\Application\Query\FindUserById;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Users\Application\DTO\UserDTO;
use App\Users\Domain\Repository\UserRepositoryInterface;

class FindUserByIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(FindUserByIdQuery $query): UserDTO
    {
        $user = $this->userRepository->findById($query->id);

        if (!$user) {
            throw new \Exception('User not found');
        }

        return UserDTO::fromEntity($user);
    }
}

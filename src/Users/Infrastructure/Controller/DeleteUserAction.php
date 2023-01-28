<?php
declare(strict_types=1);


namespace App\Users\Infrastructure\Controller;


use App\Users\Application\Command\DeleteUser\DeleteUserCommand;
use App\Users\Application\Command\DeleteUser\DeleteUserCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/api/users/{id}', methods: 'DELETE')]
class DeleteUserAction
{
    public function __invoke(
        int $id,
        DeleteUserCommandHandler $handler,
        Request $request
    ): JsonResponse {
        $command = new DeleteUserCommand($id);
        $handler($command);

        return new JsonResponse([

        ]);
    }
}
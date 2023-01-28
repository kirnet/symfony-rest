<?php
declare(strict_types=1);


namespace App\Users\Infrastructure\Controller;

use App\Users\Application\Command\UpdateUser\UpdateUserCommand;
use App\Users\Application\Command\UpdateUser\UpdateUserCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/users/{id}', methods: ['PUT'])]
class UpdateUserAction
{
    public function __invoke(
        int $id,
        SerializerInterface $serializer,
        UpdateUserCommandHandler $handler,
        Request $request
    ): JsonResponse
    {
        $command = $serializer->deserialize(
            $request->getContent(),
            UpdateUserCommand::class ,
            'json',
            ['object_to_populate' => new UpdateUserCommand($id)]
        );
        $handler($command);

        return new JsonResponse();
    }
}
<?php
declare(strict_types=1);


namespace App\Users\Infrastructure\Controller;

use App\Users\Application\Command\CreateUser\CreateUserCommand;
use App\Users\Application\Command\CreateUser\CreateUserCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/users', methods: ['POST'])]
class AddUserAction
{
    public function __construct(
        private readonly SerializerInterface $serializer
    )
    {
    }

    public function __invoke(
        CreateUserCommandHandler $handler,
        ValidatorInterface $validator,
        Request $request
    ): JsonResponse
    {
        /** @var CreateUserCommand $command */
        $command = $this->serializer->deserialize($request->getContent(), CreateUserCommand::class, 'json');
        $violations = $validator->validate($command);

        if ($violations->count() > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[] = $violation->getMessage();
            }
            return new JsonResponse(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $userId = $handler($command);

        return new JsonResponse([
            'id' => $userId
        ], Response::HTTP_CREATED);
    }
}
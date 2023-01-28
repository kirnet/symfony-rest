<?php

namespace App\Users\Infrastructure\Console;

use App\Users\Application\DTO\UserDTO;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserFlusherInterface;
use App\Users\Infrastructure\Repository\UserRepository;
use App\Users\Infrastructure\Roles;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Webmozart\Assert\Assert;

#[AsCommand(
    name: 'app:users:create-user',
    description: 'create user',
)]
final class CreateUser extends Command
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserFactory $userFactory,
        private readonly UserFlusherInterface $flusher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $rolesList = array_column(Roles::cases(), 'value');
        $io = new SymfonyStyle($input, $output);

        $email = $io->ask(
            'email',
            null,
            function (?string $input) {
                Assert::email($input, 'Email is invalid');

                return $input;
            }
        );

        $roles[] = $io->choice('role', $rolesList, Roles::ADMIN->value);

        $password = $io->askHidden(
            'password',
            function (?string $input) {
                Assert::notEmpty($input, 'Password cannot be empty');
                return $input;
            }
        );

        $user = $this->userFactory->create($email, $roles, null, null, null, $password);

        $this->userRepository->add($user);
        $this->flusher->flush();

        return Command::SUCCESS;
    }
}

<?php

namespace App\Tests\Functional\Users\Infrastructure\Repository;

use App\Tests\Resource\Fixture\Users\UserFixture;
use App\Tests\Tools\DITools;
use App\Tests\Tools\FakerTools;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Doctrine\UserFlusher;
use App\Users\Infrastructure\Repository\UserRepository;
use Faker\Generator;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase
{
    use FakerTools;
    use DITools;

    private UserRepository $repository;
    private Generator $faker;
    private AbstractDatabaseTool $databaseTool;
    private UserFactory $userFactory;
    private UserFlusher $userFlusher;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->getService(UserRepository::class);
        $this->userFactory = $this->getService(UserFactory::class);
        $this->userFlusher = $this->getService(UserFlusher::class);
        $this->faker = $this->getFaker();
        $this->databaseTool = $this->getService(DatabaseToolCollection::class)->get();
    }

    /**
     * Пользователь успешно доабвлен.
     */
    public function test_user_added_successfully(): void
    {
        $email = $this->faker->email();
        $password = $this->faker->password();
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $phone = $this->faker->phoneNumber();
        $user = $this->userFactory->create($email, ['ROLE_USER'], $firstName, $lastName, $phone, $password);

        // act
        $this->repository->add($user);
        $this->userFlusher->flush();

        // assert
        $existingUser = $this->repository->findById($user->getId());
        $this->assertEquals($user->getId(), $existingUser->getId());
    }

    public function test_user_found_successfully(): void
    {
        // arrange
        $executor = $this->databaseTool->loadFixtures([UserFixture::class]);
        /** @var User $user */
        $user = $executor->getReferenceRepository()->getReference(UserFixture::REFERENCE);

        // act
        $existingUser = $this->repository->findById($user->getId());

        // assert
        $this->assertEquals($user->getId(), $existingUser->getId());
    }
}

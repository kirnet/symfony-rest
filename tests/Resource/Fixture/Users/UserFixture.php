<?php

declare(strict_types=1);

namespace App\Tests\Resource\Fixture\Users;

use App\Tests\Tools\FakerTools;
use App\Users\Domain\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    use FakerTools;

    public const REFERENCE = 'user';

    public function __construct(private readonly UserFactory $userFactory)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $email = $this->getFaker()->email();
        $firstName = $this->getFaker()->firstName();
        $lastName = $this->getFaker()->lastName();
        $phone = $this->getFaker()->phoneNumber();
        $password = $this->getFaker()->password();
        $user = $this->userFactory->create($email, ['USER_ROLE'], $firstName, $lastName, $phone, $password);

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::REFERENCE, $user);
    }
}

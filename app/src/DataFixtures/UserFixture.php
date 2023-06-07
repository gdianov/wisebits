<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class UserFixture extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setName('testUser1');
        $user->setEmail('test@test.com');
        $user->setCreated(new DateTime());
        $user->setNotes('test notes...');

        $manager->persist($user);
        $manager->flush();
    }
}

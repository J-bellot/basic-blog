<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder
    ) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setEmail('test@test.test');
        $user->setPassword(
            $this->passwordEncoder->hashPassword($user, 'Azertyuiop8!')
        );
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        for($usr = 1; $usr<=10; $usr++){
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, 'Azertyuiop8!')
            );
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 1;
    }
}

<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class PostFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create('fr_FR');

        $users = $manager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            for ($p=0; $p < 3; $p++) { 
                $post = new Post();
                $post->setContent($faker->realText(200, 2));
                $post->setCreatedAt(new DateTimeImmutable());
                $post->setUser($user);

                $manager->persist($post);
            }
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }
}

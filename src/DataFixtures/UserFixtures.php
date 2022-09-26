<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixtures extends Fixture
{
    private $passwordHasher;
    private $dateTime;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->passwordHasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr-FR');

        $newUser = new User();
        // On prepare le password
        $plaintextPassword = "user";
        // On le hash
        $hashedPassword = $this->passwordHasher->hashPassword($newUser,$plaintextPassword);

        $role = ['ROLE_USER'];
        $newUser->setName($faker->unique()->name())
                ->setPassword($hashedPassword)
                ->setRoles($role)
                ->setUsername('user')
                ->setCreatedAt(new \DateTime());

        $manager->persist($newUser);

        $newUser = new User();
        // On prepare le password
        $plaintextPassword = "admin";
        // On le hash
        $hashedPassword = $this->passwordHasher->hashPassword($newUser,$plaintextPassword);
        $role = ['ROLE_ADMIN'];
        $newUser->setName($faker->unique()->name())
            ->setPassword($hashedPassword)
            ->setRoles($role)
            ->setUsername('admin')
            ->setCreatedAt(new \DateTime());

        $manager->persist($newUser);

        $manager->flush();
    }
}

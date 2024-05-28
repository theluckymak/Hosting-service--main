<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
private UserPasswordHasherInterface $passwordHasher;

public function __construct(UserPasswordHasherInterface $passwordHasher)
{
$this->passwordHasher = $passwordHasher;
}

public function load(ObjectManager $manager): void
{
// Create a new user entity
$user = new User();
$user->setEmail('admin@gmail.com');
$user->setUsername('admin');
$user->setPassword($this->passwordHasher->hashPassword($user, 'admin'));

// Assign the admin role
$user->setRoles(['ROLE_ADMIN']);

// Persist the user entity
$manager->persist($user);
$manager->flush();
}
}

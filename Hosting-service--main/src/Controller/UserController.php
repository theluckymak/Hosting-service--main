<?php

namespace App\Controller;

use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    #[Route(path: '/create', name: 'app_create')]
    public function createAdminUser( EntityManagerInterface $entityManager)
    {

        // Create a new User object
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setUsername('admin');

        // Encode the password
        $hashedPassowrd = $this->passwordHasher->hashPassword($user, 'admin');
        $user->setPassword($hashedPassowrd);

        // Assign admin role
        $roles = ['ROLE_ADMIN'];
        $user->setRoles($roles);

        // Persist the user object
        $entityManager->persist($user);

        // Flush changes to the database
        $entityManager->flush();

        return new Response('Admin user created successfully');
    }
}
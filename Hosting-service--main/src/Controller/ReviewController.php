<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\Reviews;
use App\Entity\User;
use App\Form\ReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    #[Route('/review', name: 'app_review')]
    public function index(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        // TODO: check if the user is logged in
        $user = $security->getUser();
        $review->setOwner($user);

        if ($form->isSubmitted() && $form->isValid()) {
            // persist
            $entityManager->persist($review);
            $entityManager->flush();



            return $this->redirectToRoute('app_review');
        }

        // Call showReviews method to retrieve user reviews
        $userReviews = $this->showReviews($entityManager);

        return $this->render('review/index.html.twig', [
            'controller_name' => 'ReviewController',
            'form' => $form->createView(),
            'userReviews' => $userReviews,
            'error'=> null,
            'user'=>null,
        ]);
    }

    // Define showReviews method to retrieve user reviews
    private function showReviews(EntityManagerInterface $entityManager): array
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        $usersReviews = [];

        foreach ($users as $user) {
            $usersReviews[$user->getUserIdentifier()] = $user->getReview();
        }

        return $usersReviews;
    }
}
<?php

namespace App\Controller;

use App\Entity\PricingPlanFeature;
use App\Entity\PricingPlans;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PricingController extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/pricing', name: 'pricing')]
    public function index(): Response
    {
        $pricingPlans = $this->doctrine
            ->getRepository(PricingPlans::class)
            ->findAll();

        $features = $this->doctrine
            ->getRepository(PricingPlanFeature::class)
            ->findAll();

        return $this->render('pricing/index.html.twig', [
            'pricing_plans' => $pricingPlans,
            'features' => $features,
            'error'=>null
        ]);
    }
}

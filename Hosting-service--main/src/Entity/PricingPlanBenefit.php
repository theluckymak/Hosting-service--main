<?php

namespace App\Entity;

use App\Repository\PricingPlanBenefitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PricingPlanBenefitRepository::class)]
class PricingPlanBenefit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'benefits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PricingPlans $pricingPlans = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPricingPlans(): ?PricingPlans
    {
        return $this->pricingPlans;
    }

    public function setPricingPlans(?PricingPlans $pricingPlans): static
    {
        $this->pricingPlans = $pricingPlans;

        return $this;
    }

    public function __toString(): string
    {
            return $this->name;
    }
}

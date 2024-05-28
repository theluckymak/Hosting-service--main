<?php

namespace App\Controller\Admin;

use App\Entity\PricingPlans;
use App\Form\PricingPlanBenefitType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PricingPlansCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PricingPlans::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            IntegerField::new('price'),
            collectionField::new('benefits')
                ->setEntryType(PricingPlanBenefitType::class)
            ->onlyOnForms()
        ];
    }

}

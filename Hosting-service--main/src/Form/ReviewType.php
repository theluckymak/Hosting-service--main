<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $textTypeOptions =  array(

            'label' => 'New Review',
            'row_attr'=> array(
                'class' => 'mb-3',
            ),
            'label_attr' => array(
                'class' => 'col-form-label'
            ),
            'attr' => array(
                'class' => 'form-control ajax-form',
            ),'constraints' =>
                new NotBlank(array(
                    'message' => 'mandatory'
                ))
        );
            $builder
            ->add('content', TextType::class, $textTypeOptions)
            ->add('save', SubmitType::class, ['label' => 'Create Review',
                'attr' => [
                    'class' => 'btn btn-primary',

                ]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
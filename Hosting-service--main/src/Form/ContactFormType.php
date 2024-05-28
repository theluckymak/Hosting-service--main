<?php

namespace App\Form;

use App\ValueObject\ContactForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $formTypeOptions = array(
                'row_attr'=> array(
                    'class' => 'mb-3',
                ),
                'label_attr' => array(
                    'class' => 'col-form-label'
                ),
                'attr' => array(
                    'class' => 'form-control',
                ),'constraints' =>
            new NotBlank(array(
                'message' => 'mandatory'
            ))
        );


        $builder
            ->add('name', TextType::class, $formTypeOptions)
            ->add('email', TextType::class, $formTypeOptions)
            ->add('subject', TextType::class, $formTypeOptions)
            ->add('message', TextareaType::class, $formTypeOptions)
            ->add('button', ButtonType::class, [
                'attr' => [
                    'class' =>'btn btn-secondary',
                    'data-bs-dismiss' => 'modal'
                ],
                'row_attr' => [
                    'class' =>'w-25 d-inline-block',
                ],
                'label' => 'Close'
            ])
            ->add('submit', SubmitType::class,[
            'attr' => [
        'class' =>'btn btn-primary'
    ],
                'row_attr' => [
                    'class' =>'w-50 d-inline-block',
                ],
                'label' => 'Send message'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactForm::class,
        ]);
    }
}

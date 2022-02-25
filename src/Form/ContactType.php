<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;



class ContactType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
 
        $builder
        ->add('name', TextType::class, [
            'label' => 'Nom du joueur/pseudo',
        'constraints' => [
            new NotBlank([
                'message' => 'Please enter a name',
            ]),
            new Length([
                'min' => 3,
                'max' => 40,
            ]),
        ],
        ])
        ->add('email', TextType::class, [
            'label' => 'Email',
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a email',
                ]),
               
            ],
                
               

        ])
        ->add('question', TextType::class, [
            'label' => 'Demande',
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a demand',
                ]),
                new Length([
                    'min' => 10,
                   
                ]),
            ],
        ])

        ->add('message', TextType::class, [
            'label' => 'message',
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a demand',
                ]),
                new Length([
                    'min' => 10,
                   
                ]),
            ],

        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer',
            'attr' => [
                'class' => 'button',
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data class' => Contact::class,
        ]);
    }
}

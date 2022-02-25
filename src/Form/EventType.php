<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Lenght;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom de l\'événement',
                'attr' => [
                    'placeholder' => 'Entrez le nom de l\'événement'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length ([
                    'min' => 10,
                    'max' => 250,
                    'minMessage' => 'Le contenu doit contenir au minimum {{ limit }} caractères',
                    'minMessage' => 'La contenu doit contenir au minimum {{ limit }} caractères',
                ])

                ]

                
            ])
            ->add('picture', FileType::class, [
                'label' => 'Importer une image',
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Entrez la description de l\'événement'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length ([
                    'min' => 10,
                    'max' => 1500,
                    'minMessage' => 'Le contenu doit contenir au minimum {{ limit }} caractères',
                    'minMessage' => 'La contenu doit contenir au minimum {{ limit }} caractères',
                ])

                ]
                
            ])
            ->add('start_at', DateTimeType::class, [
                'label' => 'Date de début',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ])
            ->add('end_at', DateTimeType::class, [
                'label' => 'Date de fin',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ])
            // ->add('team')
            // ->add('user')

            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'button',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}

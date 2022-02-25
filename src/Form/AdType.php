<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom de l\'annonce',
                'attr' => [
                    'placeholder' => 'Entrez le nom de l\'annonce'],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a name of ad',
                        ]),
                        new Length([
                            'min' => 4,
                           
                        ]),
                    ],
                
                
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Entrez la description de l\'annonce'
                ],

                 'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a description',
                        ]),
                        new Length([
                            'min' => 10,
                            'max' => 1500,
                           
                        ]),
                    ],
                
            ])
            ->add('picture', FileType::class, [
                'label' => 'Importer une image',
            ])
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
            'data_class' => Ad::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickname', TextType::class,[
                'label'=> 'Nom d\'utilisateur',
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
            ->add('firstname', TextType::class,[
                'label'=> 'Prenom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a firstname',
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 40,
                    ]),
                ],
            ])
            ->add('lastname', TextType::class,[
                'label'=> 'Nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a lastname',
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 40,
                    ]),
                ],
            ])
            ->add('nickname', TextType::class,[
                'label'=> 'Pseudo',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a pseudo',
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 40,
                    ]),
                ],
            ])
            ->add('birthdate', BirthdayType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a birthdate',
                    ]),
                   
                    
                ],
            ])
            ->add('email', TextType::class, [
                 'label' => 'Adresse email',
                'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a email',
                ]),
               
            ],

            ])
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

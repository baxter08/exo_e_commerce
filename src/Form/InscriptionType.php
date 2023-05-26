<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('nom', TextType::class, [
            'attr' => [
            'class'  => 'form-control',
            'minlenght' => '2',
            'maxlenght' => '50',
            ],
            'label' => 'Nom',
            'label_attr' => [
            'class' =>'form-label mt-4'
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 2, 'max' => 50])
            ]
            ])

        ->add('prenom', TextType::class,[ 
            'attr' => [
            'class'  => 'form-control',
            'minlenght' => '2',
            'maxlenght' => '50',
            ],
            'label' => 'Prénom',
            'label_attr' => [
            'class' =>'form-label mt-4'
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 2, 'max' => 50])
            ],
            ])

            ->add('pseudo', TextType::class, [
                'attr' => [
                'class'  => 'form-control',
                'minlenght' => '2',
                'maxlenght' => '50',
                ],
                'required' => false,
                'label' => 'Pseudo',
                'label_attr' => [
                'class' =>'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50])
                ],
                ])

            ->add('email' , EmailType::class, [
                'attr' => [
                    'class'  => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '180',
                ],
                'label' => 'Adresse email',
                'label_attr' => [
                'class' =>'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 180])
                ],

            ])

            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['max' => 180])
                ]
            ])
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Mot de passe (obligatoire: 1 majuscule, 1 chiffre, 1 minuscule)',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 6, 'max' => 32]),
                        new Assert\Regex('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,32}$/')
                    ],
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Confirmation du mot de passe',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ]
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas. Veuillez choisir un mot de passe contenant au moins une lettre majuscule, une lettre minuscule et un chiffre.',
            ])
            ->add('submit', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-info text-black mt-4'
                        
                ],
                'label' => 'S\'inscrire'
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
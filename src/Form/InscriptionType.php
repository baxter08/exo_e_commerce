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
    public function buildForm(FormBuilderInterface $builder, array $options,): void
    {
        $builder

        ->add('Nom', TextType::class, [
            'attr' => [
                'class' => 'form-control border flex flex-wrap w-1/2  ',
                'minlength' => '2',
                'maxlength' => '50',
            ],
            'label' => 'Nom',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 2, 'max' => 50])
            ],
            'row_attr' => [
                'class' => 'mb-4', // Ajout de la classe pour espacement en dessous du champ
            ]
        ])
        
        

        ->add('prenom',TextType::class,[ 
            'attr' => [
            'class'  => 'form-control border flex flex-wrap w-1/2',
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
            'row_attr' => [
                'class' => 'mb-4', // Ajout de la classe pour espacement en dessous du champ
            ]
            ])

            ->add('pseudo',TextType::class, [
                'attr' => [
                'class'  => 'form-control border flex flex-wrap w-1/2',
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
                'row_attr' => [
                    'class' => 'mb-4', // Ajout de la classe pour espacement en dessous du champ
                ]
                ])

            ->add('email' ,EmailType::class, [
                'attr' => [
                    'class'  => 'form-control border flex flex-wrap w-1/2',
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
                'row_attr' => [
                    'class' => 'mb-4', // Ajout de la classe pour espacement en dessous du champ
                ]

            ])

            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control border flex flex-wrap w-1/2'
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
                    'row_attr' => [
                        'class' => 'mb-4', // Ajout de la classe pour espacement en dessous du champ
                    ]
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control border flex flex-wrap w-1/2'
                    ],
                    'label' => 'Confirmation du mot de passe',
                    'label_attr' => [
                        'class' => 'form-label mt-4'
                    ],
                    'row_attr' => [
                        'class' => 'mb-4', // Ajout de la classe pour espacement en dessous du champ
                    ]
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas. Veuillez choisir un mot de passe contenant au moins une lettre majuscule, une lettre minuscule et un chiffre.',
            ])

            ->add('submit',SubmitType::class,[
                'attr' => [
                    'class' => 'dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]] inline-block w-full rounded bg-white px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-black shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] xl:ml-48 sm:ml-24 mt-4 sm:w-2/5'
                        
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
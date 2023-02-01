<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email' , EmailType::class, [
                'attr' => [
                    'class'  => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '180',
                ],
                'label' => 'Adresse email',
                'label_attr' => [
                'class' =>'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 180])
                ],

            ])

            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'first_options' => [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Mots de passe',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Confirmation du Mots de passe',
                    'label_attr' => [
                        'class' => 'form-label'
                    ]
                ],
                'invalid_message' => 'les mots de passe ne corespondent pas. '
            ])

            ->add('nom', TextType::class, [
                'attr' => [
                'class'  => 'form-control',
                'minlenght' => '2',
                'maxlenght' => '50',
                ],
                'label' => 'nom',
                'label_attr' => [
                'class' =>'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
                ])

            ->add('pseudo', TextType::class, [
                    'attr' => [
                    'class'  => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                    ],
                    'label' => 'pseudo (Facultatif)',
                    'label_attr' => [
                    'class' =>'form-label'
                    ],
                    'constraints' => [
                        new Assert\Length(['min' => 2, 'max' => 50])
                    ],
                    ])
            ->add('prenom', TextType::class,[ 
                'attr' => [
                'class'  => 'form-control',
                'minlenght' => '2',
                'maxlenght' => '50',
                ],
                'label' => 'nom',
                'label_attr' => [
                'class' =>'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50])
                ]
                ])

            ->add('submit', SubmitType::class,[
                'attr' => [
                'class' => 'btn btn-primary mt-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

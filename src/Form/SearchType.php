<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('q', TextType::class, [
            'attr' => [
                'placeholder' => 'Rechercher ici...'
            ],
            'label' => false
            ])

        ->add('submit', SubmitType::class,[
            'label_format' => 'border:1px solid black',
            'attr'=> [
                'class'=> 'btn btn-outline-info mb-1 text-center m-2'
            ],
            'label' => 'Rechercher'
            
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // 'data_class' => searchData::class,
            // 'method' => 'GET',
            'csrf_protection' => false
        ]);

    }

}
<?php

namespace App\Form;

use App\Entity\Quack;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content')
            ->add('created_at')

//            ->add('user', EntityType::class, [
//                'class' => 'App\Entity\User', // Update this to the actual namespace of your User entity
//                'choice_label' => 'duckname', // Update this to the property you want to display in the dropdown
////                'placeholder' => 'Choose a user', // Optional, adds an empty option to the dropdown
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quack::class,
        ]);
    }
}

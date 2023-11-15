<?php

namespace App\Form;

use App\Entity\Quack;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class QuackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextType::class, [
            'label' => 'Your Quack',
                'required' => false,
            ])
//            ->add('created_at')
            ->add('imageFile', FileType::class, [
                'label' => 'Image: (PNG, JPEG file)',
                'required' => false,
                'mapped' => false, // because this is not mapped to a database column
            ])

            ->add('tag', TextType::class, [
                'required' => false,
                'label' => 'Tags: (comma-separated e.g. duck, pond)',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quack::class,
        ]);
    }
}

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
            ->add('content')
            ->add('created_at')

//            ->add('image', FileType::class, [
//                'label' => 'Quack Image (PNG, JPG)',
//                'mapped' => false,
//                'required' => false,
//                'constraints' => [
//                    new File([
//                        'maxSize' => '1024k',
//                        'mimeTypes' => [
//                            'image/png',
//                            'image/jpeg',
//                        ],
//                        'mimeTypesMessage' => 'Please upload a valid PNG or JPG image',
//                    ])
//                ],
//            ])

            ->add('imageFile', FileType::class, [
                'label' => 'Image (PNG, JPEG file)',
                'required' => false,
                'mapped' => false, // because this is not mapped to a database column
            ])

            ->add('tag', TextType::class, [
                'required' => false,
                'label' => 'Tags (comma-separated e.g. duck, pond)',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quack::class,
        ]);
    }
}

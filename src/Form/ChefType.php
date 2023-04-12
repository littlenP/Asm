<?php

namespace App\Form;

use App\Entity\Chef;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;

class ChefType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('chefname',TextType::class)
            ->add('descriptionchef',TextareaType::class)
            ->add('chefimage',FileType::class,[
                'label'=> 'Image file',
                'mapped'=> false,
                'required'=>false,
                'constraints'=>[
                    new File([
                        'maxSize'=>'1024k',
                        'mimeTypesMessage'=>'Please upload a valid image',
                    ])
                ]
            ]   );

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chef::class,
        ]);
    }
}

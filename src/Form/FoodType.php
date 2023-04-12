<?php

namespace App\Form;

use App\Entity\Chef;
use App\Entity\Food;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;
use function Symfony\Config\Framework\HttpClient\DefaultOptions\multiplier;

class FoodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('foodname', TextType::class )
            ->add('descriptionfood' ,TextareaType::class )
            ->add('foodimage',FileType::class,[
                'label'=> 'Image file',
                'mapped'=> false,
                'required'=>false,
                'constraints'=>[
                    new File([
                        'maxSize'=>'1024k',
                        'mimeTypesMessage'=>'Please upload a valid image',
                    ])
                ]
            ])
            ->add('chef',EntityType::class,['class'=>'App\Entity\Chef','choice_label'=>'chefname',
                'multiple'=>true,
                ])
            ->add('restaurant', EntityType::class,['class'=>'App\Entity\Restaurant','choice_label'=>'restaurantname',
            'multiple'=>true,
                ]);
        [
            'mapped'=>false,
            'require'=>false,
            'constraints'=>[
            ]
        ]
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Food::class,
        ]);
    }
}

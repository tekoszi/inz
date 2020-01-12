<?php

namespace App\Form;
use App\Entity\Products;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $freespace = $options['attr'];
        var_dump($freespace);


        $builder
            ->add('barcode', IntegerType::class, [
                'attr' =>[
                    'placeholder' => 'Enter the barcode',
                    'class' => 'custom class'
                    ]
                ])
            ->add('name', TextType::class)
            ->add('price', IntegerType::class)
            ->add('quantity', IntegerType::class)
            ->add('warehouse_id', IntegerType::class)
            ->add('row_id', IntegerType::class)
            ->add('rack_id', IntegerType::class)
            ->add('shelf_id', IntegerType::class)
            ->add('Zapisz', SubmitType::class, [
                'attr' =>[
                    'placeholder' => 'Enter the barcode',
                    'class' => 'btn btn-dark mb-1'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
            'freespace' => false,
        ]);
    }
}

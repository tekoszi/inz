<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('full_name')
            ->add('email')
            ->add('address')
            ->add('password')
            ->add('roles', CollectionType::class,[
                'entry_type' => ChoiceType::class,
                'entry_options' => [
                    'choices' => [
                        'ADMIN' => 'ROLE_ADMIN',
                        'USER' => 'ROLE_USER',
                        'STOREKEEPER' => 'ROLE_STOREKEEPER',
                        'OFFICEWORKER' => 'ROLE_OFFICEWORKER',
                    ]


                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}

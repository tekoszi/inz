<?php

namespace App\Form;

use App\Entity\IssueConfirmation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IssueConfirmationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('order_id')
            ->add('user_id')
            ->add('external_order_id')
            ->add('quantity')
            ->add('status')
            ->add('date')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IssueConfirmation::class,
        ]);
    }
}

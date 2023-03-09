<?php

namespace App\Form;

use App\Entity\Booster;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoosterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rang')
            ->add('lane')
            ->add('op_gg')
            ->add('description')
            ->add('language')
            ->add('period')
            ->add('wallet')
            ->add('price')
            ->add('availability')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booster::class,
        ]);
    }
}

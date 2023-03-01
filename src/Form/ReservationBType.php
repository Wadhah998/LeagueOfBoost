<?php

namespace App\Form;

use App\Entity\ReservationB;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;



class ReservationBType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldrank')
            ->add('newrank')
            ->add('newprice')
            ->add('booster', HiddenType::class, [
                'data' => $options['booster_id'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReservationB::class,
            'booster_id' => null,
        ]);
    }
}


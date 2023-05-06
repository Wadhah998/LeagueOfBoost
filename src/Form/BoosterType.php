<?php

namespace App\Form;



use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoosterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


            ->add('voie')
            ->add('lienOpgg')
            ->add('description')
            ->add('prix')
             -> add('disponibility', ChoiceType::class, [
                'choices' => [
                    'Available' => true,
                    'not Available' => false,
                ],
                'required' => true,
                'expanded' => true,
                'multiple' => false,
            ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([


            'data_class' => User::class,

        ]);
    }
}

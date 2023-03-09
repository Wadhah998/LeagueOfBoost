<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('theme', ChoiceType::class, [
                'choices' => [
                    'Report a Booster' => 'Booster rep',
                    'Report a Coach' => 'Coach rep',
                    'Report a Customer' => 'Customer rep',
                    'Report a Bug' => 'Bug rep',
                    'Other' => 'Other',
                ],
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'Choose your theme',])
            ->add('object')
            ->add('text')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}

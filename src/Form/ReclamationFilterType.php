<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\ResetType;

class ReclamationFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('theme', ChoiceType::class, [
                'choices' => [
                    'Booster rep' => 'Booster rep',
                    'Coach rep' => 'Coach rep',
                    'Customer rep'=>  'Customer rep',
                    'Bug rep' =>'Bug rep',
                    'Other' => 'Other',
                ],
                'multiple' => false,
                'expanded' => false,
                'label' => 'Choose the report theme',
            ])
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'On hold' => '0',
                    'Saved successfully' => '1',
                ],
                'multiple' => false,
                'expanded' => false,
                'label' => 'Choose the report status',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}

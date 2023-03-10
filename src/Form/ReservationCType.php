<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Coach;
use App\Entity\ReservationC;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReservationCType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Nbr_heures', NumberType::class, [
            'constraints' => [
                new Positive([
                    'message' => 'le nbr_heures doit étre positive',
                ]),
                new LessThanOrEqual([
                    'value' => 10,
                    'message' => 'le max d heures est 10',
                ]),
            ],
        ])
            ->add('Langue', ChoiceType::class,[
                'choices' => [
                    'Anglais' => 'Anglais',
                    'Francais' => 'Francais',
                    'Arabe' => 'Arabe',
                    'Chinois' => 'Chinois',
                    'MongolienKiWadhah' => 'MongolienKiWadhah',]
                ])
                ->add('captcha', Recaptcha3Type::class, [
                    'constraints' => new Recaptcha3(),
                    'action_name' => 'ReservationC',
                    'locale' => 'de',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReservationC::class,
        ]);
    }
}

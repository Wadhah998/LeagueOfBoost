<?php

namespace App\Form;

use App\Entity\SessionCoaching;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Date;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class SessionCoachingType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Titre', TextType::class, [
            'label' => 'Titre',
            'label_attr' => ['class' => 'text-white'],
            'error_bubbling' => true,
            'constraints' => [
                new Length([
                    'max' => 60,
                    'maxMessage' => 'Le Titre ne peut pas étre plus de {{ limit }} characters',
                ]),
            ],
            'attr' => array(
                'class' => 'block border-b-2 w-full h-20 text-6x1 outline-none',
                'placeholder' => 'Enter Title...'
            ),
        ])
        ->add('Description', TextType::class, [
            'label' => 'Description',
            'label_attr' => ['class' => 'text-white'],
            'error_bubbling' => true,
            'constraints' => [
                new Length([
                    'max' => 200,
                    'maxMessage' => 'La description ne peut pas étre plus de {{ limit }} characters',
                ]),
            ],
            'attr' => array(
                'class' => 'block border-b-2 w-full h-20 text-6x1 outline-none',
                'placeholder' => 'Enter Description...'
            ),
        ])
        ->add('Prix', NumberType::class, [
            'label' => 'Prix',
            'label_attr' => ['class' => 'text-white'],
            'error_bubbling' => true,
            'constraints' => [
                new Positive([
                    'message' => '<span style="color: white;">Le prix doit être positif</span>',
                    
                ]),
            ],
            'attr' => array(
                'class' => 'block border-b-2 w-full h-20 text-6x1 outline-none',
                'placeholder' => 'Enter prix...'
            ),
        ])
        ->add('captcha', Recaptcha3Type::class, [
            'constraints' => new Recaptcha3(),
            'action_name' => 'sessionCoaching',
            'locale' => 'de',
        ])
        ->add('Date')
           /*->add('User',
            EntityType::class,array(
                'class'=>User::class,
                'choice_label'=>'id',
            ))*/
            
        
        ->add("Save",SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SessionCoaching::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\Game;
use App\Form\GameType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormView;

class Team1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('name')
            ->add('description')
            ->add('player1')
            ->add('player2')
            ->add('player3')
            ->add('player4')
            ->add('player5')
            //->add('game')

            ->add('game',
            EntityType::class,array(
                'class'=>Game::class,
                'choice_label'=>'title'
            ))
            
            ->add("Save",SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
